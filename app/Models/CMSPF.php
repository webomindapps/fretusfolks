<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CMSPF extends Model
{
    protected $table = 'cms_pf';
    protected $fillable = [
        'state_id',
        'client_id',
        'year',
        'month',
        'path',
        'status',
    ];

    public function client()
    {
        return $this->belongsTo(ClientManagement::class, 'client_id', 'id');
    }
    public function state()
    {
        return $this->hasOne(States::class, 'id','state_id');
    }
}
