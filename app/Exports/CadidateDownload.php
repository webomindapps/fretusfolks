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

                'FFI_Emp_ID' => $candidate->ffi_emp_id,
                'Client_ID' => $candidate->client_emp_id,
                'Client_Name' => $candidate->entity_name,
                'Employee_Name' => $candidate->emp_name,
                'Phone_No' => $candidate->phone1,
                'UAN_No' => $candidate->uan_no,
                'ESIC_No' => $candidate->esic_no,

            ];
        }));
    }

    public function headings(): array
    {
        return [

            'FFI_Emp_ID',
            'Client_ID',
            'Client_Name',
            'Employee_Name',
            'Phone_No',
            'UAN_No',
            'ESIC_No',

        ];
    }
}

