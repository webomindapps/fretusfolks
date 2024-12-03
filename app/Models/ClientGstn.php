<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientGstn extends Model
{
    protected $table = "client_gstn";
    protected $fillable = [
        'client_id',
        'state',
        'gstn_no',
        'status',
    ] ;
       
    public function states()
    {
        return $this->belongsTo(States::class, 'state');
    }
    public function clientManagement()
    {
        return $this->hasMany(ClientManagement::class,'client_id');
    }
}
