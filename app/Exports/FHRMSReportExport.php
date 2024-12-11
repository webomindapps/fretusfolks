<?php

namespace App\Exports;

use App\Models\FHRMSModel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class FHRMSReportExport implements FromView
{
    protected $fields;
    protected $filters;

    public function __construct(array $fields, array $filters)
    {
        $this->fields = $fields;
        $this->filters = $filters;
    }

    public function view(): View
    {
        $query = FHRMSModel::select($this->fields);

        // Apply filters
        if (!empty($this->filters['from_date']) && !empty($this->filters['to_date'])) {
            $query->whereBetween('modified_date', [$this->filters['from_date'], $this->filters['to_date']]);
        }
        if (!empty($this->filters['state'])) {
            $query->whereIn('state', $this->filters['state']);
        }
        if (!empty($this->filters['location'])) {
            $query->where('location', $this->filters['location']);
        }
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }
        if (!empty($this->filters['pending_doc'])) {
            $query->whereIn('pending_doc', $this->filters['pending_doc']);
        }
        // if (!empty($this->filters['data'])) {
        //     $query->select(array_merge('data', ['id', 'created_at', 'location', 'state', 'status']));
        // }
        $clients = $query->get();

        return view('admin.hr_management.fhrms_report.export', [
            'clients' => $clients,
            'fields' => $this->fields
        ]);
    }
}

