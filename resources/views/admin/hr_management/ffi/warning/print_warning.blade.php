<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fretus Folks</title>
    <style type="text/css" media="screen">
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

        @media print {
            body {
                padding: 0 !important;
                margin: 0 !important;
                display: block !important;
                background: #ffffff;
                -webkit-text-size-adjust: none;
                font-family: times;
            }

            .gross td {
                background: #ecbfbf !important;
            }
        }
    </style>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>

<body  class="body"
    style="padding:0 !important; margin:0 !important; display:block !important; background:#ffffff; -webkit-text-size-adjust:none">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td style="padding-left: 5%; padding-right: 5%;">
                    <img src="{{ asset('admin/images/ffi_header.jpg') }}">
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
                                                style="font-size: 12px; text-align: left; padding: 0px; width: 80%">
                                                <p style="line-height: 1.8; font-size: 14px"><b>Date:
                                                        {{ \Carbon\Carbon::parse($warningLetter->date)->format('d-m-Y') }}</b>
                                                </p>
                                                <br>
                                                <p style="line-height: 1.8; font-size: 14px">
                                                    <b>To, <br>Mr./Mrs./Ms. {{ $warningLetter->warning_letter->emp_name }}</b>
                                                    <br>{{ $warningLetter->emp_id }}
                                                    <br>{{ $warningLetter->warning_letter->location }}
                                                    <br>
                                                </p>
                                            </td>
                                            <td style="font-size: 12px; text-align: left; padding: 0px;"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <div class="content" style="line-height: 2; font-size: 14px">
                                    <p style="line-height: 1.8; font-size: 14px"><b>Sub: Warning Letter</b></p>
                                </div>
                                <br>
                                <div class="content" style="line-height: 2; font-size: 14px">
                                    <p style="line-height: 1.8; font-size: 14px"><b>Dear  {{ $warningLetter->warning_letter->emp_name }},</b>
                                    </p>
                                </div>
                                <br>
                                <div class="content1" style="line-height: 2; font-size: 14px">
                                    {{ $warningLetter->content }}
                                    You, being an employee of Fretus Folks India Pvt Ltd, bearing employee no.
                                    <b>{{ $warningLetter->emp_id }}</b> Appointed on
                                    <b>{{ \Carbon\Carbon::parse($warningLetter->warning_letter->joining_date)->format('d-m-Y') }}</b> and we have been
                                    deputed with Client Place as <b>{{ $warningLetter->warning_letter->designation }}</b>.

                                    It has been found against you that you are not following standard disciplinary
                                    measures and <b>{{ $warningLetter->content }}</b>. This gross misconduct and a major
                                    misdemeanor on your part, which is detrimental to the Client’s business and
                                    reputation in the market. Your act is absolutely unethical and gross violation to
                                    our as well as Client’s business code of conduct. Such act of yours warrants a
                                    strong disciplinary action including termination of your deputation.
                                    Thus, in the light of aforesaid circumstances, you are advised to submit a written
                                    explanation within 48 hours of receipt of this letter as to why a disciplinary
                                    action should not be taken against you. Kindly treat this letter as also a warning
                                    against such acts of misconduct in the future, whereby your services with the
                                    company would become liable to be terminated.
                                </div>
                                <br>
                                <div class="content" style="line-height: 2; font-size: 14px">
                                    <p>Yours faithfully,</p>
                                </div>
                                <table style="border-collapse: collapse; width: 100%; margin-bottom: 20px;">
                                    <tbody>
                                        <tr>
                                            <td colspan="3" style="font-size: 12px; text-align: left; padding: 7px">
                                                <p style="line-height: 1.8; font-size: 14px">
                                                    <br>
                                                    <b>For: Fretus Folks India Pvt Ltd.</b>
                                                    <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img
                                                        src="{{ asset('admin/images/seal.jpg') }}" width="100"
                                                        alt="Seal"><br>
                                                    <b>&nbsp;&nbsp;&nbsp;Authorized Signatory</b>
                                                    <br>
                                                </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <img class="abc" src="{{ asset('admin/images/ffi_fotter.jpg') }}" alt="Footer">
</body>

</html>
