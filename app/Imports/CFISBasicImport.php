<?php

namespace App\Imports;

use App\Jobs\ImportCFISJob;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CFISBasicImport implements ToCollection
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

        $chunked = $data->chunk(1000);

        foreach ($chunked as $chunk) {
            $processedData = [];

            foreach ($chunk as $row) {
                $rowArray = $row->toArray();

                if (count($rowArray) === count($header)) {
                    $processedData[] = array_combine($header, $rowArray);
                }
            }

            if (!empty($processedData)) {
                ImportCFISJob::dispatch($processedData, $this->created_by);
            }
        }
    }
}
