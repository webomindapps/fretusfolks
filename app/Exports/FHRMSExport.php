<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class FHRMSExport implements FromView
{
    public $employees;

    public function __construct($employees)
    {
        $this->employees = $employees;
    }

    public function view(): View
    {
        return view('admin.hr_management.fhrms.export.index', [
            'employees' => $this->employees
        ]);
    }
}
