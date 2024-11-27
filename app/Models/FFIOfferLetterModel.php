<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FFIOfferLetterModel extends Model
{
    public $table = 'ffi_offer_letter';
    protected $fillable = [
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
        'pf_percentage',
        'emp_pf',
        'esic_percentage',
        'emp_esic',
        'pt',
        'total_deduction',
        'employer_pf_percentage',
        'employer_pf',
        'employer_esic_percentage',
        'employer_esic',
        'mediclaim',
        'ctc'
    ];



}
