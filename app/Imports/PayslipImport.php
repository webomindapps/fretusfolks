<?php

namespace App\Imports;

use App\Jobs\ADMSPayslipCreate;
use App\Models\Payslips;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class PayslipImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, SkipsEmptyRows
{
    protected $month;
    protected $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function model(array $row)
    {
        // Skip row if employee_id is empty
        if (!isset($row['employee_id']) || empty($row['employee_id'])) {
            return null;
        }

        // Remove existing payslip if needed (optional, but be cautious about duplicates)
        Payslips::where('emp_id', $row['employee_id'])
            ->where('month', $this->month)
            ->where('year', $this->year)
            ->delete();

        ADMSPayslipCreate::dispatch([$row], $this->month, $this->year);
    }

    public function batchSize(): int
    {
        return 100; // Number of rows inserted per query
    }

    public function chunkSize(): int
    {
        return 100; // Number of rows read into memory at once
    }
}
