<?php

namespace App\Jobs;

use App\Models\BankDetails;
use Illuminate\Bus\Batchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ImportBankJob implements ShouldQueue
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
            $info[] = [
                'emp_id' => $row['emp_id'],
                'bank_name' => $row['bank_name'],
                'bank_account_no' => $row['bank_account_no'] ?? null,
                'bank_ifsc_code' => $row['bank_ifsc_code'] ?? null,
                'bank_status' => strtolower(trim($row['bank_status'])) == 'approved' ? 1 : 0,
            ];
        }
        \Log::info('Generated data:', $info);

        if (!empty($info)) {
            foreach ($info as $data) {
                BankDetails::updateOrCreate(
                    ['emp_id' => $data['emp_id']],
                    $data
                );
            }
        }
        \Log::info('Job completed successfully');


    }
}
