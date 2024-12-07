<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Payment;


class ReciveablesExport implements FromView
{
    protected $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }
    public function view(): View
    {
        $query = Payment::with('invoice');

        $selectFields = $this->fields;

        if (in_array('invoice_no', $this->fields) || in_array('service_location', $this->fields)) {
            $query->with('invoice:id,invoice_no,service_location');
        }

        $receivables = $query->get();
        return view('admin.fcms.receivables.export', [
            'receivables' => $receivables,
            'fields' => $this->fields
        ]);
    }
}
