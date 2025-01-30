<x-applayout>
    <x-admin.breadcrumb title="Back End Management" />
    <style>
        .btn-custom {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>
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
            <form action="{{ route('admin.dcs_approval.edit', $candidate->id) }}" method="POST" id="pendingDetailsForm"
                enctype="multipart/form-data">
                @csrf
                <div class="card mt-3">
                    <div class="card-header header-elements-inline d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Back end Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-contents">
                            <div class="row">
                                <input type="hidden" name="id" id="candidate_id"
                                    value="{{ $candidate->id ?? '' }}">

                                {{-- <x-forms.input label="Entity Name: " type="text" name="entity_name" id="entity_name"
                                    :required="true" size="col-lg-6 mt-2" :value="old('entity_name', $candidate->entity_name)" /> --}}
                                <x-forms.select label="Enter Client Name:" name="client_id" id="client_id"
                                    :required="true" size="col-lg-6 mt-2" :options="FretusFolks::getClientname()" :value="old('client_id', $candidate->client_id)" />
                                {{-- <x-forms.input label="FFI Employee ID:" type="text" name="ffi_emp_id" id="ffi_emp_id"
                                    :required="true" size="col-lg-6 mt-2" :value="$uniqueId" /> --}}
                                <x-forms.input label="Console ID: " type="text" name="console_id" id="console_id"
                                    :required="false" size="col-lg-6 mt-2" :value="old('console_id', $candidate->console_id)" />
                                <x-forms.input label="Enter Client Employee ID: " type="text" name="client_emp_id"
                                    id="client_emp_id" :required="false" size="col-lg-6 mt-2" :value="old('client_emp_id', $candidate->client_emp_id)" />
                                <x-forms.input label="Grade: " type="text" name="grade" id="grade"
                                    :required="false" size="col-lg-6 mt-2" :value="old('grade', $candidate->grade)" />
                                <x-forms.input label="Enter Employee Name: " type="text" name="emp_name"
                                    id="emp_name" :required="true" size="col-lg-6 mt-2" :value="old('emp_name', $candidate->emp_name)" />
                                {{-- <x-forms.input label="Middle Name: " type="text" name="middle_name" id="middle_name"
                                    :required="false" size="col-lg-4 mt-2" :value="old('middle_name', $candidate->middle_name)" />
                                <x-forms.input label="Last Name: " type="text" name="last_name" id="last_name"
                                    :required="false" size="col-lg-4 mt-2" :value="old('last_name', $candidate->last_name)" /> --}}
                                <x-forms.input label="Interview Date:  " type="date" name="interview_date"
                                    id="interview_date" :required="true" size="col-lg-6 mt-2"
                                    value="{{ old('interview_date', $candidate->interview_date ? $candidate->interview_date->format('Y-m-d') : '') }}" />

                                <x-forms.input label="Joining Date: " type="date" name="joining_date"
                                    id="joining_date" :required="true" size="col-lg-6 mt-2"
                                    value="{{ old('joining_date', $candidate->joining_date ? $candidate->joining_date->format('Y-m-d') : '') }}" />
                                {{-- <x-forms.input label="DOL " type="date" name="contract_date" id="contract_date"
                                    :required="false" size="col-lg-4 mt-2"
                                    value="{{ old('contract_date', $candidate->contract_date ? $candidate->contract_date->format('Y-m-d') : '') }}" /> --}}

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
                                    :required="true" size="col-lg-6 mt-2"
                                    value="{{ old('dob', $candidate->dob ? $candidate->dob->format('Y-m-d') : '') }}" />
                                <x-forms.radio label="Gender: " :options="[
                                    ['value' => 'Male', 'label' => 'Male'],
                                    ['value' => 'Female', 'label' => 'Female'],
                                    ['value' => 'Other', 'label' => 'Other'],
                                ]" id="gender" name="gender"
                                    :required="true" size="col-lg-6 mt-2" :value="old('gender', $candidate->gender)" />
                                <x-forms.select label="Marital Status:" name="maritial_status" id="maritial_status"
                                    :required="true" size="col-lg-6 mt-2" :options="FretusFolks::getMarital()" :value="old('maritial_status', $candidate->maritial_status)" />
                                <div id="married-fields" style="display: none;" class="col-12">
                                    <div class="row">
                                        <x-forms.input label="Spouse Name:" type="text" name="spouse_name"
                                            id="spouse_name" :required="false" size="col-lg-6 mt-2"
                                            :value="old('spouse_name', $candidate->spouse_name)" />
                                        <x-forms.input label="Spouse's DOB: " type="date" name="spouse_dob"
                                            id="spouse_dob" :required="false" size="col-lg-6 mt-2"
                                            :value="old('spouse_dob', $candidate->spouse_dob)" />
                                        <x-forms.input label="Enter Spouse Adhar Card No:" type="number"
                                            name="spouse_aadhar_no" id="spouse_aadhar_no" :required="false"
                                            size="col-lg-6 mt-2" :value="old('spouse_aadhar_no', $candidate->spouse_aadhar_no)" />
                                        <x-forms.input label="No of Children:" type="number" name="no_of_childrens"
                                            id="no_of_childrens" :required="false" size="col-lg-6 mt-2"
                                            :value="old('no_of_childrens', $candidate->no_of_childrens)" />
                                    </div>
                                </div>
                                <div id="children-details-container" class="mt-3" style="display: none;">
                                    <div id="children-details">
                                    </div>
                                    <div id="max-children-message"
                                        style="display: none; color: red; margin-top: 10px;">
                                        You can only add details for up to 2 children.
                                    </div>
                                </div>

                                <x-forms.input label="Father Name:  " type="text" name="father_name"
                                    id="father_name" :required="true" size="col-lg-6 mt-2" :value="old('father_name', $candidate->father_name)" />
                                <x-forms.input label="Father's DOB: " type="date" name="father_dob"
                                    id="father_dob" :required="true" size="col-lg-6 mt-2" :value="old('father_dob', $candidate->father_dob)" />
                                <x-forms.input label="Father's Adhar Card No:" type="number" name="father_aadhar_no"
                                    id="father_aadhar_no" :required="true" size="col-lg-6 mt-2"
                                    :value="old('father_aadhar_no', $candidate->father_aadhar_no)" />
                                <x-forms.input label="Mother Name: " type="text" name="mother_name"
                                    id="mother_name" :required="true" size="col-lg-6 mt-2" :value="old('mother_name', $candidate->mother_name)" />
                                <x-forms.input label="Mother's DOB: " type="date" name="mother_dob"
                                    id="mother_dob" :required="true" size="col-lg-6 mt-2" :value="old('mother_dob', $candidate->mother_dob)" />
                                <x-forms.input label="Mother's Adhar Card No:" type="number" name="mother_aadhar_no"
                                    id="mother_aadhar_no" :required="true" size="col-lg-6 mt-2"
                                    :value="old('mother_aadhar_no', $candidate->mother_aadhar_no)" />
                                <x-forms.input label="Religion: " type="text" name="religion" id="religion"
                                    :required="true" size="col-lg-6 mt-2" :value="old('religion', $candidate->religion)" />
                                <x-forms.input label="Languages: " type="text" name="languages" id="languages"
                                    placeholder="English,Kannada.." :required="true" size="col-lg-6 mt-2"
                                    :value="old('languages', $candidate->languages)" />
                                <x-forms.input label="Mother Tongue: " type="text" name="mother_tongue"
                                    id="mother_tongue" :required="true" size="col-lg-6 mt-2" :value="old('mother_tongue', $candidate->mother_tongue)" />
                                <x-forms.select label="Blood Group:" name="blood_group" id="blood_group"
                                    :required="true" size="col-lg-6 mt-2" :options="FretusFolks::getBlood()" :value="old('blood_group', $candidate->blood_group)" />
                                <x-forms.input label="Emergency Contact Person Number :" type="number"
                                    name="emer_contact_no" id="emer_contact_no" :required="true"
                                    size="col-lg-6 mt-2" :value="old('emer_contact_no', $candidate->emer_contact_no)" />
                                <x-forms.input label="Emergency Contact Person Name:" type="text" name="emer_name"
                                    id="emer_name" :required="true" size="col-lg-6 mt-2" :value="old('emer_name', $candidate->emer_name)" />
                                <x-forms.input label="Emergency Contact Person Relation:" type="text"
                                    name="emer_relation" id="emer_relation" :required="true" size="col-lg-6 mt-2"
                                    :value="old('emer_relation', $candidate->emer_relation)" />
                                <x-forms.select label=" Qualification:" name="qualification" id="qualification"
                                    :required="true" size="col-lg-6 mt-2" :options="FretusFolks::getQualification()" :value="old('qualification', $candidate->qualification)" />
                                <x-forms.input label="Phone 1:" type="number" name="phone1" id="phone1"
                                    :required="true" size="col-lg-6 mt-2" :value="old('phone1', $candidate->phone1)" />
                                {{-- <x-forms.input label="Phone 2:" type="number" name="phone2" id="phone2"
                                    :required="false" size="col-lg-4 mt-2" :value="old('phone2', $candidate->phone2)" /> --}}
                                <x-forms.input label="Employee Email ID: " type="email" name="email"
                                    id="email" :required="true" size="col-lg-6 mt-2" :value="old('email', $candidate->email)" />
                                <x-forms.input label="Official Email ID: " type="email" name="official_mail_id"
                                    id="official_mail_id" :required="false" size="col-lg-6 mt-2"
                                    :value="old('official_mail_id', $candidate->official_mail_id)" />
                                <x-forms.textarea label="Enter Permanent Address:" name="permanent_address"
                                    id="permanent_address" :required="true" size="col-lg-6 mt-2"
                                    :value="old('permanent_address', $candidate->permanent_address)" />
                                <x-forms.textarea label="Enter Present Address:" name="present_address"
                                    id="present_address" :required="true" size="col-lg-6 mt-2" :value="old('present_address', $candidate->present_address)" />
                                <x-forms.input label="Enter PAN Card No::" type="text" name="pan_no"
                                    id="pan_no" :required="false" size="col-lg-6 mt-2" :value="old('pan_no', $candidate->pan_no)" />
                                <div class="form-group col-lg-6 mt-2">
                                    <label for="pan_path">Attach PAN: </label>
                                    <input type="file" name="pan_path" id="pan_path"
                                        accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/pdf, image/jpg, image/png"
                                        class="form-control" value="{{ old('pan_path', $candidate->pan_path) }}">
                                </div>
                                <x-forms.input label="Enter Adhar Card No:" type="number" name="aadhar_no"
                                    id="aadhar_no" :required="true" size="col-lg-6 mt-2" :value="old('aadhar_no', $candidate->aadhar_no)" />
                                <div class="form-group col-lg-6 mt-2">
                                    <label for="aadhar_path">Attach Aadhar Card: <span
                                            style="color: red;">*</span></label>
                                    <input type="file" name="aadhar_path" id="aadhar_path"
                                        accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/pdf, image/jpg, image/png"
                                        class="form-control" value="{{ old('aadhar_path', $candidate->aadhar_path) }}"
                                        required>
                                </div>
                                <x-forms.input label="Enter Driving License No:" type="text"
                                    name="driving_license_no" id="driving_license_no" :required="false"
                                    size="col-lg-6 mt-2" :value="old('driving_license_no', $candidate->driving_license_no)" />
                                <div class="form-group col-lg-6 mt-2">
                                    <label for="driving_license_path">Attach Driving License:</label>
                                    <input type="file" name="driving_license_path" id="driving_license_path"
                                        accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/pdf, image/jpg, image/png"
                                        class="form-control"
                                        value="{{ old('driving_license_path', $candidate->driving_license_path) }}">
                                </div>
                                {{-- <div class="form-group col-lg-6 mt-2">
                                    <label for="photo">Photo: <span style="color: red;">*</span></label>
                                    <input type="file" name="photo" id="photo"
                                        accept="application/pdf, image/jpg, image/png" class="form-control"
                                        value="{{ old('photo', $candidate->photo) }}" required>
                                </div> --}}
                                <div class="form-group col-lg-6 mt-2">
                                    <label for="photo">Photo:</label>
                                    <input type="file" name="photo" id="photo"
                                        accept="image/jpg, image/png" class="form-control">
                                    <div id="image-preview-container" class="d-flex ">
                                        <img src="{{ asset('storage/' . $candidate->photo) }}" class="img-thumbnail"
                                            width="100" height="100" alt="Uploaded image">
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 mt-2">
                                    <label for="resume">Resume:</label>
                                    <input type="file" name="resume" id="resume"
                                        accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/pdf"
                                        class="form-control">
                                    <a href="{{ asset('storage/' . $candidate->resume) }}" target="_blank"
                                        class="btn btn-custom">
                                        View Resume
                                    </a>
                                </div>
                                <div class="form-group col-lg-6 mt-2">
                                    <label for="family_photo">Family Photo: <span style="color: red;">*</span></label>
                                    <input type="file" name="family_photo" id="family_photo"
                                        accept="application/pdf, image/jpg, image/png" class="form-control"
                                        value="{{ old('family_photo', $candidate->family_photo) }}" required>
                                </div>

                                {{-- <div class="form-group col-lg-6 mt-2">
                                    <label for="resume">Resume: <span style="color: red;">*</span></label>
                                    <input type="file" name="resume" id="resume"
                                        accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/pdf"
                                        class="form-control" value="{{ old('resume', $candidate->resume) }}"
                                        required>
                                </div> --}}
                                <x-forms.input label="Enter Bank Name:" type="text" name="bank_name"
                                    id="bank_name" :required="true" size="col-lg-6 mt-2" :value="old('bank_name', $candidate->bank_name)" />
                                <div class="form-group col-lg-6 mt-2">
                                    <label for="bank_document">Attach Bank Document: <span
                                            style="color: red;">*</span></label>
                                    <input type="file" name="bank_document" id="bank_document"
                                        accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/pdf"
                                        class="form-control"
                                        value="{{ old('bank_document', $candidate->bank_document) }}" required>
                                </div>
                                <x-forms.input label="Enter Bank Account No::" type="text" name="bank_account_no"
                                    id="bank_account_no" :required="true" size="col-lg-6 mt-2" :value="old('bank_account_no', $candidate->bank_account_no)" />
                                <x-forms.input label="Repeat Bank Account No:" type="text" name="bank_account_no"
                                    id="bank_account_no" :required="true" size="col-lg-6 mt-2" :value="old('bank_account_no', $candidate->bank_account_no)" />
                                <x-forms.input label="Enter Bank IFSC CODE:" type="text" name="bank_ifsc_code"
                                    id="bank_ifsc_code" :required="true" size="col-lg-6 mt-2" :value="old('bank_ifsc_code', $candidate->bank_ifsc_code)" />
                                <x-forms.select label="Do you Have UAN No? " :options="[['value' => 'No', 'label' => 'No'], ['value' => 'Yes', 'label' => 'Yes']]" id="uan_status"
                                    name="uan_status" :required="true" size="col-lg-6 mt-2 mr-2"
                                    :value="old('uan_status')" />
                                <div id="uan-number-field" style="display: none;" class="mt-3">
                                    <x-forms.input label="Enter UAN No:" type="text" name="uan_no"
                                        id="uan_no" :required="true" size="col-lg-6" :value="old('uan_no', $candidate->uan_no)" />
                                </div>
                                {{-- <x-forms.input label="ESIC No:" type="text" name="esic_no" id="esic_no"
                                    :required="false" size="col-lg-6 mt-2" :value="old('esic_no', $candidate->esic_no)" /> --}}
                                {{-- <x-forms.select label="Status:" name="status" id="status" :required="false"
                                    size="col-lg-6 mt-2" :options="FretusFolks::getStatus()" :value="old('status', $candidate->status)" /> --}}
                                {{-- <label size="col-lg-12 mt-4"><strong>Salary Details</strong></label>
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
                                </div> --}}
                                <label size="col-lg-6 mt-4"><strong>Upload Documents</strong></label>
                                <div style="border: 1px solid #d6c8c8; padding: 2%; margin-bottom: 1%;">
                                    <div id="document-rows">
                                        <div class="row ">
                                            <div class="document-row d-flex align-items-center mb-3">
                                                <select name="document_type[]" class="me-3 col-lg-5 ">
                                                    <option value="">Select Document Type</option>
                                                    <option value="voter_id">Voter ID/ PVC/ UL</option>
                                                    <option value="emp_form">Attach Employee Form</option>
                                                    <option value="education_certificate">Education Certificate
                                                    </option>
                                                    <option value="pf_esic_form">PF Form / ESIC</option>
                                                    <option value="other_certificate">Others</option>
                                                    <option value="payslip">Payslip/Fitness doc</option>
                                                    <option value="exp_letter">Exp Letter</option>
                                                </select>

                                                <input type="file"
                                                    accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/pdf"
                                                    name="document_file[]" class=" col-lg-5 me-3">

                                                <button type="button" class="btn btn-success me-2 add-row">+</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <label size="col-lg-6 mt-4"><strong>Current Uploaded Documents</strong></label>
                                <div style="border: 1px solid #d6c8c8; padding: 2%; margin-bottom: 1%;">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Document Name</th>
                                                <th>View Document</th>
                                                {{-- <th>Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- Direct File Fields --}}
                                            @php
                                                $directFileFields = [
                                                    'pan_path' => 'PAN Document',
                                                    'aadhar_path' => 'Aadhar Document',
                                                    'driving_license_path' => 'Driving License',
                                                    // 'photo' => 'Photo',
                                                    // 'resume' => 'Resume',
                                                    'bank_document' => 'Bank Document',
                                                    'voter_id' => 'Voter ID/ PVC/ UL',
                                                    'emp_form' => 'Employee Form',
                                                    'pf_esic_form' => 'PF Form / ESIC',
                                                    'payslip' => 'Payslip/Fitness Document',
                                                    'exp_letter' => 'Experience Letter',
                                                ];
                                            @endphp

                                            @foreach ($directFileFields as $field => $label)
                                                @if (!empty($candidate->$field))
                                                    <tr>
                                                        <td>{{ $label }}</td>
                                                        <td>
                                                            <a href="{{ asset('storage/' . $candidate->$field) }}"
                                                                target="_blank" class="btn btn-custom">
                                                                View {{ $label }}
                                                            </a>

                                                        </td>

                                                    </tr>
                                                @endif
                                            @endforeach

                                            {{-- Education Certificates --}}
                                            @if ($candidate->educationCertificates->isNotEmpty())
                                                @foreach ($candidate->educationCertificates as $certificate)
                                                    <tr>
                                                        <td>Education Certificate {{ $loop->iteration }}</td>
                                                        <td>
                                                            <a href="{{ asset('storage/' . $certificate->path) }}"
                                                                target="_blank" class="btn btn-custom">
                                                                View Education Certificate {{ $loop->iteration }}
                                                            </a>
                                                        </td>
                                                        <td>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif

                                            {{-- Other Certificates --}}
                                            @if ($candidate->otherCertificates->isNotEmpty())
                                                @foreach ($candidate->otherCertificates as $certificate)
                                                    <tr>
                                                        <td>Other Certificate {{ $loop->iteration }}</td>
                                                        <td>
                                                            <a href="{{ asset('storage/' . $certificate->path) }}"
                                                                target="_blank" class="btn btn-custom">
                                                                View Other Certificate {{ $loop->iteration }}
                                                            </a>
                                                        </td>
                                                        <td>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>


                                {{-- <x-forms.input label="Password:" type="text" name="psd" id="psd"
                                    :required="true" size="col-lg-6 mt-2" :value="old('psd', 'ffemp@123')" /> --}}
                                {{-- <x-forms.select label="Active Status:" name="active_status" id="active_status"
                                    :required="true" size="col-lg-6 mt-2" :options="FretusFolks::getStatus()" :value="old('active_status', $candidate->active_status)" /> --}}
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mt-4">
                                    <x-forms.button type="submit" label="Submit" class="btn btn-primary" />
                                    <button type="button" onclick="return pending_update()"
                                        class="btn btn-primary">Pending Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('scripts')
        <script>
            //maritial_status
            document.addEventListener('DOMContentLoaded', function() {
                const maritalStatus = document.getElementById('maritial_status');
                const marriedFields = document.getElementById('married-fields');

                function toggleMarriedFields() {
                    if (maritalStatus.value === 'Married') {
                        marriedFields.style.display = 'block';
                    } else {
                        marriedFields.style.display = 'none';
                        document.getElementById('spouse_name').value = '';
                        document.getElementById('spouse_dob').value = '';
                        document.getElementById('spouse_aadhar_no').value = '';
                        document.getElementById('no_of_childrens').value = '';
                    }
                }
                toggleMarriedFields();
                maritalStatus.addEventListener('change', toggleMarriedFields);
            });
            //uan
            document.addEventListener('DOMContentLoaded', function() {
                const uanStatus = document.getElementById('uan_status');
                const uanNumberField = document.getElementById('uan-number-field');
                const uanNumberInput = document.getElementById('uan_no');

                function toggleUANField() {
                    if (uanStatus.value === 'Yes') {
                        uanNumberField.style.display = 'block';
                        uanNumberInput.required = true;
                    } else {
                        uanNumberField.style.display = 'none';
                        uanNumberInput.required = false;
                        uanNumberInput.value = '';
                    }
                }
                toggleUANField();
                uanStatus.addEventListener('change', toggleUANField);
            });
            //documents
            document.addEventListener('DOMContentLoaded', function() {
                const documentRowsContainer = document.getElementById('document-rows');
                documentRowsContainer.addEventListener('click', function(event) {
                    if (event.target.classList.contains('add-row')) {
                        const newRow = document.createElement('div');
                        newRow.className = 'document-row d-flex align-items-center mb-3';
                        newRow.innerHTML = `
                    <select name="document_type[]" class="col-lg-5 me-3 " >
                        <option value="">Select Document Type</option>
                        <option value="voter_id">Voter ID/ PVC/ UL</option>
                        <option value="emp_form">Attach Employee Form</option>
                        <option value="education_certificate">Education Certificate</option>
                        <option value="pf_esic_form">PF Form / ESIC</option>
                        <option value="other_certificate">Others</option>
                        <option value="payslip">Payslip/Fitness doc</option>
                        <option value="exp_letter">Exp Letter</option>
                    </select>
                    <input type="file" name="document_file[]" 
                     accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/pdf"
class="col-lg-5 me-3 " >
                    <button type="button" class="btn btn-success me-2 add-row">+</button>
                    <button type="button" class="btn btn-danger me-2 remove-row">-</button>
                `;
                        documentRowsContainer.appendChild(newRow);
                        document.querySelectorAll('.remove-row').forEach(button => {
                            button.style.display = 'inline-block';
                        });
                    }
                });
                documentRowsContainer.addEventListener('click', function(event) {
                    if (event.target.classList.contains('remove-row')) {
                        const row = event.target.closest('.document-row');
                        row.remove();
                        if (document.querySelectorAll('.document-row').length === 1) {
                            document.querySelector('.remove-row').style.display = 'none';
                        }
                    }
                });
                if (document.querySelectorAll('.document-row').length === 1) {
                    document.querySelector('.remove-row').style.display = 'none';
                }
            });
            //no of children
            document.addEventListener('DOMContentLoaded', function() {
                const maxChildren = 2;
                let currentChildren = 0;

                const noOfChildrenField = document.getElementById('no_of_childrens');
                const childrenDetailsContainer = document.getElementById('children-details-container');
                const childrenDetails = document.getElementById('children-details');
                const maxChildrenMessage = document.getElementById('max-children-message');

                function updateChildDetails() {
                    const noOfChildren = parseInt(noOfChildrenField.value);

                    // Clear previous child details
                    childrenDetails.innerHTML = '';

                    if (noOfChildren > 0) {
                        childrenDetailsContainer.style.display = 'block';
                        maxChildrenMessage.style.display = 'none';

                        for (let i = 1; i <= noOfChildren && i <= maxChildren; i++) {
                            const childRow = document.createElement('div');
                            childRow.className = 'row align-items-center mb-2 child-row';
                            childRow.innerHTML = `
                    <x-forms.input label="Child ${i} Name:" type="text" name="child_names[]" 
                        id="child_name_${i}" :required="true" size="col-lg-6" />
                    <x-forms.input label="Child ${i} DOB:" type="date" name="child_dobs[]" 
                        id="child_dob_${i}" :required="true" size="col-lg-6" />
                `;
                            childrenDetails.appendChild(childRow);
                        }

                        if (noOfChildren > maxChildren) {
                            maxChildrenMessage.style.display = 'block';
                        }
                    } else {
                        childrenDetailsContainer.style.display = 'none';
                    }
                }

                noOfChildrenField.addEventListener('input', updateChildDetails);
            });
            //pending update
            function pending_update() {
                var formData = new FormData(document.getElementById('pendingDetailsForm'));
                fetch('{{ route('admin.dcs_approval.pending.update') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            alert('Pending details saved successfully!');
                            window.location.href = '{{ route('admin.dcs_approval') }}';
                        } else if (data.errors) {
                            let errorMessages = Object.values(data.errors)
                                .map(errorArray => errorArray.join(', '))
                                .join('\n');
                            alert(`Validation Errors:\n${errorMessages}`);
                        } else {
                            alert('Something went wrong. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert(`Error saving pending details: ${error.message}`);
                    });
            }
        </script>
    @endpush

</x-applayout>
