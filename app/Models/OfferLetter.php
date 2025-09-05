<?php

namespace App\Models;

use App\Models\CFISModel;
use Illuminate\Database\Eloquent\Model;

class OfferLetter extends Model
{
    public $table = 'offer_letter';
    protected $fillable = [
        'company_id',
        'employee_id',
        'emp_name',
        'phone1',
        'entity_name',
        'joining_date',
        'location',
        'department',
        'father_name',
        'tenure_month',
        'date',
        'tenure_date',
        'offer_letter_type',
        'status',
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
        'lwf',
        'other_deduction',
        'total_deduction',
        'take_home',
        'employer_pf',
        'employer_esic',
        'employer_lwf',
        'mediclaim',
        'ctc',
        'leave_wage',
        'email',
        'notice_period',
        'salary_date',
        'designation',
        'offer_letter_path',
        'gender_salutation',
    ];
    public function employee()
    {
        return $this->belongsTo(CFISModel::class, 'employee_id', 'ffi_emp_id');
    }

}
