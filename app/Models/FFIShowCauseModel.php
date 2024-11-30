<?php

namespace App\Models;

use App\Models\FHRMSModel;
use Illuminate\Database\Eloquent\Model;

class FFIShowCauseModel extends Model
{
    public $table = 'ffi_show_cause';

    protected $fillable = [
        'emp_id',
        'date',
        'content',
        'status',
        'date_of_update'
    ];
    public function show_letter()
    {
        return $this->belongsTo(FHRMSModel::class, 'emp_id', 'ffi_emp_id');
    }
}
