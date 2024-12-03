<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no">
    <title>Pay Slip</title>

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

    <style>
        p {
            font-size: 10px !important;
            margin-bottom: 1%;
            text-align: justify;
            line-height: 1.7;
            font-family: 'Open Sans', sans-serif;
        }

        ol,
        ul {
            font-size: 16px !important;
            margin-bottom: 1%;
            text-align: justify;
            font-family: 'Open Sans', sans-serif;
        }

        li {
            margin-bottom: 1%;
            text-align: justify;
            font-family: 'Open Sans', sans-serif;
        }

        h4 {
            padding-top: 1%;
            font-family: 'Open Sans', sans-serif;
            text-decoration: underline;
            font-weight: bold;
        }

        /* Styling for table */
        table {
            width: 100%;
            border: 2px solid #333;
            border-collapse: collapse;
            font-family: 'Open Sans', sans-serif;
            font-size: 10px !important;
        }

        th {
            color: #333;
            font-weight: bold;
            border-bottom: 2px solid #333;
            font-family: 'Open Sans', sans-serif;
            font-size: 10px !important;
        }

        td,
        th {
            padding: 3px;
            border-right: 2px solid #333;
            font-family: 'Open Sans', sans-serif;
            text-align: left;
            font-size: 8px !important;
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
                line-height: 1.7;
            }

            .table1 td,
            .table1 th {
                padding: 7px;
                border: 1px solid black;
            }

            .gross td {
                background: #ecbfbf !important;
            }

            @page {
                margin-top: 0;
                margin-bottom: 0;
                margin-left: 0;
                margin-right: 0;
            }

            .container {
                margin-left: 2%;
                margin-right: 2%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="border:2px solid #333;">
                <div class="col-md-12" style="margin-left:40px;">
                    <img src="/public/admin/images/logo.png" width="200" style="padding: 3px;margin-left: -3%;" />
                    <span>
                        <h4 style="float:right;text-decoration:none;font-size:12px">Payslip
                            {{ substr(date('F', mktime(0, 0, 0, $payslip->month, 3)), 0, 3) . ' - ' . $payslip->year }}
                        </h4>
                    </span>/
                </div>
                <div class="col-md-6">
                </div>
            </div>
            <div class="col-md-12" style="border-left:2px solid #333;border-right:2px solid #333;">
                <p style="text-align:center;margin: 0px 0;">M-20, 3rd Floor, UKS Heights, 10th Main, Jeevanbhima Nagar,
                    Bangalore-560075. Ph- 080 -43726370</p>
            </div>
            <div class="col-md-12" style="border-left:2px solid #333;border-right:2px solid #333;">
                <p style="text-align:center;margin: 0px 0;">FORM XIX</p>
            </div>
            <div class="col-md-12" style="border-left:2px solid #333;border-right:2px solid #333;">
                <p style="text-align:center;margin: 0px 0;">[See Rule 78(1)(b)]</p>
            </div>

            <table>
                <thead>
                </thead>
                <tbody>
                    <tr>
                        <td style="width: 50%;">Employee Name: {{ $payslip->employee_name }}</td>
                        <td>UAN No.:{{ $payslip->uan_no ?? 0 }} </td>
                    </tr>
                    <tr>
                        <td>Emp. ID: {{ $payslip->emp_id ?? 0 }}</td>
                        <td>PF No: {{ $payslip->pf_no ?? 0 }}</td>
                    </tr>
                    <tr>
                        <td>Designation:{{ $payslip->designation ?? 0 }} </td>
                        <td>ESI No.: {{ $payslip->esi_no ?? 0 }}</td>
                    </tr>
                    <tr>
                        <td>
                            Date of Joining:
                            @if ($payslip->date_of_joining != '0000-00-00')
                                {{ date('d-m-Y', strtotime($payslip->date_of_joining)) ?? 0 }}
                            @endif
                        </td>
                        <td>Bank Name: {{ $payslip->bank_name ?? 0 }}</td>
                    </tr>
                    <tr>
                        <td>Department: {{ $payslip->department ?? 0 }}</td>
                        <td>Account No.:{{ $payslip->account_no ?? 0 }} </td>
                    </tr>
                    <tr>
                        <td>Location: Bangalore</td>
                        <td>IFSC Code: {{ $payslip->ifsc_code ?? 0 }}</td>
                    </tr>
                </tbody>
            </table>

            <table style="margin-top: 3px;">
                <tbody>
                    <tr>
                        <td style="width: 38%;">Month Days: {{ $payslip->month_days ?? 0 }}</td>
                        <td>Leave Days: {{ $payslip->leave_days ?? 0 }}</td>
                        <td>Arrears Days:{{ $payslip->arrear_days ?? 0 }} </td>
                    </tr>
                    <tr>
                        <td>Payable Days: {{ $payslip->pay_days ?? 0 }}</td>
                        <td>LOP Days:{{ $payslip->lop_days ?? 0 }} </td>
                        <td>OT Hours:{{ $payslip->ot_hours ?? 0 }} </td>
                    </tr>
                </tbody>
            </table>

            <table style="margin-top: 3px;">
                <thead>
                    <tr>
                        <th style="width: 20%;">Particulars</th>
                        <th>Fixed Wages</th>
                        <th>Earned Wages</th>
                        <th>Particulars</th>
                        <th style="width: 13%;">Deductions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Basic + DA</td>
                        <td>{{ $payslip->fixed_basic ?? 0 }}</td>
                        <td>{{ $payslip->earned_basic ?? 0 }}</td>
                        <td>EPF</td>
                        <td>{{ $payslip->epf ?? 0 }}</td>
                    </tr>
                    <tr>
                        <td>HRA</td>
                        <td>{{ $payslip->fixed_hra ?? 0 }}</td>
                        <td>{{ $payslip->earned_hra ?? 0 }}</td>
                        <td>ESIC</td>
                        <td>{{ $payslip->esic ?? 0 }}</td>
                    </tr>
                    <tr>
                        <td>Conveyance Allowance</td>
                        <td>{{ $payslip->fixed_con_allow ?? 0 }}</td>
                        <td>{{ $payslip->earned_con_allow ?? 0 }}</td>
                        <td>PT</td>
                        <td>{{ $payslip->pt ?? 0 }}</td>
                    </tr>
                    <tr>
                        <td>Education Allowance</td>
                        <td>{{ $payslip->fixed_edu_allowance ?? 0 }}</td>
                        <td>{{ $payslip->earned_education_allowance ?? 0 }}</td>
                        <td>IT</td>
                        <td>{{ $payslip->it ?? 0 }}</td>

                    </tr>
                    <tr>
                        <td>Medical Reimbursement</td>
                        <td>{{ $payslip->fixed_med_reim ?? 0 }}</td>
                        <td>{{ $payslip->earned_med_reim ?? 0 }}</td>
                        <td>LWF</td>
                        <td>{{ $payslip->lwf ?? 0 }}</td>
                    </tr>
                    <tr>
                        <td>Special Allowance</td>
                        <td>{{ $payslip->fixed_spec_allow ?? 0 }}</td>
                        <td>{{ $payslip->earned_spec_allow ?? 0 }}</td>
                        <td>Salary Advance</td>
                        <td>{{ $payslip->salary_advance ?? 0 }}</td>
                    </tr>
                    <tr>
                        <td>Other Allowance</td>
                        <td>{{ $payslip->fixed_oth_allow ?? 0 }}</td>
                        <td>{{ $payslip->earned_oth_allow ?? 0 }}</td>
                        <td>Other Deduction</td>
                        <td>{{ $payslip->other_deduction ?? 0 }}</td>
                    </tr>
                    <tr>
                        <td>St. Bonus</td>
                        <td>{{ $payslip->fixed_st_bonus ?? 0 }}</td>
                        <td>{{ $payslip->earned_st_bonus ?? 0 }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Leave Wages</td>
                        <td>{{ $payslip->fixed_leave_wages ?? 0 }}</td>
                        <td>{{ $payslip->earned_leave_wages ?? 0 }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Holiday Wages</td>
                        <td>{{ $payslip->fixed_holidays_wages ?? 0 }}</td>
                        <td>{{ $payslip->earned_holiday_wages ?? 0 }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Attendance Bonus</td>
                        <td>{{ $payslip->fixed_attendance_bonus ?? 0 }}</td>
                        <td>{{ $payslip->earned_attendance_bonus ?? 0 }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>OT Wage</td>
                        <td>{{ $payslip->fixed_ot_wages ?? 0 }}</td>
                        <td>{{ $payslip->earned_ot_wages ?? 0 }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Incentive</td>
                        <td>{{ $payslip->fixed_incentive ?? 0 }}</td>
                        <td>{{ $payslip->earned_incentive ?? 0 }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Arrear Wages</td>
                        <td>{{ $payslip->fixed_arrear_wages ?? 0 }}</td>
                        <td>{{ $payslip->earned_arrear_wages ?? 0 }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Other Wages</td>
                        <td>{{ $payslip->fixed_other_wages ?? 0 }}</td>
                        <td>{{ $payslip->earned_other_wages ?? 0 }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="border-top: 2px solid;">
                        <th style="width: 20%;">Total Gross</th>
                        <th style="width: 134px;">{{ $payslip->fixed_gross ?? 0 }}</th>
                        <th style="width: 151px;">{{ $payslip->earned_gross ?? 0 }}</th>
                        <th>Total Deduction</th>
                        <th style="width: 13%;">{{ $payslip->total_deductions ?? 0 }}</th>
                    </tr>
                </tbody>
            </table>

            <table style="margin-top: 3px;">
                <tbody>
                    <tr>
                        <td class="bold" style="border-right:none;">Net Salary:</td>
                        <td colspan="6" class="bold">{{ $payslip->net_salary ?? 0 }}</td>
                    </tr>
                    <tr style="border-top: 2px solid;">
                        <td class="bold" style="border-right:none;">In Words:</td>
                        <td colspan="6" class="bold">{{ $payslip->in_words ?? 0 }}</td>
                    </tr>
                </tbody>
            </table>

            <p class="text-center" style="margin-top: 20px;">
                This is a computer-generated payslip; signatory not required.
            </p>
        </div>
        </section>

</body>

</html>
