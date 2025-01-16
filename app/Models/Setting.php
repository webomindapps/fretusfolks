<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'logo',
        'company_name',
        'addr_line1',
        'addr_line2',
        'gst_no',
        'pan_no',
        'email',
        'phone',
        'website',
    ];
}
