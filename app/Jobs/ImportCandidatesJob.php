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
            if (empty($row['FFI_Emp_ID'])) {
                \Log::error('Missing FFI_Emp_ID:', $row);
                continue;
            }

            $ffiEmpId = trim($row['FFI_Emp_ID']);
            // $clientid = trim($row['Client_ID']);
            // $phone = trim($row['Phone_No']);

            $matches = CFISModel::where(function ($query) use ($ffiEmpId) {
                $query->where('ffi_emp_id', $ffiEmpId);
                // ->orWhere('client_emp_id', $clientid)
                // ->orWhere('phone1', $phone);
            })->get();

            foreach ($matches as $existing) {
                $existing->update([
                    'uan_no' => $row['UAN_No'] ?? null,
                    'esic_no' => $row['ESIC_No'] ?? null,
                    'comp_status' => 1,
                ]);
                \Log::info("Updated record for ID: {$existing->id}{$existing->ffiEmpId}");
            }

        }

        \Log::info('Job completed successfully');
    }
}

