<table>
    <thead>
        <tr>
            <th>Sl No</th>
            <th>Employee ID</th>
            <th>Employee Name</th>
            <th>Interview Date</th>
            <th>Joining Date</th>
            <th>Contract Date</th>
            <th>Designation</th>
            <th>Department</th>
            <th>State</th>
            <th>Location</th>
            <th>Date of Birth</th>
            <th>Father Name</th>
            <th>Gender</th>
            <th>Blood Group</th>
            <th>Qualification</th>
            <th>Phone 1</th>
            <th>Phone 2</th>
            <th>Email</th>
            <th>Permanent Address</th>
            <th>Present Address</th>
            <th>PAN Number</th>
            <th>PAN Doc</th>
            <th>Aadhar Number</th>
            <th>Aadhar Doc</th>
            <th>Driving License No</th>
            <th>Driving License Doc</th>
            <th>Photo</th>
            <th>Resume</th>
            <th>Bank Name</th>
            <th>Bank Doc</th>
            <th>Bank Account No</th>
            <th>Bank IFSC Code</th>
            <th>UAN Generatted</th>
            <th>UAN Type</th>
            <th>UAN</th>
            <th>Voter ID</th>
            <th>Employee Form</th>
            <th>PF/ESIC Form</th>
            <th>Payslip</th>
            <th>Experience Letter</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($employees as $key => $employee)
            <tr>

                <td>{{ $key + 1 }}</td>
                <td>{{ $employee->ffi_emp_id }}</td>
                <td>{{ $employee->emp_name }}</td>
                <td>{{ $employee->interview_date }}</td>
                <td>{{ $employee->joining_date }}</td>
                <td>{{ $employee->contract_date }}</td>
                <td>{{ $employee->designation }}</td>
                <td>{{ $employee->department }}</td>
                <td>{{ $employee->state }}</td>
                <td>{{ $employee->location }}</td>
                <td>{{ $employee->dob }}</td>
                <td>{{ $employee->father_name }}</td>
                <td>{{ $employee->gender == 1 ? 'Male' : ($employee->gender == 2 ? 'Female' : 'Others') }}</td>
                <td>{{ $employee->blood_group }}</td>
                <td>{{ $employee->qualification }}</td>
                <td>{{ $employee->phone1 }}</td>
                <td>{{ $employee->phone2 }}</td>
                <td>{{ $employee->email }}</td>
                <td>{{ $employee->permanent_address }}</td>
                <td>{{ $employee->present_address }}</td>
                <td>{{ $employee->pan_no }}</td>
                <td>{{ $employee->pan_path }}</td>
                <td>{{ $employee->aadhar_no }}</td>
                <td>{{ $employee->aadhar_path }}</td>
                <td>{{ $employee->driving_license_no }}</td>
                <td>{{ $employee->driving_license_path }}</td>
                <td>
                    {{ $employee->photo }}
                </td>
                <td>
                    {{ $employee->resume }}
                </td>
                <td>{{ $employee->bank_name }}</td>
                <td>{{ $employee->bank_document }}</td>
                <td>{{ $employee->bank_account_no }}</td>
                <td>{{ $employee->bank_ifsc_code }}</td>
                <td>{{ $employee->uan_generatted }}</td>
                <td>{{ $employee->uan_type }}</td>
                <td>{{ $employee->uan_no }}</td>

                <td>
                    {{ $employee->voter_id }}

                </td>
                <td>
                    {{ $employee->emp_form }}

                </td>
                <td>
                    {{ $employee->pf_esic_form }}
                </td>
                <td>
                    {{ $employee->payslip }}
                </td>
                <td>
                    {{ $employee->exp_letter }}
                </td>
                <td>
                    @if ($employee->status == 1)
                        Pending
                    @else
                        Completed
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
