<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public $table = 'invoice';
    protected $fillable = [
        'invoice_no',
        'client_id',
        'service_location',
        'gst_no',
        'gross_value',
        'service_value',
        'source_value',
        'total_employee',
        'cgst',
        'sgst',
        'igst',
        'cgst_amount',
        'sgst_amount',
        'igst_amount',
        'tax_amount',
        'total_value',
        'credit_note',
        'debit_note',
        'grand_total',
        'file_path',
        'amount_received',
        'balance_amount',
        'tds_code',
        'tds_amount',
        'date',
        'inv_month',
        'status',
        'active_status',
    ];

    public function client()
    {
        return $this->belongsTo(ClientManagement::class, 'client_id', 'id');
    }
    public function state()
    {
        return $this->hasOne(States::class, 'id','service_location');
    }
}
