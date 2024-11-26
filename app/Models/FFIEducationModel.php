<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FFIEducationModel extends Model
{
    public $table = 'ffi_education_certificate';
    public $fillable = [
        'emp_id',
        'path'
    ];
}
