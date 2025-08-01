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
                <div class="form-card px-3">
                    <div class="header  text-white" style="background-color: #517bb9;">
                        <h4 class="modal-title">Candidate Details
                            <div>
                                <h5>{{ $candidate->ffi_emp_id }}-
                                    {{ $candidate->emp_name }}</h5>
                            </div>
                        </h4>
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
                                        <div class="col-md-4 mb-2"><b>Entity Name:</b>
                                            <span>{{ $candidate->entity_name }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>FFI Emp ID:</b>
                                            <span>{{ $candidate->ffi_emp_id }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Full Name:</b>
                                            <span>{{ $candidate->emp_name }}
                                                {{ $candidate->middle_name }} {{ $candidate->last_name }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>DOB:</b>
                                            <span>{{ \Carbon\Carbon::parse($candidate->dob)->format('d-m-Y') }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Gender:</b>
                                            <span>{{ $candidate->gender }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Designation:</b>
                                            <span>{{ $candidate->designation }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Department:</b>
                                            <span>{{ $candidate->department }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Interview Date:</b>
                                            <span>{{ \Carbon\Carbon::parse($candidate->interview_date)->format('d-m-Y') }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Joining Date:</b>
                                            <span>{{ \Carbon\Carbon::parse($candidate->joining_date)->format('d-m-Y') }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Date Of Leaving:</b>
                                            <span>{{ \Carbon\Carbon::parse($candidate->employee_last_date)->format('d-m-Y') }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Email:</b>
                                            <span>{{ $candidate->email }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Phone 1:</b>
                                            <span>{{ $candidate->phone1 }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Location:</b>
                                            <span>{{ $candidate->location }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>State:</b>
                                            <span>{{ $candidate?->clientstate->state_name }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Religion:</b>
                                            <span>{{ $candidate->religion }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Mother Tongue:</b>
                                            <span>{{ $candidate->mother_tongue }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Languages:</b>
                                            <span>{{ $candidate->languages }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Blood Group:</b>
                                            <span>{{ $candidate->blood_group }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Qualification:</b>
                                            <span>{{ $candidate->qualification }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>PAN NO:</b>
                                            <span>{{ $candidate->pan_no }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Aadhar No:</b>
                                            <span>{{ $candidate->aadhar_no }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Driving License NO:</b>
                                            <span>{{ $candidate->driving_license_no }}</span>
                                        </div>
                                        {{-- {{dd($candidate?->creator->name)}} --}}
                                        <div class="col-md-4 mb-2"><b>Created By:</b>
                                            <span>{{ $candidate?->creator->name ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-4 mb-2"><b>Approved By:</b>
                                            <span>{{ $candidate->modifiedBy->name ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-12 mb-2"><b>Permanent Address:</b>
                                            <span>{{ $candidate->permanent_address }}</span>
                                        </div>
                                        <div class="col-md-12 mb-2"><b>Present Address:</b>
                                            <span>{{ $candidate->present_address }}</span>
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
                                                <span>{{ $candidate->father_name }}</span>
                                            </div>
                                            <div class="col-md-4 mb-2"><b>Father DOB:</b>
                                                <span>{{ \Carbon\Carbon::parse($candidate->father_dob)->format('d-m-Y') }}</span>
                                            </div>
                                            <div class="col-md-4 mb-2"><b>Father Aadhar No:</b>
                                                <span>{{ $candidate->father_aadhar_no }}</span>
                                            </div>
                                            <div class="col-md-4 mb-2"><b>Mother Name:</b>
                                                <span>{{ $candidate->mother_name }}</span>
                                            </div>
                                            <div class="col-md-4 mb-2"><b>Mother DOB:</b>
                                                <span>{{ \Carbon\Carbon::parse($candidate->mother_dob)->format('d-m-Y') }}</span>
                                            </div>
                                            <div class="col-md-4 mb-2"><b>Mother Aadhar No:</b>
                                                <span>{{ $candidate->mother_aadhar_no }}</span>
                                            </div>

                                            <div class="col-md-4 mb-2"><b>Spouse Name:</b>
                                                <span>{{ $candidate->spouse_name }}</span>
                                            </div>
                                            <div class="col-md-4 mb-2"><b>Spouse DOB:</b>
                                                <span>{{ \Carbon\Carbon::parse($candidate->spouse_dob)->format('d-m-Y') }}</span>
                                            </div>
                                            <div class="col-md-4 mb-2"><b>Spouse Aadhar No:</b>
                                                <span>{{ $candidate->spouse_aadhar_no }}</span>
                                            </div>
                                            <div class="col-md-4 mb-2"><b>No. of Children:</b>
                                                <span>{{ $candidate->no_of_childrens }}</span>
                                            </div>
                                            @if ($children->isNotEmpty())
                                                @foreach ($children as $child)
                                                    <div class="col-md-4 mb-2">
                                                        <b>Child Name:</b> <span>{{ $child->name }}</span>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <b>Date of Birth:</b>
                                                        <span>{{ date('d-m-Y', strtotime($child->child_dob)) }}</span>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <b>Child Aadhar:</b> <span>{{ $child->aadhar_no }}</span>
                                                    </div>
                                                @endforeach
                                            @endif

                                            <div class="col-md-4 mb-2"><b>Emergency Contact:</b>
                                                <span>{{ $candidate->emer_contact_no }}</span>
                                            </div>
                                            <div class="col-md-4 mb-2"><b>Emergency Name:</b>
                                                <span>{{ $candidate->emer_name }}</span>
                                            </div>
                                            <div class="col-md-4 mb-2"><b>Emergency Relation:</b>
                                                <span>{{ $candidate->emer_relation }}</span>
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
                                        <div class="d-flex justify-content-end mt-2">
                                            <a href="{{ route('admin.bankdetails.create', $candidate->id) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="bx bx-add-alt" aria-hidden="true"></i> Add
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        @if ($bankdetails->isNotEmpty())
                                            <div class="table-responsive mt-2">
                                                <table class="table table-bordered">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>SL No</th>
                                                            <th>Bank Name</th>
                                                            <th>Account No</th>
                                                            <th>IFSC Code</th>
                                                            <th>Bank Document</th>
                                                            <th>Compliance Approval</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        {{-- {{dd($bankdetails)}} --}}
                                                        @foreach ($bankdetails as $index => $bank)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $bank->bank_name }}</td>
                                                                <td>{{ $bank->bank_account_no }}</td>
                                                                <td>{{ $bank->bank_ifsc_code }}</td>
                                                                <td>
                                                                    @if ($bank->bank_document)
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
                                                                        class="badge {{ $bank->bank_status == 1 ? 'bg-success' : 'bg-danger' }}">
                                                                        {{ $bank->bank_status == 1 ? 'Completed' : 'Pending' }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="badge {{ $bank->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                                                        {{ $bank->status == 1 ? 'Active' : 'Inactive' }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <div class="dropdown pop_Up dropdown_bg">
                                                                        <div class="dropdown-toggle"
                                                                            id="dropdownMenuButton-{{ $bank->id }}"
                                                                            data-bs-toggle="dropdown"
                                                                            aria-expanded="true">
                                                                            Action
                                                                        </div>
                                                                        <ul class="dropdown-menu"
                                                                            aria-labelledby="dropdownMenuButton1">
                                                                            <li>

                                                                                <a href="{{ route('admin.bankdetails.edit', $bank->id) }}"
                                                                                    class="dropdown-item">
                                                                                    <i class="bx bx-edit-alt"
                                                                                        aria-hidden="true"></i> Edit
                                                                                </a>
                                                                                <a href="{{ route('admin.bankdetails.delete', $bank) }}"
                                                                                    class="dropdown-item"
                                                                                    onclick="return confirm('Are you sure to delete this?')">
                                                                                    <i class="bx bx-trash-alt"></i>
                                                                                    Delete
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <p class="text-muted">No bank details available.</p>
                                        @endif

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
                                        <div class="col-md-3 mb-2"><b>UAN NO:</b>
                                            <span>{{ $candidate?->uan_no ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-3 mb-2"><b>ESIC No:</b>
                                            <span>{{ $candidate?->esic_no ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-3 mb-2"><b>Basic Salary:</b>
                                            <span>{{ $candidate?->basic_salary ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-3 mb-2"><b>HRA:</b>
                                            <span>{{ $candidate?->hra }}</span>
                                        </div>
                                        <div class="col-md-3 mb-2"><b>Conveyance:</b>
                                            <span>{{ $candidate?->conveyance ?? 'N/A' }}</span>
                                        </div>

                                        <div class="col-md-3 mb-2"><b>Special Allowance:</b>
                                            <span>{{ $candidate?->special_allowance ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-3 mb-2"><b>Other Allowance:</b>
                                            <span>{{ $candidate?->other_allowance ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-3 mb-2"><b>ST Bonus:</b>
                                            <span>{{ $candidate?->st_bonus ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-3 mb-2"><b>Gross Salary:</b>
                                            <span>{{ $candidate?->gross_salary ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-3 mb-2"><b>Employee PF:</b>
                                            <span>{{ $candidate?->emp_pf ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-3 mb-2"><b>Employee ESIC:</b>
                                            <span>{{ $candidate?->emp_esic ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-3 mb-2"><b>Employee LWF:</b>
                                            <span>{{ $candidate?->lwf ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-3 mb-2"><b>PT:</b>
                                            <span>{{ $candidate?->pt ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-3 mb-2"><b>Other Deduction:</b>
                                            <span>{{ $candidate?->other_deduction ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-3 mb-2"><b>Total Deduction:</b>
                                            <span>{{ $candidate?->total_deduction ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-12 mb-2"><b>Net Take Home Salary – NTH (Gross Salary – Total
                                                Deduction):</b>
                                            <span>{{ $candidate?->take_home ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-3 mb-2"><b>Employer PF:</b>
                                            <span>{{ $candidate?->employer_pf ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-3 mb-2"><b>Employer ESIC:</b>
                                            <span>{{ $candidate?->employer_esic ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-3 mb-2"><b>Employer LWF:</b>
                                            <span>{{ $candidate?->employee_lwf ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-3 mb-2"><b>Mediclaim:</b>
                                            <span>{{ $candidate?->mediclaim ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-12 mb-2"><b>Cost To Company - CTC (Gross_Salary +
                                                Employer_Deduction):</b>
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
                                                        'family_photo' => 'Family Photo',
                                                        'mother_photo' => 'Mother Photo',
                                                        'father_photo' => 'Father Photo',
                                                        'spouse_photo' => 'Spouse Photo',
                                                    ];
                                                @endphp

                                                @if ($candidate->candidateDocuments->isNotEmpty())
                                                    @foreach ($candidate->candidateDocuments as $certificate)
                                                        <tr>
                                                            <td>{{ $candidateDocuments[$certificate->name] ?? $certificate->name }}
                                                            </td>
                                                            <td>
                                                                <a href="{{ asset($certificate->path) }}"
                                                                    target="_blank" class="btn btn-primary btn-sm">
                                                                    <i class="fas fa-eye"></i> View
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif

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

                        </div>
                        <hr>

                    </div>

                </div>

            </div>
        </div>
    </div>

</x-applayout>
