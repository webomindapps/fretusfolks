<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no">
    <title>Fretus Folks</title>
    <style>
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
            }

            .gross td {
                background: #ecbfbf !important;
            }
        }
    </style>
</head>

<body class="body">
    <div>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td style="padding-left:5%;padding-right:5%;">
                        <img src="/public/admin/images/ffi_header.jpg">
                        <div style="color:#000;font-size: 21px;margin-top: 4%;margin-bottom: 5%;">
                            <div
                                style="color: #000;font-family: Tahoma;font-size: 17px;line-height: 18px;text-align: justify; padding-left: 0%;">
                                <br>
                                <table style="border-collapse:collapse;width:100%;margin-bottom:20px;">
                                    <tbody>
                                        <tr>
                                            <td colspan="3"
                                                style="font-size:12px;text-align:left;padding:0px;width:70%">
                                                <p style="line-height:1.8;font-size:12px">
                                                    <b>To<br>Mr./Mrs./Ms,
                                                        {{ $incrementLetter->incrementLetter->emp_name }}</b><br>
                                                    {{ $incrementLetter->incrementLetter->emp_name }}<br>
                                                    {{ $incrementLetter->incrementLetter->location }}<br>
                                                </p>
                                            </td>
                                            <td style="font-size:12px;text-align:left;padding:0px;">
                                                <p style="line-height:1.8;font-size:12px"><b>Date :
                                                        {{ \Carbon\Carbon::parse($incrementLetter->date)->format('d-m-Y') }}</b>
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
                                    <p style="line-height:1.8;font-size:12px"><b>Dear
                                            {{ $incrementLetter->incrementLetter->emp_name }},</b></p>
                                </div>
                                <br>
                                <div class="content1" style="line-height:1.8;font-size:14px">
                                    {{ $incrementLetter->content }}
                                </div>
                                <br><br><br><br>
                                <table style="border-collapse:collapse;width:100%;margin-bottom:20px;">
                                    <tbody>
                                        <tr>
                                            <td colspan="3" style="font-size:12px;text-align:left;padding:7px">
                                                <p style="line-height:1.8;font-size:12px">
                                                    <br><b>For : Fretus Folks India Pvt Ltd.</b><br>
                                                    <img class="abc" src="/public/admin/images/seal.png">
                                                    <b>Authorized Signatory</b><br>
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
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <img class="abc" src="/public/admin/images/ffi_footer.jpg">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td style="padding-left:5%;padding-right:5%;">
                    <br>
                    <div
                        style="color: #000;font-family: Tahoma;font-size: 17px;line-height: 18px;text-align: justify; padding-left: 0%;">
                        <h1 style="font-size:20px;text-align:center;text-decoration: underline;">Annexure - 1</h1>
                        <center>
                            <table class="table table1" border="1"
                                style="border-collapse:collapse;width:80%;margin-bottom:5px;font-size:10px;">
                                <tbody>
                                    <tr>
                                        <th
                                            style="font-size:12px;text-align:left;padding:7px;border-top: 1px solid #000;">
                                            Components</th>
                                        <th
                                            style="font-size:12px;text-align:left;padding:7px;width:30%;border-top: 1px solid #000;">
                                            Monthly salary</th>
                                        <th
                                            style="font-size:12px;text-align:left;padding:7px;width:30%;border-top: 1px solid #000;">
                                            Annual salary</th>
                                    </tr>
                                    <tr>
                                        <td>Basic</td>
                                        <td> {{ $incrementLetter->basic_salary }} </td>
                                        <td> {{ $incrementLetter->basic_salary * 12 }} </td>
                                    </tr>
                                    <tr>
                                        <td>HRA</td>
                                        <td> {{ $incrementLetter->hra }}</td>
                                        <td> {{ $incrementLetter->hra * 12 }} </td>
                                    </tr>
                                    <tr>
                                        <td>Conveyance</td>
                                        <td> {{ $incrementLetter->conveyance }}</td>
                                        <td> {{ $incrementLetter->conveyance * 12 }}</td>
                                    </tr>
                                    <tr>
                                        <td>Medical Reimbursement</td>
                                        <td>{{ $incrementLetter->medical_reimbursement }}</td>
                                        <td> {{ $incrementLetter->medical_reimbursement * 12 }} </td>
                                    </tr>
                                    <tr>
                                        <td>Special Allowance</td>
                                        <td> {{ $incrementLetter->special_allowance }}</td>
                                        <td> {{ $incrementLetter->special_allowance * 12 }} </td>
                                    </tr>
                                    <tr>
                                        <td>Other Allowance</td>
                                        <td> {{ $incrementLetter->other_allowance }}</td>
                                        <td> {{ $incrementLetter->other_allowance * 12 }}</td>
                                    </tr>
                                    <tr class="gross" style="background: #ecbfbf;">
                                        <td>Gross Salary</td>
                                        <td> {{ $incrementLetter->gross_salary }}</td>
                                        <td> {{ $incrementLetter->gross_salary * 12 }} </td>
                                    </tr>
                                    <tr>
                                        <td>Employee PF @ {{ $incrementLetter->pf_percentage }}%</td>
                                        <td> {{ $incrementLetter->emp_pf }}</td>
                                        <td> {{ $incrementLetter->emp_pf * 12 }}</td>
                                    </tr>
                                    <tr>
                                        <td>Employee ESIC PF @ {{ $incrementLetter->esic_percentage }}%
                                        </td>
                                        <td> {{ $incrementLetter->emp_esic }}</td>
                                        <td> {{ $incrementLetter->emp_esic * 12 }}</td>
                                    </tr>
                                    <tr>
                                        <td>PT</td>
                                        <td>{{ $incrementLetter->pt }}</td>
                                        <td> {{ $incrementLetter->pt * 12 }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Deduction</td>
                                        <td> {{ $incrementLetter->total_deduction }}</td>
                                        <td> {{ $incrementLetter->total_deduction * 12 }} </td>
                                    </tr>
                                    <tr class="gross" style="background: #ecbfbf;">
                                        <td>Take-home</td>
                                        <td> {{ $incrementLetter->gross_salary }}-
                                            {{ $incrementLetter->total_deduction }}</td>
                                        <td> {{ $incrementLetter->gross_salary }} -
                                            {{ $incrementLetter->total_deduction * 12 }} </td>
                                    </tr>
                                    <tr>
                                        <td>Employer PF @ {{ $incrementLetter->employer_pf_percentage }}%</td>
                                        <td> {{ $incrementLetter->employer_pf }}</td>
                                        <td> {{ $incrementLetter->employer_pf * 12 }} </td>
                                    </tr>
                                    <tr>
                                        <td>Employer ESIC PF @ {{ $incrementLetter->employer_esic_percentage }}%
                                        </td>
                                        <td> {{ $incrementLetter->employer_esic }}</td>
                                        <td> {{ $incrementLetter->employer_esic * 12 }} </td>
                                    </tr>
                                    <tr class="gross" style="background: #ecbfbf;">
                                        <td>CTC</td>
                                        <td> {{ $incrementLetter->ctc }}</td>
                                        <td> {{ $incrementLetter->ctc * 12 }} </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table style="border-collapse:collapse;width:100%;margin-bottom:5px;">
                                <tbody>
                                    <tr>
                                        <td colspan="3" style="font-size:12px;text-align:left;padding:7px">
                                            <p style="line-height:1.8;font-size:14px">
                                                <br>
                                                <b>For : Fretus Folks India Pvt Ltd.</b> <br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <img class="abc" src="/public/admin/images/ffi_footer.jpg">

                                                <br>
                                                <b>&nbsp;&nbsp;Authorized Signatory</b> <br>
                                            </p>
                                        </td>
                                        <td style="font-size:12px;text-align:left;padding:7px;width:40%">
                                            <p style="line-height:1.8;font-size:14px">
                                                <br>
                                                <b>I accept:</b> <br><br><br>
                                                <b>Signature and Date</b> <br>
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </center>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <img class="abc" src="/public/admin/images/ffi_footer.jpg">
</body>

</html>
