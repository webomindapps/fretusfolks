<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fretus Folks</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 0 !important;
            margin: 0 !important;
            display: block !important;
            background: #ffffff;
            -webkit-text-size-adjust: none;
            font-family: Times, serif;
        }

        a {
            color: #00b8e4;
            text-decoration: underline;
            font-family: Times, serif;
        }

        h3 a {
            color: #1f1f1f;
            text-decoration: none;
            font-family: Times, serif;
        }

        p {
            padding: 0 !important;
            margin: 0 !important;
            font-family: Times, serif;
        }

        .table1 td,
        .table1 th {
            border: 1px solid black;
        }

        table td,
        th {
            font-family: Times, serif;
            font-size: 14px;
            padding: 1%;
            text-align: left;
        }

        @media print {
            .gross td {
                background: #ecbfbf !important;
            }
        }
    </style>
</head>

<body class="body">
    <br>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td style="padding-left:5%; padding-right:5%;">
                    <div>
                        <div style="color:#000; font-size: 21px; margin-top: 4%; margin-bottom: 5%;">
                            <div
                                style="color: #000; font-family: Tahoma; font-size: 17px; line-height: 18px; text-align: justify;">
                                <h1 style="font-size:23px; text-align:center;">Performance Improvement Plan (PIP)</h1>
                                <h2 style="font-size:18px; text-align:center;">Confidential</h2>
                                <table style="border-collapse:collapse; width:100%; margin-bottom:20px;">
                                    <tbody>
                                        <tr>
                                            <td colspan="3" style="font-size:12px; text-align:left; padding:7px">
                                                <p style="line-height:1.8; font-size:14px">
                                                    <b>To: {{ $pipLetter->pip_letter->emp_name }}</b> <br>
                                                    <b>From: {{ $pipLetter->from_name }}</b> <br>
                                                    <b>Date:
                                                        {{ \Carbon\Carbon::parse($pipLetter->date)->format('d-m-Y') }}</b></b>
                                                    <br>
                                                </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="content" style="line-height:2; font-size:14px">
                                    {{ $pipLetter->content }}
                                </div>
                                <br>
                                <div class="content" style="line-height:2; font-size:14px">
                                    <p><b>Observations, Previous Discussions or Counseling:</b></p>
                                    {{ $pipLetter->observation }}
                                </div>
                                <div class="content" style="line-height:2; font-size:14px">
                                    <p><b>Improvement Goals:</b></p><br>
                                    {{ $pipLetter->from_name }}
                                </div>
                                <br>
                                <div class="content" style="line-height:2; font-size:14px">
                                    <p><b>Follow-up Updates:</b></p><br>
                                    {{ $pipLetter->from_name }}
                                </div>
                                <br>
                                <div class="content" style="line-height:2; font-size:14px">
                                    <p><b>Timeline for Improvement, Consequences & Expectations:</b></p><br>
                                    {{ $pipLetter->from_name }}
                                </div>
                                <br>
                                <div class="content" style="line-height:2; font-size:14px">
                                    <p><b>Signatures:</b></p>
                                    <p>Employee Name: {{ $pipLetter->pip_letter->emp_name }}</p>
                                    <p>Employee Signature: __________________</p>
                                    <p>Date: {{ \Carbon\Carbon::parse($pipLetter->date)->format('d-m-Y') }}</p>
                                </div>
                                <br>
                                <div class="content" style="line-height:2; font-size:14px">
                                    <p>Supervisor/Manager Name:{{ $pipLetter->from_name }}</p>
                                    <p>Supervisor/Manager Signature: __________________</p>
                                    <p>Date: {{ \Carbon\Carbon::parse($pipLetter->date)->format('d-m-Y') }}</p>
                                </div>
                                <table style="border-collapse:collapse; width:100%; margin-bottom:20px;">
                                    <tbody>
                                        <tr>
                                            <td colspan="3" style="font-size:12px; text-align:left; padding:7px">
                                                <p>
                                                    <b>For: Fretus Folks India Pvt Ltd.</b> <br>
                                                    <img src="{{ asset('admin/images/seal.jpg') }}" width="100"><br>
                                                    <b>Authorized Signatory</b>
                                                </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
