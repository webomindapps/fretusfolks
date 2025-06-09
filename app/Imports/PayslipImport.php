<?php

namespace App\Imports;

use App\Models\Payslips;
use App\Jobs\ADMSPayslipCreate;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PayslipImport implements ToCollection
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
                        Payslips::where('emp_id', $combined['Employee_ID'])
                            ->where('month', $this->month)
                            ->where('year', $this->year)
                            ->delete();

                        $processedData[] = $combined;
                    }
                }
            }

            if (!empty($processedData)) {
                // dd($processedData);
                ADMSPayslipCreate::dispatch($processedData, $this->month, $this->year);
            }
        }
    }


}
