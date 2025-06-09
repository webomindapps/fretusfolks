<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fretus Folks - PIP Letter</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @page {
            size: A4;
            margin: 2.5cm;
        }

        body {
            margin: 0;
            padding: 0;
            background: #ffffff;
            font-family: Times, serif;
            font-size: 14px;
            color: #000;
            line-height: 1.6;
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

        p {
            margin: 6px 0;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 6px;
        }

        .signature-block {
            margin-top: 20px;
        }

        .signature-block p {
            margin: 4px 0;
        }

        table.meta-info {
            width: 100%;
            margin-bottom: 20px;
        }

        table.meta-info td {
            padding: 6px 0;
        }

        .seal {
            margin-top: 10px;
        }

        .content-block {
            text-align: justify;
        }
    </style>
</head>

<body>
    <h1>Performance Improvement Plan (PIP)</h1>
    <h2>Confidential</h2>

    <table class="meta-info">
        <tr>
            <td><strong>To:</strong> {{ $pipLetter->pip_letter->emp_name }}</td>
        </tr>
        <tr>
            <td><strong>From:</strong> {{ $pipLetter->from_name }}</td>
        </tr>
        <tr>
            <td><strong>Date:</strong> {{ \Carbon\Carbon::parse($pipLetter->date)->format('d-m-Y') }}</td>
        </tr>
    </table>

    <div class="section content-block">
        {!! $pipLetter->content !!}
    </div>

    <div class="section content-block">
        <p class="section-title">Observations, Previous Discussions or Counseling:</p>
        {!! $pipLetter->observation !!}
    </div>

    <div class="section content-block">
        <p class="section-title">Improvement Goals:</p>
        <p>These are the goals related to areas of concern to be improved and addressed:</p>
        {!! $pipLetter->goals !!}
    </div>

    <div class="section content-block">
        <p class="section-title">Follow-up Updates:</p>
        <p>You will receive feedback on your progress according to the following schedule:</p>
        {!! $pipLetter->updates !!}
    </div>

    <div class="section content-block">
        <p class="section-title">Timeline for Improvement, Consequences & Expectations:</p>
        {!! $pipLetter->timeline !!}
    </div>

    <div class="signature-block">
        <p><strong>Employee Name:</strong> {{ $pipLetter->pip_letter->emp_name }}</p>
        <p><strong>Employee Signature:</strong> __________________</p>
        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($pipLetter->date)->format('d-m-Y') }}</p>
    </div>

    <div class="signature-block">
        <p><strong>Supervisor/Manager Name:</strong> {{ $pipLetter->from_name }}</p>
        <p><strong>Supervisor/Manager Signature:</strong> __________________</p>
        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($pipLetter->date)->format('d-m-Y') }}</p>
    </div>

    <div class="signature-block">
        <p><strong>For: Fretus Folks India Pvt Ltd.</strong></p>
        <img src="{{ public_path('admin/images/seal.png') }}" width="100" class="seal"><br>
        <strong>Authorized Signatory</strong>
    </div>
</body>

</html>