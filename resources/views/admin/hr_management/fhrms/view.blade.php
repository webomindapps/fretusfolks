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
                    <h6 class="font-weight-semibold">Employee Details</h6>
                </div>
                <div class="col-md-4 col-sm-6">
                    <p><b>FFI EMP ID :</b> <span>{{ $employee->ffi_emp_id }}</span></p>
                    <p><b>Employee Name :</b> <span>{{ $employee->emp_name }}</span></p>
                    <p><b>Interview Date :</b> <span>{{ $employee->interview_date }}</span></p>
                    <p><b>Joining Date :</b> <span>{{ $employee->joining_date }}</span></p>
                    <p><b>Contract Date :</b> <span>{{ $employee->contract_date }}</span></p>
                    <p><b>Designation :</b> <span>{{ $employee->designation }}</span></p>
                    <p><b>Department :</b> <span>{{ $employee->department }}</span></p>
                </div>
                <div class="col-md-4 col-sm-6">

                    <p><b>State :</b> <span>{{ $employee->state }}</span></p>
                    <p><b>Location :</b> <span>{{ $employee->location }}</span></p>
                    <p><b>Date of Birth :</b> <span>{{ $employee->dob }}</span></p>
                    <p><b>Gender :</b> <span>{{ $employee->gender }}</span></p>
                    <p><b>Father Name :</b> <span>{{ $employee->father_name }}</span></p>
                    <p><b>Blood Group :</b> <span>{{ $employee->blood_group }}</span></p>
                </div>
                <div class="col-md-4 col-sm-6">
                    <p><b>Qualification :</b> <span>{{ $employee->qualification }}</span></p>
                    <p><b>Phone 1 :</b> <span>{{ $employee->phone1 }}</span></p>
                    <p><b>Phone 2 :</b> <span>{{ $employee->phone2 }}</span></p>
                    <p><b>Email :</b> <span>{{ $employee->email }}</span></p>
                    <p><b>Permanent Address :</b> <span>{{ $employee->permanent_address }}</span></p>
                    <p><b>Present Address :</b> <span>{{ $employee->present_address }}</span></p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <h6 class="font-weight-semibold">Document Details</h6>
                    <p><b>PAN No :</b> <span>{{ $employee->pan_no }}</span></p>
                    <p><b>Aadhar No :</b> <span>{{ $employee->aadhar_no }}</span></p>
                    <p><b>Driving License No :</b> <span>{{ $employee->driving_license_no }}</span></p>
                </div>

                <div class="col-md-4 col-sm-6">
                    <h6 class="font-weight-semibold">Bank Details</h6>
                    <p><b>Bank Name :</b> <span>{{ $employee->bank_name }}</span></p>
                    <p><b>Bank Account No :</b> <span>{{ $employee->bank_account_no }}</span></p>
                    <p><b>Bank IFSC Code :</b> <span>{{ $employee->bank_ifsc_code }}</span></p>

                </div>
                <div class="col-md-4 col-sm-6">
                    <h6 class="font-weight-semibold">UAN Details</h6>
                    <p><b>UAN Generated :</b> <span>{{ $employee->uan_generatted }}</span></p>
                    <p><b>UAN Type :</b> <span>{{ $employee->uan_type }}</span></p>
                    <p><b>UAN No :</b> <span>{{ $employee->uan_no }}</span></p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <p><b>PAN Doc:</b> <span> <a href="{{ $employee->pan_path }}">
                                <i class="fa fa-book"></i>
                                PAN
                            </a></span></p>
                    <p><b>Aadhar Doc: </b> <span> <a href="{{ $employee->aadhar_path }}">
                                <i class="fa fa-book"></i>
                                Aadhar
                            </a></span></p>
                    <p><b>Driving License Doc:</b> <span> <a href="{{ $employee->driving_license_path }}">
                                <i class="fa fa-book"></i>
                                Driving License
                            </a></span></p>
                    <p><b>Bank Doc:</b> <span> <a href="{{ $employee->bank_document }}">
                                <i class="fa fa-book"></i>
                                Bank Doc
                            </a></span></p>
                </div>
                <div class="col-md-4 col-sm-6">
                    <h6 class="font-weight-semibold">Salary Details</h6>

                    <p><b>Basic Salary :Rs</b> <span>{{ $employee->basic_salary }}</span></p>
                    <p><b>HRA :Rs</b> <span>{{ $employee->hra }}</span></p>
                    <p><b>Conveyance :Rs</b> <span>{{ $employee->conveyance }}</span></p>
                    <p><b>Medical Reimbursement :Rs</b> <span>{{ $employee->medical_reimbursement }}</span></p>
                </div>
                <div class="col-md-4 col-sm-6">
                    <p><b>Special Allowance :Rs</b> <span>{{ $employee->special_allowance }}</span></p>
                    <p><b>Gross Salary :Rs</b> <span>{{ $employee->gross_salary }}</span></p>
                    <p><b>Total Deduction :Rs</b> <span>{{ $employee->total_deduction }}</span></p>
                    <p><b>Take Home :Rs</b> <span>{{ $employee->take_home }}</span></p>
                </div>


            </div>
            <hr>
            <h6 class="font-weight-semibold">Additional Details</h6>

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
                                        <td> <a href="{{ $edu->path }}">
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
                                            <a href="{{ $other->path }}">
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

        <div class="modal-footer">
            <button type="button" class="btn bg-primary" id="closeModalButton">Close</button>
        </div>
    </div>
</div>
