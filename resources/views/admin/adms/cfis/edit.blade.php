<x-applayout>
    <x-admin.breadcrumb title="Candidate First Information System" />
    <style>
        .btn-custom {
            background-color: #067e1a;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-custom:hover {
            background-color: #067e1a;
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
        <div class="form-card px-md-3 px-2">
            <form action="{{ route('admin.cfis.edit', $candidate->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card mt-3">
                    <div class="card-header header-elements-inline d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Edit Candidate Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-contents">
                            <div class="row">
                                <x-forms.select label="Enter Client Name:" name="client_id" id="client_id"
                                    :required="true" size="col-lg-6 mt-2" :options="FretusFolks::getClientname()" :value="old('client_id', $candidate->client_id)" />
                                {{-- <x-forms.input label="Enter Name: " type="text" name="emp_name" id="emp_name"
                                    :required="true" size="col-lg-6 mt-2" :value="old('emp_name', $candidate->emp_name)" /> --}}
                                <div class="form-group col-lg-6 mt-2">
                                    <label for="emp_name">Enter Name: <span style="color: red">*(Enter Name as per
                                            aadhar)</span></label>
                                    <input type="text" name="emp_name" id="emp_name" class="form-control"
                                        value="{{ old('emp_name', $candidate->emp_name) }}">
                                </div>
                                <div class="form-group col-lg-6 mt-2">
                                    <label for="phone1">Employee Mobile: <span style="color: red">*</span></label>
                                    <input type="number" name="phone1" id="phone1" class="form-control"
                                        maxlength="10" value="{{ old('phone1', $candidate->phone1) }}" required>
                                </div>
                                <x-forms.input label="Employee Email ID: " type="email" name="email" id="email"
                                    :required="true" size="col-lg-6 mt-2" :value="old('email', $candidate->email)" />
                                <x-forms.select label="State:" name="state" id="state" :required="true"
                                    size="col-lg-6 mt-2" :options="FretusFolks::getStates()" :value="old('state', $candidate->state)" />
                                <x-forms.input label="Location: " type="text" name="location" id="location"
                                    :required="true" size="col-lg-6 mt-2" :value="old('location', $candidate->location)" />
                                <x-forms.input label="Enter Designation: " type="text" name="designation"
                                    id="designation" :required="true" size="col-lg-6 mt-2" :value="old('designation', $candidate->designation)" />
                                <x-forms.input label="Enter Department: " type="text" name="department"
                                    id="department" :required="true" size="col-lg-6 mt-2" :value="old('department', $candidate->department)" />
                                <x-forms.input label="Date of Interview  " type="date" name="interview_date"
                                    id="interview_date" :required="true" size="col-lg-6 mt-2"
                                    value="{{ old('interview_date', $candidate->interview_date ? $candidate->interview_date->format('Y-m-d') : '') }}" />
                                {{-- <x-forms.input label="Date of Joining: " type="date" name="joining_date"
                                    id="joining_date" :required="true" size="col-lg-6 mt-2" :value="old('joining_date')" /> --}}
                                <div class="form-group col-lg-6 mt-2">
                                    <label for="aadhar_no">Employee Mobile: <span style="color: red">*</span></label>
                                    <input type="number" name="aadhar_no" id="aadhar_no" class="form-control"
                                        maxlength="10" value="{{ old('aadhar_no', $candidate->aadhar_no) }}" required>
                                </div>
                                {{-- <x-forms.input label="Attach Adhaar Card:" type="file" name="aadhar_path"
                                    id="aadhar_path" :required="true" size="col-lg-6 mt-2" :value="old('aadhar_path')" /> --}}
                                <div class="form-group col-lg-6 mt-2">
                                    <label for="driving_license_no">Enter Driving License No:</label>
                                    <input type="text" name="driving_license_no" id="driving_license_no"
                                        class="form-control"
                                        value="{{ old('driving_license_no', $candidate->driving_license_no) }}">
                                </div>
                                {{-- <x-forms.input label="Attach Driving License:" type="file"
                                    name="driving_license_path" id="driving_license_path" :required="true"
                                    size="col-lg-6 mt-2" :value="old('driving_license_path')" /> --}}
                                <div class="form-group col-lg-6 mt-2">
                                    <label for="photo">Photo:</label>
                                    <input type="file" name="photo" id="photo" accept="image/jpg, image/png"
                                        class="form-control">

                                    @if ($candidate->candidateDocuments->where('name', 'photo')->isNotEmpty())
                                        @php
                                            $photo = $candidate->candidateDocuments->where('name', 'photo')->first();
                                        @endphp
                                        <div id="image-preview-container" class="d-flex mt-2">
                                            <img src="{{ asset('storage/' .$photo->path) }}" class="img-thumbnail" width="100"
                                                height="100" alt="Uploaded image">
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group col-lg-6">
                                    <label for="resume">Resume:</label>
                                    <input type="file" name="resume" id="resume"
                                        accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/pdf"
                                        class="form-control">

                                    @if ($candidate->candidateDocuments->where('name', 'resume')->isNotEmpty())
                                        @php
                                            $resume = $candidate->candidateDocuments->where('name', 'resume')->first();
                                        @endphp
                                        <a href="{{ asset('storage/' .$resume->path) }}" target="_blank"
                                            class="btn btn-custom mt-2">
                                            View Resume
                                        </a>
                                    @endif
                                </div>


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
            document.getElementById("photo").addEventListener("change", function(event) {
                const previewContainer = document.getElementById("image-preview-container");
                previewContainer.innerHTML = ""; // Clear previous preview

                const file = event.target.files[0];

                if (file) {
                    // Check file type
                    const validTypes = ["image/jpeg", "image/png"];
                    if (!validTypes.includes(file.type)) {
                        alert("Invalid file type. Please select a JPG or PNG image.");
                        return;
                    }


                    // Create an image element for preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement("img");
                        img.src = e.target.result;
                        img.alt = "Image Preview";
                        img.style.maxWidth = "200px";
                        img.style.maxHeight = "200px";
                        img.classList.add("img-thumbnail");
                        previewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            });
            //validation
            $(document).ready(function() {
                $("#cfisform").on("submit", function(e) {
                    var isValid = true;
                    $(".error").remove();

                    var empName = $("#emp_name").val();
                    if (!empName) {
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
