<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'invoice_id',
        'client_id',
        'total_amt',
        'total_amt_gst',
        'payment_received_date',
        'month',
        'tds_code',
        'tds_percentage',
        'tds_amount',
        'amount_received',
        'balance_amount',
        'payment_received',
        'status',
        'active_status',
        'date_time',
        'modify_by',
    ];

    public function client()
    {
        return $this->belongsTo(ClientManagement::class, 'client_id', 'id');
    }
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }
    public function tds_code()
    {
        return $this->belongsTo(TdsCode::class, 'tds_code', 'code');
    }
}
