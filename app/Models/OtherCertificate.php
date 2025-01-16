<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtherCertificate extends Model
{
    public $table = 'other_certificate';

    public $fillable = [
        'emp_id',
        'path'
    ];
}
