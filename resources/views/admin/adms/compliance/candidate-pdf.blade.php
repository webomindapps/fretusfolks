<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Candidate Details</title>

    <style>
        @page {
            margin: 100px 55px 120px 55px;
        }

        header {
            position: fixed;
            top: -100px;
        }

        footer {
            position: fixed;
            bottom: -40px;
        }

        .page-break {
            page-break-after: always;
        }

        body {
            padding: 0 !important;
            margin: 0 !important;
            display: block !important;
            -webkit-text-size-adjust: none;
            font-family: Times, serif;
            font-size: 13px;
        }

        h3 a,
        p,
        ol,
        .text2 a {
            font-family: Times, serif;
        }

        a {
            color: #00b8e4;
            text-decoration: underline;
        }

        h3 a {
            color: #1f1f1f;
            text-decoration: none;
        }

        .text2 a {
            color: #ea4261;
            text-decoration: none;
        }

        ol li {
            margin-top: 1%;
            line-height: 1.7;
        }
    </style>
</head>

<body>
    <x-letter-head />

    <div class="container">
        <h1>Candidate Details</h1>
        <hr>

        <!-- Personal Details Section -->
        <h2 class="bg-light p-2">Personal Details</h2>
        <div class="row">

            <div class="col-md-4 mt-2"><b>Entity Name:</b> <span>{{ $candidate->entity_name }}</span></div>
            <div class="col-md-4 mt-2"><b>FFI Emp ID:</b> <span>{{ $candidate->ffi_emp_id }}</span></div>
            <div class="col-md-4 mt-2"><b>Full Name:</b> <span>{{ $candidate->emp_name }} {{ $candidate->middle_name }}
                    {{ $candidate->last_name }}</span></div>
            <div class="col-md-4 mt-2"><b>DOB:</b>
                <span>{{ \Carbon\Carbon::parse($candidate->dob)->format('d-m-Y') }}</span>
            </div>
            <div class="col-md-4 mt-2"><b>Gender:</b> <span>{{ $candidate->gender }}</span></div>
            <div class="col-md-4 mt-2"><b>Designation:</b> <span>{{ $candidate->designation }}</span></div>
            <div class="col-md-4 mt-2"><b>Department:</b> <span>{{ $candidate->department }}</span></div>
            <div class="col-md-4 mt-2"><b>Joining Date:</b>
                <span>{{ \Carbon\Carbon::parse($candidate->joining_date)->format('d-m-Y') }}</span>
            </div>
            <div class="col-md-4 mt-2"><b>Email:</b> <span>{{ $candidate->email }}</span></div>
            <div class="col-md-4 mt-2"><b>Phone 1:</b> <span>{{ $candidate->phone1 }}</span></div>
            <div class="col-md-4 mt-2"><b>Location:</b> <span>{{ $candidate->location }}</span></div>
            <div class="col-md-4 mt-2"><b>State:</b> <span>{{ $candidate?->clientstate->state_name }}</span></div>
            <div class="col-md-4 mt-2"><b>Religion:</b> <span>{{ $candidate->religion }}</span></div>
            {{-- <div class="col-md-4 mt-2"><b>Religion:</b> <span>{{ $candidate->religion }}</span></div> --}}
            <div class="col-md-4 mt-2"><b>Mother Tounge:</b> <span>{{ $candidate->mother_tongue }}</span></div>
            <div class="col-md-4 mt-2"><b>Blood Group:</b> <span>{{ $candidate->blood_group }}</span></div>
            <div class="col-md-4 mt-2"><b>Qualification:</b> <span>{{ $candidate->qualification }}</span></div>
            <div class="col-md-4 mt-2"><b>Permanent Address:</b> <span>{{ $candidate->permanent_address }}</span></div>
            <div class="col-md-4 mt-2"><b>Present Address:</b> <span>{{ $candidate->present_address }}</span></div>

        </div>

        <hr>

        <!-- Family Details Section -->
        <h2 class="bg-light p-2">Family Details</h2>
        <div class="row">
            <div class="col-md-4 mt-2"><b>Father Name:</b> <span>{{ $candidate->father_name }}</span></div>
            <div class="col-md-4 mt-2"><b>Father DOB:</b>
                <span>{{ \Carbon\Carbon::parse($candidate->father_dob)->format('d-m-Y') }}</span>
            </div>
            <div class="col-md-4 mt-2"><b>Father Aadhar No:</b> <span>{{ $candidate->father_aadhar_no }}</span></div>

            <div class="col-md-4 mt-2"><b>Mother Name:</b> <span>{{ $candidate->mother_name }}</span></div>
            <div class="col-md-4 mt-2"><b>Mother DOB:</b>
                <span>{{ \Carbon\Carbon::parse($candidate->mother_dob)->format('d-m-Y') }}</span>
            </div>
            <div class="col-md-4  mt-2"><b>Mother Aadhar No:</b> <span>{{ $candidate->mother_aadhar_no }}</span></div>

            <div class="col-md-4 mt-2"><b>Spouse Name:</b> <span>{{ $candidate->spouse_name }}</span></div>
            <div class="col-md-4 mt-2"><b>Spouse DOB:</b>
                <span>{{ \Carbon\Carbon::parse($candidate->spouse_dob)->format('d-m-Y') }}</span>
            </div>
            <div class="col-md-4 mt-2"><b>Spouse Aadhar No:</b> <span>{{ $candidate->spouse_aadhar_no }}</span></div>
            <div class="col-md-4 mt-2"><b>No. of Children:</b> <span>{{ $candidate->no_of_childrens }}</span></div>
            @if ($children->isNotEmpty())
                @foreach ($children as $child)
                    <div class="col-md-4 mt-2">
                        <b>Child Name:</b> <span>{{ $child->name }}</span>
                    </div>
                    <div class="col-md-4 mt-2">
                        <b>Date of Birth:</b> <span>{{ date('d-m-Y', strtotime($child->child_dob)) }}</span>
                    </div>
                @endforeach
            @endif

            <div class="col-md-4 mt-2"><b>Emergency Contact:</b> <span>{{ $candidate->emer_contact_no }}</span></div>
            <div class="col-md-4 mt-2"><b>Emergency Name:</b> <span>{{ $candidate->emer_name }}</span></div>
            <div class="col-md-4 mt-2"><b>Emergency Relation:</b> <span>{{ $candidate->emer_relation }}</span></div>
        </div>

        <div class="page-break"></div>


        <!-- Salary Details Section -->
        <h2 class="bg-light p-2">Salary Details</h2>
        <div class="row">
            <div class="col-md-4 mt-2"><b>Basic Salary:</b> <span>{{ $candidate->basic_salary }}</span></div>
            <div class="col-md-4 mt-2"><b>HRA:</b> <span>{{ $candidate->hra }}</span></div>
            <div class="col-md-4 mt-2"><b>Conveyance:</b> <span>{{ $candidate->conveyance }}</span></div>
            <div class="col-md-4 mt-2"><b>Medical Reimbursement:</b>
                <span>{{ $candidate->medical_reimbursement }}</span>
            </div>

            <div class="col-md-4 mt-2"><b>Special Allowance:</b> <span>{{ $candidate->special_allowance }}</span></div>
            <div class="col-md-4 mt-2"><b>Other Allowance:</b> <span>{{ $candidate->other_allowance }}</span></div>
            <div class="col-md-4 mt-2"><b>ST Bonus:</b> <span>{{ $candidate->st_bonus }}</span></div>
            <div class="col-md-4 mt-2"><b>Gross Salary:</b> <span>{{ $candidate->gross_salary }}</span></div>

            <div class="col-md-4 mt-2"><b>Employee PF:</b> <span>{{ $candidate->emp_pf }}</span></div>
            <div class="col-md-4 mt-2"><b>Employee ESIC:</b> <span>{{ $candidate->emp_esic }}</span></div>
            <div class="col-md-4 mt-2"><b>PT:</b> <span>{{ $candidate->pt }}</span></div>
            <div class="col-md-4 mt-2"><b>Total Deduction:</b> <span>{{ $candidate->total_deduction }}</span></div>

            <div class="col-md-4 mt-2"><b>Take Home:</b> <span>{{ $candidate->take_home }}</span></div>
            <div class="col-md-4 mt-2"><b>Employer PF:</b> <span>{{ $candidate->employer_pf }}</span></div>
            <div class="col-md-4 mt-2"><b>Employer ESIC:</b> <span>{{ $candidate->employer_esic }}</span></div>
            <div class="col-md-4 mt-2"><b>Mediclaim:</b> <span>{{ $candidate->mediclaim }}</span></div>

            <div class="col-md-4 mt-2"><b>CTC:</b> <span>{{ $candidate->ctc }}</span></div>
        </div>
    </div>
</body>

</html>
