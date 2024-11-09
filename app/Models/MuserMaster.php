<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as ModelsRole;

class MuserMaster extends Model
{
    public $table = 'muser_master';
    protected $fillable = ['emp_id', 'name', 'email', 'username', 'password', 'enc_pass', 'user_type', 'status', 'date', 'ref_no'];

    public function role()
    {
        return $this->belongsTo(ModelsRole::class, 'user_type');
    }
}
