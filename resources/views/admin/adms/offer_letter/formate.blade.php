<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no">
    <title>Fretus Folks</title>
</head>

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
        /* background: red; */
        -webkit-text-size-adjust: none;
        font-family: times;
        font-size: 13px;
    }

    a {
        color: #00b8e4;
        text-decoration: underline;
        font-family: times;
    }

    h3 a {
        color: #1f1f1f;
        text-decoration: none;
        font-family: times;
    }

    .text2 a {
        color: #ea4261;
        text-decoration: none;
        font-family: times;
    }

    p {
        padding: 0 !important;
        margin: 0 !important;
        font-family: times;
    }

    ol {
        font-family: times;
    }

    ol li {
        margin-top: 1%;
        line-height: 1.7;
    }

    .table1 td,
    .table1 th {
        border: 1px solid black;
        padding: 5px 8px;
    }
</style>
</head>

<body class="body">
    <x-letter-head />
    <div style="color:#000;font-size: 21px;margin-top: 0%;margin-bottom: 5%;padding: 0 10px;">
        <div
            style="color: #000;font-family: Tahoma;font-size: 17px;line-height: 18px;text-align: justify; padding-left: 0%;">
            <div><br>
                <table style="border-collapse:collapse;width:100%;margin-bottom:20px;">
                    <tbody>
                        <tr>
                            <td colspan="3" style="font-size:12px;text-align:left;padding:7px">
                                <p style="line-height:1.8;font-size:14px">
                                    {{-- <b>Mr. /Mrs. /Ms. : {{ $offerLetter->employee?->emp_name }}</b> <br> --}}
                                    <b>Employee ID : {{ $offerLetter->employee?->ffi_emp_id }}</b> <br>
                                    {{-- <b>Place : {{ $offerLetter->employee?->location }}</b> <br> --}}
                                </p>
                            </td>
                            <td style="font-size:12px;text-align:left;padding:7px;width:30%">
                                <p style="line-height:1.8;font-size:14px">
                                    <b>Date
                                        :{{ \Carbon\Carbon::parse($offerLetter->employee?->joining_date)->format('d-m-Y') }}</b>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div
            style="color: #000;font-family: Tahoma;font-size: 17px;line-height: 15px;text-align: justify; padding-left: 0%;">
            <h1 style="font-size:18px;text-align:center;text-decoration: underline;">Appointment Letter</h1>
            <br>
            <p style="font-size:12px;line-height:1.5;">
                <b>To</b>
                <b> Mr./Mrs./Ms {{ $offerLetter->employee?->emp_name }}</b><br>
                <b>S/o {{ $offerLetter->employee?->father_name }}</b><br>
                <b>Location : {{ $offerLetter->employee?->location }}</b> <br>
                <br>
                <span style="margin-left:0%;">
                    We are pleased to offer you employment at <b>Fretus Folks India Pvt Ltd (FFI)</b>. as per the
                    following terms:
                    <br>
                    <b><u>DEPUTATION:</u></b>
                    You are deputed to<b>{{ $offerLetter->employee?->entity_name }}</b>. under this employment. The
                    terms of employment is exclusively with <b>Fretus Folks India Pvt Ltd (FFI)</b>. which are
                    summarised as under.
                    <br>
                    You will with effect from be deputed by <b>Fretus Folks India Pvt Ltd (FFI)</b>.to work at client's
                    office / premises at any of their locations.
                    <br>
                    <b><u>Date of
                            Joining:</u>{{ \Carbon\Carbon::parse($offerLetter->employee?->joining_date)->format('d-m-Y') }}
                    </b>
                    <br>
                    <b><u>POSITION:</u></b> You are appointed
                    as<b>{{ $offerLetter->employee?->designation }}-{{ $offerLetter->employee?->department }} </b>
                    <br>
                    <b><u>REMUNERATION:</u></b> The details of your salary break up with components are as per the
                    enclosure attached herewith in annexture – A
                    <br>
                    <b><u>WORKING HOURS:</u></b>
                    You will follow the working hours of the client where you will be deputed. You may have to work on
                    shifts, based on the client's requirement. Your attendance will be maintained by the Reporting
                    Officer of the client, who shall at the end of the month share the attendance with the contact
                    person at <b>Fretus Folks India Pvt Ltd (FFI)</b>. for pay-roll processing.
                    <br>
                    <b><u>Separation & SUSPENSION:</u></b>
                    At the time of <b>Separation</b> of the employment either due to <b>Separation</b> by either you or
                    the Company or upon the lapse of the term of employment, if there are any dues owing from you to the
                    Company, the same may be adjusted against any money due to you by the Company on account of salary
                    including bonus or any other payment owned to you under the terms of your employment.
                    <br>
                    During the tenure of your Employment, any deviation or misconduct in any form that were noticed by
                    the company or if there are any breach of internal policies or any regulation that was mutually
                    agreed to be complied with, <b>Fretus Folks India Pvt Ltd (FFI)</b>. or principal employer has the
                    rights and authority to suspend your services until you are notified to resume work in writing.
                    <b>Fretus Folks India Pvt Ltd (FFI)</b>. reserves all such right to withheld full or a portion of
                    your salary during such suspension period.
                    <br>
                    <b><u>Probation Period:</u></b>
                    "After successfully completing a six-month probationary period from your date of joining the
                    Company, your continued employment will be subject to confirmation by the Company. Please note that
                    the probation period may be revised based on performance and other relevant factors.
                    <br>
                    <b><u>NOTICE PERIOD:</u></b>
                    In the eventuality if you wish to separate from the organization within the period of probationary
                    you need to serve 15 day's notice and after the confirmation you should serve the notice period of
                    30 day’s. The Employment can be terminated at the discretion of <b>Fretus Folks India Pvt Ltd
                        (FFI)</b> within the period of probationary you need to serve 15 day's notice and after the
                    confirmation you should serve the notice period of 30 day’s.
                    <br>
                    However due to breach of code of conduct, misbehavior or indiscipline etc, then in such cases,
                    <b>Fretus Folks India Pvt Ltd (FFI)</b>. will have / reserve rights to terminate immediately without
                    giving notice period.
                    <br>
                    <br>
                    <b><u>INDEMNITY:</u></b>
                    You shall be responsible for protecting any property of the Client entrusted to you in the due
                    discharge of your duties and you shall indemnify the Client if there is a loss of any kind to the
                    said property.To the fullest extent permitted by the Applicable Law, you shall hold the Client, its
                    agents, employees and assigns, free and harmless and indemnify and defend Client from and against
                    any and all suits, actions, proceedings, claims, demands, liabilities, costs and charges, legal
                    expenses, damages or penalties of any nature actually or allegedly arising out of or related to your
                    services at the Location or to any alleged actions or omissions by you, including, but not limited
                    to, those resulting from, or claimed to result from injury, death or damage to you.
                    <br>
                    <b><u>TRANSFER:</u></b>
                    You are liable to be transferred to any other department of the Client or <b>Fretus Folks India Pvt
                        Ltd (FFI)</b>.or at any other branches across India in which the client or <b>Fretus Folks India
                        Pvt Ltd (FFI)</b>
                    or any of the employer subsidiary company has any kind of interest. That also upon such transfer,
                    the present terms and conditions shall be applicable, to such a post or at the place of transfer
                    <br>
                    <b><u>CODE OF CONDUCT:</u></b>
                    You shall not engage in any act subversive of discipline in the course of your duty/ies for the
                    Client either within the Client's organization or outside it, and if you were at any time found
                    indulging in such act/s, the Company shall reserve the right to initiate disciplinary action as is
                    deemed fit against you.
                    <br>
                    <b><u>ADDRESS FOR COMMUNICATION:</u></b>
                    The address of communication for the purpose of service of notice and other official communication
                    to the company shall be the registered address of the company which is,<b> Fretus Folks India Pvt
                        Ltd.
                        No. M 20, 3rd Floor, UKS Heights, Sector XI, Jeevan Bhima Nagar,Bangalore-560075.</b> The
                    address of
                    communication and service of notice and other official communication is the address set out as above
                    and your present residential address namely. In the event there is a change in your address, you
                    shall inform the same in writing to the Management and that shall be the address last furnished by
                    you, shall be deemed to be sufficient for communication and shall be deemed to be effective on you.
                    <br>
                    <b><u>BACKGROUND VERIFICATION:</u></b>
                    The company reserves the right to have your back ground verified directly or through an outside
                    agency. If on such verification it is found that you have furnished wrong information or concealed
                    any material information your services are liable to be terminated.
                    <br>
                    <b><u>ABSENTEEISM:</u></b>
                    You should be regular and punctual in your attendance. If you remain absent for 3 consecutive
                    working days or more without sanction of leave or prior permission or if you over stay sanctioned
                    leave beyond 3consecutive working days or more it shall be deemed that you have voluntarily
                    abandonment your employment with the company and your services are liable to be terminated
                    accordingly.
                    <br>
                    <b><u>RULES AND REGULATIONS:</u></b>
                    You shall be bound by the Rules & Regulations framed by the company from time to time in relation to
                    conduct, discipline and other service conditions which will be deemed as Rules, Regulation and order
                    and shall form part and parcel of this letter of appointment.
                    <br>
                    <b><u>OTHER TERMS OF EMPLOYMENT:</u></b>
                    In addition to the terms of appointment mentioned above, you are also governed by the standard
                    employment rules of , <b>Fretus Folks India Pvt Ltd (FFI)</b>. (as per Associate Manual). The
                    combined rules and procedures as contained in
                    this letter will constitute the standard employment rules and you are required to read both of them
                    in conjunction.
                    <br>
                    <b><u>JURISDICTION:</u></b>
                    Notwithstanding the place of working or placement or the normal or usual residence of the employee
                    concerned or the place where this instrument is signed or executed this Employment shall only be
                    subject to the jurisdiction of the High Court of Judicature of <b> Karnataka At Bangalore</b> and
                    its subordinate Courts.
                    <br>
                    <b><u>DEEMED CANCELLATION OF EMPLOYMENT:</u></b>
                    The Employment stands cancelled and revoked if you do not report to duty within 3 days from the date
                    of joining & your act will be construed as deemed and implied rejection of the offer of employment
                    from your side; hence no obligation would arise on the part of the company in lieu of such
                    Employment issued.
                </span>
            </p>
            <br>
            <b>You are requested to bring the following documents at the time of joining: </b>
            <p style="font-size:12px;line-height:1.5;margin-left:3%;margin-top: 1% !important;">
            <ol type="1" style="font-size:12px;line-height:1.5;">
                <li>
                    Educational Certificates for 10th and 12 standard or the highest qualification held by you.
                </li>
                <li>Experience Letter / Relieving letter of the past company, if any.</li>
                <li>
                    Latest month pay slip,if any.
                </li>
                <li>
                    Photo ID proof (Aadhar Card/Driving Licence/Election I-Card/Passport/Pan Card)
                </li>
                <li>
                    Address Proof (Aadhar Card/Driving Licence/Election I-Card/Passport/Pan Card)
                </li>
                <li>
                    5 passport size photographs
                </li>
                <li>
                    PAN card, if any.
                </li>
                <li>
                    UAN Card, if any.
                </li>
                <li>
                    Aadhaar Card
                </li>
            </ol>
            </p>
            <div style="color: #000; font-family: Tahoma; font-size: 17px; line-height: 18px; text-align: justify;">
                <p style="font-size:12px; line-height:1.8;">
                    <span>
                        Here's wishing you the very best in your assignment with us and as a token of your
                        understanding
                        and accepting of the standard terms of employment, you are requested to sign the duplicate
                        copy
                        of this letter and return to us within a day.
                    </span><br>

                </p>
                <table style="border-collapse:collapse;width:100%;margin-bottom:0px;">
                    <tbody>
                        <tr>
                            <td colspan="3" style="font-size:12px; text-align:left; padding:7px;">
                                <p style="line-height:1.8; font-size:14px;">
                                    With warm regards,<br>
                                    <br>
                                    <b>For : Fretus Folks India Pvt Ltd.</b>
                                </p>
                                <img src="{{ public_path('admin/images/seal.png') }}" width="100">
                                <p style="line-height:1.8; font-size:14px;">
                                    <b>Authorized Signatory</b>
                                </p>
                            </td>
                            {{-- <td style="font-size:12px; text-align:left; padding:7px; width:40%">
                                <p style="line-height:1.8; font-size:14px;">
                                    <b>I accept:</b><br><br><br>
                                    <b>(Signature of an Employee)</b>
                                </p>
                            </td> --}}
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div
        style="color: #000;font-family: Tahoma;font-size: 13px;line-height: 1.5;text-align: justify;padding-left: 0%; margin-top:100px;">
        <h1 style="font-size:17px;text-align:center;text-decoration: underline;"> Annexure - 1</h1>
        <p>
            <span style="margin-left:0%;">
                <b><u>Compensation Shee:</u></b>
                <br><br><br>
                Offer No: {{ $offerLetter->employee?->employee_id }} <br>
                Associate Name:{{ $offerLetter->employee?->emp_name }}<br>
                Designation:{{ $offerLetter->employee?->designation }}<br>
                Department :{{ $offerLetter->employee?->department }}<br>
                Location: {{ $offerLetter->employee?->location }}
            </span>
        </p>
        <center>
            <table class="table table1 annexure_table" border="1"
                style="border-collapse:collapse;width:80%;margin:20px auto;">
                <tbody>
                    <tr>
                        <th style="font-size:12px;text-align:left;padding:7px;border-top: 1px solid #000;">
                            Components</th>
                        <th style="font-size:12px;text-align:left;padding:7px;width:30%;border-top: 1px solid #000;">
                            Monthly salary</th>
                        <th style="font-size:12px;text-align:left;padding:7px;width:30%;border-top: 1px solid #000;">
                            Annual salary</th>
                    </tr>
                    <tr>
                        <td>Basic</td>
                        <td>{{ $offerLetter->basic_salary }}</td>
                        <td>{{ $offerLetter->basic_salary * 12 }}</td>
                    </tr>
                    <tr>
                        <td>HRA</td>
                        <td>{{ $offerLetter->hra }}</td>
                        <td>{{ $offerLetter->hra * 12 }}</td>
                    </tr>
                    <tr>
                        <td>Conveyance</td>
                        <td>{{ $offerLetter->conveyance }}</td>
                        <td>{{ $offerLetter->conveyance * 12 }}</td>
                    </tr>
                    <tr>
                        <td>St.Bonus</td>
                        <td>{{ $offerLetter->st_bonus }}</td>
                        <td>{{ $offerLetter->st_bonus * 12 }}</td>
                    </tr>
                    <tr>
                        <td>Special Allowance</td>
                        <td>{{ $offerLetter->special_allowance }}</td>
                        <td>{{ $offerLetter->special_allowance * 12 }}</td>
                    </tr>
                    {{-- <tr>
                        <td>Other Allowance</td>
                        <td>{{ $offerLetter->other_allowance }}</td>
                        <td>{{ $offerLetter->other_allowance * 12 }}</td>
                    </tr> --}}
                    <tr class="gross" style="background: #ecbfbf;">
                        <td>Gross Salary</td>
                        <td>{{ $offerLetter->gross_salary }}</td>
                        <td>{{ $offerLetter->gross_salary * 12 }}</td>
                    </tr>
                    <tr>
                        <td>Employee PF @ {{ $offerLetter->pf_percentage }}%</td>
                        <td>{{ $offerLetter->emp_pf }}</td>
                        <td>{{ $offerLetter->emp_pf * 12 }}</td>
                    </tr>
                    <tr>
                        <td>Employee ESIC PF @ {{ $offerLetter->esic_percentage }}%
                        </td>
                        <td>{{ $offerLetter->emp_esic }}</td>
                        <td>{{ $offerLetter->emp_esic * 12 }}</td>
                    </tr>
                    <tr>
                        <td>PT</td>
                        <td>{{ $offerLetter->pt }}</td>
                        <td>{{ $offerLetter->pt * 12 }}</td>
                    </tr>

                    <tr class="gross" style="background: #ecbfbf;">
                    <tr>
                        <td>Total Deduction</td>
                        <td>{{ $offerLetter->total_deduction }}</td>
                        <td>{{ $offerLetter->total_deduction * 12 }}</td>
                    </tr>
                    <td>Take-home</td>
                    <td>{{ $offerLetter->gross_salary - $offerLetter->total_deduction }}
                    </td>
                    <td>{{ ($offerLetter->gross_salary - $offerLetter->total_deduction) * 12 }}
                    </td>
                    </tr>
                    <tr>
                        <td>Employer PF @ {{ $offerLetter->employer_pf_percentage }}%
                        </td>
                        <td>{{ $offerLetter->employer_pf }}</td>
                        <td>{{ $offerLetter->employer_pf * 12 }}</td>
                    </tr>
                    <tr>
                        <td>Employer ESIC PF @
                            {{ $offerLetter->employer_esic_percentage }}%</td>
                        <td>{{ $offerLetter->employer_esic }}</td>
                        <td>{{ $offerLetter->employer_esic * 12 }}</td>
                    </tr>
                    <tr>
                        <td>Medical Insurance</td>
                        <td>{{ $offerLetter->medical_reimbursement }}</td>
                        <td>{{ $offerLetter->medical_reimbursement * 12 }}</td>
                    </tr>
                    <tr class="gross" style="background: #ecbfbf;">
                        <td>CTC</td>
                        <td>{{ $offerLetter->ctc }}</td>
                        <td>{{ $offerLetter->ctc * 12 }}</td>
                    </tr>
                </tbody>
            </table>
        </center>
        <p style="font-size:12px; line-height:1.8;">
            <span>
                <b>Note:</b> This is a performance linked pay and shall be processed as per Deputed company’s variable
                pay policy.
                <br><br>
                <b>Signature</b>
                <br><br>
                <b>Name: {{ $offerLetter->employee?->emp_name }}</b>
            </span><br>
        </p>
    </div>
</body>

</html>
