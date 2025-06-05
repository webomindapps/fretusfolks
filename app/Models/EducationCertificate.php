<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationCertificate extends Model
{
    public $table = 'education_certificate';

    public $fillable = [
        'emp_id',
        'path',
        'status',
    ];
}
