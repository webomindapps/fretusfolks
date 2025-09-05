<?php

namespace App\Models;

use App\Models\States;
use App\Models\ClientManagement;
use Illuminate\Database\Eloquent\Model;

class OtherPayslip extends Model
{
    protected $table = 'other_payslips';
    protected $fillable = [
        'state_id',
        'client_id',
        'ffi_emp_id',
        'year',
        'month',
        'path',
        'status',
    ];

    public function client()
    {
        return $this->belongsTo(ClientManagement::class, 'client_id', 'id');
    }
    public function state()
    {
        return $this->hasOne(States::class, 'id', 'state_id');
    }
}
