<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class MuserMaster extends Authenticatable
{
    use HasRoles;
    public $table = 'muser_master';
    protected $fillable = ['emp_id', 'name', 'email', 'username', 'password', 'enc_pass', 'user_type', 'status', 'date', 'ref_no'];
    public function getAuthPassword()
    {
        return $this->enc_pass;
    }
    public function hrMasters()
    {
        return $this->hasMany(HRMasters::class, 'user_id', 'id');
    }
    public function client()
    {
        return $this->belongsTo(ClientManagement::class, 'id');
    }
}
