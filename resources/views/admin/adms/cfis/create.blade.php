<x-applayout>
    <x-admin.breadcrumb title="Candidate First Information System" />

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
            <form action="{{ route('admin.cfis.create') }}" method="POST" enctype="multipart/form-data" id="cfisform">
                @csrf
                <div class="card mt-3">
                    <div class="card-header header-elements-inline d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">New Candidate Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-contents">
                            <div class="row">
                                <x-forms.select label="Enter Client Name:" name="client_id" id="client_id"
                                    :required="true" size="col-lg-6 mt-2" :options="FretusFolks::getClientname()" :value="old('client_id')" />
                                {{-- <x-forms.input label="Enter Associate Name: " type="text" name="emp_name"
                                    id="emp_name" :required="true" size="col-lg-6 mt-2" :value="old('emp_name')" /> --}}
                                <div class="form-group col-lg-6 mt-2">
                                    <label for="emp_name">Enter Employee Name: <span style="color: red">*(Enter Name as
                                            per aadhar)</span></label>
                                    <input type="text" name="emp_name" id="emp_name" class="form-control"
                                        value="{{ old('emp_name') }}" required>
                                </div>
                                <div class="form-group col-lg-6 mt-2">
                                    <label for="emp_name">Employee Mobile: <span style="color: red">*</span></label>
                                    <input type="text" name="phone1" id="phone1" class="form-control"
                                        maxlength="10" value="{{ old('phone1') }}" required>
                                </div>

                                <x-forms.input label="Employee Email ID: " type="email" name="email" id="email"
                                    :required="true" size="col-lg-6 mt-2" :value="old('email')" />
                                <x-forms.select label="State:" name="state" id="state" :required="true"
                                    size="col-lg-6 mt-2" :options="FretusFolks::getStates()" :value="old('state')" />
                                <x-forms.input label="Location: " type="text" name="location" id="location"
                                    :required="true" size="col-lg-6 mt-2" :value="old('location')" />
                                <x-forms.input label="Enter Designation: " type="text" name="designation"
                                    id="designation" :required="true" size="col-lg-6 mt-2" :value="old('designation')" />
                                <x-forms.input label="Enter Department: " type="text" name="department"
                                    id="department" :required="true" size="col-lg-6 mt-2" :value="old('department')" />
                                <x-forms.input label="Date of Interview  " type="date" name="interview_date"
                                    id="interview_date" :required="true" size="col-lg-6 mt-2" :value="old('interview_date')" />
                                {{-- <x-forms.input label="Date of Joining: " type="date" name="joining_date"
                                    id="joining_date" :required="true" size="col-lg-6 mt-2" :value="old('joining_date')" /> --}}
                                <div class="form-group col-lg-6 mt-2">
                                    <label for="emp_name">Enter Adhar Card No: <span style="color: red">*</span></label>
                                    <input type="text" name="aadhar_no" id="aadhar_no" class="form-control"
                                        maxlength="12" value="{{ old('aadhar_no') }}" required>
                                </div>

                                {{-- <x-forms.input label="Attach Adhaar Card:" type="file" name="aadhar_path"
                                    id="aadhar_path" :required="true" size="col-lg-6 mt-2" :value="old('aadhar_path')" /> --}}
                                <div class="form-group col-lg-6 mt-2">
                                    <label for="driving_license_no">Enter Driving License No:</label>
                                    <input type="text" name="driving_license_no" id="driving_license_no"
                                        class="form-control" value="{{ old('driving_license_no') }}">
                                </div>
                                {{-- <x-forms.input label="Attach Driving License:" type="file"
                                    name="driving_license_path" id="driving_license_path" :required="true"
                                    size="col-lg-6 mt-2" :value="old('driving_license_path')" /> --}}
                                <div class="form-group col-lg-6 mt-2">
                                    <label for="photo">Photo:<span style="color: red;">*</span></label>
                                    <input type="file" name="photo" id="photo" accept="image/jpg, image/png"
                                        required class="form-control" value="{{ old('photo') }}">

                                </div>
                                <div class="form-group col-lg-6 mt-2">
                                    <label for="resume">Resume:<s<span style="color: red;">*</span></label>
                                    <input type="file" name="resume" id="resume"
                                        accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/pdf"
                                        required class="form-control">
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
            $(document).ready(function() {
                $("#cfisform").on("submit", function(e) {
                    var isValid = true;
                    $(".error").remove();

                    var empName = $("#emp_name").val();
                    if (empName == '') {
                        isValid = false;
                        $("#emp_name").after(
                            "<span class='error' style='color:red; font-size: 13px;'>Employee name is required</span>"
                        );
                    }

                    var phone = $("#phone1").val();
                    if (phone && !/^\d{10,}$/.test(phone)) {
                        isValid = false;
                        $("#phone1").after(
                            "<span class='error' style='color:red; font-size: 13px;'>Please enter a valid phone number with at least 10 digits</span>"
                        );
                    }

                    var email = $("#email").val();
                    if (email && !/^[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,}$/.test(email)) {
                        isValid = false;
                        $("#email").after(
                            "<span class='error' style='color:red; font-size: 13px;'>Please enter a valid email address</span>"
                        );
                    }

                    var state = $("#state").val();
                    if (!state) {
                        isValid = false;
                        $("#state").after(
                            "<span class='error' style='color:red; font-size: 13px;'>State is required</span>"
                        );
                    }

                    var location = $("#location").val();
                    if (!location) {
                        isValid = false;
                        $("#location").after(
                            "<span class='error' style='color:red; font-size: 13px;'>Location is required</span>"
                        );
                    }

                    var designation = $("#designation").val();
                    if (!designation) {
                        isValid = false;
                        $("#designation").after(
                            "<span class='error' style='color:red; font-size: 13px;'>Designation is required</span>"
                        );
                    }

                    var department = $("#department").val();
                    if (!department) {
                        isValid = false;
                        $("#department").after(
                            "<span class='error' style='color:red; font-size: 13px;'>Department is required</span>"
                        );
                    }

                    var interviewDate = $("#interview_date").val();
                    if (!interviewDate) {
                        isValid = false;
                        $("#interview_date").after(
                            "<span class='error' style='color:red; font-size: 13px;'>Interview date is required</span>"
                        );
                    }

                    var aadharNo = $("#aadhar_no").val();
                    if (aadharNo && !/^\d{12}$/.test(aadharNo)) {
                        isValid = false;
                        $("#aadhar_no").after(
                            "<span class='error' style='color:red; font-size: 13px;'>Aadhar number must be 12 digits</span>"
                        );
                    }

                    var drivingLicenseNo = $("#driving_license_no").val();
                    if (drivingLicenseNo && !/^[a-zA-Z0-9]+$/.test(drivingLicenseNo)) {
                        isValid = false;
                        $("#driving_license_no").after(
                            "<span class='error' style='color:red; font-size: 13px;'>Please enter a valid driving license number</span>"
                        );
                    }

                    var photo = $("#photo").val();
                    if (photo && !/\.(jpg|jpeg|png)$/i.test(photo)) {
                        isValid = false;
                        $("#photo").after(
                            "<span class='error' style='color:red; font-size: 13px;'>Please upload a valid photo (JPG, PNG, or PDF)</span>"
                        );
                    }

                    var resume = $("#resume").val();
                    if (resume && !/\.(doc|docx|pdf)$/i.test(resume)) {
                        isValid = false;
                        $("#resume").after(
                            "<span class='error' style='color:red; font-size: 13px;'>Please upload a valid resume (DOC, DOCX, or PDF)</span>"
                        );
                    }

                    if (!isValid) {
                        e.preventDefault();
                        console.log("Form validation failed, please correct the errors.");
                    }
                });
            });
        </script>
    @endpush

</x-applayout>
