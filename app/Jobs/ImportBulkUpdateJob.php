<?php

namespace App\Jobs;

use App\Models\CFISModel;
use Illuminate\Bus\Queueable;
use Illuminate\Bus\Batchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ImportBulkUpdateJob implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels, Batchable;

    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $info = [];
        // dd($this->data);
        foreach ($this->data as $row) {
            $info[] = [
                'ffi_emp_id' => $row['FFI_EMP_ID'],
                'emp_name' => $row['Employee_Name'],
                'employee_last_date' => isset($row['Employee_Last_date']) && is_numeric($row['Employee_Last_date'])
                    ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['Employee_Last_date'])->format('Y-m-d')
                    : null,
            ];


        }

        if (!empty($info)) {
            foreach ($info as $data) {
                CFISModel::updateOrCreate(
                    ['ffi_emp_id' => $data['ffi_emp_id']],
                    $data
                );
            }
        }
    }
}
