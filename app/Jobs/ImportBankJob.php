<?php

namespace App\Jobs;

use App\Models\CFISModel;
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
        \Log::info('Bank Details Job Started', ['data_count' => count($this->data)]);

        foreach ($this->data as $row) {
            if (empty($row['FFI_Emp_ID'])) {
                \Log::error('Missing FFI_Emp_ID:', $row);
                continue;
            }

            $ffiEmpId = trim($row['FFI_Emp_ID']);
            $clientid = trim($row['Client_ID']);
            $aadhar = trim($row['Aadhar_No']);

            // Match using only FFI_Emp_ID (you can add more fields as needed)
            $matches = CFISModel::where(function ($query) use ($ffiEmpId) {
                $query->where('ffi_emp_id', $ffiEmpId);
                // You can enable these if needed
                // ->orWhere('client_emp_id', $clientid)
                // ->orWhere('aadhar_no', $aadhar);
            })->get();

            foreach ($matches as $existing) {
                // Create or update bank details for each matched candidate
                $details = BankDetails::updateOrCreate(
                    ['emp_id' => $existing->id],  // Assuming emp_id should match CFISModel ID
                    [
                        'bank_name' => $row['Bank_Name'] ?? null,
                        'bank_account_no' => $row['Bank_Account_No'] ?? null,
                        'bank_ifsc_code' => $row['Bank_IFSC_Code'] ?? null,
                        'remark' => $row['Remark'] ?? null,
                        'bank_status' => 1,
                    ]
                );

                \Log::info("Bank details updated for EMP_ID {$existing->id} (FFI_Emp_ID: {$existing->ffi_emp_id})", $details->toArray());
            }

            if ($matches->isEmpty()) {
                \Log::warning("No match found for FFI_Emp_ID: $ffiEmpId");
            }
        }

        \Log::info('Bank Details Job Completed');
    }


}
