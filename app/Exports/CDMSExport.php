<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class CDMSExport implements FromView
{
    public $clients;
    public function __construct($clients)
    {
        $this->clients = $clients;
    }

    public function view(): View
    {
        return view('admin.client_mangement.cdms.export.index', [
            'clients' => $this->clients
        ]);
    }
}
