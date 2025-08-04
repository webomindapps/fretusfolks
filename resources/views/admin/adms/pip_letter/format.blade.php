<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fretus Folks - PIP Letter</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <style type="text/css" media="screen">
        @page {
            margin: 100px 0 120px 20px;
        }

        header {
            position: fixed;
            top: -100px;
            left: -40px;
            right: 0;
        }

        footer {
            position: fixed;
            bottom: -120px;
            left: -20px;
        }

        body {
            margin: 100px;
            margin-left: 20px !important;
            margin-right: 40px !important;
            margin-bottom: 40px !important;

            padding: 0;
            background: #ffffff;
            font-family: Times, serif;
            font-size: 14px;
            color: #000;
            line-height: 1.6;
            display: block !important;
            -webkit-text-size-adjust: none;
        }

        h1,
        h2 {
            text-align: center;
            margin: 0;
        }

        h1 {
            font-size: 22px;
            margin-top: 10px;
        }

        h2 {
            font-size: 18px;
            margin-bottom: 20px;
        }

        h3 a {
            color: #1f1f1f;
            text-decoration: none;
            font-family: Times, serif;
        }

        a {
            color: #00b8e4;
            text-decoration: underline;
            font-family: Times, serif;
        }

        .text2 a {
            color: #ea4261;
            text-decoration: none;
        }

        p,
        .content1 p,
        .signature-block p {
            margin: 6px 0;
            padding: 0;
            font-family: Times, serif;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
            text-decoration: underline;
        }

        .signature-block {
            margin-top: 20px;
        }

        .signature-block p {
            margin: 4px 0;
        }

        .content-block {
            text-align: justify;
        }

        table.meta-info,
        .table1 {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        table.meta-info td,
        .table1 td,
        .table1 th {
            padding: 6px 10px;
            font-family: Times, serif;
            font-size: 14px;
            text-align: left;
            border: 1px solid black;
        }

        ol {
            font-family: Times, serif;
            padding-left: 20px;
        }

        ol li {
            margin-top: 1%;
            line-height: 2;
        }

        @media print {
            body {
                background: #ffffff;
                font-family: Times, serif;
                left: 60px !important;
            }

            header {
                position: fixed;
                top: -100px;
            }

            footer {
                position: fixed;
                bottom: -40px;
            }

            .table1 td,
            .table1 th {
                border: 1px solid black;
            }

            table td,
            th {
                font-family: Times, serif;
                font-size: 14px;
                text-align: left;
                padding: 6px 10px;
            }
        }
    </style>

</head>

<body>
    <x-letter-head />

    <h1>Performance Improvement Plan (PIP)</h1>
    <h2>Confidential</h2>
    <div class="meta-info">
        <p style="line-height:1.8;font-size:13px;">
            <span><b>To,</b></span> <br>
            <span><b> {{ $pipLetter->pip_letters->emp_name ?? 'N/A' }}</b></span> <br>

            <span><b>From : {{ $pipLetter->from_name }}</b></span> <br>
            <span><b>Date : {{ \Carbon\Carbon::parse($pipLetter->date)->format('d-m-Y') }}</b></span> <br>

        </p>
    </div>
    {{-- <table class="meta-info">
        <tr>
            <td><strong>To:</strong> {{ $pipLetter->pip_letters->emp_name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td><strong>From:</strong> {{ $pipLetter->from_name }}</td>
        </tr>
        <tr>
            <td><strong>Date:</strong> {{ \Carbon\Carbon::parse($pipLetter->date)->format('d-m-Y') }}</td>
        </tr>
    </table> --}}

    <div class="section content-block">
        <p>
            The purpose of this Performance Improvement Plan (PIP) is to define serious areas of concern, gaps in
            your work performance, reiterate at {{ $pipLetter->pip_letters->entity_name ?? 'N/A' }}. expectations, and
            allow you the
            opportunity to demonstrate improvement and commitment.
        </p>
        {{-- {!! $pipLetter->content !!} --}}
    </div>

    <div class="section content-block">
        <p class="section-title">Observations, Previous Discussions or Counseling:</p>
        {{-- <p>
            In spite of constant follow-up, motivation and warnings, since last 6 weeks, the performance is
            observed below mark. So intend to put you on pip.
        </p> --}}
        {!! $pipLetter->observation !!}
    </div>

    <div class="section content-block">
        <p class="section-title">Improvement Goals:</p>
        <p>These are the goals related to areas of concern to be improved and addressed:</p>
        <table style="width:100%; border-collapse: collapse; font-family: Times, serif; font-size: 14px;">
            <tr>
                <td style="border: 1px solid #000; width: 40px; text-align: center; height: 40px;"></td>
                <td style="border: 1px solid #000; height: 40px;"></td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; text-align: center; height: 40px;"></td>
                <td style="border: 1px solid #000; height: 40px;"></td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; text-align: center; height: 40px;"></td>
                <td style="border: 1px solid #000; height: 40px;"></td>
            </tr>
        </table>
    </div>
    <div style="page-break-after: always;"></div>

    <div class="section content-block">
        <p class="section-title">Follow-up Updates:</p>
        <p>You will receive feedback on your progress according to the following schedule:</p>
        <table style="width:100%; border-collapse: collapse; font-family: Times, serif; font-size: 14px;">
            <thead>
                <tr>
                    <th style="border: 1px solid #000; width: 40px; text-align: center; height: 30px;">Date Scheduled
                    </th>
                    <th style="border: 1px solid #000; text-align: left; height: 30px;">Activity</th>
                    <th style="border: 1px solid #000; text-align: left; height: 30px;">Conducted By</th>
                    <th style="border: 1px solid #000; text-align: left; height: 30px;">Completion Date</th>
                    <th style="border: 1px solid #000; text-align: left; height: 30px;">Remarks</th>


                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 1px solid #000; height: 30px;"></td>
                    <td style="border: 1px solid #000; height: 30px;"></td>
                    <td style="border: 1px solid #000; height: 30px;"></td>
                    <td style="border: 1px solid #000; height: 30px;"></td>
                    <td style="border: 1px solid #000; height: 30px;"></td>

                </tr>
                <tr>
                    <td style="border: 1px solid #000; height: 30px;"></td>
                    <td style="border: 1px solid #000; height: 30px;"></td>
                    <td style="border: 1px solid #000; height: 30px;"></td>
                    <td style="border: 1px solid #000; height: 30px;"></td>
                    <td style="border: 1px solid #000; height: 30px;"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #000; height: 30px;"></td>
                    <td style="border: 1px solid #000; height: 30px;"></td>
                    <td style="border: 1px solid #000; height: 30px;"></td>
                    <td style="border: 1px solid #000; height: 30px;"></td>
                    <td style="border: 1px solid #000; height: 30px;"></td>
                </tr>
            </tbody>
        </table>

        {{-- {!! $pipLetter->updates !!} --}}
    </div>

    <div class="section content-block">
        <p class="section-title">Timeline for Improvement, Consequences & Expectations:</p>

        {!! $pipLetter->timeline !!}
    </div>
    <div style="page-break-after: always;"></div>

    <div class="signature-block">
        <p><strong>Employee Name:</strong> {{ $pipLetter->pip_letters->emp_name ?? 'N/A' }}</p>
        <p><strong>Employee Signature:</strong> __________________</p>
        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($pipLetter->date)->format('d-m-Y') }}</p>
    </div>

    <div class="signature-block">
        <p><strong>Supervisor/Manager Name:</strong> {{ $pipLetter->from_name }}</p>
        <p><strong>Supervisor/Manager Signature:</strong> __________________</p>
        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($pipLetter->date)->format('d-m-Y') }}</p>
    </div>

    <table>
        <tr>
            <td>
                <p><strong>For: Fretus Folks India Pvt Ltd.</strong></p>
                <img src="{{ public_path('admin/images/seal.png') }}" width="100" alt="Seal" />
                <p style="line-height:1.8; font-size:14px;">
                    <b>Authorized Signatory</b>
                </p>
            </td>
        </tr>
    </table>
</body>

</html>
