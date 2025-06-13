<?php

namespace App\Imports;

use App\Jobs\ImportBankJob;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CandidatesBankImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $header = $rows->first();
        $data = $rows->slice(1);

        $chunks = $data->chunk(1000);
        // dd($chunks);
        foreach ($chunks as $chunk) {
            $processedData = [];

            foreach ($chunk as $row) {
                if (count($row) === count($header)) {
                    $processedData[] = array_combine($header->toArray(), $row->toArray());
                }
            }

            if (!empty($processedData)) {
                //  dd($processedData);
                ImportBankJob::dispatch($processedData);
            }
        }
    }
}
