<?php

namespace App\Models;

use App\Models\FHRMSModel;
use Illuminate\Database\Eloquent\Model;

class FFITerminationModel extends Model
{
    public $table = 'ffi_termination_letter';

    protected $fillable = [
        'emp_id',
        'date',
        'absent_date',
        'show_cause_date',
        'termination_date',
        'content',
        'status',
        'date_of_update'
    ];
    public function term_letter()
    {
        return $this->belongsTo(FHRMSModel::class, 'emp_id', 'ffi_emp_id');
    }
}
