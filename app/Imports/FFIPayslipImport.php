<?php

namespace App\Imports;

use App\Jobs\PayslipCreate;
use App\Models\FFIPayslipsModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class FFIPayslipImport implements ToCollection
{
    protected $month;
    protected $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function collection(Collection $rows)
    {
        $header = $rows->first()->toArray();
        $data = $rows->slice(1); // skip header

        $chunks = $data->chunk(1000);

        foreach ($chunks as $index => $chunk) {
            $payload = [];

            foreach ($chunk as $row) {
                $rowArray = $row->toArray();
                if (count($rowArray) === count($header)) {
                    $combined = array_combine($header, $rowArray);

                    if (!empty($combined['Employee_ID'])) {
                        // Remove existing records
                        FFIPayslipsModel::where('emp_id', $combined['Employee_ID'])
                            ->where('month', $this->month)
                            ->where('year', $this->year)
                            ->delete();

                        $payload[] = $combined;
                    }
                }
            }

            if (!empty($payload)) {
                PayslipCreate::dispatch($payload, $this->month, $this->year);
            }
        }
    }
}
