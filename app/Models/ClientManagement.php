<?php

namespace App\Models;

use App\Models\CFISModel;
use Illuminate\Database\Eloquent\Model;

class ClientManagement extends Model
{
    protected $table = "client_management";
    protected $fillable = [
        'client_code',
        'client_ffi_id',
        'client_name',
        'land_line',
        'client_email',
        'contact_person',
        'contact_person_phone',
        'contact_person_email',
        'contact_name_comm',
        'contact_phone_comm',
        'contact_email_comm',
        'registered_address',
        'communication_address',
        'pan',
        'tan',
        'gstn',
        'website_url',
        'mode_agreement',
        'agreement_type',
        'other_agreement',
        'agreement_doc',
        'region',
        'service_state',
        'contract_start',
        'contract_end',
        'rate',
        'commercial_type',
        'remark',
        'status',
        'modify_by',
        'modify_date',
        'active_status',
    ];
    public function gstn()
    {
        return $this->belongsTo(ClientGstn::class);
    }
    public function state()
    {
        return $this->belongsTo(States::class, 'service_state', 'id');
    }
    public function client()
    {
        return $this->hasMany(CFISModel::class, 'client_id', 'id');
    }
    public function user()
    {
        return $this->hasMany(MuserMaster::class, 'id');
    }
    public function hrMasters()
    {
        return $this->hasMany(HRMasters::class, 'client_id', 'id');
    }
     public function incrementid()
    {
        return $this->hasMany(IncrementLetter::class, 'company_id');
    }
}
