<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Performance Improvement Plan</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @page {
            size: A4;
            margin: 2.5cm;
        }

        body {
            font-family: Times, serif;
            font-size: 14px;
            color: #000;
            background: #fff;
            margin: 0;
            padding: 0;
        }

        h1,
        h2 {
            text-align: center;
            margin-bottom: 0;
        }

        h1 {
            font-size: 22px;
            margin-top: 10px;
        }

        h2 {
            font-size: 18px;
            margin-bottom: 30px;
        }

        p {
            margin: 8px 0;
            line-height: 1.6;
        }

        table {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }

        .section-title {
            font-weight: bold;
            margin-top: 15px;
            text-decoration: underline;
        }

        .signature-block p {
            margin: 3px 0;
        }

        .seal {
            margin-top: 10px;
        }

        .content {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <h1>Performance Improvement Plan (PIP)</h1>
    <h2>Confidential</h2>

    <table>
        <tr>
            <td>
                <p><strong>To:</strong> {{ $pipLetter->pip_letter->emp_name }}</p>
                <p><strong>From:</strong> {{ $pipLetter->from_name }}</p>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($pipLetter->date)->format('d-m-Y') }}</p>
            </td>
        </tr>
    </table>

    <div class="content">
        {!! $pipLetter->content !!}
    </div>

    <div class="content">
        <p class="section-title">Observations, Previous Discussions or Counseling:</p>
        {!! $pipLetter->observation !!}
    </div>

    <div class="content">
        <p class="section-title">Improvement Goals:</p>
        <p>These are the goals related to areas of concern to be improved and addressed:</p>
        {!! $pipLetter->goals !!}
    </div>

    <div class="content">
        <p class="section-title">Follow-up Updates:</p>
        <p>You will receive feedback on your progress according to the following schedule:</p>
        {!! $pipLetter->updates !!}
    </div>

    <div class="content">
        <p class="section-title">Timeline for Improvement, Consequences & Expectations:</p>
        {!! $pipLetter->timeline !!}
    </div>

    <div class="signature-block">
        <p><strong>Employee Name:</strong> {{ $pipLetter->pip_letter->emp_name }}</p>
        <p><strong>Employee Signature:</strong> __________________</p>
        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($pipLetter->date)->format('d-m-Y') }}</p>
    </div>

    <br>

    <div class="signature-block">
        <p><strong>Supervisor/Manager Name:</strong> {{ $pipLetter->from_name }}</p>
        <p><strong>Supervisor/Manager Signature:</strong> __________________</p>
        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($pipLetter->date)->format('d-m-Y') }}</p>
    </div>

    <br>

    <table>
        <tr>
            <td>
                <p><strong>For: Fretus Folks India Pvt Ltd.</strong></p>
                <img src="{{ public_path('admin/images/seal.png')}}" width="100">
                <p style="line-height:1.8; font-size:14px;">
                    <b>Authorized Signatory</b>
                </p>
            </td>
        </tr>
    </table>

</body>

</html>
