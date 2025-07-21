<?php

namespace App\Imports;

use App\Jobs\ADMSOfferJOB;
use App\Models\OfferLetter;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ADMSOfferImport implements ToCollection
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
                        // Remove existing records
                        OfferLetter::where('employee_id', $combined['Employee_ID'])
                            ->delete();

                        $processedData[] = $combined;
                    }

                }
            }

            if (!empty($processedData)) {
                // dd($processedData);
                ADMSOfferJOB::dispatch($processedData);
            }
        }
    }
}
