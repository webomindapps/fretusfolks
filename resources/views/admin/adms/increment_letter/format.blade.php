<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no">
    <title>Fretus Folks</title>
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

        body {
            padding: 0 !important;
            margin: 0 !important;
            display: block !important;
            background: #ffffff;
            -webkit-text-size-adjust: none;
            font-family: times;
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

        /* Campaign Monitor wraps the text in editor in paragraphs. In order to preserve design spacing we remove the padding/margin */
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
            line-height: 2
        }

        .table1 td,
        .table1 th {
            border: 1px solid black;
        }

        .content1 p {
            margin-bottom: 1% !important;
        }

        @media print {
            body {
                padding: 0 !important;
                margin: 0 !important;
                display: block !important;
                background: #ffffff;
                -webkit-text-size-adjust: none;
                font-family: times;
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

            /* Campaign Monitor wraps the text in editor in paragraphs. In order to preserve design spacing we remove the padding/margin */
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
                line-height: 2
            }

            .table1 td,
            .table1 th {
                border: 1px solid black;
                padding: 5px 8px;
            }

            .gross td {
                background: #ecbfbf !important;
            }
        }
    </style>
</head>

<body class="body">
    <x-letter-head />
    <div style="color:#000;font-size: 21px;margin-top: 4%;margin-bottom: 5%;">
        <div
            style="color: #000;font-family: Tahoma;font-size: 17px;line-height: 18px;text-align: justify; padding-left: 0%;">
            <br>
            <table style="border-collapse:collapse;width:100%;margin-bottom:20px;">
                <tbody>
                    <tr>
                        <td colspan="3" style="font-size:12px;text-align:left;padding:0px;width:70%">
                            <p style="line-height:1.8;font-size:12px">
                                <b>To<br>Mr./Mrs./Ms,
                                    {{ $increment->emp_name }}</b><br>
                                {{ $increment->emp_name }}<br>
                                {{ $increment->location }}<br>
                            </p>
                        </td>
                        <td style="font-size:12px;text-align:left;padding:0px;">
                            <p style="line-height:1.8;font-size:12px">
                                <b>Date : {{ \Carbon\Carbon::parse($increment->date)->format('d-m-Y') }}</b>
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>
            <div class="content" style="line-height:2;font-size:14px">
                <p style="line-height:1.8;font-size:12px"><b>Sub : Increment Letter</b></p>
            </div>
            <br>
            <div class="content" style="line-height:2;font-size:14px">
                <p style="line-height:1.8;font-size:12px">
                    <b>Dear {{ $increment->emp_name }},</b>
                </p>
            </div>
            <br>
            <div class="content1" style="line-height:1.8;font-size:14px">
                {{-- {!! $increment->content !!} --}}
                <p style="text-align: justify;">In recognition of your performance and the contribution to the company,
                    we are pleased to inform you that you have be given an increase of {{ $increment->Increment_Percentage }}% on
                    CTC(Cost to the Company) which will be effective from {{ $increment->effective_date }}.</p>
                <p style="text-align: justify;">Current CTC (per annum): {{ $increment->current_ctc }}</p>
                <p style="text-align: justify;">Old CTC (per annum): {{ $increment->old_ctc }}</p>
                <p style="text-align: justify;">Current Designation: {{ $increment->designation }}</p>
                <p style="text-align: justify;">Old Designation: {{$increment->old_designation }}</p>
                <p style="text-align: justify;">&nbsp;</p>
                <p style="text-align: justify;">Your commitment has been invaluable, and we look forward to your
                    continued engagement.&nbsp; All other terms and conditions of your contract are as per the annexure
                    attached below.</p>
                <p style="text-align: justify;">&nbsp;</p>
                <p style="text-align: justify;">With best wishes and warm regards.</p>

            </div>
            <br><br><br><br>
            <table style="border-collapse:collapse;width:100%;margin-bottom:20px;">
                <tbody>
                    <tr>
                        <td colspan="3" style="font-size:12px;text-align:left;padding:7px">
                            <p style="line-height:1.8;font-size:12px">
                                <b>For : Fretus Folks India Pvt Ltd.</b>
                            </p>
                            <img class="abc" src="{{ public_path('admin/images/seal.png') }}">
                            <p style="line-height:1.8;font-size:12px">
                                <b>Authorized Signatory</b>
                            </p>
                        </td>
                        <td style="font-size:12px;text-align:left;padding:7px;width:40%">
                            <p style="line-height:1.8;font-size:12px">
                                <br><b>I accept:</b><br><br><br>
                                <b>Signature and Date</b><br>
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>
        </div>
    </div>
    <div
        style="color: #000;font-family: Tahoma;font-size: 17px;line-height: 18px;text-align: justify; padding-left: 0%;">
        <h1 style="font-size:20px;text-align:center;text-decoration: underline;">Annexure - 1</h1>
        <center>
            <table class="table table1 annexure_table" border="1"
                style="border-collapse:collapse;width:80%;margin-bottom:5px;font-size:10px; margin:20px auto;"">
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
                        <td> {{ $increment->basic_salary }} </td>
                        <td> {{ $increment->basic_salary * 12 }} </td>
                    </tr>
                    <tr>
                        <td>HRA</td>
                        <td> {{ $increment->hra }}</td>
                        <td> {{ $increment->hra * 12 }} </td>
                    </tr>
                    <tr>
                        <td>Conveyance</td>
                        <td> {{ $increment->conveyance }}</td>
                        <td> {{ $increment->conveyance * 12 }}</td>
                    </tr>
                    <tr>
                        <td>Medical Reimbursement</td>
                        <td>{{ $increment->medical_reimbursement }}</td>
                        <td> {{ $increment->medical_reimbursement * 12 }} </td>
                    </tr>
                    <tr>
                        <td>Special Allowance</td>
                        <td> {{ $increment->special_allowance }}</td>
                        <td> {{ $increment->special_allowance * 12 }} </td>
                    </tr>
                    <tr>
                        <td>Other Allowance</td>
                        <td> {{ $increment->other_allowance }}</td>
                        <td> {{ $increment->other_allowance * 12 }}</td>
                    </tr>
                    <tr class="gross" style="background: #ecbfbf;">
                        <td>Gross Salary</td>
                        <td> {{ $increment->gross_salary }}</td>
                        <td> {{ $increment->gross_salary * 12 }} </td>
                    </tr>
                    <tr>
                        <td>Employee PF @ {{ $increment->pf_percentage }}%</td>
                        <td> {{ $increment->emp_pf }}</td>
                        <td> {{ $increment->emp_pf * 12 }}</td>
                    </tr>
                    <tr>
                        <td>Employee ESIC PF @ {{ $increment->esic_percentage }}%
                        </td>
                        <td> {{ $increment->emp_esic }}</td>
                        <td> {{ $increment->emp_esic * 12 }}</td>
                    </tr>
                    <tr>
                        <td>PT</td>
                        <td>{{ $increment->pt }}</td>
                        <td> {{ $increment->pt * 12 }}</td>
                    </tr>
                    <tr>
                        <td>Total Deduction</td>
                        <td> {{ $increment->total_deduction }}</td>
                        <td> {{ $increment->total_deduction * 12 }} </td>
                    </tr>
                    <tr class="gross" style="background: #ecbfbf;">
                        <td>Take-home</td>
                        <td> {{ $increment->gross_salary }}-
                            {{ $increment->total_deduction }}</td>
                        <td> {{ $increment->gross_salary }} -
                            {{ $increment->total_deduction * 12 }} </td>
                    </tr>
                    <tr>
                        <td>Employer PF @ {{ $increment->employer_pf_percentage }}%</td>
                        <td> {{ $increment->employer_pf }}</td>
                        <td> {{ $increment->employer_pf * 12 }} </td>
                    </tr>
                    <tr>
                        <td>Employer ESIC PF @ {{ $increment->employer_esic_percentage }}%
                        </td>
                        <td> {{ $increment->employer_esic }}</td>
                        <td> {{ $increment->employer_esic * 12 }} </td>
                    </tr>
                    <tr class="gross" style="background: #ecbfbf;">
                        <td>CTC</td>
                        <td> {{ $increment->ctc }}</td>
                        <td> {{ $increment->ctc * 12 }} </td>
                    </tr>
                </tbody>
            </table>
        </center>
    </div>
</body>

</html>
