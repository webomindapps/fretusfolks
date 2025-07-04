<?php

namespace App\Models;

use App\Models\States;
use App\Models\ClientManagement;
use Illuminate\Database\Eloquent\Model;

class CMSCLRA extends Model
{
    protected $table = 'cms_clras';
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
        return $this->hasOne(States::class, 'id', 'state_id');
    }
}
