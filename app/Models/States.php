<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class States extends Model
{
    public $table = 'states';
    protected $fillable = [
        'country_id',
        'state_name',
    ];
    public function clientGstns()
    {
        return $this->hasMany(ClientGstn::class);
    }
}
