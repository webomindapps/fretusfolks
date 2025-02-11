<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Performance Improvement Plan (PIP)</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 0 !important;
            margin: 0 !important;
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
            font-size: 10px;
            padding: 0%;
            text-align: left;
        }

        @media print {
            .gross td {
                background: #ecbfbf !important;
            }
        }
    </style>
</head>

<body>
    <br>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="page-break-before: always;">
        <tbody>
            <tr>
                <td style="padding-left:5%; padding-right:5%;">
                    <div>
                        <h1 style="font-size:16px; text-align:center;">Performance Improvement Plan (PIP)</h1>
                        <h2 style="font-size:14px; text-align:center;">Confidential</h2>

                        <table style="border-collapse:collapse; width:100%; margin-bottom:20px;">
                            <tbody>
                                <tr>
                                    <td colspan="3" style="font-size:10px; text-align:left; padding:7px">
                                        <p style="line-height:1.8; font-size:14px">
                                            <b>To: {{ $pipLetter->pip_letter->emp_name }}</b> <br>
                                            <b>From: {{ $pipLetter->from_name }}</b> <br>
                                            <b>Date: {{ \Carbon\Carbon::parse($pipLetter->date)->format('d-m-Y') }}</b>
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="content" style="line-height:2; font-size:12px">
                            {!! $pipLetter->content !!}
                        </div>

                        <br>
                        <div class="content" style="line-height:2; font-size:12px">
                            <p><b>Observations, Previous Discussions or Counseling:</b></p>
                            {!! $pipLetter->observation !!}
                        </div>

                        <br>
                        <div class="content" style="line-height:2; font-size:12px">
                            <p><b>Improvement Goals:</b> These are the goals related to areas of concern to be improved
                                and addressed:</p>
                            {!! $pipLetter->goals !!}
                        </div>

                        <br>
                        <div class="content" style="line-height:2; font-size:12px">
                            <p><b>Follow-up Updates:</b> You will receive feedback on your progress according to the
                                following schedule:</p>
                            {!! $pipLetter->updates !!}
                        </div>

                        <br>
                        <div class="content" style="line-height:2; font-size:12px">
                            <p><b>Timeline for Improvement, Consequences & Expectations:</b></p>
                            {!! $pipLetter->timeline !!}
                        </div>

                        <br>
                        <div class="content" style="line-height:2; font-size:12px">
                            <p><b>Signatures:</b></p>
                            <p>Employee Name: {{ $pipLetter->pip_letter->emp_name }}</p>
                            <p>Employee Signature: __________________</p>
                            <p>Date: {{ \Carbon\Carbon::parse($pipLetter->date)->format('d-m-Y') }}</p>
                        </div>

                        <br>
                        <div class="content" style="line-height:2; font-size:12px">
                            <p>Supervisor/Manager Name: {{ $pipLetter->from_name }}</p>
                            <p>Supervisor/Manager Signature: __________________</p>
                            <p>Date: {{ \Carbon\Carbon::parse($pipLetter->date)->format('d-m-Y') }}</p>
                        </div>

                        <table style="border-collapse:collapse; width:100%; margin-bottom:20px;">
                            <tbody>
                                <tr>
                                    <td colspan="3" style="font-size:12px; text-align:left; padding:7px">
                                        <p>
                                            <b>For: Fretus Folks India Pvt Ltd.</b> <br>
                                            <img src="{{ public_path('admin/images/seal.png') }}" width="50"><br>
                                            <b>Authorized Signatory</b>
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
