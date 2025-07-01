<?php

namespace App\Imports;

use App\Jobs\ADMSTerminationJOB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ADMSTerminationImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
     public function collection(Collection $rows)
    {
        $header = $rows->first()->toArray();
        $data = $rows->slice(1);

        $chunked = $data->chunk(1000);
        // dd($chunked);
        foreach ($chunked as $chunk) {
            $processedData = [];

            foreach ($chunk as $row) {
                $rowArray = $row->toArray();

                if (count($rowArray) === count($header)) {
                    $combined = array_combine($header, $rowArray);

                    if (!empty($combined['Employee_ID'])) {
                        $processedData[] = $combined;
                    }
                }
            }

            if (!empty($processedData)) {
                // dd($processedData);
                ADMSTerminationJOB::dispatch($processedData);
            }
        }
    }
}
