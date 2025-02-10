<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncrementLetter extends Model
{
    public $table = "increment_letter";
    protected $fillable = [
        'company_id',
        'employee_id',
        'date',
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
        'total_deduction',
        'take_home',
        'employer_pf',
        'employer_esic',
        'mediclaim',
        'ctc',
        'content',
        'effective_date',
        'Increment_Percentage',
        'designation',
        'old_ctc',
        'old_designation',
        'emp_name',
        'increment_path',
    ];
    public function incrementletters()
    {
        return $this->belongsTo(FHRMSModel::class, 'employee_id', 'ffi_emp_id');
    }
}
