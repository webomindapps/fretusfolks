<?php

namespace App\Imports;

use App\Jobs\ImportBulkUpdateJob;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CfisBulkImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        // Remove the header row
        $header = $rows->first();
        $data = $rows->slice(1);

        // Chunk rows into 1000-record batches
        $chunks = $data->chunk(1000);

        foreach ($chunks as $chunk) {
            $processedData = [];

            foreach ($chunk as $row) {
                // Skip rows that don't match header count
                if (count($row) === count($header)) {
                    $processedData[] = array_combine($header->toArray(), $row->toArray());
                }
            }

            if (!empty($processedData)) {
                ImportBulkUpdateJob::dispatch($processedData);
            }
        }
    }
}
