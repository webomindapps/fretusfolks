<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TdsCode extends Model
{
    public $table = 'tds_code';
    protected $fillable = [
        'code',
        'discount',
        'status',
    ];
    public function tds()
    {
        return $this->hasMany(Payment::class, 'id','tds_code');
    }
}
