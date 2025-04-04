<?php

namespace App\Exports;

use App\Models\CFISModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeExport implements FromCollection
{
    protected $employee;

    public function __construct($employee)
    {
        $this->employee = $employee;
    }

    public function collection()
    {
        return collect([
            [
                'Name' => $this->employee->name,
                'Email' => $this->employee->email,
                'Phone' => $this->employee->phone,
                'Contract Date' => $this->employee->contract_date,
                // Add more fields as needed
            ]
        ]);
    }
}
