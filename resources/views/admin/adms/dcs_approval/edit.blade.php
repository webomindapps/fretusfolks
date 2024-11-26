<x-applayout>
    <x-admin.breadcrumb title="Back End Management" />

    @if ($errors->any())
        <div class="col-lg-12 pb-4 px-2">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    <div class="col-lg-12 pb-4">
        <div class="form-card px-3">
            <form action="{{ route('admin.dcs_approval.edit', $candidate->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="card mt-3">
                    <div class="card-header header-elements-inline d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Back end Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-contents">
                            <div class="row">
                                <x-forms.input label="Entity Name: " type="text" name="entity_name" id="entity_name"
                                    :required="true" size="col-lg-6 mt-2" :value="old('entity_name', $candidate->entity_name)" />
                                <x-forms.select label="Enter Client Name:" name="client_id" id="client_id"
                                    :required="true" size="col-lg-6 mt-2" :options="FretusFolks::getClientname()" :value="old('client_id', $candidate->client_id)" />
                                <x-forms.input label="Enter FFI Employee ID: " type="text" name="ffi_emp_id"
                                    id="ffi_emp_id" :required="true" size="col-lg-6 mt-2" :value="old('ffi_emp_id', $candidate->ffi_emp_id)" />
                                <x-forms.input label="Console ID: " type="text" name="console_id" id="console_id"
                                    :required="false" size="col-lg-6 mt-2" :value="old('console_id', $candidate->console_id)" />
                                <x-forms.input label="Enter Client Employee ID: " type="text" name="client_emp_id"
                                    id="client_emp_id" :required="false" size="col-lg-6 mt-2" :value="old('client_emp_id', $candidate->client_emp_id)" />
                                <x-forms.input label="Grade: " type="text" name="grade" id="grade"
                                    :required="false" size="col-lg-6 mt-2" :value="old('grade', $candidate->grade)" />
                                <x-forms.input label="Enter Employee Name: " type="text" name="emp_name"
                                    id="emp_name" :required="true" size="col-lg-4 mt-2" :value="old('emp_name', $candidate->emp_name)" />
                                <x-forms.input label="Middle Name: " type="text" name="middle_name" id="middle_name"
                                    :required="false" size="col-lg-4 mt-2" :value="old('middle_name', $candidate->middle_name)" />
                                <x-forms.input label="Last Name: " type="text" name="last_name" id="last_name"
                                    :required="false" size="col-lg-4 mt-2" :value="old('last_name', $candidate->last_name)" />
                                <x-forms.input label="Interview Date:  " type="date" name="interview_date"
                                    id="interview_date" :required="true" size="col-lg-4 mt-2" :value="old('interview_date', $candidate->interview_date)" />
                                <x-forms.input label="Joining Date: " type="date" name="joining_date"
                                    id="joining_date" :required="true" size="col-lg-4 mt-2" :value="old('joining_date', $candidate->joining_date)" />
                                <x-forms.input label="DOL " type="date" name="contract_date" id="contract_date"
                                    :required="false" size="col-lg-4 mt-2" :value="old('contract_date', $candidate->contract_date)" />
                                <x-forms.input label="Enter Designation: " type="text" name="designation"
                                    id="designation" :required="true" size="col-lg-6 mt-2" :value="old('designation', $candidate->designation)" />
                                <x-forms.input label="Enter Department: " type="text" name="department"
                                    id="department" :required="false" size="col-lg-6 mt-2" :value="old('department', $candidate->department)" />
                                <x-forms.select label="State:" name="state" id="state" :required="true"
                                    size="col-lg-6 mt-2" :options="FretusFolks::getStates()" :value="old('state', $candidate->state)" />
                                <x-forms.input label="Location: " type="text" name="location" id="location"
                                    :required="true" size="col-lg-6 mt-2" :value="old('location', $candidate->location)" />
                                <x-forms.input label="Branch: " type="text" name="branch" id="branch"
                                    :required="false" size="col-lg-6 mt-2" :value="old('branch', $candidate->branch)" />
                                <x-forms.input label="DOB: " type="date" name="dob" id="dob"
                                    :required="true" size="col-lg-6 mt-2" :value="old('dob', $candidate->dob)" />
                                <x-forms.radio label="Gender: " :options="[
                                    ['value' => 'Male', 'label' => 'Male'],
                                    ['value' => 'Female', 'label' => 'Female'],
                                    ['value' => 'Other', 'label' => 'Other'],
                                ]" id="gender" name="gender"
                                    :required="true" size="col-lg-4 mt-2" :value="old('gender', $candidate->gender)" />
                                <x-forms.input label="Father Name:  " type="text" name="father_name"
                                    id="father_name" :required="true" size="col-lg-4 mt-2" :value="old('father_name', $candidate->father_name)" />
                                <x-forms.input label="Mother Name: " type="text" name="mother_name"
                                    id="mother_name" :required="true" size="col-lg-4 mt-2" :value="old('mother_name', $candidate->mother_name)" />
                                <x-forms.input label="Religion: " type="text" name="religion" id="religion"
                                    :required="true" size="col-lg-4 mt-2" :value="old('religion', $candidate->religion)" />
                                <x-forms.input label="Languages: " type="text" name="languages" id="languages"
                                    :required="true" size="col-lg-4 mt-2" :value="old('languages', $candidate->languages)" />
                                <x-forms.input label="Mother Tongue: " type="text" name="mother_tongue"
                                    id="mother_tongue" :required="true" size="col-lg-4 mt-2" :value="old('mother_tongue', $candidate->mother_tongue)" />
                                <x-forms.select label="Marital Status:" name="maritial_status" id="maritial_status"
                                    :required="true" size="col-lg-6 mt-2" :options="FretusFolks::getMarital()" :value="old('maritial_status', $candidate->maritial_status)" />
                                <x-forms.input label="Emergency Contact Person:" type="number"
                                    name="emer_contact_no" id="emer_contact_no" :required="true"
                                    size="col-lg-6 mt-2" :value="old('emer_contact_no', $candidate->emer_contact_no)" />
                                <x-forms.input label="Spouse Name: " type="text" name="spouse_name"
                                    id="spouse_name" :required="false" size="col-lg-4 mt-2" :value="old('spouse_name', $candidate->spouse_name)" />
                                <x-forms.input label="No of Children: " type="number" name="no_of_childrens"
                                    id="no_of_childrens" :required="false" size="col-lg-4 mt-2" :value="old('no_of_childrens', $candidate->no_of_childrens)" />
                                <x-forms.select label="Blood Group:" name="blood_group" id="blood_group"
                                    :required="true" size="col-lg-4 mt-2" :options="FretusFolks::getBlood()" :value="old('blood_group', $candidate->blood_group)" />
                                <x-forms.input label="Qualification:" type="number" name="qualification"
                                    id="qualification" :required="true" size="col-lg-6 mt-2" :value="old('qualification', $candidate->no_of_qualificationchildrens)" />
                                <x-forms.input label="Phone 1:" type="number" name="phone1" id="phone1"
                                    :required="true" size="col-lg-6 mt-2" :value="old('phone1', $candidate->phone1)" />
                                <x-forms.input label="Phone 2:" type="number" name="phone2" id="phone2"
                                    :required="false" size="col-lg-4 mt-2" :value="old('phone2', $candidate->phone2)" />
                                <x-forms.input label="Employee Email ID: " type="email" name="email"
                                    id="email" :required="true" size="col-lg-4 mt-2" :value="old('email', $candidate->email)" />
                                <x-forms.input label="Official Email ID: " type="email" name="official_mail_id"
                                    id="official_mail_id" :required="false" size="col-lg-4 mt-2"
                                    :value="old('official_mail_id', $candidate->official_mail_id)" />
                                <x-forms.textarea label="Enter Permanent Address:" name="permanent_address"
                                    id="permanent_address" :required="true" size="col-lg-6 mt-2"
                                    :value="old('permanent_address', $candidate->permanent_address)" />
                                <x-forms.textarea label="Enter Present Address:" name="present_address"
                                    id="present_address" :required="true" size="col-lg-6 mt-2" :value="old('present_address', $candidate->present_address)" />
                                <x-forms.input label="Enter PAN Card No::" type="text" name="pan_no"
                                    id="pan_no" :required="false" size="col-lg-6 mt-2" :value="old('pan_no', $candidate->pan_no)" />
                                <x-forms.input label="Attach PAN:" type="file" name="pan_path" id="pan_path"
                                    :required="false" size="col-lg-6 mt-2" :value="old('pan_path', $candidate->pan_path)" />
                                <x-forms.input label="Enter Adhar Card No:" type="number" name="aadhar_no"
                                    id="aadhar_no" :required="true" size="col-lg-6 mt-2" :value="old('aadhar_no', $candidate->aadhar_no)" />
                                <x-forms.input label="Attach Adhaar Card:" type="file" name="aadhar_path"
                                    id="aadhar_path" :required="true" size="col-lg-6 mt-2" :value="old('aadhar_path', $candidate->aadhar_path)" />
                                <x-forms.input label="Enter Driving License No:" type="text"
                                    name="driving_license_no" id="driving_license_no" :required="true"
                                    size="col-lg-6 mt-2" :value="old('driving_license_no', $candidate->driving_license_no)" />
                                <x-forms.input label="Attach Driving License:" type="file"
                                    name="driving_license_path" id="driving_license_path" :required="true"
                                    size="col-lg-6 mt-2" :value="old('driving_license_path', $candidate->driving_license_path)" />
                                <x-forms.input label="Photo:" type="file" name="photo" id="photo"
                                    :required="true" size="col-lg-6 mt-2" :value="old('photo', $candidate->photo)" />
                                <x-forms.input label="Resume:" type="file" name="resume" id="resume"
                                    :required="true" size="col-lg-6 mt-2" :value="old('resume', $candidate->resume)" />
                                <x-forms.input label="Enter Bank Name:" type="number" name="bank_name"
                                    id="bank_name" :required="false" size="col-lg-6 mt-2" :value="old('bank_name', $candidate->bank_name)" />
                                <x-forms.input label="Attach Bank Document:" type="file" name="bank_document"
                                    id="bank_document" :required="false" size="col-lg-6 mt-2" :value="old('bank_document', $candidate->bank_document)" />
                                <x-forms.input label="Enter Bank Account No::" type="text" name="bank_account_no"
                                    id="bank_account_no" :required="false" size="col-lg-6 mt-2" :value="old('bank_account_no', $candidate->bank_account_no)" />
                                <x-forms.input label="Repeat Bank Account No:" type="text" name="bank_account_no"
                                    id="bank_account_no" :required="false" size="col-lg-6 mt-2"
                                    :value="old('bank_account_no', $candidate->bank_account_no)" />
                                <x-forms.input label="Enter Bank IFSC CODE:" type="text" name="bank_ifsc_code"
                                    id="bank_ifsc_code" :required="false" size="col-lg-6 mt-2"
                                    :value="old('bank_ifsc_code', $candidate->bank_ifsc_code)" />
                                <x-forms.input label="UAN No:" type="text" name="uan_no" id="uan_no"
                                    :required="false" size="col-lg-6 mt-2" :value="old('uan_no', $candidate->uan_no)" />
                                <x-forms.input label="ESIC No:" type="text" name="esic_no" id="esic_no"
                                    :required="false" size="col-lg-6 mt-2" :value="old('esic_no', $candidate->esic_no)" />
                                <x-forms.select label="Status:" name="status" id="status" :required="false"
                                    size="col-lg-6 mt-2" :options="FretusFolks::getStatus()" :value="old('status', $candidate->status)" />
                                <label size="col-lg-12 mt-4"><strong>Salary Details</strong></label>
                                <div
                                    style="border:
                                    1px solid #d6c8c8;padding: 2%;margin-bottom: 1%;">
                                    <div class="row">
                                        <x-forms.input label="Basic Salary: " type="number" name="basic_salary"
                                            id="basic_salary" :required="true" size="col-lg-3 mt-1"
                                            :value="old('basic_salary', $candidate->basic_salary)" />
                                        <x-forms.input label="HRA: " type="number" name="hra" id="hra"
                                            :required="true" size="col-lg-3 mt-1" :value="old('hra', $candidate->hra)" />
                                        <x-forms.input label="Conveyance: " type="number" name="conveyance"
                                            id="conveyance" :required="true" size="col-lg-3 mt-1"
                                            :value="old('conveyance', $candidate->conveyance)" />
                                        <x-forms.input label="Medical Reimbursement:  " type="number"
                                            name="medical_reimbursement" id="medical_reimbursement"
                                            :required="true" size="col-lg-3 mt-2" :value="old('medical_reimbursement', $candidate->medical_reimbursement)" />
                                        <x-forms.input label="Special Allowance: " type="number"
                                            name="special_allowance" id="special_allowance" :required="true"
                                            size="col-lg-3 mt-2" :value="old('special_allowance', $candidate->special_allowance)" />
                                        <x-forms.input label="ST:" type="number" name="st_bonus" id="st_bonus"
                                            :required="true" size="col-lg-3 mt-2" :value="old('st_bonus', $candidate->st_bonus)" />
                                        <x-forms.input label="Other Allowance:  " type="number"
                                            name="other_allowance" id="other_allowance" :required="true"
                                            size="col-lg-3 mt-2" :value="old('other_allowance', $candidate->other_allowance)" />
                                        <x-forms.input label="Gross Salary: " type="number" name="gross_salary"
                                            id="gross_salary" :required="true" size="col-lg-3 mt-2"
                                            :value="old('gross_salary', $candidate->gross_salary)" />
                                        <x-forms.input label="Employee PF: " type="number" name="emp_pf"
                                            id="emp_pf" :required="true" size="col-lg-2 mt-2"
                                            :value="old('emp_pf', $candidate->emp_pf)" />
                                        <x-forms.input label="Employee ESIC :" type="number" name="emp_esic"
                                            id="emp_esic" :required="true" size="col-lg-2 mt-2"
                                            :value="old('emp_esic', $candidate->emp_esic)" />
                                        <x-forms.input label="PT: " type="number" name="pt" id="pt"
                                            :required="true" size="col-lg-2 mt-2" :value="old('pt', $candidate->pt)" />
                                        <x-forms.input label="Total Deduction:" type="number" name="total_deduction"
                                            id="total_deduction" :required="true" size="col-lg-3 mt-2"
                                            :value="old('total_deduction', $candidate->total_deduction)" />
                                        <x-forms.input label="Take Home Salary:" type="number" name="take_home"
                                            id="take_home" :required="true" size="col-lg-3 mt-2"
                                            :value="old('take_home', $candidate->take_home)" />
                                        <x-forms.input label="Employer PF: " type="number" name="employer_pf"
                                            id="employer_pf" :required="true" size="col-lg-3 mt-2"
                                            :value="old('employer_pf', $candidate->employer_pf)" />
                                        <x-forms.input label="Employer ESIC: " type="number" name="employer_esic"
                                            id="employer_esic" :required="true" size="col-lg-3 mt-2"
                                            :value="old('employer_esic', $candidate->employer_esic)" />
                                        <x-forms.input label="Mediclaim Insurance:  " type="number" name="mediclaim"
                                            id="mediclaim" :required="true" size="col-lg-3 mt-2"
                                            :value="old('mediclaim', $candidate->mediclaim)" />
                                        <x-forms.input label="Grand Total:  " type="number" name="ctc"
                                            id="ctc" :required="true" size="col-lg-3 mt-2"
                                            :value="old('basic_salary', $candidate->ctc)" />
                                    </div>
                                </div>
                                <label size="col-lg-12 mt-4"><strong>Upload Documents</strong></label>
                                <div
                                    style="border:
                                    1px solid #d6c8c8;padding: 2%;margin-bottom: 1%;">
                                    <div class="row">
                                        <x-forms.input label="Voter ID/ PVC/UL:" type="file" name="voter_id"
                                            id="voter_id" :required="false" size="col-lg-4 mt-2"
                                            :value="old('voter_id', $candidate->voter_id)" />
                                        <x-forms.input label="Attach Employee Form:" type="file" name="emp_form"
                                            id="emp_form" :required="false" size="col-lg-4 mt-2"
                                            :value="old('emp_form', $candidate->emp_form)" />
                                        {{-- <x-forms.input label="Education Certificate:" type="file" name="path"
                                        id="path" :required="false" size="col-lg-4 mt-2" :value="old('path', $candidate->path)" /> --}}
                                        <x-forms.input label="PF Form / ESIC:" type="file" name="pf_esic_form"
                                            id="pf_esic_form" :required="false" size="col-lg-3 mt-2"
                                            :value="old('pf_esic_form', $candidate->pf_esic_form)" />
                                        {{-- <x-forms.input label="Others:" type="file" name="bank_document"
                                        id="bank_document" :required="false" size="col-lg-3 mt-2" :value="old('bank_document', $candidate->bank_document)" /> --}}
                                        <x-forms.input label="Payslip/Fitness doc:" type="file" name="payslip"
                                            id="payslip" :required="false" size="col-lg-3 mt-2"
                                            :value="old('payslip', $candidate->payslip)" />
                                        <x-forms.input label="Exp Letter:" type="file" name="exp_letter"
                                            id="exp_letter" :required="false" size="col-lg-3 mt-2"
                                            :value="old('exp_letter', $candidate->exp_letter)" />
                                    </div>
                                </div>
                                <x-forms.input label="Password:" type="password" name="psd" id="psd"
                                    :required="true" size="col-lg-6 mt-2" :value="old('psd', $candidate->psd)" />
                                <x-forms.select label="Active Status:" name="active_status" id="active_status"
                                    :required="true" size="col-lg-6 mt-2" :options="FretusFolks::getStatus()" :value="old('active_status', $candidate->active_status)" />
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mt-4">
                                    <x-forms.button type="submit" label="Save" class="btn btn-primary" />
                                    <x-forms.button type="buton" label="Pending Save" class="btn btn-primary" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-applayout>
