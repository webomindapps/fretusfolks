<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankDetails extends Model
{
    public $table = 'bank_details';

    public $fillable = [
        'emp_id',
        'bank_name',
        'bank_account_no',
        'bank_document',
        'bank_ifsc_code',
        'bank_status',
        'status',
    ];
}
