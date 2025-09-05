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

        $alreadyReinserted = []; // Track reinserted phone or aadhar separately
        $alreadyInsertedInThisRun = []; // Avoid duplicates within same import
        $ffiEmpIdsInThisRun = []; // Track FFI_EMP_IDs during current import

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

                    // Unique key to track within current import
                    $uniqueKey = $ffiEmpId . '|' . $phone . '|' . $aadhar;

                    // ✅ 1. FFI_EMP_ID must be unique
                    if (in_array($ffiEmpId, $ffiEmpIdsInThisRun)) {
                        $chunkDuplicates[] = "Duplicate FFI_EMP_ID in current import at row #$index - $ffiEmpId";
                        continue;
                    }

                    $ffiExists = DB::table('backend_management')->where('ffi_emp_id', $ffiEmpId)->exists();
                    if ($ffiExists) {
                        $chunkDuplicates[] = "FFI_EMP_ID already exists with active record at row #$index - $ffiEmpId";
                        continue;
                    }

                    // ✅ 2. Check phone1 separately
                    $phoneExists = DB::table('backend_management')->where('phone1', $phone)->get();
                    if ($phoneExists->count()) {
                        $hasActivePhone = $phoneExists->whereNull('employee_last_date')->count() > 0;
                        if ($hasActivePhone) {
                            $chunkDuplicates[] = "Phone number already exists with active record at row #$index - $phone";
                            continue;
                        }

                        // Prevent reusing same phone again in current import
                        if (in_array('phone|' . $phone, $alreadyReinserted)) {
                            $chunkDuplicates[] = "Phone number reuse blocked (already reinserted) at row #$index - $phone";
                            continue;
                        }

                        $alreadyReinserted[] = 'phone|' . $phone;
                    }

                    // ✅ 3. Check aadhar_no separately
                    $aadharExists = DB::table('backend_management')->where('aadhar_no', $aadhar)->get();
                    if ($aadharExists->count()) {
                        $hasActiveAadhar = $aadharExists->whereNull('employee_last_date')->count() > 0;
                        if ($hasActiveAadhar) {
                            $chunkDuplicates[] = "Aadhar number already exists with active record at row #$index - $aadhar";
                            continue;
                        }

                        if (in_array('aadhar|' . $aadhar, $alreadyReinserted)) {
                            $chunkDuplicates[] = "Aadhar reuse blocked (already reinserted) at row #$index - $aadhar";
                            continue;
                        }

                        $alreadyReinserted[] = 'aadhar|' . $aadhar;
                    }

                    // ✅ Passed all checks
                    $processedData[] = $row;
                    $alreadyInsertedInThisRun[] = $uniqueKey;
                    $ffiEmpIdsInThisRun[] = $ffiEmpId;
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
