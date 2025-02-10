<?php

namespace App\Models;

use App\Models\States;
use App\Models\OfferLetter;
use App\Models\ClientManagement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CFISModel extends Model
{
    use HasFactory;
    protected $table = 'backend_management';

    protected $fillable = [
        'client_id',
        'entity_name',
        'console_id',
        'ffi_emp_id',
        'grade',
        'client_emp_id',
        'emp_name',
        'middle_name',
        'last_name',
        'interview_date',
        'joining_date',
        'contract_date',
        'designation',
        'department',
        'state',
        'location',
        'branch',
        'dob',
        'gender',
        'father_name',
        'father_dob',
        'father_aadhar_no',
        'mother_name',
        'mother_dob',
        'mother_aadhar_no',
        'religion',
        'languages',
        'mother_tongue',
        'maritial_status',
        'emer_contact_no',
        'emer_name',
        'emer_relation',
        'spouse_name',
        'spouse_dob',
        'spouse_aadhar_no',
        'no_of_childrens',
        'blood_group',
        'qualification',
        'phone1',
        'phone2',
        'email',
        'official_mail_id',
        'permanent_address',
        'present_address',
        'pan_no',
        'pan_path',
        'aadhar_no',
        'aadhar_path',
        'driving_license_no',
        'driving_license_path',
        'photo',
        'family_photo',
        'mother_photo',
        'father_photo',
        'spouse_photo',
        'resume',
        'bank_document',
        'bank_name',
        'bank_account_no',
        'bank_ifsc_code',
        'uan_no',
        'esic_no',
        'basic_salary',
        'hra',
        'conveyance',
        'medical_reimbursement',
        'special_allowance',
        'other_allowance',
        'st_bonus',
        'gross_salary',
        'emp_pf',
        'emp_esic',
        'pt',
        'total_deduction',
        'take_home',
        'employer_pf',
        'employer_esic',
        'mediclaim',
        'ctc',
        'status',
        'modify_by',
        'password',
        'refresh_code',
        'psd',
        'voter_id',
        'emp_form',
        'pf_esic_form',
        'payslip',
        'exp_letter',
        'modified_date',
        'data_status',
        'created_at',
        'created_by',
        'active_status',
        'dcs_approval',
        'hr_approval',
        'pan_status',
        'note',
    ];

    protected $casts = [
        'interview_date' => 'date',
        'joining_date' => 'date',
        'contract_date' => 'date',
        'dob' => 'date',
        'modified_date' => 'datetime',
        'created_at' => 'date',
        'status' => 'integer',
        'data_status' => 'integer',
        'active_status' => 'integer',
        'dcs_approval' => 'integer',
    ];

    protected $hidden = [
        'password',
        'refresh_code',
        'psd',
    ];

    public $timestamps = false;
    public function client()
    {
        return $this->belongsTo(ClientManagement::class, 'client_id', 'id');
    }
    public function clientstate()
    {
        return $this->belongsTo(States::class, 'state', 'id');
    }
    public function educationCertificates()
    {
        return $this->hasMany(EducationCertificate::class, 'emp_id', 'id');
    }

    public function otherCertificates()
    {
        return $this->hasMany(OtherCertificate::class, 'emp_id', 'id');
    }
    public function candidateDocuments()
    {
        return $this->hasMany(CandidateDocuments::class, 'emp_id', 'id');
    }
    public function assignedClients()
    {
        return $this->hasMany(HRMasters::class, 'user_id');
    }
    public function hrMasters()
    {
        return $this->hasMany(HRMasters::class, 'client_id', 'client_id');
    }
    public function employee()
    {
        return $this->hasMany(OfferLetter::class);
    }
    public function warningletter()
    {
        return $this->hasMany(WarningLetter::class);
    }
    public function showcauseletter()
    {
        return $this->hasMany(ShowcauseLetter::class);
    }
}
