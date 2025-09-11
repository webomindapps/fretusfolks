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
        $employee = CFISModel::where('ffi_emp_id', $this->data['ffi_emp_id'])->first();
        if ($employee) {
            $employee->update([
                'employee_last_date' => date('Y-m-d', strtotime($this->data['Employee_Last_date'])),
                'status' => 1,
            ]);
        }
    }
}
