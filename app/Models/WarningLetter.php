<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarningLetter extends Model
{
    public $table = 'warning_letter';
    protected $fillable = ['id', 'emp_id', 'date', 'content', 'status', 'date_of_update', 'warning_letter_path'];

    public function warningletter()
    {
        return $this->belongsTo(CFISModel::class,'emp_id','ffi_emp_id');
    }
}
