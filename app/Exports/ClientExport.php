<?php

namespace App\Exports;

use App\Models\ClientManagement; // Adjust this model based on your database
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ClientExport implements FromView
{
    protected $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function view(): View
    {
        // Retrieve only the selected fields from the database
        $clients = ClientManagement::select($this->fields)->get();

        return view('admin.client_mangement.cdms_report.export', [
            'clients' => $clients,
            'fields' => $this->fields
        ]);
    }
}
