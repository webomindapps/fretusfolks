<?php

namespace App\Imports;

use App\Models\CFISModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CandidatesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return CFISModel::updateOrCreate(
            [
                'ffi_emp_id' => $row['ffi_emp_id']
            ],
            [
                'emp_name' => $row['emp_name'],
                'email' => $row['email'],
                'uan_no' => $row['uan_no'],
                'esic_no' => $row['esic_no'],
                'comp_status' => 1,
            ]
        );
    }
}