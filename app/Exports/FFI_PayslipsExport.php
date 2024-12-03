<?php

namespace App\Exports;

use App\Models\FFIPayslipsModel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class FFI_PayslipsExport implements FromView
{
    protected $month;
    protected $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function view(): View
    {
        $employees = FFIPayslipsModel::where('month', $this->month)
            ->where('year', $this->year)
            ->get();

        return view('admin.hr_management.ffi.payslips.export.index', [
            'employees' => $employees,
            'month' => $this->month,
            'year' => $this->year,
        ]);
    }
}
