<?php

namespace App\Imports;

use App\Models\Payslips;
use App\Jobs\ADMSPayslipCreate;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PayslipImport implements ToCollection, WithHeadingRow
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
        $chunked = $rows->chunk(1000);
        // dd($chunked);

        foreach ($chunked as $chunk) {
            $validChunk = $chunk->filter(function ($row) {
                return isset($row['emp_id']) && !is_null($row['emp_id']) && trim($row['emp_id']) !== '';
            });

            $validChunk->each(function ($row) {
                if ($this->month && $this->year) {
                    Payslips::where('emp_id', $row['emp_id'])
                        ->where('month', $this->month)
                        ->where('year', $this->year)
                        ->delete();
                }
            });

            if ($validChunk->isNotEmpty()) {
                ADMSPayslipCreate::dispatch($validChunk->toArray(), $this->month, $this->year);
            }
        }

    }
}
