<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class BankDownload implements FromCollection, WithHeadings
{
    protected $candidates;

    public function __construct($candidates)
    {
        $this->candidates = $candidates;
    }

    public function collection()
    {
        return new Collection($this->candidates->map(function ($candidate) {
            return [
                'Row_ID' => $candidate->emp_id,
                'FFI_Emp_ID' => $candidate->clients?->ffi_emp_id,
                'Client_ID' => $candidate->clients?->client_emp_id,
                'Client_Name' => $candidate->clients?->entity_name,
                'Emp_Name' => $candidate->clients?->emp_name,
                'Aadhar_No' => "'" . $candidate->clients?->aadhar_no,

                'Bank_Name' => $candidate->bank_name,
                'Bank_Account_No' => "'" . $candidate->bank_account_no,
                'Bank_IFSC_Code' => $candidate->bank_ifsc_code,
                // 'Bank_Status' => $candidate->bank_status == 1 ? 'Active' : 'In-Active',
                'Remark' => $candidate->remark,

            ];
        }));
    }

    public function headings(): array
    {
        return [
            'Row_ID',
            'FFI_Emp_ID',
            'Client_ID',
            'Client_Name',
            'Emp_Name',
            'Aadhar_No',
            'Bank_Name',
            'Bank_Account_No',
            'Bank_IFSC_Code',
            // 'Bank_Status',
            'Remark'

        ];
    }
}
