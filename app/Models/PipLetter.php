<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PipLetter extends Model
{
    public $table = 'pip_letter';

    protected $fillable = [
        'from_name',
        'emp_id',
        'date',
        'content',
        'observation',
        'goals',
        'updates',
        'timeline',
        'status',
        'date_of_update',
        'pip_letter_path'
    ];
    public function pip_letters()
    {
        return $this->belongsTo(CFISModel::class, 'emp_id', 'ffi_emp_id');
    }
}
