<x-applayout>
    <x-admin.breadcrumb title=" New FFI Offer Letter" />

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
            <form action="{{ route('admin.ffi_offer_letter.create') }}" method="POST" enctype="multipart/form-data"
                id="employeeForm">
                @csrf
                <div class="card mt-3">
                    <div class="card-header header-elements-inline d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Offer Letter Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-contents">
                            <div class="row">
                                <div class="col-lg-6 mt-2">
                                    <label for="ffi_emp_id">Employee ID:</label>
                                    <input type="text" id="ffi_emp_id" name="ffi_emp_id"
                                        onchange="return fetchEmployeeDetails()" required>
                                    <input type="hidden" id="fetchEmployeeRoute"
                                        data-url="{{ route('admin.get.employee.details', ['ffi_emp_id' => ':ffi_emp_id']) }}">
                                </div>
                                <x-forms.input label="Enter Employee Name: " type="text" name="emp_name"
                                    id="emp_name" :required="true" size="col-lg-6 mt-2" readonly />
                                <x-forms.input label="Interview Date: " type="date" name="interview_date"
                                    id="interview_date" :required="true" size="col-lg-6 mt-2" readonly />
                                <x-forms.input label="Contract End Date: " type="date" name="contract_date"
                                    id="contract_date" :required="true" size="col-lg-6 mt-2" readonly />
                                <x-forms.input label="Designation: " type="text" name="designation" id="designation"
                                    :required="true" size="col-lg-6 mt-2" readonly />
                                <x-forms.input label="Department: " type="text" name="department" id="department"
                                    :required="false" size="col-lg-6 mt-2" readonly />
                                <x-forms.input label="Location: " type="text" name="location" id="location"
                                    :required="true" size="col-lg-6 mt-2" readonly />
                               
                                <x-forms.select label="Offer Letter For:" name="offer_letter_type"
                                    id="offer_letter_type" :required="true" class="form-control" size="col-lg-6 mt-2"
                                    :options="FretusFolks::getLetterFormate()" />


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
                                        <x-forms.input label="Other Allowance: " type="number" name="other_allowance"
                                            id="other_allowance" :required="true" size="col-lg-3 mt-2"
                                            :value="old('other_allowance')" />
                                        <x-forms.input label="ST: " type="number" name="st_bonus" id="st_bonus"
                                            :required="true" size="col-lg-3 mt-2" :value="old('st_bonus')" />
                                        <x-forms.input label="Gross Salary: " type="number" name="gross_salary"
                                            id="gross_salary" :required="true" size="col-lg-3 mt-2"
                                            :value="old('gross_salary')" />
                                        <x-forms.input label="PF Percentage: " type="number" name="pf_percentage"
                                            id="pf_percentage" :required="true" size="col-lg-3 mt-2"
                                            :value="old('pf_percentage')" />
                                        <x-forms.input label="Employee PF: " type="number" name="emp_pf"
                                            id="emp_pf" :required="true" size="col-lg-2 mt-2"
                                            :value="old('emp_pf')" />
                                        <x-forms.input label="ESIC Percentage: " type="number"
                                            name="esic_percentage" id="esic_percentage" :required="true"
                                            size="col-lg-3 mt-2" :value="old('esic_percentage')" />
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
                                        <x-forms.input label="Employer PF Percentage: " type="number"
                                            name="employer_pf_percentage" id="employer_pf_percentage"
                                            :required="true" size="col-lg-3 mt-2" :value="old('employer_pf_percentage')" />
                                        <x-forms.input label="Employer ESIC: " type="number" name="employer_esic"
                                            id="employer_esic" :required="true" size="col-lg-3 mt-2"
                                            :value="old('employer_esic')" />
                                        <x-forms.input label="Employer ESIC Percentage: " type="number"
                                            name="employer_esic_percentage" id="employer_esic_percentage"
                                            :required="true" size="col-lg-3 mt-2" :value="old('employer_esic_percentage')" />
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
                                    <x-forms.button type="submit" label="Save" class="btn btn-primary" />
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
                            $('#interview_date').val(response.data.interview_date);
                            $('#contract_date').val(response.data.contract_date);
                            $('#designation').val(response.data.designation);
                            $('#department').val(response.data.department);
                            $('#location').val(response.data.location);
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
                $('#emp_name, #interview_date, #contract_date, #designation, #department, #location').val('');
                alert('All fields have been cleared.');
            }
        </script>
    @endpush


</x-applayout>
