<?php

namespace App\Imports;

use App\Models\Payslips;
use App\Jobs\ADMSPayslipCreate;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithColumnLimit;

class PayslipImport implements ToCollection, WithHeadingRow, WithChunkReading, SkipsEmptyRows, WithColumnLimit
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
        foreach ($rows as $row) {
            $row = $row->toArray();

            if (!isset($row['employee_id']) || empty($row['employee_id'])) {
                continue;
            }


            // Optional: check for newline characters
            $hasNewline = false;
            foreach ($row as $cell) {
                if (is_string($cell) && preg_match("/\r|\n/", $cell)) {
                    $hasNewline = true;
                    break;
                }
            }

            if ($hasNewline) {
                continue;
            }

            Payslips::where('emp_id', $row['employee_id'])
                ->where('month', $this->month)
                ->where('year', $this->year)
                ->delete();
            // dd($row);
            ADMSPayslipCreate::dispatch([$row], $this->month, $this->year);
        }
    }
    public function endColumn(): string
    {
        return 'BH';
    }
    public function chunkSize(): int
    {
        return 100;
    }
}
