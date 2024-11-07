<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MuserMaster extends Model
{
    public $table = 'muser_master';
    protected $fillable = ['emp_id', 'name', 'email', 'username', 'password', 'enc_pass', 'user_type', 'status', 'date', 'ref_no'];
}
