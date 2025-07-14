<x-applayout>
     <x-admin.breadcrumb title="{{ false }}" isBack="{{ true }}" />
    <style>
        .custom-card {
            border-radius: 8px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .custom-header {
            background-color: #d8e6f3;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 8px 8px 0 0;
            font-weight: bold;
        }

        .custom-header:hover {
            background-color: #d8e6f3;
        }
    </style>
    <div class="content">
        <div class="row">
            <div class="col-lg-12 pb-4 ">
                <div class="form-card px-md-3 px-2">
                    <div class="header  text-white" style="background-color: #517bb9;">
                        <div class="row">
                            <div class="col-lg-10">
                                <h4 class="modal-title">Candidate Details
                                    <div>
                                        <h5>{{ $candidate?->ffi_emp_id }}-
                                            {{ $candidate?->emp_name }}</h5>
                                    </div>
                                </h4>
                            </div>
                            <div class="col-lg-2">
                                <h5>Status: {{ $candidate?->status == 1 ? 'Active' : 'Inactive' }}</h5>
                            </div>
                        </div>

                    </div>
                    <div class="accordion" id="accordionExample">
                        <div class="card custom-card">
                            <div class="custom-header d-flex justify-content-between align-items-center"
                                data-bs-toggle="collapse" data-bs-target="#personalDetails" aria-expanded="true"
                                aria-controls="personalDetails">
                                <span>Personal Details</span>
                                <i class="bx bx-chevron-down chevron-icon"></i>
                            </div>
                            <div id="personalDetails" class="accordion-collapse collapse show"
                                aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-2"><b>CLient Name:</b>
                                            <span>{{ $candidate?->entity_name ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>FFI Emp ID:</b>
                                            <span>{{ $candidate?->ffi_emp_id ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Client Emp ID:</b>
                                            <span>{{ $candidate?->client_emp_id ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Full Name:</b>
                                            <span>{{ $candidate?->emp_name }}
                                                {{ $candidate?->middle_name }} {{ $candidate?->last_name }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>DOB:</b>
                                            <span>{{ \Carbon\Carbon::parse($candidate?->dob)->format('d-m-Y') }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Gender:</b>
                                            <span>{{ $candidate?->gender }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Designation:</b>
                                            <span>{{ $candidate?->designation ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Department:</b>
                                            <span>{{ $candidate?->department ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Interview Date:</b>
                                            <span>{{ \Carbon\Carbon::parse($candidate?->interview_date)->format('d-m-Y') }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Joining Date:</b>
                                            <span>{{ \Carbon\Carbon::parse($candidate?->joining_date)->format('d-m-Y') }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Email:</b>
                                            <span>{{ $candidate?->email ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Phone 1:</b>
                                            <span>{{ $candidate?->phone1 ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Location:</b>
                                            <span>{{ $candidate?->location ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>State:</b>
                                            <span>{{ $candidate?->clientstate->state_name ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Religion:</b>
                                            <span>{{ $candidate?->religion ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Mother Tongue:</b>
                                            <span>{{ $candidate?->mother_tongue ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Languages:</b>
                                            <span>{{ $candidate?->languages ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Blood Group:</b>
                                            <span>{{ $candidate?->blood_group ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Qualification:</b>
                                            <span>{{ $candidate?->qualification ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>PAN No:</b>
                                            <span>{{ $candidate?->pan_no ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Aadhar No:</b>
                                            <span>{{ $candidate?->aadhar_no ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Driving License NO:</b>
                                            <span>{{ $candidate?->driving_license_no ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Password:</b>
                                            <span>{{ $candidate?->psd ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Created By:</b>
                                            <span>{{ $candidate?->creator->name ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-12 mb-2"><b>Permanent Address:</b>
                                            <span>{{ $candidate?->permanent_address ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-12 mb-2"><b>Present Address:</b>
                                            <span>{{ $candidate?->present_address ?? 'N/A' }}</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <hr>
                        <div class="card custom-card">
                            <div class="custom-header d-flex justify-content-between align-items-center"
                                data-bs-toggle="collapse" data-bs-target="#familyDetails" aria-expanded="false"
                                aria-controls="familyDetails">
                                <span>Family Details</span>
                                <i class="bx bx-chevron-down chevron-icon"></i>
                            </div>
                            <div id="familyDetails" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-2"><b>Father Name:</b>
                                                <span>{{ $candidate?->father_name ?? 'N/A' }}</span>
                                            </div>
                                            <div class="col-md-4 mb-2"><b>Father DOB:</b>
                                                <span>{{ $candidate?->father_dob && $candidate->father_dob != '0000-00-00' ? \Carbon\Carbon::parse($candidate->father_dob)->format('d-m-Y') : 'N/A' }}
                                                </span>
                                            </div>
                                            <div class="col-md-4 mb-2"><b>Father Aadhar No:</b>
                                                <span>{{ $candidate?->father_aadhar_no ?? 'N/A' }}</span>
                                            </div>
                                            <div class="col-md-4 mb-2"><b>Mother Name:</b>
                                                <span>{{ $candidate?->mother_name ?? 'N/A' }}</span>
                                            </div>
                                            <div class="col-md-4 mb-2"><b>Mother DOB:</b>
                                                <span>{{ $candidate?->mother_dob && $candidate->mother_dob != '0000-00-00' ? \Carbon\Carbon::parse($candidate->mother_dob)->format('d-m-Y') : 'N/A' }}
                                                </span>
                                            </div>
                                            <div class="col-md-4 mb-2"><b>Mother Aadhar No:</b>
                                                <span>{{ $candidate?->mother_aadhar_no ?? 'N/A' }}</span>
                                            </div>

                                            <div class="col-md-4 mb-2"><b>Spouse Name:</b>
                                                <span>{{ $candidate?->spouse_name ?? 'N/A' }}</span>
                                            </div>
                                            <div class="col-md-4 mb-2"><b>Spouse DOB:</b>
                                                <span>{{ $candidate?->spouse_dob && $candidate->spouse_dob != '0000-00-00' ? \Carbon\Carbon::parse($candidate->spouse_dob)->format('d-m-Y') : 'N/A' }}
                                                </span>
                                            </div>
                                            <div class="col-md-4 mb-2"><b>Spouse Aadhar No:</b>
                                                <span>{{ $candidate?->spouse_aadhar_no ?? 'N/A' }}</span>
                                            </div>
                                            <div class="col-md-4 mb-2"><b>No. of Children:</b>
                                                <span>{{ $candidate?->no_of_childrens ?? 'N/A' }}</span>
                                            </div>
                                            @if ($children->isNotEmpty())
                                                @foreach ($children as $child)
                                                    @if (!empty($child->name) && $child->name !== 'N/A')
                                                        <div class="col-md-4 mb-2">
                                                            <b>Child Name:</b> <span>{{ $child->name }}</span>
                                                        </div>
                                                    @endif
                                                    @if (!empty($child->gender) && $child->gender !== 'N/A')
                                                        <div class="col-md-4 mb-2">
                                                            <b>Child Gender:</b> <span>{{ $child->gender }}</span>
                                                        </div>
                                                    @endif
                                                    @if (!empty($child->child_dob) && $child->child_dob !== 'N/A')
                                                        <div class="col-md-4 mb-2">
                                                            <b>Date of Birth:</b>
                                                            <span>{{ !empty($child->child_dob) && $child->child_dob != '0000-00-00' ? date('d-m-Y', strtotime($child->child_dob)) : 'N/A' }}
                                                            </span>
                                                        </div>
                                                    @endif

                                                    @if (!empty($child->aadhar_no) && $child->aadhar_no !== 'N/A')
                                                        <div class="col-md-4 mb-2">
                                                            <b>Child Aadhar:</b> <span>{{ $child->aadhar_no }}</span>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif

                                            <div class="col-md-4 mb-2"><b>Emergency Contact:</b>
                                                <span>{{ $candidate?->emer_contact_no ?? 'N/A' }}</span>
                                            </div>
                                            <div class="col-md-4 mb-2"><b>Emergency Name:</b>
                                                <span>{{ $candidate?->emer_name ?? 'N/A' }}</span>
                                            </div>
                                            <div class="col-md-4 mb-2"><b>Emergency Relation:</b>
                                                <span>{{ $candidate?->emer_relation ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="card custom-card">
                            <div class="custom-header d-flex justify-content-between align-items-center w-100"
                                data-bs-toggle="collapse" data-bs-target="#bankDetails" aria-expanded="false"
                                aria-controls="bankDetails">
                                <span>Bank Details</span>
                                <i class="bx bx-chevron-down chevron-icon"></i>
                            </div>

                            <div id="bankDetails" class="accordion-collapse collapse" aria-labelledby="headingbank"
                                data-bs-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>SL No</th>
                                                        <th>Bank Name</th>
                                                        <th>Account No</th>
                                                        <th>IFSC Code</th>
                                                        <th>Bank Document</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($bankdetails->isNotEmpty())
                                                        @foreach ($bankdetails as $index => $bank)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $bank?->bank_name ?? 'N/A' }}</td>
                                                                <td>{{ $bank?->bank_account_no ?? 'N/A' }}</td>
                                                                <td>{{ $bank?->bank_ifsc_code ?? 'N/A' }}</td>
                                                                <td>
                                                                    @if ($bank?->bank_document)
                                                                        <a href="{{ asset($bank->bank_document) }}"
                                                                            target="_blank"
                                                                            class="btn btn-sm btn-primary">
                                                                            View
                                                                        </a>
                                                                    @else
                                                                        <span class="text-muted">No Document</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="badge {{ $bank->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                                                        {{ $bank->status == 1 ? 'Active' : 'Inactive' }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td>1</td>
                                                            <td>{{ $candidate?->bank_name ?? 'N/A' }}</td>
                                                            <td>{{ $candidate?->bank_account_no ?? 'N/A' }}</td>
                                                            <td>{{ $candidate?->bank_ifsc_code ?? 'N/A' }}</td>
                                                            <td>
                                                                @if (!empty($candidate?->bank_document))
                                                                    <a href="{{ asset($candidate->bank_document) }}"
                                                                        target="_blank"
                                                                        class="btn btn-sm btn-primary">
                                                                        View
                                                                    </a>
                                                                @else
                                                                    <span class="text-muted">No Document</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <span class="badge bg-secondary">N/A</span>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <hr>

                        <div class="card custom-card">
                            <div class="custom-header d-flex justify-content-between align-items-center"
                                data-bs-toggle="collapse" data-bs-target="#salaryDetails" aria-expanded="false"
                                aria-controls="salaryDetails">
                                <span>Salary Details</span>
                                <i class="bx bx-chevron-down chevron-icon"></i>
                            </div>

                            <div id="salaryDetails" class="accordion-collapse collapse"
                                aria-labelledby="headingsalary" data-bs-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-2"><b>UAN NO:</b>
                                            <span>{{ $candidate?->uan_no ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>ESIC No:</b>
                                            <span>{{ $candidate?->esic_no ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Basic Salary:</b>
                                            <span>{{ $candidate?->basic_salary ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>HRA:</b> <span>{{ $candidate?->hra }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Conveyance:</b>
                                            <span>{{ $candidate?->conveyance ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Medical Reimbursement:</b>
                                            <span>{{ $candidate?->medical_reimbursement ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Special Allowance:</b>
                                            <span>{{ $candidate?->special_allowance ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Other Allowance:</b>
                                            <span>{{ $candidate?->other_allowance ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>ST Bonus:</b>
                                            <span>{{ $candidate?->st_bonus ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Gross Salary:</b>
                                            <span>{{ $candidate?->gross_salary ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Employee PF:</b>
                                            <span>{{ $candidate?->emp_pf ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Employee ESIC:</b>
                                            <span>{{ $candidate?->emp_esic ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>PT:</b>
                                            <span>{{ $candidate?->pt ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Total Deduction:</b>
                                            <span>{{ $candidate?->total_deduction ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Take Home:</b>
                                            <span>{{ $candidate?->take_home ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Employer PF:</b>
                                            <span>{{ $candidate?->employer_pf ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Employer ESIC:</b>
                                            <span>{{ $candidate?->employer_esic ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Mediclaim:</b>
                                            <span>{{ $candidate?->mediclaim ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>CTC:</b>
                                            <span>{{ $candidate?->ctc ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="card custom-card">
                            <div class="custom-header d-flex justify-content-between align-items-center"
                                data-bs-toggle="collapse" data-bs-target="#externalDocuments" aria-expanded="false"
                                aria-controls="externalDocuments">
                                <span>External Documents</span>
                                <i class="bx bx-chevron-down chevron-icon"></i>
                            </div>


                            <div id="externalDocuments" class="accordion-collapse collapse"
                                aria-labelledby="headingexternal" data-bs-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>Document Type</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $candidateDocumentsMap = [
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
                                                        'family_photo' => 'Family Photo',
                                                        'mother_photo' => 'Mother Photo',
                                                        'father_photo' => 'Father Photo',
                                                        'spouse_photo' => 'Spouse Photo',
                                                    ];
                                                @endphp

                                                @foreach ($candidateDocumentsMap as $field => $label)
                                                    @php
                                                        // Check if document exists in relation table
                                                        $docFromRelation = $candidate->candidateDocuments->firstWhere(
                                                            'name',
                                                            $field,
                                                        );
                                                        $docPath = null;

                                                        if ($docFromRelation && $docFromRelation->path) {
                                                            $docPath = $docFromRelation->path;
                                                        } elseif (!empty($candidate->$field)) {
                                                            // If not in relation, fallback to backend field in candidate
                                                            $docPath = $candidate->$field;
                                                        }
                                                    @endphp

                                                    @if (!empty($docPath))
                                                        <tr>
                                                            <td>{{ $label }}</td>
                                                            <td>
                                                                <a href="{{ asset($docPath) }}" target="_blank"
                                                                    class="btn btn-primary btn-sm">
                                                                    <i class="fas fa-eye"></i> View
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach



                                                @if ($candidate->educationCertificates->isNotEmpty())
                                                    @foreach ($candidate->educationCertificates as $certificate)
                                                        <tr>
                                                            <td>Education Certificate {{ $loop->iteration }}</td>
                                                            <td>
                                                                <a href="{{ asset($certificate->path) }}"
                                                                    target="_blank" class="btn btn-primary btn-sm">
                                                                    <i class="fas fa-eye"></i> View
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif

                                                @if ($candidate->otherCertificates->isNotEmpty())
                                                    @foreach ($candidate->otherCertificates as $certificate)
                                                        <tr>
                                                            <td>Other Certificate {{ $loop->iteration }}</td>
                                                            <td>
                                                                <a href="{{ asset($certificate->path) }}"
                                                                    target="_blank" class="btn btn-primary btn-sm">
                                                                    <i class="fas fa-eye"></i> View
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="card custom-card">
                                <div class="custom-header d-flex justify-content-between align-items-center"
                                    data-bs-toggle="collapse" data-bs-target="#internalDocuments"
                                    aria-expanded="false" aria-controls="internalDocuments">
                                    <span>Internal Documents</span>
                                    <i class="bx bx-chevron-down chevron-icon"></i>
                                </div>


                                <div id="internalDocuments" class="accordion-collapse collapse"
                                    aria-labelledby="headinginternal" data-bs-parent="#accordionExample">
                                    <div class="card-body">
                                        <table class="table table-bordered table-striped">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>Document Type</th>
                                                    <th>Issued Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($candidate->offerletters as $offer)
                                                    <tr>
                                                        <td>Offer Letter</td>
                                                        <td>{{ \Carbon\Carbon::parse($offer->date)->format('d-m-Y') }}
                                                        </td>
                                                        <td>
                                                            @if (!empty($offer->offer_letter_path))
                                                                <a href="{{ asset($offer->offer_letter_path) }}"
                                                                    target="_blank" class="btn btn-primary btn-sm">
                                                                    <i class="fas fa-eye"></i> View
                                                                </a>
                                                            @else
                                                                <a href="{{ route('admin.generate.offer.letter', ['id' => $offer->id]) }}"
                                                                    target="_blank" class="btn btn-warning btn-sm">
                                                                    <i class="fas fa-eye"></i> View Details
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @foreach ($candidate->incrementletters as $incrementletter)
                                                    <tr>
                                                        <td>Increment Letter</td>
                                                        <td>{{ \Carbon\Carbon::parse($incrementletter->date)->format('d-m-Y') }}
                                                        </td>
                                                        <td>
                                                            @if (!empty($incrementletter->increment_path))
                                                                <a href="{{ asset($incrementletter->increment_path) }}"
                                                                    target="_blank" class="btn btn-primary btn-sm">
                                                                    <i class="fas fa-eye"></i> View
                                                                </a>
                                                            @else
                                                                <a href="{{ route('admin.increment_letter.viewpdf', $incrementletter->id) }}"
                                                                    target="_blank" class="btn btn-primary btn-sm">
                                                                    <i class="fas fa-eye"></i> View
                                                                </a>
                                                            @endif

                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @foreach ($candidate->warningletters as $warning)
                                                    <tr>
                                                        <td>Warning Letter</td>
                                                        <td>{{ \Carbon\Carbon::parse($warning->date)->format('d-m-Y') }}
                                                        </td>
                                                        <td>
                                                            @if (!empty($warning->warning_letter_path))
                                                                <a href="{{ asset($warning->warning_letter_path) }}"
                                                                    target="_blank" class="btn btn-primary btn-sm">
                                                                    <i class="fas fa-eye"></i> View
                                                                </a>
                                                            @else
                                                                <a href="{{ route('admin.warning_letter.viewpdf', ['id' => $warning->id]) }}"
                                                                    target="_blank" class="btn btn-primary btn-sm">
                                                                    <i class="fas fa-eye"></i> View
                                                                </a>
                                                            @endif

                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @foreach ($candidate->showcauseletters as $show)
                                                    <tr>
                                                        <td>Show Cause Letter</td>
                                                        <td>{{ \Carbon\Carbon::parse($show->date)->format('d-m-Y') }}
                                                        </td>
                                                        <td>
                                                            @if (!empty($show->showcause_letter_path))
                                                                <a href="{{ asset($show->showcause_letter_path) }}"
                                                                    target="_blank" class="btn btn-primary btn-sm">
                                                                    <i class="fas fa-eye"></i> View
                                                                </a>
                                                            @else
                                                                <a href="{{ route('admin.showcause_letter.viewpdf', ['id' => $show->id]) }}"
                                                                    target="_blank" class="btn btn-primary btn-sm">
                                                                    <i class="fas fa-eye"></i> View
                                                                </a>
                                                            @endif

                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @foreach ($candidate->terminationletter as $term)
                                                    <tr>
                                                        <td>Termination Letter</td>
                                                        <td>{{ \Carbon\Carbon::parse($term->date)->format('d-m-Y') }}
                                                        </td>
                                                        <td>
                                                            @if (!empty($term->termination_letter_path))
                                                                <a href="{{ asset($term->termination_letter_path) }}"
                                                                    target="_blank" class="btn btn-primary btn-sm">
                                                                    <i class="fas fa-eye"></i> View
                                                                </a>
                                                            @else
                                                                <a href="{{ route('admin.termination_letter.viewpdf', ['id' => $term->id]) }}"
                                                                    target="_blank" class="btn btn-primary btn-sm">
                                                                    <i class="fas fa-eye"></i> View
                                                                </a>
                                                            @endif

                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @foreach ($candidate->pipletter as $pip)
                                                    <tr>
                                                        <td>PIP Letter</td>
                                                        <td>{{ \Carbon\Carbon::parse($pip->date)->format('d-m-Y') }}
                                                        </td>
                                                        <td>
                                                            <a href="{{ asset($pip->pip_letter_path) }}"
                                                                target="_blank" class="btn btn-primary btn-sm">
                                                                <i class="fas fa-eye"></i> View
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        {{-- <div class="card custom-card">
                            <div class="custom-header d-flex justify-content-between align-items-center"
                                data-bs-toggle="collapse" data-bs-target="#payslip" aria-expanded="false"
                                aria-controls="payslip">
                                <span>Payslips</span>
                                <i class="bx bx-chevron-down chevron-icon"></i>
                            </div>


                            <div id="payslip" class="accordion-collapse collapse" aria-labelledby="headingpayslip"
                                data-bs-parent="#accordionExample">
                                <div class="card-body">
                                    <table class="table table-bordered table-striped">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Document</th>
                                                <th>Month</th>
                                                <th>year</th>
                                                <th>date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($candidate->payslipletter as $payslip)
                                                <tr>
                                                    <td>Payslips</td>
                                                    <td>{{ DateTime::createFromFormat('!m', $payslip->month)->format('F') }}
                                                    </td>
                                                    <td>{{ $payslip->year }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($payslip->date_upload)->format('d-m-Y') }}
                                                    </td>
                                                    <td>
                                                        <a href="{{ asset($payslip->payslips_letter_path) }}"
                                                            target="_blank" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-eye"></i> View
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> --}}
                    </div>

                </div>

            </div>
        </div>
    </div>

</x-applayout>
