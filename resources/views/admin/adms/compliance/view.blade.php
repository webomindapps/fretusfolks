<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-primary text-white">
            <h5 class="modal-title">Candidate Details - {{ $candidate->emp_name }}</h5>
            <button type="button" class="close text-white" id="closeModalButton">×</button>
        </div>

        <div class="modal-body">
            <!-- Personal Details Section -->
            <h5 class="bg-light p-2">Personal Details</h5>
            <div class="row">
                <div class="col-md-4"><b>Entity Name:</b> <span>{{ $candidate->entity_name }}</span></div>
                <div class="col-md-4"><b>FFI Emp ID:</b> <span>{{ $candidate->ffi_emp_id }}</span></div>
                <div class="col-md-4"><b>Full Name:</b> <span>{{ $candidate->emp_name }} {{ $candidate->middle_name }}
                        {{ $candidate->last_name }}</span></div>
                <div class="col-md-4"><b>DOB:</b>
                    <span>{{ \Carbon\Carbon::parse($candidate->dob)->format('d-m-Y') }}</span>
                </div>
                <div class="col-md-4"><b>Gender:</b> <span>{{ $candidate->gender }}</span></div>
                <div class="col-md-4"><b>Designation:</b> <span>{{ $candidate->designation }}</span></div>
                <div class="col-md-4"><b>Department:</b> <span>{{ $candidate->department }}</span></div>
                <div class="col-md-4"><b>Joining Date:</b>
                    <span>{{ \Carbon\Carbon::parse($candidate->joining_date)->format('d-m-Y') }}</span>
                </div>
                <div class="col-md-4"><b>Email:</b> <span>{{ $candidate->email }}</span></div>
                <div class="col-md-4"><b>Phone 1:</b> <span>{{ $candidate->phone1 }}</span></div>
                <div class="col-md-4"><b>Location:</b> <span>{{ $candidate->location }}</span></div>
                <div class="col-md-4"><b>State:</b> <span>{{ $candidate?->clientstate->state_name }}</span></div>
                <div class="col-md-4"><b>Religion:</b> <span>{{ $candidate->religion }}</span></div>
                <div class="col-md-4"><b>Religion:</b> <span>{{ $candidate->religion }}</span></div>
                <div class="col-md-4"><b>Mother Tounge:</b> <span>{{ $candidate->mother_tongue }}</span></div>
                <div class="col-md-4"><b>Blood Group:</b> <span>{{ $candidate->blood_group }}</span></div>
                <div class="col-md-4"><b>Qualification:</b> <span>{{ $candidate->qualification }}</span></div>
                <div class="col-md-4"><b>Permanent Address:</b> <span>{{ $candidate->permanent_address }}</span></div>
                <div class="col-md-4"><b>Present Address:</b> <span>{{ $candidate->present_address }}</span></div>

            </div>

            <hr>

            <!-- Family Details Section -->
            <h5 class="bg-light p-2">Family Details</h5>
            <div class="row">
                <div class="col-md-4"><b>Father Name:</b> <span>{{ $candidate->father_name }}</span></div>
                <div class="col-md-4"><b>Father DOB:</b>
                    <span>{{ \Carbon\Carbon::parse($candidate->father_dob)->format('d-m-Y') }}</span>
                </div>
                <div class="col-md-4"><b>Father Aadhar No:</b> <span>{{ $candidate->father_aadhar_no }}</span></div>

                <div class="col-md-4"><b>Mother Name:</b> <span>{{ $candidate->mother_name }}</span></div>
                <div class="col-md-4"><b>Mother DOB:</b>
                    <span>{{ \Carbon\Carbon::parse($candidate->mother_dob)->format('d-m-Y') }}</span>
                </div>
                <div class="col-md-4"><b>Mother Aadhar No:</b> <span>{{ $candidate->mother_aadhar_no }}</span></div>

                <div class="col-md-4"><b>Spouse Name:</b> <span>{{ $candidate->spouse_name }}</span></div>
                <div class="col-md-4"><b>Spouse DOB:</b>
                    <span>{{ \Carbon\Carbon::parse($candidate->spouse_dob)->format('d-m-Y') }}</span>
                </div>
                <div class="col-md-4"><b>Spouse Aadhar No:</b> <span>{{ $candidate->spouse_aadhar_no }}</span></div>
                <div class="col-md-4"><b>No. of Children:</b> <span>{{ $candidate->no_of_childrens }}</span></div>
                @if ($children->isNotEmpty())
                    @foreach ($children as $child)
                        <div class="col-md-4">
                            <b>Child Name:</b> <span>{{ $child->name }}</span>
                        </div>
                        <div class="col-md-4">
                            <b>Date of Birth:</b> <span>{{ date('d-m-Y', strtotime($child->child_dob)) }}</span>
                        </div>
                    @endforeach
                @endif

                <div class="col-md-4"><b>Emergency Contact:</b> <span>{{ $candidate->emer_contact_no }}</span></div>
                <div class="col-md-4"><b>Emergency Name:</b> <span>{{ $candidate->emer_name }}</span></div>
                <div class="col-md-4"><b>Emergency Relation:</b> <span>{{ $candidate->emer_relation }}</span></div>
            </div>

            <hr>

            <!-- Salary Details Section -->
            <h5 class="bg-light p-2">Salary Details</h5>
            <div class="row">
                <div class="col-md-4"><b>UAN NO:</b> <span>{{ $candidate->uan_no }}</span></div>
                <div class="col-md-4"><b>ESIC No:</b> <span>{{ $candidate->esic_no }}</span></div>

                <div class="col-md-4"><b>Basic Salary:</b> <span>{{ $candidate->basic_salary }}</span></div>
                <div class="col-md-4"><b>HRA:</b> <span>{{ $candidate->hra }}</span></div>
                <div class="col-md-4"><b>Conveyance:</b> <span>{{ $candidate->conveyance }}</span></div>
                <div class="col-md-4"><b>Medical Reimbursement:</b>
                    <span>{{ $candidate->medical_reimbursement }}</span>
                </div>

                <div class="col-md-4"><b>Special Allowance:</b> <span>{{ $candidate->special_allowance }}</span></div>
                <div class="col-md-4"><b>Other Allowance:</b> <span>{{ $candidate->other_allowance }}</span></div>
                <div class="col-md-4"><b>ST Bonus:</b> <span>{{ $candidate->st_bonus }}</span></div>
                <div class="col-md-4"><b>Gross Salary:</b> <span>{{ $candidate->gross_salary }}</span></div>

                <div class="col-md-4"><b>Employee PF:</b> <span>{{ $candidate->emp_pf }}</span></div>
                <div class="col-md-4"><b>Employee ESIC:</b> <span>{{ $candidate->emp_esic }}</span></div>
                <div class="col-md-4"><b>PT:</b> <span>{{ $candidate->pt }}</span></div>
                <div class="col-md-4"><b>Total Deduction:</b> <span>{{ $candidate->total_deduction }}</span></div>

                <div class="col-md-4"><b>Take Home:</b> <span>{{ $candidate->take_home }}</span></div>
                <div class="col-md-4"><b>Employer PF:</b> <span>{{ $candidate->employer_pf }}</span></div>
                <div class="col-md-4"><b>Employer ESIC:</b> <span>{{ $candidate->employer_esic }}</span></div>
                <div class="col-md-4"><b>Mediclaim:</b> <span>{{ $candidate->mediclaim }}</span></div>

                <div class="col-md-4"><b>CTC:</b> <span>{{ $candidate->ctc }}</span></div>
            </div>

            <hr>
            <h5 class="bg-light p-2">Documents</h5>

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
                                    <td>{{ $candidateDocuments[$certificate->name] ?? $certificate->name }}</td>
                                    <td>
                                        <a href="{{ asset($certificate->path) }}" target="_blank"
                                            class="btn btn-primary btn-sm">
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
                                        <a href="{{ asset($certificate->path) }}" target="_blank"
                                            class="btn btn-primary btn-sm">
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
                                        <a href="{{ asset($certificate->path) }}" target="_blank"
                                            class="btn btn-primary btn-sm">
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
</div>
