<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class FFIAssetExport implements FromView
{
    public $issues;

    public function __construct($issues)
    {
        $this->issues = $issues;
    }

    public function view(): View
    {
        return view('admin.fcms.ffi_assets.export.index', [
            'issues' => $this->issues
        ]);
    }
}