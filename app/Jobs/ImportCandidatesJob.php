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

            $ffiEmpId = $row['FFI_Emp_ID'];
            $clientid = $row['Client_ID'];
            $phone = $row['Phone_No'];

            $existing = CFISModel::where('ffi_emp_id', $ffiEmpId)
                ->whereIn('phone1', $phone)
                ->whereIn('client_emp_id', $clientid)->first();

            if ($existing) {
                // Only update UAN and ESIC
                $existing->update([
                    'uan_no' => $row['UAN_No'] ?? null,
                    'esic_no' => $row['ESIC_No'] ?? null,
                    'comp_status' => 1,

                ]);

                \Log::info("Updated UAN/ESIC for ffi_emp_id: $ffiEmpId");
            }
        }

        \Log::info('Job completed successfully');
    }
}

