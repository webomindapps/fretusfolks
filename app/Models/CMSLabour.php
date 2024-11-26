<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CMSLabour extends Model
{
    protected $table = 'cms_labour';
    protected $fillable = [
        'state_id',
        'client_id',
        'location',
        'notice_received_date',
        'notice_document',
        'closure_date',
        'closure_document',
        'status',
    ];

    public function client()
    {
        return $this->belongsTo(ClientManagement::class, 'client_id', 'id');
    }
    public function state()
    {
        return $this->hasOne(States::class, 'id', 'state_id');
    }
}
