<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HRMasters extends Model
{
    public $table = 'hr_masters';
    protected $fillable = [
        'user_id',
        'client_id',
        
    ];
    public function user()
    {
        return $this->belongsTo(MuserMaster::class, 'user_id');
    }

    public function client()
    {
        return $this->belongsTo(ClientManagement::class, 'client_id', 'id');
    }
}
