<?php

namespace App\Exports;

use App\Models\FHRMSModel;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class FHRMSReportExport implements FromView
{
    protected $data;
    protected $fields;

    public function __construct(Collection $data, array $fields)
    {
        $this->data = $data;
        $this->fields = $fields;

    }

    public function view(): View
    {
        return view('admin.hr_management.fhrms_report.export', [
            'clients' => $this->data,
            'fields' => $this->fields
        ]);
    }
}
