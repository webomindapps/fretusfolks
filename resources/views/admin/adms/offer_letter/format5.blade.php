<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta content="telephone=no" name="format-detection" />
    <title>Fretus Folks</title>
    <style>
        @page {
            margin: 200px 0 120px 0;
        }

        .cash {
            text-align: right;
        }

        li {
            line-height: 1.5;
        }

        ol li {
            font-size: 12px;
            margin-top: -5px;
        }

        b {
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
        }

        header {
            position: fixed;
            top: -200px;
            left: 0;
            right: 0;
            height: 170px;
        }

        footer {
            position: fixed;
            bottom: -60px;
        }

        .salary-details-table {
            border-collapse: collapse;
            width: 60%;
            font-size: 10px;
            margin-left: auto;
            margin-right: auto;
        }

        .salary-details-table tr th,
        {
        text-align: left;
        padding: 5px 10px;
        width: 50%;
        }

        .salary-details-table tr td {
            text-align: right;
            padding: 5px 10px;
            width: 50%;
        }
    </style>
</head>

<body>
    <x-letter-head />
    <div style="margin:0px 35;">
        <h1 style="font-size:18px;text-align:center;text-decoration:underline;margin-top:20px">Offer cum Appointment
            letter</h1>

        <p style="text-align:right;">Date : <b
                style="font-weight:bold;">{{ \Carbon\Carbon::parse($offerLetter->joining_date)->format('d-m-Y') }}</b>
        </p>

        <p style="font-size:14px;line-height:1.5;text-align:justify;">
            To, <br />
            {{ $offerLetter->emp_name }} <br />
            {{ $offerLetter->gender_salutation }}
            {{ $offerLetter->father_name }}<br>
            Emp : {{ $offerLetter->employee_id }} <br />
            Address : {{ $offerLetter->location }}
        </p>

        <p style="margin:20px 0px;">Dear {{ $offerLetter->emp_name }},</p>

        <p style="font-size:12.7px;line-height:1.5;text-align:justify;">
            We are pleased to offer you employment to work as {{ $offerLetter->designation }} as on
            {{ \Carbon\Carbon::parse($offerLetter->joining_date)->format('d-m-Y') }} on deputation with our
            client/s, <b style="font-weight:bold;">{{ $offerLetter->entity_name }}</b>. for a fixed
            period of
            employment, on the following terms and conditions:
        </p>

        <ol>
            <li>
                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    You will be working at the site assigned from our client Blue Dart Express Ltd, under this probation
                    if you are found guilty of activities such <b style="font-weight:bold;">as Cash mismanagement,
                        Theft, Bike Meter tampering, Fake delivery, Disrespect to
                        {{ $offerLetter->entity_name }} and other delivery associate, irregularity at
                        work,</b> Client is liable to separate you with immediate effect and we shall end your contract
                    on the day of separation from client.
                </p>
            </li>
            <li>
                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    Duration of your contract is {{ $offerLetter->tenure_month }} months
                </p>
            </li>
            <li>
                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    Notwithstanding anything above, depending upon the afore mentioned project/work, the company
                    reserves its right to extend your temporary appointment for such a period or periods as may be
                    necessary depending upon the exigencies relatable to the work for which you are hereby engaged. The
                    same shall be informed to you in advance. In the event, the company shall be in writing extend your
                    temporary assignment on the terms as may be indicated in such extension of the assignment you shall
                    be governed by such terms and conditions as may be indicated therein.
                </p>
            </li>
            <li>
                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    You will be entitled for leaves as per shops and establishment act and other applicable laws in
                    India.
                </p>
            </li>
            <li>
                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    During the period of fixed contract of {{ $offerLetter->tenure_month }}, your services
                    could be deputed at the sole discretion of the management to any of our client’s company to do work
                    pertaining to or incidental to the client’s business. Your service can be transferred from one
                    location to another (within state) as per business requirement
                </p>
            </li>
            <li>
                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    In case of any adverse remarks found from the reference given by you, the documents submitted by
                    you/outcome of the police verification report then this appointment will stand withdrawn
                    immediately.
                </p>
            </li>
        </ol>
        <ol start="7">
            <li>
                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    You will not be absent from your duty without sufficient reasons, you will obtain prior written
                    permission / sanction from the supervisor about your absence giving reasons thereof and probable
                    duration immediately, failing which, the same will be treated as loss of Pay.
                </p>
            </li>

            <li>
                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    If you did not report to work for continuous 3 days without proper notification of absenteeism,
                    company is liable to end your contract on immediate basis, on request from client.
                </p>
            </li>
            <li>
                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    Client holds the discretion to do a thorough background verification of your candidature as seems
                    fit and can initiate police verification, background check, court cases verification,
                </p>
            </li>
            <li>
                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    If you found guilty in any one of them, Client have the full authority to end your contract
                    immediately and report the findings to nearest police station
                </p>
            </li>
            <li>
                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    You will be governed by the conduct, discipline, rules and regulations as laid down by the
                    management.
                </p>
            </li>
            <li>
                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    The salary will be paid to you, subject to the receipt of payment from
                    {{ $offerLetter->entity_name }}. (to which you have been deputed).
                </p>
            </li>
            <li>
                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    This contract shall be terminable by either party giving {{ $offerLetter->notice_period }}
                    days’ notice in writing or salary on lieu of notice, to the other.
                </p>
            </li>
            <li>
                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    We are consciously endeavoring to build an atmosphere of trust, openness, responsiveness, autonomy
                    and growth among all members to the Fretus Folks India Pvt Ltd. As a new entrant, we would like you
                    to whole-heartedly contribute in this process.
                </p>
            </li>
            <li>
                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    As a token of acceptance of the above terms and conditions, you are requested to sign the duplicate
                    copy of this letter and return to us.
                </p>
            </li>
        </ol>

        <p style="font-size:12px;line-height:1.5;text-align:justify;">
            With warm regards,
        </p>

        <table width="100%">
            <tbody>
                <tr>
                    <td colspan="3" style="font-size:14px;text-align:left;">
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
        <div style="page-break-after: always;"></div>
        <h3 style="text-align:center;font-weight:bold;">Annexure Salary Break Up</h3>
        <table class="salary-details-table" border="1">
            <tr>
                <th>Basic + DA</th>
                <td>{{ $offerLetter->basic_salary }}</td>
            </tr>
            <tr>
                <th>HRA</th>
                <td>{{ $offerLetter->hra }}</td>
            </tr>
            <tr>
                <th>Other Allowance</th>
                <td>{{ $offerLetter->other_allowance }}</td>
            </tr>
            <tr style="background-color:#FFC300;">
                <th>Gross Salary</th>
                <td>{{ $offerLetter->gross_salary }}</td>
            </tr>
            <tr>
                <th>Employee PF </th>
                <td>{{ $offerLetter->emp_pf }}</td>
            </tr>
            <tr>
                <th>Employee ESIC </th>
                <td>{{ $offerLetter->emp_esic }}</td>
            </tr>
            <tr>
                <th>Employee LWF </th>
                <td>{{ $offerLetter->lwf }}</td>
            </tr>
            <tr>
                <th>PT</th>
                <td>{{ $offerLetter->pt }}</td>
            </tr>
            <tr style="background-color:#B8E6FB;">
                <th>Total Deduction</th>
                <td>{{ $offerLetter->total_deduction }}</td>
            </tr>
            <tr style="background-color:#B8E6FB;">
                <th>Take-home</th>
                <td>{{ $offerLetter->take_home }}</td>
            </tr>
            <tr>
                <th>Employer PF</th>
                <td>{{ $offerLetter->employer_pf }}</td>
            </tr>
            <tr>
                <th>Employer ESIC</th>
                <td>{{ $offerLetter->employer_esic }}</td>
            </tr>
            <tr>
                <th>Employer LWF</th>
                <td>{{ $offerLetter->employer_lwf }}</td>
            </tr>
            <tr style="background-color:#FFC300;">
                <th>CTC</th>
                <td>{{ $offerLetter->ctc }}</td>
            </tr>
            <tr style="background-color:#FFC300;">
                <th>Annual CTC</th>
                <td>{{ $offerLetter->ctc * 12 }}</td>
            </tr>
        </table>

        <table width="100%" style="margin-top:75px;">
            <tbody>
                <tr>
                    <td colspan="3" style="font-size:14px;text-align:left;">
                        <p style="line-height:1.8;">
                            <b>For Fretus Folks India Pvt Ltd.</b> <br>

                        </p><img src="{{ public_path('admin/images/seal.png') }}" style="" width="100"><br>
                        <p><b>&nbsp;&nbsp;&nbsp;Authorized Signatory</b> <br>
                        </p>
                    </td>
                    <td colspan="3" style="font-size:14px;text-align:left;">
                        <p style="line-height:1.8;">
                            Name : <b style="font-weight:bold;">
                                {{ $offerLetter->emp_name }}</b><br /><br />
                            Signature:
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
</body>

</html>
