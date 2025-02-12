<x-applayout>
    <x-admin.breadcrumb title="Document Rejection" />
    <style>
        .btn-custom {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
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
    @foreach ($candidate->candidateDocuments as $doc)
        @if ($doc->status == 2)
            <div class="alert alert-danger">
                <strong>Note:</strong> The document <b>{{ $doc->name }}</b> has been rejected.
            </div>
        @endif
    @endforeach
    @foreach ($candidate->otherCertificates as $doc)
        @if ($doc->status == 2)
            <div class="alert alert-danger">
                <strong>Note:</strong> One odf the Other Certificate has been rejected.
            </div>
        @endif
    @endforeach
    @foreach ($candidate->educationCertificates as $doc)
        @if ($doc->status == 2)
            <div class="alert alert-danger">
                <strong>Note:</strong> One odf the Education Certificate has been rejected.
            </div>
        @endif
    @endforeach
    @if (old('note', $candidate->note))
        <div class="alert alert-danger text-danger font-weight-bold">
            <strong>Rejected Field:</strong> {{ old('note', $candidate->note) }}
        </div>
    @endif

    <div class="col-lg-12 pb-4">
        <div class="form-card px-3">
            <form action="{{ route('admin.dcs_approval.docedit', $candidate->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="card mt-3">
                    <div class="card-header header-elements-inline d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Back End Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-contents">
                            <div class="row">
                                <x-forms.select label="Enter Client Name:" name="client_id" id="client_id"
                                    :required="true" size="col-lg-6 mt-2" :options="FretusFolks::getClientname()" :value="old('client_id', $candidate->client_id)" />

                                <x-forms.input label="Console ID: " type="text" name="console_id" id="console_id"
                                    :required="false" size="col-lg-6 mt-2" :value="old('console_id', $candidate->console_id)" />
                                <x-forms.input label="Enter Client Employee ID: " type="text" name="client_emp_id"
                                    id="client_emp_id" :required="false" size="col-lg-6 mt-2" :value="old('client_emp_id', $candidate->client_emp_id)" />
                                <x-forms.input label="Grade: " type="text" name="grade" id="grade"
                                    :required="false" size="col-lg-6 mt-2" :value="old('grade', $candidate->grade)" />
                                <x-forms.input label="Enter Employee Name: " type="text" name="emp_name"
                                    id="emp_name" :required="true" size="col-lg-6 mt-2" :value="old('emp_name', $candidate->emp_name)" />

                                <x-forms.input label="Interview Date:  " type="date" name="interview_date"
                                    id="interview_date" :required="true" size="col-lg-6 mt-2"
                                    value="{{ old('interview_date', $candidate->interview_date ? $candidate->interview_date->format('Y-m-d') : '') }}" />

                                <x-forms.input label="Joining Date: " type="date" name="joining_date"
                                    id="joining_date" :required="true" size="col-lg-6 mt-2"
                                    value="{{ old('joining_date', $candidate->joining_date ? $candidate->joining_date->format('Y-m-d') : '') }}" />

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
                                <x-forms.radio label="Gender: " :options="[
                                    ['value' => 'Male', 'label' => 'Male'],
                                    ['value' => 'Female', 'label' => 'Female'],
                                    ['value' => 'Other', 'label' => 'Other'],
                                ]" id="gender" name="gender"
                                    :required="true" size="col-lg-12 mt-2" :value="old('gender', $candidate->gender)" />
                                <x-forms.input label="DOB: " type="date" name="dob" id="dob"
                                    :required="true" size="col-lg-6 mt-2"
                                    value="{{ old('dob', $candidate->dob ? $candidate->dob->format('Y-m-d') : '') }}" />
                                <x-forms.select label="Marital Status:" name="maritial_status" id="maritial_status"
                                    :required="true" size="col-lg-6 mt-2" :options="FretusFolks::getMarital()" :value="old('maritial_status', $candidate->maritial_status)" />
                                <div id="married-fields" style="display: none;" class="col-12">
                                    <div class="row">
                                        <div class="form-group col-lg-3 mt-2">
                                            <label for="spouse_name">Spouse Name:<span
                                                    style="color: red">*</span></label>
                                            <input type="text" name="spouse_name" id="spouse_name"
                                                class="form-control"
                                                value="{{ old('spouse_name', $candidate->spouse_name) }}">
                                        </div>

                                        <div class="form-group col-lg-3 mt-2">
                                            <label for="spouse_dob">Spouse's DOB:<span
                                                    style="color: red">*</span></label>
                                            <input type="date" name="spouse_dob" id="spouse_dob"
                                                class="form-control"
                                                value="{{ old('spouse_dob', $candidate->spouse_dob) }}">
                                        </div>

                                        <div class="form-group col-lg-3 mt-2">
                                            <label for="spouse_aadhar_no">Enter Spouse Adhar Card No: <span
                                                    style="color: red">*</span></label>
                                            <input type="text" name="spouse_aadhar_no" id="spouse_aadhar_no"
                                                class="form-control" maxlength="12" inputmode="numeric"
                                                value="{{ old('spouse_aadhar_no', $candidate->spouse_aadhar_no) }}">
                                        </div>
                                        <div class="form-group col-lg-3 mt-2">
                                            <label for="spouse_photo">Spouse Photo: </label>
                                            <input type="file" name="spouse_photo" id="spouse_photo"
                                                accept="application/pdf, image/jpg, image/png" class="form-control"
                                                value="{{ old('spouse_photo', $candidate->spouse_photo) }}">
                                        </div>
                                        <x-forms.input label="No of Children:" type="number" name="no_of_childrens"
                                            id="no_of_childrens" :required="false" size="col-lg-6 mt-2"
                                            :value="old('no_of_childrens', $candidate->no_of_childrens)" />
                                    </div>
                                    <div id="children-details-container" class="mt-3" style="display: none;">
                                        <div id="children-details">
                                        </div>
                                        <div id="max-children-message"
                                            style="display: none; color: red; margin-top: 10px;">
                                            You can only add details for up to 2 children.
                                        </div>
                                    </div>
                                </div>



                                <x-forms.input label="Father Name:  " type="text" name="father_name"
                                    id="father_name" :required="true" size="col-lg-3 mt-2" :value="old('father_name', $candidate->father_name)" />
                                <x-forms.input label="Father's DOB: " type="date" name="father_dob"
                                    id="father_dob" :required="true" size="col-lg-3 mt-2" :value="old('father_dob', $candidate->father_dob)" />
                                <div class="form-group col-lg-3 mt-2">
                                    <label for="father_aadhar_no">Father's Adhar Card No: <span
                                            style="color: red">*</span></label>
                                    <input type="text" name="father_aadhar_no" id="father_aadhar_no"
                                        class="form-control" maxlength="12" inputmode="numeric"
                                        value="{{ old('father_aadhar_no', $candidate->father_aadhar_no) }}" required>
                                </div>
                                <div class="form-group col-lg-3 mt-2">
                                    <label for="father_photo">Father Photo: </label>
                                    <input type="file" name="father_photo" id="father_photo"
                                        accept="application/pdf, image/jpg, image/png" class="form-control"
                                        value="{{ old('father_photo', $candidate->father_photo) }}">
                                </div>
                                <x-forms.input label="Mother Name: " type="text" name="mother_name"
                                    id="mother_name" :required="true" size="col-lg-3 mt-2" :value="old('mother_name', $candidate->mother_name)" />
                                <x-forms.input label="Mother's DOB: " type="date" name="mother_dob"
                                    id="mother_dob" :required="true" size="col-lg-3 mt-2" :value="old('mother_dob', $candidate->mother_dob)" />
                                <div class="form-group col-lg-3 mt-2">
                                    <label for="mother_aadhar_no">Mother's Adhar Card No: <span
                                            style="color: red">*</span></label>
                                    <input type="text" name="mother_aadhar_no" id="mother_aadhar_no"
                                        class="form-control" maxlength="12" inputmode="numeric"
                                        value="{{ old('mother_aadhar_no', $candidate->mother_aadhar_no) }}" required>
                                </div>
                                <div class="form-group col-lg-3 mt-2">
                                    <label for="mother_photo">Mother Photo: </label>
                                    <input type="file" name="mother_photo" id="mother_photo"
                                        accept="application/pdf, image/jpg, image/png" class="form-control"
                                        value="{{ old('mother_photo', $candidate->mother_photo) }}">
                                </div>
                                <x-forms.input label="Religion: " type="text" name="religion" id="religion"
                                    :required="true" size="col-lg-6 mt-2" :value="old('religion', $candidate->religion)" />
                                <x-forms.input label="Languages: " type="text" name="languages" id="languages"
                                    placeholder="English,Kannada.." :required="true" size="col-lg-6 mt-2"
                                    :value="old('languages', $candidate->languages)" />
                                <x-forms.input label="Mother Tongue: " type="text" name="mother_tongue"
                                    id="mother_tongue" :required="true" size="col-lg-6 mt-2" :value="old('mother_tongue', $candidate->mother_tongue)" />
                                <x-forms.select label="Blood Group:" name="blood_group" id="blood_group"
                                    :required="true" size="col-lg-6 mt-2" :options="FretusFolks::getBlood()" :value="old('blood_group', $candidate->blood_group)" />
                                <div class="form-group col-lg-6 mt-2">
                                    <label for="emer_contact_no">Emergency Contact Person Number: <span
                                            style="color: red">*</span></label>
                                    <input type="text" name="emer_contact_no" id="emer_contact_no"
                                        class="form-control" maxlength="10" inputmode="numeric"
                                        value="{{ old('emer_contact_no', $candidate->emer_contact_no) }}" required>
                                </div><x-forms.input label="Emergency Contact Person Name:" type="text"
                                    name="emer_name" id="emer_name" :required="true" size="col-lg-6 mt-2"
                                    :value="old('emer_name', $candidate->emer_name)" />
                                <x-forms.input label="Emergency Contact Person Relation:" type="text"
                                    name="emer_relation" id="emer_relation" :required="true" size="col-lg-6 mt-2"
                                    :value="old('emer_relation', $candidate->emer_relation)" />
                                <x-forms.select label=" Qualification:" name="qualification" id="qualification"
                                    :required="true" size="col-lg-6 mt-2" :options="FretusFolks::getQualification()" :value="old('qualification', $candidate->qualification)" />
                                <div class="form-group col-lg-4 mt-2">
                                    <label for="phone1">Phone: <span style="color: red">*</span></label>
                                    <input type="text" name="phone1" id="phone1" class="form-control"
                                        maxlength="10" inputmode="numeric"
                                        value="{{ old('phone1', $candidate->phone1) }}" required>
                                </div>
                                <x-forms.input label="Employee Email ID: " type="email" name="email"
                                    id="email" :required="true" size="col-lg-4 mt-2" :value="old('email', $candidate->email)" />
                                <x-forms.input label="Official Email ID: " type="email" name="official_mail_id"
                                    id="official_mail_id" :required="false" size="col-lg-4 mt-2"
                                    :value="old('official_mail_id', $candidate->official_mail_id)" />
                                <div class="form-group col-lg-6 mt-2">
                                    <label for="permanent_address">Enter Permanent Address:<span
                                            style="color: red">*</span></label>
                                    <textarea name="permanent_address" id="permanent_address" class="form-control" required>{{ old('permanent_address', $candidate->permanent_address) }}</textarea>
                                </div>

                                <div class="form-group col-lg-6 mt-2">
                                    <label for="present_address">Enter Present Address:<span
                                            style="color: red">*</span></label>
                                    <textarea name="present_address" id="present_address" class="form-control" required>{{ old('present_address', $candidate->present_address) }}</textarea>
                                </div>
                                <div class="form-group col-lg-6 mt-2">
                                    <label for="pan_status">Do you have a PAN Card? <span
                                            style="color: red">*</span></label>
                                    <select name="pan_status" id="pan_status" class="form-control">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>

                                <!-- PAN Card Input Fields (Initially Hidden) -->
                                <div id="panFields" style="display: none;">
                                    <div class="row">
                                        <x-forms.input label="Enter PAN Card No:" type="text" name="pan_no"
                                            id="pan_no" :required="false" size="col-lg-6 mt-2"
                                            :value="old('pan_no', $candidate->pan_no)" />
                                        <div class="form-group col-lg-6 mt-2">
                                            <label for="pan_path">Attach PAN: </label>
                                            <input type="file" name="pan_path" id="pan_path"
                                                accept=".doc, .docx, .pdf, .jpg, .png" class="form-control"
                                                value="{{ old('pan_path', $candidate->pan_path) }}">
                                        </div>
                                        <div class="col-lg-6">
                                            @if (!empty($child->photo))
                                                <!-- Check if the child has a photo -->
                                                <div id="image-preview-container" class="d-flex mt-2">
                                                    <img src="{{ asset('storage/' . $child->photo) }}"
                                                        class="img-thumbnail" width="100" height="100"
                                                        alt="Child photo">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Document Download & Upload Section (Initially Hidden) -->
                                <div id="documentSection" style="display: none;">
                                    <div class="row">
                                        <div class="form-group col-lg-6 mt-2">
                                            <label>Download PAN Declaration Document:</label>
                                            <a id="downloadLink" class="btn btn-primary"
                                                download="PAN_Declaration.pdf"
                                                style="cursor: pointer;width: 30%;display: block;">Download</a>
                                        </div>
                                        <div class="form-group col-lg-6 mt-2">
                                            <label for="pan_declaration">Upload Signed Document:</label>
                                            <input type="file" name="pan_declaration" id="pan_declaration"
                                                accept=".doc, .docx, .pdf, .jpg, .png" class="form-control">
                                        </div>
                                        <input type="hidden" id="statename"
                                            value="{{ $candidate->clientstate->state_name ?? 'State' }}">
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 mt-2">
                                    <label for="aadhar_no">Enter Adhar Card No: </label>
                                    <input type="text" name="aadhar_no" id="aadhar_no" class="form-control"
                                        maxlength="12" inputmode="numeric"
                                        value="{{ old('aadhar_no', $candidate->aadhar_no) }}">
                                </div>
                                <div class="form-group col-lg-6 mt-2">
                                    <label for="aadhar_path">Attach Aadhar Card: </label>
                                    <input type="file" name="aadhar_path" id="aadhar_path"
                                        accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/pdf, image/jpg, image/png"
                                        class="form-control"a
                                        value="{{ old('aadhar_path', $candidate->aadhar_path) }}">
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

                                <x-forms.input label="Attach New Photo:" type="file" name="photo"
                                    id="photo" :required="false" size="col-lg-6 mt-2" />
                                <x-forms.input label="Attach New Resume:" type="file" name="resume"
                                    id="resume" :required="false" size="col-lg-6 mt-2" />
                                <div class="form-group col-lg-6 mt-2">
                                    <label for="family_photo">Family Photo: </label>
                                    <input type="file" name="family_photo" id="family_photo"
                                        accept="application/pdf, image/jpg, image/png" class="form-control"
                                        value="{{ old('family_photo', $candidate->family_photo) }}">
                                </div>
                                <x-forms.input label="Enter Bank Name:" type="text" name="bank_name"
                                    id="bank_name" :required="true" size="col-lg-6 mt-2" :value="old('bank_name', $candidate->bank_name)" />

                                <x-forms.input label="Attach New Bank Document:" type="file" name="bank_document"
                                    id="bank_document" :required="false" size="col-lg-6 mt-2" />
                                <x-forms.input label="Enter Bank Account No::" type="text" name="bank_account_no"
                                    id="bank_account_no" :required="true" size="col-lg-6 mt-2" :value="old('bank_account_no', $candidate->bank_account_no)" />
                                <x-forms.input label="Repeat Bank Account No:" type="text" name="bank_account_no"
                                    id="bank_account_no" :required="false" size="col-lg-6 mt-2" :value="old('bank_account_no', $candidate->bank_account_no)" />
                                <x-forms.input label="Enter Bank IFSC CODE:" type="text" name="bank_ifsc_code"
                                    id="bank_ifsc_code" :required="true" size="col-lg-6 mt-2" :value="old('bank_ifsc_code', $candidate->bank_ifsc_code)" />
                                <x-forms.input label="UAN No:" type="text" name="uan_no" id="uan_no"
                                    :required="false" size="col-lg-6 mt-2" :value="old('uan_no', $candidate->uan_no)" />

                                <label class="col-lg-12 mt-4"><strong>Current Uploaded Documents</strong></label>
                                <div style="border: 1px solid #d6c8c8; padding: 2%; margin-bottom: 1%;">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Document Name</th>
                                                <th>View Document</th>
                                                <th>Upload Document</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $candidateDocuments = [
                                                    'pan_path' => 'PAN Document',
                                                    'aadhar_path' => 'Aadhar Document',
                                                    'driving_license_path' => 'Driving License',
                                                    'photo' => 'Photo',
                                                    'resume' => 'Resume',
                                                    'bank_document' => 'Bank Document',
                                                    'voter_id' => 'Voter ID/ PVC/ UL',
                                                    'emp_form' => 'Employee Form',
                                                    'pf_esic_form' => 'PF Form / ESIC',
                                                    'payslip' => 'Payslip/Fitness Document',
                                                    'exp_letter' => 'Experience Letter',
                                                    'father_photo' => 'Father Photo',
                                                    'mother_photo' => 'Mother Photo',
                                                    'spouse_photo' => 'Spouse_photo',
                                                    'family_photo' => 'Family Photo',
                                                    'pan_declaration' => 'Pan Declaration',
                                                ];
                                            @endphp

                                            @if ($candidate->candidateDocuments->isNotEmpty())
                                                @foreach ($candidate->candidateDocuments as $certificate)
                                                    <tr>
                                                        <td>
                                                            {{ $candidateDocuments[$certificate->name] ?? $certificate->name }}
                                                        </td>
                                                        <td>
                                                            <a href="{{ asset('storage/' . $certificate->path) }}"
                                                                target="_blank" class="btn btn-custom">
                                                                View
                                                                {{ $candidateDocuments[$certificate->name] ?? $certificate->name }}
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <input type="file"
                                                                accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/pdf"
                                                                name="document_file[{{ $certificate->name }}]"
                                                                class="form-control">
                                                        </td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm dropdown-toggle"
                                                                    type="button"
                                                                    id="statusDropdown{{ $certificate->id }}"
                                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                                    {{ $certificate->status == 1 ? 'Approved' : ($certificate->status == 0 ? 'Pending' : 'Rejected') }}
                                                                </button>
                                                                <ul class="dropdown-menu"
                                                                    aria-labelledby="statusDropdown{{ $certificate->id }}">
                                                                    <li><a class="dropdown-item"
                                                                            href="{{ route('admin.document.status', ['id' => $certificate->id, 'newStatus' => 0]) }}">Pending</a>
                                                                    </li>
                                                                    <li><a class="dropdown-item"
                                                                            href="{{ route('admin.document.status', ['id' => $certificate->id, 'newStatus' => 2]) }}">Rejected</a>
                                                                    </li>
                                                                    {{-- <li><a class="dropdown-item"
                                                                            href="{{ route('admin.document.status', ['id' => $certificate->id, 'newStatus' => 1]) }}">Approved</a>
                                                                    </li> --}}
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif

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
                                                            <input type="file"
                                                                accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/pdf"
                                                                name="document_file[education_certificate_{{ $loop->iteration }}]"
                                                                class="form-control">
                                                        </td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm dropdown-toggle"
                                                                    type="button"
                                                                    id="statusDropdown{{ $certificate->id }}"
                                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                                    {{ $certificate->status == 1 ? 'Approved' : ($certificate->status == 0 ? 'Pending' : 'Rejected') }}
                                                                </button>
                                                                <ul class="dropdown-menu"
                                                                    aria-labelledby="statusDropdown{{ $certificate->id }}">
                                                                    <li><a class="dropdown-item"
                                                                            href="{{ route('admin.document.status', ['id' => $certificate->id, 'newStatus' => 0]) }}">Pending</a>
                                                                    </li>
                                                                    <li><a class="dropdown-item"
                                                                            href="{{ route('admin.document.status', ['id' => $certificate->id, 'newStatus' => 2]) }}">Rejected</a>
                                                                    </li>
                                                                    {{-- <li><a class="dropdown-item"
                                                                            href="{{ route('admin.document.status', ['id' => $certificate->id, 'newStatus' => 1]) }}">Approved</a>
                                                                    </li> --}}
                                                                </ul>
                                                            </div>
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
                                                            <input type="file"
                                                                accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/pdf"
                                                                name="document_file[other_certificate_{{ $loop->iteration }}]"
                                                                class="form-control">
                                                        </td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm dropdown-toggle"
                                                                    type="button"
                                                                    id="statusDropdown{{ $certificate->id }}"
                                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                                    {{ $certificate->status == 1 ? 'Approved' : ($certificate->status == 0 ? 'Pending' : 'Rejected') }}
                                                                </button>
                                                                <ul class="dropdown-menu"
                                                                    aria-labelledby="statusDropdown{{ $certificate->id }}">
                                                                    <li><a class="dropdown-item"
                                                                            href="{{ route('admin.document.status', ['id' => $certificate->id, 'newStatus' => 0]) }}">Pending</a>
                                                                    </li>
                                                                    <li><a class="dropdown-item"
                                                                            href="{{ route('admin.document.status', ['id' => $certificate->id, 'newStatus' => 2]) }}">Rejected</a>
                                                                    </li>
                                                                    {{-- <li><a class="dropdown-item"
                                                                            href="{{ route('admin.document.status', ['id' => $certificate->id, 'newStatus' => 1]) }}">Approved</a>
                                                                    </li> --}}
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>

                                </div>

                                {{-- <label size="col-lg-12 mt-4"><strong>Salary Details</strong></label>
                                <div
                                    style="border:
                                    1px solid #d6c8c8;padding: 2%;margin-bottom: 1%;">
                                    <div class="row">
                                        <x-forms.input label="Basic Salary: " type="number" name="basic_salary"
                                            id="basic_salary" :required="false" size="col-lg-3 mt-1"
                                            :value="old('basic_salary', $candidate->basic_salary)" />
                                        <x-forms.input label="HRA: " type="number" name="hra" id="hra"
                                            :required="false" size="col-lg-3 mt-1" :value="old('hra', $candidate->hra)" />
                                        <x-forms.input label="Conveyance: " type="number" name="conveyance"
                                            id="conveyance" :required="false" size="col-lg-3 mt-1"
                                            :value="old('conveyance', $candidate->conveyance)" />
                                        <x-forms.input label="Medical Reimbursement:  " type="number"
                                            name="medical_reimbursement" id="medical_reimbursement"
                                            :required="false" size="col-lg-3 mt-2" :value="old('medical_reimbursement', $candidate->medical_reimbursement)" />
                                        <x-forms.input label="Special Allowance: " type="number"
                                            name="special_allowance" id="special_allowance" :required="false"
                                            size="col-lg-3 mt-2" :value="old('special_allowance', $candidate->special_allowance)" />
                                        <x-forms.input label="ST:" type="number" name="st_bonus" id="st_bonus"
                                            :required="false" size="col-lg-3 mt-2" :value="old('st_bonus', $candidate->st_bonus)" />
                                        <x-forms.input label="Other Allowance:  " type="number"
                                            name="other_allowance" id="other_allowance" :required="false"
                                            size="col-lg-3 mt-2" :value="old('other_allowance', $candidate->other_allowance)" />
                                        <x-forms.input label="Gross Salary: " type="number" name="gross_salary"
                                            id="gross_salary" :required="false" size="col-lg-3 mt-2"
                                            :value="old('gross_salary', $candidate->gross_salary)" />
                                        <x-forms.input label="Employee PF: " type="number" name="emp_pf"
                                            id="emp_pf" :required="false" size="col-lg-2 mt-2"
                                            :value="old('emp_pf', $candidate->emp_pf)" />
                                        <x-forms.input label="Employee ESIC :" type="number" name="emp_esic"
                                            id="emp_esic" :required="false" size="col-lg-2 mt-2"
                                            :value="old('emp_esic', $candidate->emp_esic)" />
                                        <x-forms.input label="PT: " type="number" name="pt" id="pt"
                                            :required="false" size="col-lg-2 mt-2" :value="old('pt', $candidate->pt)" />
                                        <x-forms.input label="Total Deduction:" type="number" name="total_deduction"
                                            id="total_deduction" :required="false" size="col-lg-3 mt-2"
                                            :value="old('total_deduction', $candidate->total_deduction)" />
                                        <x-forms.input label="Take Home Salary:" type="number" name="take_home"
                                            id="take_home" :required="false" size="col-lg-3 mt-2"
                                            :value="old('take_home', $candidate->take_home)" />
                                        <x-forms.input label="Employer PF: " type="number" name="employer_pf"
                                            id="employer_pf" :required="false" size="col-lg-3 mt-2"
                                            :value="old('employer_pf', $candidate->employer_pf)" />
                                        <x-forms.input label="Employer ESIC: " type="number" name="employer_esic"
                                            id="employer_esic" :required="false" size="col-lg-3 mt-2"
                                            :value="old('employer_esic', $candidate->employer_esic)" />
                                        <x-forms.input label="Mediclaim Insurance:  " type="number" name="mediclaim"
                                            id="mediclaim" :required="false" size="col-lg-3 mt-2"
                                            :value="old('mediclaim', $candidate->mediclaim)" />
                                        <x-forms.input label="Grand Total:  " type="number" name="ctc"
                                            id="ctc" :required="false" size="col-lg-3 mt-2"
                                            :value="old('basic_salary', $candidate->ctc)" />
                                    </div>
                                </div> --}}

                                <label><strong>Upload Documents</strong></label>
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
                                <x-forms.select label="Status " :options="[
                                    // ['value' => '1', 'label' => 'Approved'],
                                    ['value' => '0', 'label' => 'Pending'],
                                    ['value' => '2', 'label' => 'Rejected'],
                                ]" id="hr_approval"
                                    name="hr_approval" :required="true" size="col-lg-6 mt-2 mr-2"
                                    :value="old('hr_approval')" />
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
    <script>
        //maritial_status
        document.addEventListener('DOMContentLoaded', function() {
            const maritalStatus = document.getElementById('maritial_status');
            const marriedFields = document.getElementById('married-fields');

            function toggleMarriedFields() {
                if (maritalStatus.value === 'Married') {
                    marriedFields.style.display = 'block';
                    $('#spouse_aadhar_no').on('blur input', function() {
                        $(this).next('.error').remove();
                        var aadharPattern = /^\d{12}$/;
                        $(' #spouse_aadhar_no').each(function() {
                            var aadharNumber = $(this).val();
                            if (!aadharNumber) {
                                isValid = false;
                                $(this).after(
                                    "<span class='error' style='color:red; font-size: 13px;'>Please enter the Aadhar number.</span>"
                                );
                            } else if (!aadharPattern.test(aadharNumber)) {
                                isValid = false;
                                $(this).after(
                                    "<span class='error' style='color:red; font-size: 13px;'>Aadhar number must be a 12-digit numeric value.</span>"
                                );
                            }
                        });
                    });

                } else {
                    marriedFields.style.display = 'none';
                    document.getElementById('spouse_name').value = '';
                    document.getElementById('spouse_dob').value = '';
                    document.getElementById('spouse_aadhar_no').value = '';
                    document.getElementById('spouse_photo').value = '';
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
                <input type="file" accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/pdf"
                name="document_file[]" class="col-lg-5 me-3 " >
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
            const noOfChildrenField = document.getElementById('no_of_childrens');
            const childrenDetailsContainer = document.getElementById('children-details-container');
            const childrenDetails = document.getElementById('children-details');
            const maxChildrenMessage = document.getElementById('max-children-message');

            function calculateAge(dob) {
                if (!dob) return 0;
                const birthDate = new Date(dob);
                const today = new Date();
                return (today.getFullYear() - birthDate.getFullYear()) * 12 + (today.getMonth() - birthDate
                    .getMonth());
            }

            function updateChildDetails(existingChildren = []) {
                const noOfChildren = parseInt(noOfChildrenField.value) || 0;
                childrenDetails.innerHTML = '';

                if (noOfChildren > 0) {
                    childrenDetailsContainer.style.display = 'block';
                    maxChildrenMessage.style.display = 'none';

                    for (let i = 1; i <= noOfChildren && i <= maxChildren; i++) {
                        let childData = existingChildren[i - 1] || {};

                        const childRow = document.createElement('div');
                        childRow.className = 'row align-items-center mb-2 child-row';
                        childRow.innerHTML = `
                        <div class="form-group col-lg-3">
                            <label for="child_name_${i}">Child ${i} Name:<span style="color: red;">*</span></label>
                            <input type="text" name="child_names[]" id="child_name_${i}" class="form-control" 
                                   value="${childData.name || ''}" required>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="child_dob_${i}">Child ${i} DOB:<span style="color: red;">*</span></label>
                            <input type="date" name="child_dobs[]" id="child_dob_${i}" class="form-control"
                                   value="${childData.dob || ''}" required>
                        </div>
                        <div class="form-group col-lg-3 child-aadhar" id="child_aadhar_field_${i}" style="display: none;">
                            <label for="child_aadhar_${i}">Child ${i} Aadhar No:<span style="color: red;">*</span></label>
                            <input type="text" name="child_aadhar[]" id="child_aadhar_${i}" class="form-control" 
                                   value="${childData.aadhar_no || ''}" maxlength="12" inputmode="numeric">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="child_photo_${i}">Child ${i} Photo:</label>
                            <input type="file" name="child_photo[]" id="child_photo_${i}" accept="application/pdf, image/jpg, image/png" 
                                   class="form-control">
                        </div>
                    `;
                        childrenDetails.appendChild(childRow);

                        let dobField = document.getElementById(`child_dob_${i}`);
                        dobField.addEventListener('input', function() {
                            checkChildAge(i);
                        });

                        if (childData.dob) {
                            checkChildAge(i);
                        }
                    }

                    if (noOfChildren > maxChildren) {
                        maxChildrenMessage.style.display = 'block';
                    }
                } else {
                    childrenDetailsContainer.style.display = 'none';
                }
            }

            function checkChildAge(index) {
                const dobField = document.getElementById(`child_dob_${index}`);
                const aadharField = document.getElementById(`child_aadhar_field_${index}`);
                const aadharInput = document.getElementById(`child_aadhar_${index}`);

                if (dobField.value) {
                    const ageInMonths = calculateAge(dobField.value);
                    if (ageInMonths > 6) {
                        aadharField.style.display = 'block';
                        aadharInput.setAttribute('required', 'required');
                    } else {
                        aadharField.style.display = 'none';
                        aadharInput.removeAttribute('required');
                    }
                }
            }

            noOfChildrenField.addEventListener('input', function() {
                updateChildDetails();
            });

            let existingChildren = {!! json_encode(
                old('child_names')
                    ? collect(old('child_names'))->map(function ($name, $index) {
                        return [
                            'name' => $name,
                            'dob' => old('child_dobs')[$index] ?? '',
                            'aadhar_no' => old('child_aadhar')[$index] ?? '',
                        ];
                    })
                    : $children ?? [],
            ) !!};

            if (existingChildren.length > 0) {
                noOfChildrenField.value = existingChildren.length;
                updateChildDetails(existingChildren);
            }
        });
    </script>
</x-applayout>
