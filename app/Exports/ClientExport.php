<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\ClientManagement; // Adjust this model based on your database

class ClientExport implements FromView
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
        // Retrieve only the selected fields from the database
        return view('admin.client_mangement.cdms_report.export', [
            'clients' => $this->data,
            'fields' => $this->fields,
        ]);
    }
}
