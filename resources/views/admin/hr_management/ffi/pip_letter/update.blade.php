<x-applayout>
    <x-admin.breadcrumb title="Edit FFI Pip Letter" />

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
            <form action="{{ route('admin.ffi_pip_letter.edit', $pip->id) }}" method="POST" enctype="multipart/form-data"
                id="employeeForm">
                @csrf
                <div class="card mt-3">
                    <div class="card-header header-elements-inline d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Edit Pip Letter Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-contents">
                            <div class="row">
                                <x-forms.input label="From: " type="text" name="from_name" id="from_name"
                                    :required="true" size="col-lg-6 mt-2" :value="$pip->from_name" />
                                <div class="col-lg-6 mt-2">
                                    <label for="ffi_emp_id">Employee ID:</label>
                                    <input type="text" id="ffi_emp_id" name="ffi_emp_id" value="{{ $pip->emp_id }}"
                                        onchange="return fetchEmployeeDetails()" required>
                                    <input type="hidden" id="fetchEmployeeRoute"
                                        data-url="{{ route('admin.get.employee.details', ['ffi_emp_id' => ':ffi_emp_id']) }}">
                                </div>
                                <x-forms.input label="Enter Employee Name: " type="text" name="emp_name"
                                    id="emp_name" :required="true" size="col-lg-6 mt-2" :value="$pip->pip_letter->emp_name" readonly />
                                <x-forms.input label="Designation: " type="text" name="designation" id="designation"
                                    :required="true" size="col-lg-6 mt-2" :value="$pip->pip_letter->designation" readonly />
                                <x-forms.input label="Date: " type="date" name="date" id="date"
                                    :required="false" size="col-lg-6 mt-2" :value="$pip->date" />
                                <x-forms.textarea label="Content: " type="text" name="content" id="content"
                                    :required="true" size="col-lg-12 mt-2" :value="$pip->content" />
                                <x-forms.textarea label="Observations, Previous Discussions or Counseling : "
                                    type="text" name="observation" id="observation" :required="true"
                                    size="col-lg-12 mt-2" :value="$pip->observation" />
                                <x-forms.textarea label="Improvement Goals  " type="text" name="goals"
                                    id="goals" :required="true" size="col-lg-12 mt-2" :value="$pip->goals" />
                                <x-forms.textarea label="Follow-up Updates : " type="text" name="updates"
                                    id="updates" :required="true" size="col-lg-12 mt-2" :value="$pip->updates" />
                                <x-forms.textarea label="Timeline for Improvement, Consequences & Expectations : "
                                    type="text" name="timeline" id="timeline" :required="true"
                                    size="col-lg-12 mt-2" :value="$pip->timeline" />

                            </div>
                            <div class="row">
                                <div class="col-lg-12 mt-4">
                                    <x-forms.button type="submit" label="Update" class="btn btn-primary" />
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
                            $('#designation').val(response.data.designation);

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
                $('#emp_name, #designation').val('');
                alert('All fields have been cleared.');
            }
        </script>
    @endpush

</x-applayout>
