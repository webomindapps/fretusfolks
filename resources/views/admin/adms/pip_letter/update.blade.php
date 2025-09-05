<x-applayout>
    <x-admin.breadcrumb title=" New ADMS Pip Letter" isBack="{{ true }}" />

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
            <form action="{{ route('admin.pip_letter.edit', $pip->id) }}" method="POST" enctype="multipart/form-data"
                id="employeeForm">
                @csrf
                <div class="card mt-3">
                    <div class="card-header header-elements-inline d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Pip Letter Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-contents">
                            <div class="row">
                                <x-forms.input label="From: " type="text" name="from_name" id="from_name"
                                    :required="true" size="col-lg-6 mt-2" :value="old('from_name', $pip->from_name)" />
                                <div class="col-lg-6 mt-2">
                                    <label for="ffi_emp_id">Employee ID:</label>
                                    <input type="text" id="emp_id" name="emp_id"
                                        onchange="return fetchEmployeeDetails()" value="{{ $pip->emp_id }}" required>
                                    <input type="hidden" id="fetchEmployeeRoute"
                                        data-url="{{ route('admin.pip_letter.details', ['emp_id' => ':emp_id']) }}">
                                </div>
                                <x-forms.input label="Enter Employee Name: " type="text" name="emp_name"
                                    id="emp_name" :required="true" size="col-lg-6 mt-2"
                                    value="{{ $pip->pip_letters->emp_name }}" readonly />
                                <x-forms.input label="Designation: " type="text" name="designation" id="designation"
                                    :required="true" size="col-lg-6 mt-2"   value="{{ $pip->pip_letters->designation }}" readonly />
                                <x-forms.input label="Date: " type="date" name="date" id="date"
                                    :required="false" size="col-lg-6 mt-2" :value="old('date',$pip->date)" />
                                <x-forms.textarea label="Content: " name="content" id="content" :required="true"
                                    size="col-lg-12 mt-2"
                                    value=" The purpose of this Performance Improvement Plan (PIP) is to define serious areas ofconcern, gaps in your work performance, reiterate at Hiveloop Technology Pvt Ltd.
                                    expectations, and allow you the opportunity to demonstrate improvement and commitment." />

                                <x-forms.textarea label="Observations, Previous Discussions or Counseling : "
                                    type="text" name="observation" id="observation" :required="true"
                                    size="col-lg-12 mt-2"
                                    value="In spite of constant follow-up, motivation and warnings, since last 6 weeks, the performance is observed below mark. So intend to put you on pip." />

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Improvement Goals: <span class="text-danger">*</span></label>
                                            <textarea id="goals" name="goals" class="form-control form-input-styled editor" data-fouc>{{ old('goals', '<p>&nbsp;</p><table style="border-collapse: collapse; width: 100%; height: 72px; margin-left: auto; margin-right: auto;" border="1"><tbody><tr style="height: 36px;"><td style="width: 17.8899%; height: 36px; text-align: center;">1</td><td style="width: 82.1101%; height: 36px; text-align: center;">No of Listings created &ndash; 1000</td></tr><tr style="height: 36px; text-align: center;"><td style="width: 17.8899%; height: 36px; text-align: center;">2</td><td style="width: 82.1101%; height: 36px; text-align: center;">New sellers added &ndash; 10</td></tr></tbody></table>') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Follow-up Updates: <span class="text-danger">*</span></label>
                                            <textarea id="updates" name="updates" class="form-control form-input-styled editor" data-fouc>{{ old('updates','<table style="border-collapse: collapse; width: 98.2671%; height: 146px;" border="1"><tbody><tr style="height: 41px;"><td style="width: 20%; height: 41px; text-align: center;"><span style="font-size: 10pt;">Date Scheduled</span></td><td style="width: 20%; height: 41px; text-align: center;"><span style="font-size: 10pt;">Activity</span></td><td style="width: 20%; height: 41px; text-align: center;"><span style="font-size: 10pt;">Conducted By</span></td><td style="width: 20%; height: 41px; text-align: center;"><span style="font-size: pt;">Completion Date</span></td><td style="width: 20%; height: 41px; text-align: center;"><span style="font-size: 10pt;">Remarks</span></td></tr><tr style="height: 37px;"><td style="width: 20%; height: 37px; text-align: center;"><span style="font-size: 10pt;">10th August&rsquo;2018</span></td><td style="width: 20%; height: 37px; text-align: center;"><span style="font-size: 10pt;">1st review</span></td><td style="width: 20%; height: 37px; text-align: center;"><span style="font-size: 10pt;">[Supervisor/Manager]</span></td><td style="width: 20%; height: 37px; text-align: center;"><span style="font-size: 10pt;">10th August&rsquo;2018</span></td><td style="width: 20%; height: 37px; text-align: justify;"><span style="font-size: 10pt;">Review report needs to share with the employee.</span></td></tr></tbody></table>') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <x-forms.textarea label="Timeline for Improvement, Consequences & Expectations: "
                                    name="timeline" id="timeline" :required="true" size="col-lg-12 mt-2"
                                    value="Effective immediately, you are placed on a (15 days) PIP, that is from 06.08.2018 onwards. 
                                    During this time you will be expected to make regular progress on the plan outlined above. 
                                    Failure to meet or exceed these expectations, or any display of gross misconduct will result in further disciplinary action, up to and including separation.
                                      
                                    The PIP does not alter the employment-at-will relationship. Additionally, the contents of this PIP are to remain confidential. 
                                    Should you have questions or concerns regarding the content, you will be expected to follow up directly with the reporting manager or with us. 
                                       
                                    We will meet again on as noted above to discuss your Performance Improvement Plan. Please schedule accordingly." />

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
                const ffi_emp_id = $('#emp_id').val();

                if (!ffi_emp_id) {
                    alert('Employee ID is required. Please enter a valid Employee ID.');
                    clearFields();
                    return;
                }
                const routeUrl = $('#fetchEmployeeRoute').data('url').replace(':emp_id', ffi_emp_id);

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
