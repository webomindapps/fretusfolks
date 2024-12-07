{{-- resources/views/termination_letter.blade.php --}}

@csrf
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no">
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

        /* Linked Styles */
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
            line-height: 2
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
    </style>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <x-letter-head />
    <div>
        <div style="color:#000;font-size: 21px;margin-top: 4%;margin-bottom: 0%;">
            <div
                style="color: #000;font-family: Tahoma;font-size: 17px;line-height: 18px;text-align: justify; padding-left: 0%;">
                <div>
                    {{-- Content goes here --}}
                </div>
            </div>
            <div
                style="color: #000;font-family: Tahoma;font-size: 17px;line-height: 18px;text-align: justify; padding-left: 0%;">
                <table style="border-collapse:collapse;width:100%;margin-bottom:20px;">
                    <tbody>
                        <tr>
                            <td colspan="3"
                                style="font-size:12px;text-align:left;padding:0px;width:80%">
                                <p style="line-height:1.8;font-size:14px"><b>Date :
                                        {{ \Carbon\Carbon::parse($termLetter->date)->format('d-m-Y') }}</b>
                                </p>
                                <p style="line-height:1.8;font-size:14px">
                                    <b>To,
                                        <br>Mr./Mrs./Ms, {{ $termLetter->term_letter->emp_name }}</b>
                                    <br> {{ $termLetter->emp_id }}
                                    <br> {{ $termLetter->term_letter->location }} <br>
                                </p>
                            </td>
                            <td style="font-size:12px;text-align:left;padding:0px;"></td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <div class="content" style="line-height:2;font-size:14px">
                    <p style="line-height:1.8;font-size:14px"><b>Sub : Termination of Employment</b></p>
                </div>
                <br>
                <div class="content" style="line-height:2;font-size:14px">
                    <p style="line-height:1.8;font-size:14px"><b>Dear
                            {{ $termLetter->term_letter->emp_name }},</b></p>
                </div>
                <br>
                <div class="content1" style="line-height:2;font-size:14px">
                    This is further to our letters referred above calling upon you to report for duty
                    immediately or to intimate to us in writing the reason for your unauthorized absence
                    since the
                    <strong>{{ \Carbon\Carbon::parse($termLetter->absent_date)->format('d-m-Y') }}</strong>.
                    Kindly submit all the assets to the company. You have neither resumed duty nor
                    provided any explanation for your continued unauthorized absence. In the
                    circumstances, we are treating your unauthorized absence as voluntary abandonment of
                    service, as communicated to you earlier via our letter dated
                    <strong>{{ \Carbon\Carbon::parse($termLetter->show_cause_date)->format('d-m-Y') }}</strong>.

                    Consequently, as permitted under the terms of your appointment letter, your
                    employment with Fretus Folks India Pvt Ltd shall stand terminated effective from the
                    closing of office hours on
                    <strong>{{ \Carbon\Carbon::parse($termLetter->termination_date)->format('d-m-Y') }}</strong>.
                    Kindly note that as per the terms and conditions of your appointment letter, you
                    were to serve 15 days’ notice or compensate salary in lieu thereof. Please be
                    informed that we are completing your full & final settlement formalities and there
                    are no dues payable to you as per our records, after recovery of the notice period
                    compensation due to the company. The relieving letter and service certificate can be
                    issued only after receipt of (a) your resignation letter along with (b) your
                    supervisor’s formal no-due clearance, within seven days, after which, we regret, we
                    cannot entertain any further queries on this matter.
                </div>
                <br>
                <div class="content" style="line-height:2;font-size:14px">
                    <p>Yours faithfully, </p>
                </div>
                <br>
                <table style="border-collapse:collapse;width:100%;margin-bottom:0px;">
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
            </div>
        </div>
        <br>
    </div>
</html>
