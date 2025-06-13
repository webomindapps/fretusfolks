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
        \Log::info('Bank Details:', ['data' => $this->data]);

        foreach ($this->data as $row) {

            $ffiEmpId = $row['FFI_Emp_ID'];
            $clientid = $row['Client_ID'];
            $aadhar = $row['Aadhar_No'];

            $existing = CFISModel::where('ffi_emp_id', $ffiEmpId)
                ->where('aadhar_no', $aadhar)
                ->where('client_emp_id', $clientid)
                ->first();


            if ($existing) {
                // Only update UAN and ESIC
                $details = BankDetails::updateOrCreate(['emp_id' => $row['Row_ID']], [
                    'emp_id' => $row['Row_ID'],
                    'bank_name' => $row['Bank_Name'] ?? null,
                    'bank_account_no' => $row['Bank_Account_No'] ?? null,
                    'bank_ifsc_code' => $row['Bank_IFSC_Code'] ?? null,
                    'bank_status' => match (strtolower(trim($row['Bank_Status']))) {
                        'In-Active' => 0,
                        'Active' => 1,
                        default => 0,
                    },
                    // 'bank_status' => strtolower(trim($row['Bank_Status'])) == 'Active' ? 1 : 0,
                ]);

                \Log::info('Updated Bank Details:', ['details' => $details->toArray()]);
            }


        }

        \Log::info('Job completed successfully');


    }
}
