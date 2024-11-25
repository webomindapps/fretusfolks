<?php

namespace App\Imports;

use Log;
use Exception;
use Carbon\Carbon;
use App\Models\FHRMSModel;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class FHRMSImport implements SkipsEmptyRows, ToModel, WithHeadingRow, SkipsOnFailure, WithValidation, WithBatchInserts, WithChunkReading, WithUpserts
{
    use SkipsFailures;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {
        try {
            $employee = FHRMSModel::create([
                'ffi_emp_id' => $row['ffi_emp_id'],
                'emp_name' => $row['emp_name'],
                'interview_date' => Carbon::createFromFormat('d-m-Y', $row['interview_date'])->format('Y-m-d'),
                'joining_date' => Carbon::createFromFormat('d-m-Y', $row['joining_date'])->format('Y-m-d'),
                'contract_date' => Carbon::createFromFormat('d-m-Y', $row['contract_date'])->format('Y-m-d'),
                'designation' => $row['designation'],
                'department' => $row['department'],
                'state' => $row['state'],
                'location' => $row['location'],
                'dob' => Carbon::createFromFormat('d-m-Y', $row['dob'])->format('Y-m-d'),
                'gender' => $row['gender'],
                'father_name' => $row['father_name'],
                'blood_group' => $row['blood_group'],
                'qualification' => $row['qualification'],
                'phone1' => $row['phone1'],
                'phone2' => $row['phone2'],
                'email' => $row['email'],
                'permanent_address' => $row['permanent_address'],
                'present_address' => $row['present_address'],
                'pan_no' => $row['pan_no'],
                'pan_path' => $row['pan_path'],
                'aadhar_no' => $row['aadhar_no'],
                'aadhar_path' => $row['aadhar_path'],
                'driving_license_no' => $row['driving_license_no'],
                'driving_license_path' => $row['driving_license_path'],
                'photo' => $row['photo'],
                'resume' => $row['resume'],
                'bank_document' => $row['bank_document'],
                'bank_name' => $row['bank_name'],
                'bank_account_no' => $row['bank_account_no'],
                'bank_ifsc_code' => $row['bank_ifsc_code'],
                'uan_generatted' => $row['uan_generatted'],
                'uan_type' => $row['uan_type'],
                'uan_no' => $row['uan_no'],
                'basic_salary' => $row['basic_salary'],
                'hra' => $row['hra'],
                'conveyance' => $row['conveyance'],
                'medical_reimbursement' => $row['medical_reimbursement'],
                'special_allowance' => $row['special_allowance'],
                'other_allowance' => $row['other_allowance'],
                'st_bonus' => $row['st_bonus'],
                'gross_salary' => $row['gross_salary'],
                'emp_pf' => $row['emp_pf'],
                'emp_esic' => $row['emp_esic'],
                'pt' => $row['pt'],
                'total_deduction' => $row['total_deduction'],
                'take_home' => $row['take_home'],
                'employer_pf' => $row['employer_pf'],
                'employer_esic' => $row['employer_esic'],
                'mediclaim' => $row['mediclaim'],
                'ctc' => $row['ctc'],
                'status' => 0,
                'password' => $row['password'],
                'voter_id' => $row['voter_id'],
                'emp_form' => $row['emp_form'],
                'pf_esic_form' => $row['pf_esic_form'],
                'payslip' => $row['payslip'],
                'exp_letter' => $row['exp_letter'],

            ]);
            return $employee;
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
    public function rules(): array
    {
        return [
            'ffi_emp_id' => 'required',
            'emp_name' => 'required|string|max:255',
            'interview_date' => 'required|date',
            'joining_date' => 'required|date',
            'contract_date' => 'required|date',
            'designation' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'state' => 'nullable|string',
            'location' => 'required|string|max:255',
            'dob' => 'required|date',
            'father_name' => 'required|string|max:255',
            'gender' => 'nullable',
            'blood_group' => 'required|string',
            'qualification' => 'required|string|max:255',
            'phone1' => 'required|digits:10',
            'phone2' => 'nullable|digits:10',
            'email' => 'nullable|email|max:255',
            'permanent_address' => 'required|string',
            'present_address' => 'required|string',
            'pan_no' => 'nullable|string|max:20',
            'pan_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'aadhar_no' => 'required|string|max:20',
            'aadhar_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'driving_license_no' => 'nullable|string|max:20',
            'driving_license_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'resume' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'bank_name' => 'nullable|string|max:255',
            'bank_document' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'bank_account_no' => 'nullable|string|max:20',
            'repeat_acc_no' => 'nullable|string|same:bank_account_no',
            'bank_ifsc_code' => 'required|string|max:20',
            'uan_generatted' => 'nullable|string|max:255',
            'uan_type' => 'nullable|string',
            'uan_no' => 'nullable|string|max:20',
            'status' => 'nullable',
            'basic_salary' => 'required|numeric',
            'hra' => 'required|numeric',
            'conveyance' => 'required|numeric',
            'medical_reimbursement' => 'required|numeric',
            'special_allowance' => 'required|numeric',
            'other_allowance' => 'required|numeric',
            'st_bonus' => 'required|numeric',
            'gross_salary' => 'required|numeric',
            'emp_pf' => 'required|numeric',
            'emp_esic' => 'required|numeric',
            'pt' => 'required|numeric',
            'total_deduction' => 'required|numeric',
            'take_home' => 'required|numeric',
            'employer_pf' => 'required|numeric',
            'employer_esic' => 'required|numeric',
            'mediclaim' => 'required|numeric',
            'ctc' => 'required|numeric',
            'voter_id' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'emp_form' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'pf_esic_form' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'payslip' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'exp_letter' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'education_certificates' => 'nullable|array',
            'education_certificates.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
            'others' => 'nullable|array',
            'others.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
            'password' => 'required|string|min:8',
        ];
    }
    public function batchSize(): int
    {
        return 50;
    }

    public function chunkSize(): int
    {
        return 50;
    }
    public function uniqueBy()
    {
        return 'ffi_emp_id';
    }
}
