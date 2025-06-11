<?php

namespace App\Imports;

use Log;
use Exception;
use App\Jobs\FHRMSJob;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;


class FHRMSImport implements ToCollection
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
                    $ffiEmpId = $row['FFI_Emp_ID'] ?? null;


                    // Skip this row if FFI_Emp_ID is null or empty
                    if (empty($ffiEmpId)) {
                        continue;
                    }

                    $exists = DB::table('fhrms')
                        ->where('ffi_emp_id', $ffiEmpId)

                        ->exists();

                    if ($exists) {
                        $chunkDuplicates[] = "Duplicate at row #" . ($index + 1) . " - FFI_Emp_ID: $ffiEmpId" . "<br>";
                    } else {
                        $processedData[] = $row;

                    }
                }
            }

            if (!empty($chunkDuplicates)) {
                $allDuplicates = array_merge($allDuplicates, $chunkDuplicates);
            }

            if (!empty($processedData)) {
                FHRMSJob::dispatch($processedData, $this->created_by);
            }
        }

        // Throw error after all processing
        if (!empty($allDuplicates)) {
            $errorMessage = "Duplicate records found:\n" . implode("\n", $allDuplicates);
            throw new \Exception($errorMessage);
        }
    }

}