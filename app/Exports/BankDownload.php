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

                'Emp ID' => $candidate->emp_id,
                'Bank Name' => $candidate->bank_name,
                'Bank Account No' => $candidate->bank_account_no,
                'Bank IFSC Code' => $candidate->bank_ifsc_code,
                'Status' => $candidate->bank_status == 1 ? 'Approved' : 'Pending',
            ];
        }));
    }

    public function headings(): array
    {
        return [

            'emp_id',
            'bank_name',
            'bank_account_no',
            'bank_ifsc_code',
            'bank_status'
        ];
    }
}
