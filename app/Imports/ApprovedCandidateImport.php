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

        foreach ($chunked as $chunk) {
            $processedData = [];
            $chunkDuplicates = [];

            foreach ($chunk as $index => $row) {
                $rowArray = $row->toArray();

                if (count($rowArray) === count($header)) {
                    $row = array_combine($header, $rowArray);
                    // dd($row);
                    $ffiEmpId = $row['FFI_EMP_ID'] ?? null;
                    $phone = $row['Phone_No'] ?? null;
                    $aadhar = $row['Aadhar_No'] ?? null;

                    // Skip this row if FFI_Emp_ID is null or empty
                    if (empty($ffiEmpId)) {
                        continue;
                    }

                    $exists = DB::table('backend_management')
                        ->where('ffi_emp_id', $ffiEmpId)
                        ->orWhere('phone1', $phone)
                        ->orWhere('aadhar_no', $aadhar)
                        ->exists();

                    if ($exists) {
                        $chunkDuplicates[] = "Duplicate at row #" . ($index) . " - FFI_Emp_ID: $ffiEmpId, Phone_NO: $phone, Aadhar_No: $aadhar";
                    } else {
                        $processedData[] = $row;

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

        // Throw error after all processing
        if (!empty($allDuplicates)) {
            $errorMessage = "Duplicate records found:<br>" . implode("<br>", $allDuplicates);
            throw new \Exception($errorMessage);
        }
    }


}
