<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header bg-primary">
            <div class="modal-title">
                <h5 class="" id="client_details">{{ $employee->emp_name }}</h5>
            </div>
            <button type="button" class="close" id="closeModalButton">×</button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <h6 class="font-weight-semibold"></h6>
                </div>
                <div class="col-md-4 col-sm-6">
                    <p><b>Employee Name :</b> <span>{{ $employee->emp_name }}</span></p>
                    <p><b>Department :</b> <span>{{ $employee->department }}</span></p>
                    <p><b>Date of Birth :</b> <span>{{ \Carbon\Carbon::parse($employee->dob)->format('d-m-Y') }}</span>
                    </p>
                    <p><b>Email :</b> <span>{{ $employee->email }}</span></p>
                    <p><b>Father Name :</b> <span>{{ $employee->father_name }}</span></p>
                    <p><b>Permanent Address :</b> <span>{{ $employee->permanent_address }}</span></p>

                </div>
                <div class="col-md-4 col-sm-6">
                    <p><b>FFI EMP ID :</b> <span>{{ $employee->ffi_emp_id }}</span></p>
                    <p><b>Joining Date :</b>
                        <span>{{ \Carbon\Carbon::parse($employee->joining_date)->format('d-m-Y') }}</span>
                    </p>
                    <p><b>Qualification :</b> <span>{{ $employee->qualification }}</span></p>
                    <p><b>Phone 1 :</b> <span>{{ $employee->phone1 }}</span></p>
                    <p><b>State :</b> <span>{{ $employee->stateRelation?->state_name }}</span></p>
                    <p><b>Present Address :</b> <span>{{ $employee->present_address }}</span></p>

                </div>
                <div class="col-md-4 col-sm-6">
                    <p><b>Designation :</b> <span>{{ $employee->designation }}</span></p>
                    <p><b>Contract Date :</b>
                        <span>{{ \Carbon\Carbon::parse($employee->contract_date)->format('d-m-Y') }}</span>
                    </p>
                    <p><b>Gender :</b>
                        <span>{{ $employee->gender == 1 ? 'Male' : ($employee->gender == 2 ? 'Female' : 'Others') }}</span>
                    </p>
                    <p><b>Phone 2 :</b> <span>{{ $employee->phone2 }}</span></p>
                    <p><b>Location :</b> <span>{{ $employee->location }}</span></p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <p><b>Bank Name :</b> <span>{{ $employee->bank_name }}</span></p>
                    <p><b>UAN Generated :</b> <span>{{ $employee->uan_generatted }}</span></p>
                    <p><b>UAN No :</b> <span>{{ $employee->uan_no }}</span></p>
                    <p><b>PAN No :</b> <span>{{ $employee->pan_no }}</span></p>
                </div>
                <div class="col-md-4 col-sm-6">
                    <p><b>Aadhar No :</b> <span>{{ $employee->aadhar_no }}</span></p>
                    <p><b>Bank Account No :</b> <span>{{ $employee->bank_account_no }}</span></p>
                    <p><b>UAN Type :</b> <span>{{ $employee->uan_type }}</span></p>
                </div>
                <div class="col-md-4 col-sm-6">
                    <p><b>Driving License No :</b> <span>{{ $employee->driving_license_no }}</span></p>
                    <p><b>Bank IFSC Code :</b> <span>{{ $employee->bank_ifsc_code }}</span></p>

                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <p><b>Aadhar No :</b> <span>{{ $employee->aadhar_no }}</span></p>
                </div>

                <div class="col-md-4 col-sm-6">
                    <p><b>Driving License No :</b> <span>{{ $employee->driving_license_no }}</span></p>
                </div>
                <div class="col-md-4 col-sm-6">
                    <p><b>PAN No :</b> <span>{{ $employee->pan_no }}</span></p>
                </div>
            </div>
            <hr>
            <div class="row">

                <div class="col-md-3 col-sm-6">
                    <p><b>Basic Salary :</b> <span>Rs{{ $employee->basic_salary }}</span></p>
                    <p><b>Special Allowance :</b> <span>Rs{{ $employee->special_allowance }}</span></p>
                    <p><b>Employee PF (%):</b> <span>{{ $employee->employer_pf_percentage }}</span></p>
                    <p><b>Employee PF (%):</b> <span>{{ $employee->pf_percentage }}</span></p>
                    <p><b>CTC :</b> <span>Rs{{ $employee->ctc }}</span></p>

                </div>
                <div class="col-md-3 col-sm-6">
                    <p><b>HRA :</b> <span>Rs{{ $employee->hra }}</span></p>
                    <p><b>ST Bonus:</b> <span>Rs{{ $employee->st_bonus }}</span></p>
                    <p><b>Employee ESIC (%):</b> <span>{{ $employee->employer_esic_percentage }}</span></p>
                    <p><b>Employee ESIC (%):</b> <span>{{ $employee->esic_percentage }}</span></p>
                </div>
                <div class="col-md-3 col-sm-6">

                    <p><b>Conveyance :</b> <span>Rs{{ $employee->conveyance }}</span></p>
                    <p><b>Other Allowance :</b> <span>Rs{{ $employee->other_allowance }}</span></p>
                    <p><b>PT :</b> <span>Rs{{ $employee->pt }}</span></p>
                    <p><b>Medical Insurance :</b> <span>Rs{{ $employee->mediclaim }}</span></p>

                </div>
                <div class="col-md-3 col-sm-6">

                    <p><b>Medical Reimbursement :</b> <span>Rs{{ $employee->medical_reimbursement }}</span></p>
                    <p><b>Gross Salary :</b> <span>Rs{{ $employee->gross_salary }}</span></p>
                    <p><b>Total Deduction :</b> <span>Rs{{ $employee->total_deduction }}</span></p>
                    <p><b>Take Home Salary :</b> <span>Rs{{ $employee->take_home }}</span></p>
                </div>

            </div>
            <hr>
            <p><b>Password :</b> <span>{{ $employee->psd }}</span></p>
            <hr>
            <h6 class="font-weight-semibold">Certificates</h6>
            <hr>
            <h6 class="font-weight-semibold">Education Certificates:</h6>

            <div class="row">
                <div class="col-md-12 col-sm-12">
                    @if ($education->isNotEmpty())
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Si No</th>
                                    <th>Certificates</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($education as $edu)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td> <a href="{{ $edu->path }}"target="_blank">
                                                <i class="fa fa-book"></i>
                                                Education Certificate
                                            </a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
            <hr>
            <h6 class="font-weight-semibold">Other Certificates:</h6>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    @if ($others->isNotEmpty())
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Si No</th>
                                    <th>Certificates</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($others as $other)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ $other->path }}"target="_blank">
                                                <i class="fa fa-book"></i>
                                                Certificate
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>

        {{-- <div class="modal-footer">
            <button type="button" class="btn bg-primary" id="closeModalButton">Close</button>
        </div> --}}
    </div>
</div>
