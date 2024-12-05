<?php

namespace App\Exports;

use App\Models\Payment;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class tdsReportExport implements FromView
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

        $payments = $query->get();
        return view('admin.fcms.tds_report.export', [
            'tds_code' => $payments,
            'fields' => $this->fields
        ]);
    }
}

