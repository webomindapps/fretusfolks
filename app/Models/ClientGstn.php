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
       
    public function state()
    {
        return $this->belongsTo(States::class, 'state');
    }
    public function clientManagement()
    {
        return $this->hasMany(ClientManagement::class);
    }
}