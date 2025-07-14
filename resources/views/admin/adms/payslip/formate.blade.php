<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta content="telephone=no" name="format-detection">

    <title> Payslip - {{ $payslip['emp_name'] ?? '' }} - {{ $payslip['emp_id'] ?? '' }}
        - {{ isset($payslip['month']) ? \Carbon\Carbon::create()->month((int) $payslip['month'])->format('F') : '' }}
        - {{ $payslip['year'] ?? '' }}
    </title>

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">


    <style>
        /* General Styling */
        body,
        p,
        ul,
        ol,
        li,
        h4,
        table,
        th,
        td {
            font-family: 'Open Sans', sans-serif;
        }

        p {
            font-size: 10px !important;
            margin-bottom: 1%;
            text-align: justify;
            line-height: 1.7;
        }

        ul,
        ol {
            font-size: 16px !important;
            margin-bottom: 1%;
            text-align: justify;
        }

        li {
            margin-bottom: 1%;
            text-align: justify;
        }

        h4 {
            padding-top: 1%;
            text-decoration: underline;
            font-weight: bold;
        }

        /* Table Styling */
        table {
            width: 100%;
            border: 2px solid #333;
            border-collapse: collapse;
            font-size: 10px !important;
        }

        th,
        td {
            padding: 3px;
            border-right: 2px solid #333;
            text-align: left;
            font-size: 8px !important;
        }

        th {
            color: #333;
            font-weight: bold;
            border-bottom: 2px solid #333;
        }

        /* Print Styling */
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
            }

            .text2 a {
                color: #ea4261;
                text-decoration: none;
            }

            p,
            ol {
                padding: 0 !important;
                margin: 0 !important;
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
                margin: 0;
            }

            .container {
                margin-left: 2%;
                margin-right: 2%;
            }

            .payslip-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                border: 2px solid #333;
                padding: 10px;
            }

            .payslip-header .logo img {
                width: 200px;
            }

            .payslip-header .title h5 {
                margin: 0;
                font-size: 14px;
            }

        }
    </style>
</head>

<body>
    <section class="about-company-area" id="store" style="    margin-top: 4%;padding-bottom:6%;">

        <div class="container">
            <div class="row">
                <div class="col-md-12" style="border:2px solid #333; padding: 10px;">
                    <div class="payslip-header">
                        <div class="logo">
                            <img src="{{ public_path('admin/images/main_logo.png') }}" alt="Logo" />
                            <h5 style="float:right;">Payslip -
                                {{ isset($payslip['month']) ? \Carbon\Carbon::create()->month((int) $payslip['month'])->format('F') : '' }}
                                -
                                {{ $payslip['year'] ?? '' }}
                            </h5>

                        </div>
                        <div class="title">
                        </div>
                    </div>
                </div>

                <div class="col-md-12" style="border-left:2px solid #333;border-right:2px solid #333;">
                    <p style="text-align:center;margin: 0px 0;">VBC Tower, #39, 1st Floor, CMH Road, Indiranagar,
                        Bangalore-560038. Ph- 080-43726370</p>
                </div>
                <div class="col-md-12" style="border-left:2px solid #333;border-right:2px solid #333;">
                    <p style="text-align:center;margin: 0px 0;">FORM XIX</p>
                </div>
                <div class="col-md-12" style="border-left:2px solid #333;border-right:2px solid #333;">
                    <p style="text-align:center;margin: 0px 0;">[See Rule 78(1)(b)]</p>
                </div>

                <table>
                    <tbody>
                        <tr>
                            <td style="width: 50%;">Employee Name : {{ $payslip['emp_name'] ?? '' }}</td>
                            <td>Client Name : {{ $payslip['client_name'] ?? 0 }} </td>
                        </tr>
                        <tr>
                            <td>FFI Emp. ID : {{ $payslip['emp_id'] ?? 0 }}</td>
                            <td>UAN No. : {{ $payslip['uan_no'] ?? 0 }} </td>
                        </tr>
                        <tr>
                            <td>Client Emp ID. : {{ $payslip['client_emp_id'] ?? 0 }}</td>
                            <td>PF No : {{ empty($payslip['pf_no']) ? 0 : $payslip['pf_no'] }}</td>
                        </tr>
                        <tr>
                            <td>Designation : {{ $payslip['designation'] ?? 0 }} </td>
                            <td>ESI No. : {{ empty($payslip['esi_no']) ? 0 : $payslip['esi_no'] }}</td>
                        </tr>
                        <tr>
                            <td>
                                Date of Joining :
                                {{ isset($payslip['doj']) ? \Carbon\Carbon::parse($payslip['doj'])->format('d-m-Y') : '' }}
                            </td>
                            <td>Bank Name: {{ $payslip['bank_name'] ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td>Department : {{ $payslip['department'] ?? 0 }}</td>
                            <td>Account No. : {{ $payslip['account_no'] ?? 0 }} </td>
                        </tr>
                        <tr>
                            <td>Location : {{ $payslip['location'] ?? 0 }}</td>
                            <td>IFSC Code : {{ $payslip['ifsc_code'] ?? 0 }}</td>
                        </tr>
                    </tbody>
                </table>

                <table style="margin-top: 3px;">
                    <tbody>
                        <tr>
                            <td style="width: 38%;">Month Days:
                                {{ empty($payslip['month_days']) ? 0 : $payslip['month_days'] }}</td>
                            <td>Leave Taken: {{ empty($payslip['leave_days']) ? 0 : $payslip['leave_days'] }}</td>
                            <td>Arrears Days: {{ empty($payslip['arrears_days']) ? 0 : $payslip['arrears_days'] }}
                            </td>
                            <td>Leave Balance : {{ empty($payslip['leave_balance']) ? 0 : $payslip['leave_balance'] }}
                            </td>
                        </tr>
                        <tr>
                            <td>Payable Days: {{ empty($payslip['payable_days']) ? 0 : $payslip['payable_days'] }}</td>
                            <td>LOP Days: {{ empty($payslip['lop_days']) ? 0 : $payslip['lop_days'] }} </td>
                            <td>OT Hours: {{ empty($payslip['ot_hours']) ? 0 : $payslip['ot_hours'] }} </td>
                            <td></td>
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
                            <td>{{ $payslip['fixed_basic_da'] ?? 0 }}</td>
                            <td>{{ $payslip['earn_basic'] ?? 0 }}</td>
                            <td>EPF</td>
                            <td>{{ $payslip['epf'] ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td>HRA</td>
                            <td>{{ empty($payslip['fixed_hra']) ? 0 : $payslip['fixed_hra'] }}</td>
                            <td>{{ empty($payslip['earn_hr']) ? 0 : $payslip['earn_hr'] }}</td>
                            <td>ESIC</td>
                            <td>{{ empty($payslip['esic']) ? 0 : $payslip['esic'] }}</td>
                        </tr>
                        <tr>
                            <td>Conveyance Allowance</td>
                            <td>{{ empty($payslip['fixed_conveyance']) ? 0 : $payslip['fixed_conveyance'] }}</td>
                            <td>{{ empty($payslip['earn_conveyance']) ? 0 : $payslip['earn_conveyance'] }}</td>
                            <td>PT</td>
                            <td>{{ empty($payslip['pt']) ? 0 : $payslip['pt'] }}</td>
                        </tr>
                        {{-- <tr>
                            <td>Education Allowance</td>
                            <td>{{ empty($payslip['fix_education_allowance']) ? 0 : $payslip['fix_education_allowance'] }}
                            </td>
                            <td>{{ empty($payslip['earn_education_allowance']) ? 0 : $payslip['earn_education_allowance'] }}
                            </td>
                            <td>IT</td>
                            <td>{{ empty($payslip['it']) ? 0 : $payslip['it'] }}</td>

                        </tr> --}}
                        {{-- <tr>
                            <td>Medical Reimbursement</td>
                            <td>{{ empty($payslip['fixed_medical_reimbursement']) ? 0 : $payslip['fixed_medical_reimbursement'] }}
                            </td>
                            <td>{{ empty($payslip['earn_medical_allowance']) ? 0 : $payslip['earn_medical_allowance'] }}
                            </td>
                            <td>LWF</td>
                            <td>{{ empty($payslip['lwf']) ? 0 : $payslip['lwf'] }}</td>
                        </tr> --}}
                        <tr>
                            <td>Special Allowance</td>
                            <td>{{ empty($payslip['fixed_special_allowance']) ? 0 : $payslip['fixed_special_allowance'] }}
                            </td>
                            <td>{{ empty($payslip['earn_special_allowance']) ? 0 : $payslip['earn_special_allowance'] }}
                            </td>
                            <td>IT</td>
                            <td>{{ empty($payslip['it']) ? 0 : $payslip['it'] }}</td>
                            {{-- <td>Salary Advance</td>
                            <td>{{ empty($payslip['salary_advance']) ? 0 : $payslip['salary_advance'] }}</td> --}}
                        </tr>
                        <tr>
                            <td>Other Allowance</td>
                            <td>{{ empty($payslip['fixed_other_allowance']) ? 0 : $payslip['fixed_other_allowance'] }}
                            </td>
                            <td>{{ empty($payslip['earn_other_allowance']) ? 0 : $payslip['earn_other_allowance'] }}
                            </td>
                            <td>LWF</td>
                            <td>{{ empty($payslip['lwf']) ? 0 : $payslip['lwf'] }}</td>
                            {{-- <td>Other Deduction</td>
                            <td>{{ empty($payslip['other_deduction']) ? 0 : $payslip['other_deduction'] }}</td> --}}
                        </tr>
                        <tr>
                            <td>St. Bonus</td>
                            <td>{{ empty($payslip['fixed_st_bonus']) ? 0 : $payslip['fixed_st_bonus'] }}</td>
                            <td>{{ empty($payslip['earn_st_bonus']) ? 0 : $payslip['earn_st_bonus'] }}</td>
                            <td>Salary Advance</td>
                            <td>{{ empty($payslip['salary_advance']) ? 0 : $payslip['salary_advance'] }}</td>
                            {{-- <td></td>
                            <td></td> --}}
                        </tr>
                        <tr>
                            <td>Leave Wages</td>
                            <td>{{ empty($payslip['fix_leave_wages']) ? 0 : $payslip['fix_leave_wages'] }}</td>
                            <td>{{ empty($payslip['earn_leave_wages']) ? 0 : $payslip['earn_leave_wages'] }}</td>
                            <td>Other Deduction</td>
                            <td>{{ empty($payslip['other_deduction']) ? 0 : $payslip['other_deduction'] }}</td>
                            {{-- <td></td>
                            <td></td> --}}
                        </tr>
                        <tr>
                            <td>Holiday Wages</td>
                            <td>{{ empty($payslip['fixed_holiday_wages']) ? 0 : $payslip['fixed_holiday_wages'] }}</td>
                            <td>{{ empty($payslip['earn_holiday_wages']) ? 0 : $payslip['earn_holiday_wages'] }}</td>
                            <td>Notice Period Deduction</td>
                            <td>{{ empty($payslip['notice_period_deducation']) ? 0 : $payslip['notice_period_deducation'] }}
                            </td>
                            {{-- <td></td>
                            <td></td> --}}
                        </tr>
                        <tr>
                            <td>Attendance Bonus</td>
                            <td>{{ empty($payslip['fixed_attendance_bonus']) ? 0 : $payslip['fixed_attendance_bonus'] }}
                            </td>
                            <td>{{ empty($payslip['earn_attendance_bonus']) ? 0 : $payslip['earn_attendance_bonus'] }}
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>OT Wage</td>
                            <td>{{ empty($payslip['fixed_ot_wages']) ? 0 : $payslip['fixed_ot_wages'] }}</td>
                            <td>{{ empty($payslip['earn_ot_wages']) ? 0 : $payslip['earn_ot_wages'] }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Incentive</td>
                            <td>{{ empty($payslip['fix_incentive_wages']) ? 0 : $payslip['fix_incentive_wages'] }}</td>
                            <td>{{ empty($payslip['earn_incentive_wages']) ? 0 : $payslip['earn_incentive_wages'] }}
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Arrear Wages</td>
                            <td>{{ empty($payslip['fix_arrear_wages']) ? 0 : $payslip['fix_arrear_wages'] }}</td>
                            <td>{{ empty($payslip['earn_arrear_wages']) ? 0 : $payslip['earn_arrear_wages'] }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Other Wages</td>
                            <td>{{ empty($payslip['fixed_other_wages']) ? 0 : $payslip['fixed_other_wages'] }}</td>
                            <td>{{ empty($payslip['earn_other_wages']) ? 0 : $payslip['earn_other_wages'] }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="border-top: 2px solid;">
                            <th style="width: 20%;">Total Gross</th>
                            <th style="width: 134px;">{{ $payslip['fixed_total_earnings'] ?? 0 }}</th>
                            <th style="width: 151px;">{{ $payslip['earn_total_gross'] ?? 0 }}</th>
                            <th>Total Deduction</th>
                            <th style="width: 13%;">{{ $payslip['total_deduction'] ?? 0 }}</th>
                        </tr>
                    </tbody>
                </table>

                <table style="margin-top: 3px;">
                    <tbody>
                        <tr>
                            <td style="border-right:none; font-weight: bold;">Net Salary:</td>
                            <td colspan="6" style=" font-weight: bold;">{{ $payslip['net_salary'] ?? 0 }}</td>
                        </tr>
                        <tr style="border-top: 2px solid;">
                            <td style="border-right:none; font-weight: bold;">In Words:</td>
                            <td colspan="6" style=" font-weight: bold;">{{ $payslip['in_words'] ?? 0 }}</td>
                        </tr>
                    </tbody>
                </table>

                <p class="text-center" style="margin-top: 20px;">
                    This is a computer-generated payslip signatory not required.
                </p>
            </div>
        </div>
    </section>

</body>

</html>
