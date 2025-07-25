<x-applayout>
    <x-admin.breadcrumb title="Fretus HR Management System" isBack="{{ true }}" />

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
        <div class="form-card px-md-3 px-2">
            <form action="{{ route('admin.fhrms.create') }}" method="POST" enctype="multipart/form-data"
                id="pendingDetailsForm">
                @csrf
                <div class="card mt-3">
                    <div class="card-header header-elements-inline d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Employee Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-contents">
                            <div class="row">
                                <x-forms.input label="Enter FFI Employee ID: " type="text" name="ffi_emp_id"
                                    id="ffi_emp_id" :required="true" size="col-lg-6 mt-2" :value="old('ffi_emp_id')" />
                                <x-forms.input label="Enter Employee Name: " type="text" name="emp_name"
                                    id="emp_name" :required="true" size="col-lg-6 mt-2" :value="old('emp_name')" />
                                <x-forms.input label="Interview Date: " type="date" name="interview_date"
                                    id="interview_date" :required="true" size="col-lg-4 mt-2" :value="old('interview_date')" />
                                <x-forms.input label="Joining Date: " type="date" name="joining_date"
                                    id="joining_date" :required="true" size="col-lg-4 mt-2" :value="old('joining_date')" />
                                <x-forms.input label="Contract End Date: " type="date" name="contract_date"
                                    id="contract_date" :required="false" size="col-lg-4 mt-2" :value="old('contract_date')" />
                                <x-forms.input label="Designation: " type="text" name="designation" id="designation"
                                    :required="true" size="col-lg-6 mt-2" :value="old('designation')" />
                                <x-forms.input label="Department: " type="text" name="department" id="department"
                                    :required="false" size="col-lg-6 mt-2" :value="old('department')" />
                                <x-forms.select label="State:" name="state" id="state" :required="true"
                                    size="col-lg-6 mt-2" :options="FretusFolks::getStates()" :value="old('state')" />
                                <x-forms.input label="Location: " type="text" name="location" id="location"
                                    :required="true" size="col-lg-6 mt-2" :value="old('location')" />
                                <x-forms.input label="Date of Birth: " type="date" name="dob" id="dob"
                                    :required="true" size="col-lg-6 mt-2" :value="old('dob')" />
                                <x-forms.input label="Father's Name: " type="text" name="father_name"
                                    id="father_name" :required="true" size="col-lg-6 mt-2" :value="old('father_name')" />
                                <x-forms.radio label="Gender: " :options="[
                                    ['value' => 'Male', 'label' => 'Male'],
                                    ['value' => 'Female', 'label' => 'Female'],
                                    ['value' => 'Other', 'label' => 'Other'],
                                ]" id="gender" name="gender"
                                    :required="true" size="col-lg-6 mt-2 mr-2" :value="old('gender')" />

                                <x-forms.select label="Blood Group:" name="blood_group" id="blood_group"
                                    :required="true" size="col-lg-4 mt-2" :options="FretusFolks::getBlood()" :value="old('blood_group')" />
                                <x-forms.input label="Qualification: " type="text" name="qualification"
                                    id="qualification" :required="true" size="col-lg-6 mt-2" :value="old('qualification')" />
                                <x-forms.input label="Phone1: " type="number" name="phone1" id="phone1"
                                    :required="true" size="col-lg-6 mt-2" :value="old('phone1')" />
                                <x-forms.input label="Phone2: " type="number" name="phone2" id="phone2"
                                    :required="false" size="col-lg-6 mt-2" :value="old('phone2')" />
                                <x-forms.input label="Email ID:  " type="email" name="email" id="email"
                                    :required="false" size="col-lg-6 mt-2" :value="old('email')" />
                                <x-forms.textarea label="Enter Permanent Address: " type="text"
                                    name="permanent_address" id="permanent_address" :required="true"
                                    size="col-lg-6 mt-2" :value="old('permanent_address')" />
                                <x-forms.textarea label="Enter Present Address: " type="text"
                                    name="present_address" id="present_address" :required="true"
                                    size="col-lg-6 mt-2" :value="old('present_address')" />
                                <x-forms.input label="Enter PAN Card No: " type="text" name="pan_no"
                                    id="pan_no" :required="false" size="col-lg-6 mt-2" :value="old('pan_no')" />
                                <x-forms.input label="Attach PAN:" type="file" name="pan_path" id="pan_path"
                                    :required="true" size="col-lg-6 mt-2" />
                                <x-forms.input label="Enter Adhar Card No:  " type="text" name="aadhar_no"
                                    id="aadhar_no" :required="true" size="col-lg-6 mt-2" :value="old('aadhar_no')" />
                                <x-forms.input label="Attach Adhaar Card: " type="file" name="aadhar_path"
                                    id="aadhar_path" :required="true" size="col-lg-6 mt-2" />
                                <x-forms.input label="Enter Driving License No: " type="text"
                                    name="driving_license_no" id="driving_license_no" :required="false"
                                    size="col-lg-6 mt-2" :value="old('driving_license_no')" />
                                <x-forms.input label="Attach Driving License: " type="file"
                                    name="driving_license_path" id="driving_license_path" :required="false"
                                    size="col-lg-6 mt-2" />
                                <x-forms.input label="Upload Photo: " type="file" name="photo" id="photo"
                                    :required="true" size="col-lg-6 mt-2" />
                                <x-forms.input label="Upload Resume: " type="file" name="resume" id="resume"
                                    :required="true" size="col-lg-6 mt-2" />
                                <x-forms.input label="Enter Bank Name: " type="text" name="bank_name"
                                    id="bank_name" :required="false" size="col-lg-6 mt-2" :value="old('bank_name')" />
                                <x-forms.input label="Attach Bank Document: " type="file" name="bank_document"
                                    id="bank_document" :required="false" size="col-lg-6 mt-2" />
                                <x-forms.input label="Enter Bank Account No: " type="text" name="bank_account_no"
                                    id="bank_account_no" :required="false" size="col-lg-6 mt-2" :value="old('bank_account_no')" />
                                <x-forms.input label="Repeat Bank Account No: " type="text" name="repeat_acc_no"
                                    id="repeat_acc_no" :required="false" size="col-lg-6 mt-2" :value="old('repeat_acc_no')" />
                                <x-forms.input label="IFSC Code: " type="text" name="bank_ifsc_code"
                                    id="bank_ifsc_code" :required="true" size="col-lg-6 mt-2" :value="old('bank_ifsc_code')" />
                                <x-forms.input label="UAN Generated: " type="text" name="uan_generatted"
                                    id="uan_generatted" :required="false" size="col-lg-3 mt-2" :value="old('uan_generatted')" />
                                <x-forms.select label="UAN Type: " name="uan_type" id="uan_type" :required="false"
                                    size="col-lg-3 mt-2" :options="FretusFolks::getUan()" :value="old('uan_type')" />
                                <x-forms.input label="UAN Number: " type="text" name="uan_no" id="uan_no"
                                    :required="false" size="col-lg-6 mt-2" :value="old('uan_no')" />
                                <x-forms.select label="Status:" name="status" id="status" :required="false"
                                    size="col-lg-6 mt-2" :options="FretusFolks::getStatus()" :value="old('status')" />
                                <label size="col-lg-12 mt-4"><strong>Salary Details</strong></label>
                                <div
                                    style="border:
                                    1px solid #d6c8c8;padding: 2%;margin-bottom: 1%;">
                                    <div class="row">
                                        <x-forms.input label="Basic Salary: " type="number" name="basic_salary"
                                            id="basic_salary" :required="true" size="col-lg-3 mt-2"
                                            :value="old('basic_salary')" />
                                        <x-forms.input label="HRA: " type="number" name="hra" id="hra"
                                            :required="true" size="col-lg-3 mt-2" :value="old('hra')" />
                                        <x-forms.input label="Conveyance: " type="number" name="conveyance"
                                            id="conveyance" :required="true" size="col-lg-3 mt-2"
                                            :value="old('conveyance')" />
                                        <x-forms.input label="Medical Reimbursement: " type="number"
                                            name="medical_reimbursement" id="medical_reimbursement" :required="true"
                                            size="col-lg-3 mt-2" :value="old('medical_reimbursement')" />
                                        <x-forms.input label="Special Allowance: " type="number"
                                            name="special_allowance" id="special_allowance" :required="true"
                                            size="col-lg-3 mt-2" :value="old('special_allowance')" />
                                        <x-forms.input label="Other Allowance: " type="number"
                                            name="other_allowance" id="other_allowance" :required="true"
                                            size="col-lg-3 mt-2" :value="old('other_allowance')" />
                                        <x-forms.input label="ST: " type="number" name="st_bonus" id="st_bonus"
                                            :required="true" size="col-lg-3 mt-2" :value="old('st_bonus')" />
                                        <x-forms.input label="Gross Salary: " type="number" name="gross_salary"
                                            id="gross_salary" :required="true" size="col-lg-3 mt-2"
                                            :value="old('gross_salary')" />
                                        {{-- <x-forms.input label="PF Percentage: " type="number" name="pf_percentage" id="pf_percentage" 
                                        :required="true" size="col-lg-6 mt-2" :value="old('pf_percentage')" /> --}}
                                        <x-forms.input label="Employee PF: " type="number" name="emp_pf"
                                            id="emp_pf" :required="true" size="col-lg-2 mt-2"
                                            :value="old('emp_pf')" />
                                        {{-- <x-forms.input label="ESIC Percentage: " type="number" name="esic_percentage" id="esic_percentage" 
                                        :required="true" size="col-lg-6 mt-2" :value="old('esic_percentage')" /> --}}
                                        <x-forms.input label="Employee ESIC: " type="number" name="emp_esic"
                                            id="emp_esic" :required="true" size="col-lg-2 mt-2"
                                            :value="old('emp_esic')" />
                                        <x-forms.input label="PT: " type="number" name="pt" id="pt"
                                            :required="true" size="col-lg-2 mt-2" :value="old('pt')" />
                                        <x-forms.input label="Total Deduction: " type="number"
                                            name="total_deduction" id="total_deduction" :required="true"
                                            size="col-lg-3 mt-2" :value="old('total_deduction')" />
                                        <x-forms.input label="Take Home Salary: " type="number" name="take_home"
                                            id="take_home" :required="true" size="col-lg-3 mt-2"
                                            :value="old('take_home')" />
                                        <x-forms.input label="Employer PF: " type="number" name="employer_pf"
                                            id="employer_pf" :required="true" size="col-lg-3 mt-2"
                                            :value="old('employer_pf')" />
                                        <x-forms.input label="Employer ESIC: " type="number" name="employer_esic"
                                            id="employer_esic" :required="true" size="col-lg-3 mt-2"
                                            :value="old('employer_esic')" />
                                        <x-forms.input label="Mediclaim: " type="number" name="mediclaim"
                                            id="mediclaim" :required="true" size="col-lg-3 mt-2"
                                            :value="old('mediclaim')" />
                                        <x-forms.input label="CTC: " type="number" name="ctc" id="ctc"
                                            :required="true" size="col-lg-3 mt-2" :value="old('ctc')" />
                                    </div>
                                </div>
                                <label size="col-lg-12 mt-4"><strong>Upload Documents</strong></label>
                                <div
                                    style="border:
                                    1px solid #d6c8c8;padding: 2%;margin-bottom: 1%;">
                                    <div class="row">
                                        <x-forms.input label="Attach Voter ID: " type="file" name="voter_id"
                                            id="voter_id" :required="false" size="col-lg-4 mt-2" />
                                        <x-forms.input label="Attach Employee Form: " type="file" name="emp_form"
                                            id="emp_form" :required="true" size="col-lg-4 mt-2" />
                                        <x-forms.input label="Education Certificate: " type="file"
                                            name="education_certificates[]" id="education_certificates"
                                            :required="false" size="col-lg-4 mt-2" multiple />
                                        <x-forms.input label="PF/ESIC Form: " type="file" name="pf_esic_form"
                                            id="pf_esic_form" :required="false" size="col-lg-6 mt-2" />
                                        <x-forms.input label="Payslip: " type="file" name="payslip"
                                            id="payslip" :required="false" size="col-lg-6 mt-2" />
                                        <x-forms.input label="Others: " type="file" name="others[]"
                                            id="others" :required="false" size="col-lg-4 mt-2" multiple />
                                        <x-forms.input label="Experience Letter: " type="file" name="exp_letter"
                                            id="exp_letter" :required="false" size="col-lg-6 mt-2" />
                                    </div>
                                </div>
                                <x-forms.input label="Password: " type="password" name="password" id="password"
                                    :required="true" size="col-lg-3 mt-2" :value="old('password')" />
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mt-4">
                                    <x-forms.button type="submit" label="Save" class="btn btn-primary" />
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
            function pending_update() {
                var formData = new FormData(document.getElementById('pendingDetailsForm'));

                fetch('{{ route('admin.fhrms.pending.store') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'                        },
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            alert('Pending details saved successfully!');
                            window.location.href = '{{ route('admin.fhrms') }}';
                        } else {
                            alert('Something went wrong.');
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
