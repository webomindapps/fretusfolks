<?php

namespace App\Models;

use App\Models\States;
use App\Models\FFIAssetModel;
use App\Models\FFIWarningModel;
use App\Models\FFIPipLetterModel;
use App\Models\FFIShowCauseModel;
use App\Models\FFIOfferLetterModel;
use App\Models\FFITerminationModel;
use App\Models\FFIIncrementLetterModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FHRMSModel extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

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
    public function stateRelation()
    {
        return $this->belongsTo(States::class, 'state', 'id');
    }
    public function employee()
    {
        return $this->hasMany(FFIOfferLetterModel::class);
    }
    public function incrementletter()
    {
        return $this->hasMany(FFIIncrementLetterModel::class);
    }
    public function term_letter()
    {
        return $this->hasMany(FFITerminationModel::class);
    }
    public function warning_letter()
    {
        return $this->hasMany(FFIWarningModel::class);
    }
    public function show_letter()
    {
        return $this->hasMany(FFIShowCauseModel::class);
    }
    public function pip_letter()
    {
        return $this->hasMany(FFIPipLetterModel::class);
    }
    public function assets()
    {
        return $this->hasMany(FFIAssetModel::class, 'employee_id');
    }
}
