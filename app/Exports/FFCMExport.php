<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class FFCMExport implements FromView
{
    public $expenses;

    public function __construct($expenses)
    {
        $this->expenses = $expenses;
    }

    public function view(): View
    {
        // Check if $expenses is a valid collection/array
        return view('admin.fcms.ffcm.export.index', [
            'expenses' => $this->expenses
        ]);
    }
}
