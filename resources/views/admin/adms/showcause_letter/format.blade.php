<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="telephone=no" name="format-detection">
    <title>Fretus Folks</title>
    <style type="text/css" media="screen">
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

        p {
            padding: 0 !important;
            margin: 0 !important;
            font-family: times;
        }

        .content1 p {
            padding: 0 !important;
            margin-bottom: 1% !important;
            font-family: times;
        }

        ol {
            font-family: times;
        }

        ol li {
            margin-top: 1%;
            line-height: 2;
        }

        .table1 td,
        .table1 th {
            border: 1px solid black;
        }

        table td,
        th {
            font-family: times;
            font-size: 14px;
            padding-right: 1%;
            padding-left: 1%;
            text-align: left;
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

            .table1 td,
            .table1 th {
                border: 1px solid black;
            }

            table td,
            th {
                font-family: times;
                font-size: 14px;
                padding-right: 1%;
                padding-left: 1%;
                text-align: left;
            }
        }
    </style>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="body"
    style="padding: 0 !important; margin: 0 !important; display: block !important; background: #ffffff; -webkit-text-size-adjust: none">
    <x-letter-head />
    <div>
        <div style="color: #000; font-size: 21px; margin-top: 4%; margin-bottom: 0%;">
            <div
                style="color: #000; font-family: Tahoma; font-size: 17px; line-height: 18px; text-align: justify; padding-left: 0%;">
                <div><br></div>
            </div>
            <div
                style="color: #000; font-family: Tahoma; font-size: 17px; line-height: 18px; text-align: justify; padding-left: 0%;">
                <table style="border-collapse: collapse; width: 100%; margin-bottom: 20px;">
                    <tbody>
                        <tr>
                            <td colspan="3"
                                style="font-size: 12px; text-align: left; padding: 0px; width: 80%;">
                                <p style="line-height: 1.8; font-size: 14px">
                                    <b>Date:
                                        {{ \Carbon\Carbon::parse($showLetter->date)->format('d-m-Y') }}</b>
                                </p>
                                <p style="line-height: 1.8; font-size: 14px">
                                    <b>To,<br>Mr./Mrs./Ms,
                                        {{ $showLetter->showcauseletter->emp_name }}</b><br>
                                    {{ $showLetter->emp_id }}<br>
                                    {{ $showLetter->showcauseletter->location }}<br>
                                </p>
                            </td>
                            <td style="font-size: 12px; text-align: left; padding: 0px;"></td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <div class="content" style="line-height: 2; font-size: 14px">
                    <p style="line-height: 1.8; font-size: 14px"><b>Sub: Show-cause Notice</b></p>
                </div>
                <br>
                <div class="content" style="line-height: 2; font-size: 14px">
                    <p style="line-height: 1.8; font-size: 14px"><b>Dear
                            {{ $showLetter->showcauseletter->emp_name }},</b>
                    </p>
                </div>
                <br>
                <div class="content1" style="line-height: 2; font-size: 14px">
                    Based on the attendance records, it has been observed that you have not been
                    reporting for your duty with <strong>Fretus Folks India Pvt Ltd</strong> since
                    <span><strong>{{ $showLetter->content }}</strong></span>. Such absence is
                    without any prior permission or intimation.
                    <strong>Fretus Folks India Pvt Ltd</strong> is treating your unauthorized
                    absenteeism as willful misconduct on your part and is issuing this letter to you as
                    a final notice. You are hereby called upon to report for duty or intimate us in
                    writing the reason for your unauthorized absence, within two (2) days from the date
                    of this notice, failing which <strong>Fretus Folks India Pvt Ltd</strong> shall
                    treat your unauthorized absenteeism as “Voluntary abandonment of employment.”
                    Consequently, your last working day, prior to your unauthorized absenteeism, will be
                    treated as the last working day with us, and we will accordingly commence your exit
                    formalities without any further notice.
                </div>
                <br>
                <div class="content" style="line-height: 2; font-size: 14px">
                    <p>Regards,</p>
                </div>
                <br>
                <div class="content" style="line-height: 2; font-size: 14px">
                    <p>Yours Sincerely,</p>
                </div>
                <br>
                <table style="border-collapse: collapse; width: 100%; margin-bottom: 0px;">
                    <tbody>
                        <tr>
                            <td colspan="3" style="font-size:12px; text-align:left; padding:7px;">
                                <p style="line-height:1.8; font-size:14px;">
                                    Yours faithfully,<br>
                                    <b>For : Fretus Folks India Pvt Ltd.</b>
                                </p>
                                <img src="{{ public_path('admin/images/seal.png') }}" width="100">
                                <p style="line-height:1.8; font-size:14px;">
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
</body>

</html>
