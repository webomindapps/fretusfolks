<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DCSChildren extends Model
{
    public $table = 'children';

    public $fillable = [
        'emp_id',
        'name',
        'dob',
        'gender',
        'photo',
        'aadhar_no'
    ];
}
