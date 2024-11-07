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
}
