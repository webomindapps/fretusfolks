<x-applayout>
    <x-admin.breadcrumb title=" New ADMS Offer Letter" isBack="{{ true }}" />

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
            <form action="{{ route('admin.offer_letter.create') }}" method="POST" enctype="multipart/form-data"
                id="employeeForm">
                @csrf
                <div class="card mt-3">
                    <div class="card-header header-elements-inline d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Offer Letter Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-contents">
                            <div class="row">
                                {{-- <div class="col-lg-6 mt-2">
                                    <label for="ffi_emp_id">Employee ID:</label>
                                    <input type="text" id="ffi_emp_id" name="ffi_emp_id"
                                        onchange="return fetchEmployeeDetails()" required>
                                    <input type="hidden" id="fetchEmployeeRoute"
                                        data-url="{{ route('admin.increment_letter.details', ['ffi_emp_id' => ':ffi_emp_id']) }}">
                                </div> --}}
                                <x-forms.input label="FFI Employee ID:" type="text" name="employee_id"
                                    id="employee_id" :required="true" size="col-lg-6 mt-2" :value="old('employee_id')" />

                                <x-forms.select label="Enter Client Name:" name="company_id" id="company_id"
                                    :required="true" size="col-lg-6 mt-2" :options="FretusFolks::getClientname()" :value="old('company_id')" />
                                <x-forms.input label="Enter Employee Name: " type="text" name="emp_name"
                                    id="emp_name" :required="true" size="col-lg-6 mt-2" :value="old('emp_name')" />
                                <x-forms.input label="Joining Date: " type="date" name="joining_date"
                                    id="joining_date" :required="true" size="col-lg-6 mt-2" :value="old('joining_date')" />
                                {{-- <x-forms.input label="Contract End Date " type="date" name="contract_date"
                                    id="contract_date" :required="true" size="col-lg-6 mt-2" :value="old('contract_date')" /> --}}

                                <x-forms.input label="Designation: " type="text" name="designation" id="designation"
                                    :required="true" size="col-lg-6 mt-2" :value="old('designation')" />
                                <x-forms.input label="Department: " type="text" name="department" id="department"
                                    :required="true" size="col-lg-6 mt-2" :value="old('department')" />
                                <x-forms.input label="Location: " type="text" name="location" id="location"
                                    :required="true" size="col-lg-6 mt-2" :value="old('location')" />
                                <div class="form-group col-lg-6 mt-2">
                                    <label for="offer_letter_type">Offer Letter For: <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" id="offer_letter_type" name="offer_letter_type"
                                        required>
                                        <option value="">-- Select --</option>
                                        <option value="4">Udaan</option>
                                        <option value="2">Grofers</option>
                                        <option value="3">Other</option>
                                        <option value="5">Blue Dart</option>
                                    </select>
                                </div>

                                <x-forms.input label="Tenure Month(Integer): " type="text" name="tenure_month"
                                    id="tenure_month" :required="true" size="col-lg-6 mt-2" :value="old('tenure_month')" />
                                <x-forms.input label="Father Name:  " type="text" name="father_name" id="father_name"
                                    :required="true" size="col-lg-6 mt-2" :value="old('father_name')" />
                                <x-forms.input label="Email ID: " type="email" name="email" id="email"
                                    :required="true" size="col-lg-6 mt-2" :value="old('email')" />
                                <div class="form-group col-lg-6 mt-2">
                                    <label for="phone1">Phone: <span style="color: red">*</span></label>
                                    <input type="text" name="phone1" id="phone1" class="form-control"
                                        maxlength="10" inputmode="numeric" required>
                                </div>

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
                                        <x-forms.input label="Leave Wage: " type="number" name="leave_wage"
                                            id="leave_wage" :required="true" size="col-lg-3 mt-2"
                                            :value="old('leave_wage')" />
                                        <x-forms.input label="Special Allowance: " type="number"
                                            name="special_allowance" id="special_allowance" :required="true"
                                            size="col-lg-3 mt-2" :value="old('special_allowance')" />
                                        <x-forms.input label="Other Allowance: " type="number"
                                            name="other_allowance" id="other_allowance" :required="true"
                                            size="col-lg-3 mt-2" :value="old('other_allowance')" />
                                        <x-forms.input label="ST Bonus: " type="number" name="st_bonus"
                                            id="st_bonus" :required="true" size="col-lg-3 mt-2"
                                            :value="old('st_bonus')" />
                                        <x-forms.input label="Gross Salary: " type="number" name="gross_salary"
                                            id="gross_salary" :required="true" size="col-lg-3 mt-2"
                                            :value="old('gross_salary')" />
                                        <x-forms.input label="PF Percentage: " type="number" name="pf_percentage"
                                            id="pf_percentage" :required="true" size="col-lg-3 mt-2"
                                            :value="old('pf_percentage')" />
                                        <x-forms.input label="Employee PF: " type="number" name="emp_pf"
                                            id="emp_pf" :required="true" size="col-lg-3 mt-2"
                                            :value="old('emp_pf')" />

                                        <x-forms.input label="Employee ESIC: " type="number" name="emp_esic"
                                            id="emp_esic" :required="true" size="col-lg-3 mt-2"
                                            :value="old('emp_esic')" />
                                        <x-forms.input label="PT: " type="number" name="pt" id="pt"
                                            :required="true" size="col-lg-3 mt-2" :value="old('pt')" />
                                        <x-forms.input label="Employee Lwf: " type="number" name="lwf"
                                            id="lwf" :required="true" size="col-lg-3 mt-2"
                                            :value="old('lwf', '0')" />
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
                                        <x-forms.input label="Employer LWF: " type="number" name="employer_lwf"
                                            id="employer_lwf" :required="true" size="col-lg-3 mt-2"
                                            :value="old('employer_lwf')" />
                                        <x-forms.input label="Mediclaim: " type="number" name="mediclaim"
                                            id="mediclaim" :required="true" size="col-lg-3 mt-2"
                                            :value="old('mediclaim')" />
                                        <x-forms.input label="CTC: " type="number" name="ctc" id="ctc"
                                            :required="true" size="col-lg-3 mt-2" :value="old('ctc')" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mt-4">
                                    <x-forms.button type="submit" label="Submit" class="btn btn-primary" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- @push('scripts')
        <script>
            function fetchEmployeeDetails() {
                const ffi_emp_id = $('#ffi_emp_id').val();

                if (!ffi_emp_id) {
                    alert('Employee ID is required. Please enter a valid Employee ID.');
                    clearFields();
                    return;
                }
                const routeUrl = $('#fetchEmployeeRoute').data('url').replace(':ffi_emp_id', ffi_emp_id);

                $.ajax({
                    url: routeUrl,
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            $('#emp_name').val(response.data.emp_name);
                            $('#designation').val(response.data.designation);
                            $('#department').val(response.data.department);
                            $('#location').val(response.data.location);
                            $('#basic_salary').val(response.data.basic_salary ?? 0);
                            $('#hra').val(response.data.hra ?? 0);
                            $('#pt').val(response.data.pt ?? 0);
                            $('#lwf').val(response.data.lwf ?? 0);
                            $('#conveyance').val(response.data.conveyance ?? 0);
                            console.log("Designation Value:", response.data.conveyance ?? 0);

                            $('#medical_reimbursement').val(response.data.medical_reimbursement ?? 0);
                            $('#special_allowance').val(response.data.special_allowance ?? 0);
                            $('#other_allowance').val(response.data.other_allowance ?? 0);
                            $('#st_bonus').val(response.data.st_bonus ?? 0);
                            $('#take_home').val(response.data.take_home)
                            $('#gross_salary').val(response.data.gross_salary ?? 0);
                            $('#pf_percentage').val(response.data.pf_percentage ?? 0);
                            $('#emp_pf').val(response.data.emp_pf ?? 0);
                            $('#employer_esic').val(response.data.employer_esic ?? 0);
                            $('#employer_esic_percentage').val(response.data.employer_esic_percentage ?? 0);
                            $('#mediclaim').val(response.data.mediclaim ?? 0);
                            $('#ctc').val(response.data.ctc ?? 0);
                        } else {
                            alert(response.message);
                            clearFields();
                        }
                    },
                    error: function(xhr, status, error) {
                        alert(`Error: ${error}`);
                        clearFields();
                    }
                });
            }

            function clearFields() {
                $('#emp_name, #designation, #department, #location, #basic_salary, #hra, #conveyance, #medical_reimbursement, #special_allowance, #other_allowance, #st_bonus, #gross_salary, #pf_percentage, #emp_pf, #employer_esic, #employer_esic_percentage, #mediclaim, #ctc ')
                    .val('');
                alert('All fields have been cleared.');
            }
        </script>
    @endpush --}}
</x-applayout>
