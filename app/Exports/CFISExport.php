<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class CFISExport implements FromView
{
    public $candidates;
    public function __construct($candidates)
    {
        $this->candidates = $candidates;
    }

    public function view(): View
    {
        return view('admin.adms.cfis.export.index', [
            'candidates' => $this->candidates
        ]);
    }
}
