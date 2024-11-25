<?php

namespace App\Models;

use App\Models\States;
use Illuminate\Database\Eloquent\Model;

class FHRMSModel extends Model
{
    public $table = 'fhrms';
    protected $fillable = [
        'ffi_emp_id',
        'emp_name',
        'interview_date',
        'joining_date',
        'contract_date',
        'designation',
        'department',
        'state',
        'location',
        'dob',
        'gender',
        'father_name',
        'blood_group',
        'qualification',
        'phone1',
        'phone2',
        'email',
        'permanent_address',
        'present_address',
        'pan_no',
        'pan_path',
        'aadhar_no',
        'aadhar_path',
        'driving_license_no',
        'driving_license_path',
        'photo',
        'resume',
        'bank_document',
        'bank_name',
        'bank_account_no',
        'bank_ifsc_code',
        'uan_generatted',
        'uan_type',
        'uan_no',
        'basic_salary',
        'hra',
        'conveyance',
        'medical_reimbursement',
        'special_allowance',
        'other_allowance',
        'st_bonus',
        'gross_salary',
        'pf_percentage',
        'emp_pf',
        'esic_percentage',
        'emp_esic',
        'pt',
        'total_deduction',
        'take_home',
        'employer_pf_percentage',
        'employer_pf',
        'employer_esic_percentage',
        'employer_esic',
        'mediclaim',
        'ctc',
        'status',
        'modify_by',
        'password',
        'psd',
        'voter_id',
        'emp_form',
        'pf_esic_form',
        'payslip',
        'exp_letter',
        'modified_date',
        'data_status',
        'ref_no',
        'active_status',
    ];
    public function state()
    {
        return $this->belongsTo(States::class);
    }
}
