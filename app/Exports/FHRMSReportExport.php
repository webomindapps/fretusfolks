<?php

namespace App\Exports;

use App\Models\FHRMSModel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class FHRMSReportExport implements FromView
{
    protected $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }
    public function view(): View
    {
        $clients = FHRMSModel::select($this->fields)->get();

        return view('admin.hr_management.fhrms_report.export', [
            'clients' => $clients,
            'fields' => $this->fields
        ]);
    }
}
