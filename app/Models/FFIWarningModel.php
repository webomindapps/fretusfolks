<?php

namespace App\Models;

use App\Models\FHRMSModel;
use Illuminate\Database\Eloquent\Model;

class FFIWarningModel extends Model
{
    public $table = 'ffi_warning_letter';

    protected $fillable = [
        'emp_id',
        'date',
        'content',
        'status',
        'date_of_update'
    ];
    public function warning_letter()
    {
        return $this->belongsTo(FHRMSModel::class, 'emp_id', 'ffi_emp_id');
    }
}
