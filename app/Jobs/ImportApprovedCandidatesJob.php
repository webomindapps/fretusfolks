<?php

namespace App\Jobs;

use App\Models\CFISModel;
use App\Models\BankDetails;
use App\Models\DCSChildren;
use App\Models\States;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use App\Models\ClientManagement;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ImportApprovedCandidatesJob implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels, Batchable;

    protected $data;
    protected $created_by;

    /**
     * Create a new job instance.
     */
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

        // dd($this->data);
        foreach ($this->data as $row) {

            $state = States::where('state_name', $row['State'])->first();
            $client = ClientManagement::where('client_name', $row['Client_Name'])->first();

            $employee = CFISModel::create([
                'entity_name' => $row['Client_Name'],
                'ffi_emp_id' => $row['FFI_EMP_ID'] ?? null,
                'client_emp_id' => $row['Client_ID'] ?? null,
                'console_id' => $row['console_id'] ?? null,
                'grade' => $row['Grade'] ?? null,
                'emp_name' => $row['Emp_Name'],
                'email' => $row['Email'] ?? null,
                'interview_date' => isset($row['Interview_Date']) && is_numeric($row['Interview_Date'])
                    ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['Interview_Date'])->format('Y-m-d')
                    : null,
                'joining_date' => isset($row['Joining_Date']) && is_numeric($row['Joining_Date'])
                    ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['Joining_Date'])->format('Y-m-d')
                    : null,
                'contract_date' => isset($row['Contract_End_Date']) && is_numeric($row['Contract_End_Date'])
                    ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['Contract_End_Date'])->format('Y-m-d')
                    : null,

                'designation' => $row['Designation'] ?? null,
                'department' => $row['Department'] ?? null,
                'location' => $row['Location'] ?? null,
                'branch' => $row['Branch'] ?? null,
                'gender' => $row['Gender'] ?? null,
                'dob' => isset($row['Date_of_Birth']) && is_numeric($row['Date_of_Birth'])
                    ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['Date_of_Birth'])->format('Y-m-d')
                    : null,
                'qualification' => $row['Qualification'] ?? null,
                'father_name' => $row['Father_Name'] ?? null,
                'father_dob' => isset($row['Father_DOB']) && is_numeric($row['Father_DOB'])
                    ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['Father_DOB'])->format('Y-m-d')
                    : null,
                'father_aadhar_no' => $row['Father_Aadhar'] ?? null,
                'mother_name' => $row['Mother_Name'] ?? null,
                'mother_dob' => isset($row['Mother_DOB']) && is_numeric($row['Mother_DOB'])
                    ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['Mother_DOB'])->format('Y-m-d')
                    : null,
                'mother_aadhar_no' => $row['Mother_Aadhar'] ?? null,
                'religion' => $row['Religion'] ?? null,
                'languages' => $row['Languages'] ?? null,
                'mother_tongue' => $row['Mother_Tongue'] ?? null,
                'maritial_status' => $row['Maritial_Status'] ?? null,
                'spouse_name' => $row['Spouse_Name'] ?? null,
                'spouse_dob' => isset($row['Spouse_DOB']) && is_numeric($row['Spouse_DOB'])
                    ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['Spouse_DOB'])->format('Y-m-d')
                    : null,
                'spouse_aadhar_no' => $row['Spouse_Aadhar'] ?? null,
                'no_of_childrens' => $row['No_of_Childrens'] ?? null,
                'emer_contact_no' => $row['Emer_Contact_No'] ?? null,
                'emer_name' => $row['Emer_Name'] ?? null,
                'emer_relation' => $row['Emer_Relation'] ?? null,
                'blood_group' => $row['Blood_Group'] ?? null,
                'phone1' => $row['Phone_No'] ?? null,
                'official_mail_id' => $row['Official_Mail_ID'] ?? null,
                'permanent_address' => $row['Permanent_Address'] ?? null,
                'present_address' => $row['Present_Address'] ?? null,
                'pan_no' => $row['Pan_No'] ?? null,
                'aadhar_no' => $row['Aadhar_No'] ?? null,
                'driving_license_no' => $row['Driving_License_No'] ?? null,
                'uan_no' => $row['UAN_No'] ?? null,
                'esic_no' => $row['ESIC_No'] ?? null,
                'basic_salary' => $row['Basic_Salary'] ?? null,
                'hra' => $row['HRA'] ?? null,
                'conveyance' => $row['conveyance'] ?? null,
                'medical_reimbursement' => $row['medical_reimbursement'] ?? null,
                'special_allowance' => $row['Special_Allowance'] ?? null,
                'other_allowance' => $row['Other_Allowance'] ?? null,
                'st_bonus' => $row['ST_Bonus'] ?? null,
                'gross_salary' => $row['Gross_Salary'] ?? null,
                'emp_pf' => $row['Emp_PF'] ?? null,
                'emp_esic' => $row['Emp_ESIC'] ?? null,
                'pt' => $row['PT'] ?? null,
                'lwf' => $row['Emp_LWF'] ?? null,
                'total_deduction' => $row['Total_Deduction'] ?? null,
                'take_home' => $row['Take_Home'] ?? null,
                'employer_pf' => $row['Employer_PF'] ?? null,
                'employer_esic' => $row['Employer_ESIC'] ?? null,
                'employee_lwf' => $row['Employer_LWF'] ?? null,
                'mediclaim' => $row['Mediclaim'] ?? null,
                'ctc' => $row['CTC'] ?? null,
                'psd' => $row['Password'] ?? null,
                'password' => isset($row['Password']) ? bcrypt($row['Password']) : null,
                'dcs_approval' => match (strtolower(trim($row['DCS_Approval'] ?? ''))) {
                    'Approved' => 1,
                    'Pending' => 0,
                    'Rejected' => 2,
                    default => null,
                },
                'hr_approval' => 0,
                'status' => 1,
                // 'dcs_approval' => 0,
                'data_status' => 0,
                'created_by' => $this->created_by,
                'client_id' => $client?->id,
                'state' => $state?->id,

            ]);
            \Log::info('Imported employee last', $employee->toArray());
            for ($i = 1; $i <= 4; $i++) {
                $childNameKey = "Child_{$i}_Name";
                $childDobKey = "Child_{$i}_DOB";
                $childGenderKey = "Child_{$i}_Gender";

                if (!empty($row[$childNameKey])) {
                    DCSChildren::create([
                        'emp_id' => $employee->id,
                        'name' => $row[$childNameKey],
                        'dob' => isset($row[$childDobKey]) && is_numeric($row[$childDobKey])
                            ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[$childDobKey])->format('Y-m-d')
                            : null,
                        'gender' => $row[$childGenderKey] ?? null,
                    ]);
                }
            }
            BankDetails::create([
                'emp_id' => $employee->id,
                'bank_name' => $row['Bank_Name'] ?? null,
                'bank_account_no' => $row['Bank_Account_No'] ?? null,
                'bank_ifsc_code' => $row['Bank_IFSC_Code'] ?? null,
                'bank_status' => 0,
            ]);
        }

        // if (!empty($info)) {
        //     try {
        //         foreach ($info as $data) {
        //             CFISModel::create($data);
        //         }
        //         // dd('Data saved successfully!');
        //     } catch (\Exception $e) {
        //         // dd('Error: ', $e->getMessage());
        //     }
        // }
    }
}
