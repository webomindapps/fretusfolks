<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta content="telephone=no" name="format-detection" />
    <title>Fretus Folks</title>
    <style>
        @page {
            margin: 200px 0 50px 0;
        }

        .cash {
            text-align: right;
        }

        li {
            line-height: 1.5;
            margin-top: 0px !important;
        }

        b {
            font-weight: bold;
        }

        header {
            position: fixed;
            top: -200px;
            left: -30px;
            right: 0;
            height: 170px;
        }

        footer {
            position: fixed;
            bottom: -50px;
            left: -20px;
        }

        body {
            margin-bottom: -19px !important;
        }

        .table1 {
            border-collapse: collapse;
            width: 60%;
            margin-left: auto;
            margin-right: auto;
            font-size: 14.5px;
        }

        .table1 th,
        .table1 td {
            padding: 4px;
            border: 1px solid #000;
        }

        .table1 td:first-child {
            text-align: left;
        }

        .table1 td:nth-child(2),
        .table1 td:nth-child(3),
        .table1 th:nth-child(2),
        .table1 th:nth-child(3) {
            text-align: center;
        }

        h1 {
            font-size: 15px;
            text-align: center;
            text-decoration: underline;
            margin-bottom: 15px;
        }

        p,
        li {
            font-size: 14.5px;
            line-height: 1.5;
            text-align: justify;
            margin-top: -1px !important;
        }

        .signature-table td {
            vertical-align: top;
            padding: 10px;
        }

        .seal {
            width: 100px;
            margin-top: 10px;
        }

        .header-row {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .header-row .left,
        .header-row .right {
            font-size: 14.5px;
        }
    </style>
</head>

<body>
    <x-letter-head />
    <div style="margin:0px 35 0;">
        <h1 style="font-size:18px;text-align:center;text-decoration:underline;margin-top:20px">Offer cum Appointment
            letter</h1>

        <p style="font-size:14.5px;text-align:right;">Date : <b
                style="font-weight:bold;">{{ \Carbon\Carbon::parse($offerLetter->joining_date)->format('d-m-Y') }}</b>
        </p>

        <p style="font-size:14.5px;line-height:1.5;text-align:justify;">
            <span>To,</span><br>
            <span>Mr./Mrs./Ms.: <b>{{ $offerLetter->emp_name }}</b></span><br>
            <span> <b>
                    {{ $offerLetter->gender_salutation }}
                    {{ $offerLetter->father_name }}
                </b> </span><br>
            <span>Emp ID: <b>{{ $offerLetter->employee_id }}</b></span><br>
            <span>Address: <b>{{ $offerLetter->location }}</b></span><br>
        </p>

        <p style="font-size:14.5px;margin:20px 0px;">Dear {{ $offerLetter->emp_name }},</p>

        <p style="font-size:14.5px;line-height:1.5;text-align:justify;">
            We are pleased to offer you employment to work as {{ $offerLetter->designation }} as on
            {{ \Carbon\Carbon::parse($offerLetter->joining_date)->format('d-m-Y') }} on deputation with our
            client/s, <b style="font-weight:bold;">{{ $offerLetter->entity_name }}</b>. for a fixed
            period of
            employment, on the following terms and conditions:
        </p>

        <ol>
            <li>
                <p style="font-size:14.5px;line-height:1.5;text-align:justify;">
                    You will be working at the site assigned from our client Blue Dart Express Ltd, under this probation
                    if you are found guilty of activities such <b style="font-weight:bold;">as Cash mismanagement,
                        Theft, Bike Meter tampering, Fake delivery, Disrespect to
                        {{ $offerLetter->entity_name }} and other delivery associate, irregularity at
                        work,</b> Client is liable to separate you with immediate effect and we shall end your contract
                    on the day of separation from client.
                </p>
            </li>
            <li>
                <p style="font-size:14.5px;line-height:1.5;text-align:justify;">
                    Duration of your contract is {{ $offerLetter->tenure_month }} Months
                </p>
            </li>
            <li>
                <p style="font-size:14.5px;line-height:1.5;text-align:justify;">
                    Notwithstanding anything above, depending upon the afore mentioned project/work, the company
                    reserves its right to extend your temporary appointment for such a period or periods as may be
                    necessary depending upon the exigencies relatable to the work for which you are hereby engaged. The
                    same shall be informed to you in advance. In the event, the company shall be in writing extend your
                    temporary assignment on the terms as may be indicated in such extension of the assignment you shall
                    be governed by such terms and conditions as may be indicated therein.
                </p>
            </li>
            <li>
                <p style="font-size:14.5px;line-height:1.5;text-align:justify;">
                    You will be entitled for leaves as per shops and establishment act and other applicable laws in
                    India.
                </p>
            </li>
            <li>
                <p style="font-size:14.5px;line-height:1.5;text-align:justify;">
                    During the period of fixed contract of {{ $offerLetter->tenure_month }} Months, your services
                    could be deputed at the sole discretion of the management to any of our client’s company to do work
                    pertaining to or incidental to the client’s business. Your service can be transferred from one
                    location to another (within state) as per business requirement
                </p>
            </li>
            <li>
                <p style="font-size:14.5px;line-height:1.5;text-align:justify;">
                    In case of any adverse remarks found from the reference given by you, the documents submitted by
                    you/outcome of the police verification report then this appointment will stand withdrawn
                    immediately.
                </p>
            </li>

            <li>
                <p style="font-size:14.5px;line-height:1.5;text-align:justify;">
                    You will not be absent from your duty without sufficient reasons, you will obtain prior written
                    permission / sanction from the supervisor about your absence giving reasons thereof and probable
                    duration immediately, failing which, the same will be treated as loss of Pay.
                </p>
            </li>
        </ol>
        <ol start="8">
            <li>
                <p style="font-size:14.5px;line-height:1.5;text-align:justify;">
                    If you did not report to work for continuous 3 days without proper notification of absenteeism,
                    company is liable to end your contract on immediate basis, on request from client.
                </p>
            </li>
            <li>
                <p style="font-size:14.5px;line-height:1.5;text-align:justify;">
                    Client holds the discretion to do a thorough background verification of your candidature as seems
                    fit and can initiate police verification, background check, court cases verification,
                </p>
            </li>
            <li>
                <p style="font-size:14.5px;line-height:1.5;text-align:justify;">
                    If you found guilty in any one of them, Client have the full authority to end your contract
                    immediately and report the findings to nearest police station
                </p>
            </li>
            <li>
                <p style="font-size:14.5px;line-height:1.5;text-align:justify;">
                    You will be governed by the conduct, discipline, rules and regulations as laid down by the
                    management.
                </p>
            </li>
            <li>
                <p style="font-size:14.5px;line-height:1.5;text-align:justify;">
                    The salary will be paid to you, subject to the receipt of payment from
                    {{ $offerLetter->entity_name }}. (to which you have been deputed).
                </p>
            </li>
            <li>
                <p style="font-size:14.5px;line-height:1.5;text-align:justify;">
                    This contract shall be terminable by either party giving {{ $offerLetter->notice_period }}
                    days’ notice in writing or salary on lieu of notice, to the other.
                </p>
            </li>
            <li>
                <p style="font-size:14.5px;line-height:1.5;text-align:justify;">
                    We are consciously endeavoring to build an atmosphere of trust, openness, responsiveness, autonomy
                    and growth among all members to the Fretus Folks India Pvt Ltd. As a new entrant, we would like you
                    to whole-heartedly contribute in this process.
                </p>
            </li>
            <li>
                <p style="font-size:14.5px;line-height:1.5;text-align:justify;">
                    As a token of acceptance of the above terms and conditions, you are requested to sign the duplicate
                    copy of this letter and return to us.
                </p>
            </li>
        </ol>

        <p style="font-size:14.5px;line-height:1.5;text-align:justify;">
            With warm regards,
        </p>

        <table width="100%">
            <tbody>
                <tr>
                    <td colspan="3" style="font-size:14.5px;text-align:left;">
                        <p style="line-height:1.8;">
                            <b>For Fretus Folks India Pvt Ltd.</b> <br>
                        </p>

                        <img src="{{ public_path('admin/images/seal.png') }}" style="" width="100"><br>
                        <p> <b>&nbsp;&nbsp;&nbsp;Authorized Signatory</b> <br>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div style="page-break-after: always;"></div>
    <div style="color: #000;font-family: Tahoma;font-size: 14.5px;ltext-align: justify; ">
        <h1>Annexure - A</h1>

        <table class="table1">
            <thead>
                <tr>
                    <th>Components</th>
                    <th>Monthly Salary</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Basic + DA</td>
                    <td>{{ $offerLetter->basic_salary ?? 0 }}</td>
                </tr>
                <tr>
                    <td>HRA</td>
                    <td>{{ $offerLetter->hra ?? 0 }}</td>
                </tr>
                <tr>
                    <td>Special Allowance</td>
                    <td>{{ $offerLetter->special_allowance ?? 0 }}</td>
                </tr>
                <tr>
                    <td>Other Allowance</td>
                    <td>{{ $offerLetter->other_allowance ?? 0 }}</td>
                </tr>
                <tr>
                    <td>Conveyance</td>
                    <td>{{ $offerLetter->conveyance ?? 0 }}</td>
                </tr>
                <tr>
                    <td>St. Bonus</td>
                    <td>{{ $offerLetter->st_bonus ?? 0 }}</td>
                </tr>
                <tr style="background-color:#f9e93d;">
                    <td><b>Gross Salary</b></td>
                    <td><b>{{ $offerLetter->gross_salary ?? 0 }}</b></td>
                </tr>
                <tr>
                    <td>Employee PF</td>
                    <td>{{ $offerLetter->emp_pf ?? 0 }}</td>
                </tr>
                <tr>
                    <td>Employee ESIC</td>
                    <td>{{ $offerLetter->emp_esic ?? 0 }}</td>
                </tr>
                <tr>
                    <td>Employee LWF</td>
                    <td>{{ $offerLetter->lwf ?? 0 }}</td>
                </tr>
                <tr>
                    <td>Professional Tax (PT)</td>
                    <td>{{ $offerLetter->pt ?? 0 }}</td>
                </tr>
                <tr>
                    <td>Other Deduction</td>
                    <td>{{ $offerLetter->other_deduction ?? 0 }}</td>
                </tr>

                <tr style="background-color:#ffb4b4;">
                    <td><b>Total Deduction</b></td>
                    <td><b>{{ $offerLetter->total_deduction ?? 0 }}</b></td>
                </tr>
                <tr style="background-color:#7eb568;">
                    <td><b>Net Take-home</b></td>
                    <td><b>{{ $offerLetter->take_home ?? 0 }}</b></td>
                </tr>
                <tr>
                    <td>Employer PF</td>
                    <td>{{ $offerLetter->employer_pf ?? 0 }}</td>
                </tr>
                <tr>
                    <td>Employer ESIC</td>
                    <td>{{ $offerLetter->employer_esic ?? 0 }}</td>
                </tr>
                <tr>
                    <td>Employer LWF</td>
                    <td>{{ $offerLetter->employer_lwf ?? 0 }}</td>
                </tr>
                <tr>
                    <td>Mediclaim</td>
                    <td>{{ $offerLetter->mediclaim ?? 0 }}</td>
                </tr>
                <tr style="background-color:#6997c9;">
                    <td><b>Cost To Company (CTC)</b></td>
                    <td><b>{{ $offerLetter->ctc ?? 0 }}</b></td>

                </tr>
                <tr style="background-color:#6997c9;">
                    <td><b>Annual CTC</b></td>
                    <td><b>{{ $offerLetter->ctc * 12 }}</b></td>
                </tr>
            </tbody>
        </table>

        <table style="border-collapse:collapse; width:100%; margin-top:20px; margin-left:80px !important;">
            <tbody>
                <tr>
                    <!-- Company Signatory -->
                    <td style="font-size:14.5px; text-align:left; width:60%;">
                        <p style="font-size:14.5px; margin: 0 0 5px 0;">
                            <b>For: Fretus Folks India Pvt Ltd.</b>
                        </p>
                        <img src="{{ public_path('admin/images/seal.png') }}" width="100" style="margin:5px 0;"
                            alt="Seal" />
                        <p style="font-size:14.5px; margin: 0;">
                            <b>Authorized Signatory</b>
                        </p>
                    </td>

                    <!-- Employee Acknowledgment -->
                    <td style="font-size:14.5px; text-align:left;  width:40%;">
                        <p style="font-size:14.5px; margin: 0 0 5px 0;">
                            Name: <b>{{ $offerLetter->emp_name }}</b>
                        </p>
                        <p style="font-size:14.5px; margin: 5px 0 0 0;">
                            Signature:
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
