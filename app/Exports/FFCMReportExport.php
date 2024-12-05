<?php

namespace App\Exports;

use App\Models\FFCMModel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class FFCMReportExport implements FromView
{
    protected $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }
    public function view(): View
    {
        $clients = FFCMModel::select($this->fields)->get();

        return view('admin.fcms.ffcm_reports.export', [
            'clients' => $clients,
            'fields' => $this->fields
        ]);
    }
}
