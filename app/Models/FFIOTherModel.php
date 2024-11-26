<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FFIOTherModel extends Model
{
    public $table = 'ffi_other_certificate';

    public $fillable = [
        'emp_id',
        'path'
    ];

}
