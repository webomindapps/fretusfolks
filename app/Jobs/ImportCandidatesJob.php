<?php
namespace App\Jobs;

use App\Models\CFISModel;
use Illuminate\Bus\Queueable;
use Illuminate\Bus\Batchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ImportCandidatesJob implements ShouldQueue
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
        foreach ($this->data as $row) {
            if (!isset($row['ffi_emp_id'])) {
                \Log::error('Missing ffi_emp_id:', $row);
                continue; // Skip this record if ffi_emp_id is missing
            }

            $info = [
                'ffi_emp_id' => $row['ffi_emp_id'],
                'emp_name' => $row['emp_name'],
                'email' => $row['email'] ?? null,
                'uan_no' => $row['uan_no'] ?? null,
                'esic_no' => $row['esic_no'] ?? null,
                'comp_status' => 1,
            ];

            \Log::info('Processing record:', $info);

            // ✅ Correct usage of updateOrCreate
            CFISModel::updateOrCreate(
                ['ffi_emp_id' => $info['ffi_emp_id']], // Condition to find the record
                $info // Data to update or insert
            );
        }

        \Log::info('Job completed successfully');
    }
}

