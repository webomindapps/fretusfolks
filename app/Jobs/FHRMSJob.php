<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\States;
use App\Models\FHRMSModel;
use Illuminate\Bus\Batchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class FHRMSJob implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels, Batchable;

    protected $data;
    protected $created_by;

    public function __construct($data, $created_by)
    {
        $this->data = $data;
        $this->created_by = $created_by;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Log::info('Imported employee', $this->data);
        foreach ($this->data as $row) {
            $state = States::where('state_name', $row['State'] ?? null)->first();

            $employee = FHRMSModel::create([
                'ffi_emp_id' => $row['FFI_Emp_ID'] ?? null,
                'emp_name' => $row['Emp_Name'] ?? null,
                'interview_date' => !empty($row['Interview_Date']) ? Carbon::createFromFormat('d-m-Y', $row['Interview_Date'])->format('Y-m-d') : null,
                'joining_date' => !empty($row['Joining_Date']) ? Carbon::createFromFormat('d-m-Y', $row['Joining_Date'])->format('Y-m-d') : null,
                'contract_date' => !empty($row['contract_date']) ? Carbon::createFromFormat('d-m-Y', $row['contract_date'])->format('Y-m-d') : null,
                'designation' => $row['Designation'] ?? null,
                'department' => $row['Department'] ?? null,
                'state' => $state?->id,
                'location' => $row['Location'] ?? null,
                'dob' => !empty($row['Date_of_Birth']) ? Carbon::createFromFormat('d-m-Y', $row['Date_of_Birth'])->format('Y-m-d') : null,

                // 'dob' => Carbon::createFromFormat('d-m-Y', $row['Date_of_Birth'])->format('Y-m-d'),
                // 'gender' => match (strtolower(trim($row['Gender']))) {
                //     'Others' => 3,
                //     'Male' => 1,
                //     'Female' => 2,
                //     default => null,
                // },
                'gender' => $row['Gender'] ?? null,
                'father_name' => $row['Father_Name'] ?? null,
                'blood_group' => $row['Blood_Group'] ?? null,
                'qualification' => $row['Qualification'] ?? null,
                'phone1' => $row['Phone_No'] ?? null,
                'phone2' => $row['Phone_No2'] ?? null,
                'email' => $row['Email'] ?? null,
                'permanent_address' => $row['Permanent_Address'] ?? null,
                'present_address' => $row['Present_Address'] ?? null,
                'pan_no' => $row['PAN_No'] ?? null,
                'pan_path' => $row['pan_path'] ?? null,
                'aadhar_no' => $row['Aadhar_No'] ?? null,
                'aadhar_path' => $row['aadhar_path'] ?? null,
                'driving_license_no' => $row['Driving_License_No'] ?? null,
                'driving_license_path' => $row['driving_license_path'] ?? null,
                'photo' => $row['photo'] ?? null,
                'resume' => $row['resume'] ?? null,
                'bank_document' => $row['bank_document'] ?? null,
                'bank_name' => $row['Bank_Name'] ?? null,
                'bank_account_no' => $row['Bank_Account_No'] ?? null,
                'bank_ifsc_code' => $row['Bank_IFSC_Code'] ?? null,
                'uan_generatted' => $row['uan_generatted'] ?? null,
                'uan_type' => $row['uan_type'] ?? null,
                'uan_no' => $row['UAN_No'] ?? null,
                'basic_salary' => $row['Basic_Salary'] ?? null,
                'hra' => $row['HRA'] ?? null,
                'conveyance' => $row['Conveyance'] ?? null,
                'medical_reimbursement' => $row['Medical_Reimbursement'] ?? null,
                'special_allowance' => $row['Special_Allowance'] ?? null,
                'other_allowance' => $row['Other_Allowance'] ?? null,
                'st_bonus' => $row['ST_Bonus'] ?? null,
                'gross_salary' => $row['Gross_Salary'] ?? null,
                'emp_pf' => $row['Emp_PF'] ?? null,
                'emp_esic' => $row['Emp_ESIC'] ?? null,
                'pt' => $row['PT'] ?? null,
                'total_deduction' => $row['Total_Deduction'] ?? null,
                'take_home' => $row['Take_Home'] ?? null,
                'employer_pf' => $row['Employer_PF'] ?? null,
                'employer_esic' => $row['Employer_ESIC'] ?? null,
                'mediclaim' => $row['Mediclaim'] ?? null,
                'ctc' => $row['CTC'] ?? null,
                'status' => 1,
                'psd' => $row['Password'] ?? null,
                'password' => isset($row['Password']) ? bcrypt($row['Password']) : null,
                'voter_id' => $row['voter_id'] ?? null,
                'emp_form' => $row['emp_form'] ?? null,
                'pf_esic_form' => $row['pf_esic_form'] ?? null,
                'payslip' => $row['payslip'] ?? null,
                'exp_letter' => $row['exp_letter'] ?? null,
            ]);
        }
        \Log::info('Imported employee last', $employee->toArray());



    }
}
