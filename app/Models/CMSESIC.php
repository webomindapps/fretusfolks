<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CMSESIC extends Model
{
    protected $table = 'cms_esic';
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
