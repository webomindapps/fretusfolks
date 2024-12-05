<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FFCMModel extends Model
{
    protected $table = 'expenses';
    protected $fillable = [
        'date',
        'month',
        'nature_expenses',
        'amount',
        'status',
    ];

}
