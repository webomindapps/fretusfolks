<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Jobs\ImportApprovedCandidatesJob;
use Maatwebsite\Excel\Concerns\ToCollection;

class ApprovedCandidateImport implements ToCollection
{
    protected $created_by;

    public function __construct($created_by)
    {
        $this->created_by = $created_by;
    }

    public function collection(Collection $rows)
    {
        $header = $rows->first()->toArray();
        $data = $rows->slice(1);
        $allDuplicates = [];

        $chunked = $data->chunk(1000);

        $alreadyReinserted = []; // Track reinserted combinations
        $alreadyInsertedInThisRun = []; // Prevent inserting same record twice in this import

        foreach ($chunked as $chunk) {
            $processedData = [];
            $chunkDuplicates = [];

            foreach ($chunk as $index => $row) {
                $rowArray = $row->toArray();

                if (count($rowArray) === count($header)) {
                    $row = array_combine($header, $rowArray);
                    $ffiEmpId = trim($row['FFI_EMP_ID'] ?? '');
                    $phone = trim($row['Phone_No'] ?? '');
                    $aadhar = trim($row['Aadhar_No'] ?? '');

                    if (empty($ffiEmpId)) {
                        continue;
                    }

                    $uniqueKey = $ffiEmpId . '|' . $phone . '|' . $aadhar;

                    // Already inserted in this run?
                    if (in_array($uniqueKey, $alreadyInsertedInThisRun)) {
                        $chunkDuplicates[] = "Duplicate in current import at row #$index - FFI_Emp_ID: $ffiEmpId, Phone: $phone, Aadhar: $aadhar";
                        continue;
                    }

                    // Fetch all records from DB that match same FFI + Phone + Aadhar
                    $matchingRecords = DB::table('backend_management')
                        ->where('ffi_emp_id', $ffiEmpId)
                        ->where('phone1', $phone)
                        ->where('aadhar_no', $aadhar)
                        ->get();

                    $totalExisting = $matchingRecords->count();
                    $hasExitRecord = $matchingRecords->whereNotNull('employee_last_date')->count() > 0;
                    $hasActiveRecord = $matchingRecords->whereNull('employee_last_date')->count() > 0;

                    if ($totalExisting == 0) {
                        // No existing record — safe to insert
                        $processedData[] = $row;
                        $alreadyInsertedInThisRun[] = $uniqueKey;
                    } elseif ($totalExisting == 1 && $hasExitRecord) {
                        // One exited record exists — allow reinsertion only once
                        if (!in_array($uniqueKey, $alreadyReinserted)) {
                            $processedData[] = $row;
                            $alreadyInsertedInThisRun[] = $uniqueKey;
                            $alreadyReinserted[] = $uniqueKey;
                        } else {
                            $chunkDuplicates[] = "Duplicate (exit data already reused) at row #$index - FFI_Emp_ID: $ffiEmpId, Phone: $phone, Aadhar: $aadhar";
                        }
                    } else {
                        // Already two records (one active and one exited) — do not allow more
                        $chunkDuplicates[] = "Duplicate (already 2 records exist) at row #$index - FFI_Emp_ID: $ffiEmpId, Phone: $phone, Aadhar: $aadhar";
                    }
                }
            }

            if (!empty($chunkDuplicates)) {
                $allDuplicates = array_merge($allDuplicates, $chunkDuplicates);
            }

            if (!empty($processedData)) {
                ImportApprovedCandidatesJob::dispatch($processedData, $this->created_by);
            }
        }



        if (!empty($allDuplicates)) {
            $errorMessage = "Duplicate records found:<br>" . implode("<br>", $allDuplicates);
            throw new \Exception($errorMessage);
        }
    }


}
