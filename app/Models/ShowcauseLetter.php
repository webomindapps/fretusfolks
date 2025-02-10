<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShowcauseLetter extends Model
{
    public $table="show_cause";
    protected $fillable=['id', 'emp_id', 'date', 'content', 'status', 'date_of_update', 'showcause_letter_path'];

    public function showcauseletter()
    {
        return $this->belongsTo(CFISModel::class,'emp_id','ffi_emp_id');
    }
}
