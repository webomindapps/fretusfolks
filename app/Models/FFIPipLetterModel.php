<?php

namespace App\Models;

use App\Models\FHRMSModel;
use Illuminate\Database\Eloquent\Model;

class FFIPipLetterModel extends Model
{
    public $table = 'ffi_pip_letter';

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
        'date_of_update'
    ];
    public function pip_letter()
    {
        return $this->belongsTo(FHRMSModel::class, 'emp_id', 'ffi_emp_id');
    }
}
