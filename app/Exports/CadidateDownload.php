<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CadidateDownload implements FromCollection, WithHeadings
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

                'FFI Emp ID' => $candidate->ffi_emp_id,
                'Employee Name' => $candidate->emp_name,
                'Email' => $candidate->email,
                'UAN No' => $candidate->uan_no,
                'ESIC No' => $candidate->esic_no,

            ];
        }));
    }

    public function headings(): array
    {
        return [

            'ffi_emp_id',
            'emp_name',
            'email',
            'uan_no',
            'esic_no',

        ];
    }
}

