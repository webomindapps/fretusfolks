<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TerminationLetter extends Model
{
    public $table = "termination_letter";
    protected $fillable = ['emp_id', 'date', 'absent_date', 'show_cause_date', 'termination_date', 'content', 'status', 'date_of_update','termination_letter_path'];

    public function term_letter()
    {
        return $this->belongsTo(CFISModel::class, 'emp_id', 'ffi_emp_id');
    }
}
