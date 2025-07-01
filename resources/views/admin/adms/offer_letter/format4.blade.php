<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta content="telephone=no" name="format-detection" />
    <title>Fretus Folks</title>
    <style>
        @page {
            margin: 200px 55px 120px 55px;
            /* top increased to make space for header */
        }

        .cash {
            text-align: right;
        }

        li {
            line-height: 1.5;
        }

        b {
            font-weight: bold;
        }

        header {
            position: fixed;
            top: -200px;
            left: 0;
            right: 0;
            height: 170px;
        }

        footer {
            position: fixed;
            bottom: -60px;
        }

        .table1 td:nth-child(2),
        td:nth-child(3) {
            text-align: right;

        }

        .table1 td,
        .table1 th {
            padding: 3px 3px 3px 3px;
        }

        .table1 td {
            font-size: 12px;
        }
    </style>
</head>

<body>
    <x-letter-head />
    <div style="margin:0px 35">
        <h1 style="font-size:18px;text-align:center;text-decoration:underline;margin-top:20px">Deputation Letter</h1>

        <p style="font-size:12px;line-height:1.5;text-align:justify;">
            Employee Code : <b>{{ $offerLetter->employee_id }}</b> <br />
            Agency : <b>Fretus Folks India Pvt Ltd</b> <br />
            Employee Name : <b>{{ $offerLetter->emp_name }}</b> <br />
            Designation : <b>{{ $offerLetter->designation }}</b> <br />
            Dept : <b>{{ $offerLetter->department }}</b> <br />
            Contact No. : <b>{{ $offerLetter->phone1 }}</b> <br />
            Address : <b>{{ $offerLetter->location }}</b> <br />

        </p>

        <p style="font-size:12px;line-height:1.5;">
            <b>Dear Mr./Mrs./Ms {{ $offerLetter->emp_name }}</b>
        </p>
        <p style="font-size:12px;line-height:1.5;text-align:justify;">
            <span style="">
                We are glad to inform you that you have been deputed to <b>{{ $offerLetter->location }}</b>
                with
                <b>{{ $offerLetter->entity_name }}</b>(herein after referred as ‘Udaan), with effect from
                <b>{{ \Carbon\Carbon::parse($offerLetter->joining_date)->format('d-m-Y') }}</b>.
            </span>
        </p>

        <p style="font-size:12px;line-height:1.5;text-align:justify;">
            <span style="">
                Except as mentioned herein this Deputation Letter, all the other terms and conditions of your
                appointment and any further amendments remain unaltered.
            </span>
        </p>
        <p style="font-size:12px;line-height:1.5;text-align:justify;">
            <span style="">
                During the period of your association with the Client, you will be required to abide by and adhere to
                the policies, rules, and regulations of the Client, including but not limited to, Code of Conduct,
                Discipline, Business Ethics and Contract of employment and any amendments made thereof that may be
                communicated by us or by the Client, from time to time. Such policies, rules and regulations may be
                subject to modification or amendment at the sole discretion of the Client and you shall be bound to
                abide by the same.
            </span>
        </p>

        <p style="font-size:12px;line-height:1.5;text-align:justify;">
            <span style="">
                We take this opportunity to wish you every success in your assignment.

            </span>
        </p>
        <table width="100%" border="0">
            <tbody>
                <tr>
                    <td colspan="3" style="font-size:14px;text-align:left;">
                        <p style="line-height:1.8;">
                            <b>Fretus Folks India Pvt Ltd.</b> <br><br>
                        </p><img src="{{ public_path('admin/images/seal.png') }}" style="" width="100"><br>
                        <p>
                            <b>&nbsp;&nbsp;&nbsp;Authorized Signatory</b> <br>
                        </p>
                    </td>
                    <td style="font-size:14px;text-align:right;">
                        <p style="line-height:1.8;">
                            <br><br><br><br>
                            <b>I accepted
                                :&nbsp;</b><br><br><br><br>
                            <b>(Signature of an Employee) </b> <br>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
        <pagebreak />
        <h1 style="font-size:14px;text-align:center;text-decoration:underline;margin-top:20px">Offer cum Appointment
            Letter</h1>

        <p style="font-size:12px;line-height:1.5;text-align:justify;">
            <span style="">
                Further to your application and subsequent discussion for employment with us, we are pleased to appoint
                you as <b>{{ $offerLetter->designation }}</b>,
                <b>{{ $offerLetter->department }}</b> at <b>{{ $offerLetter->location }}</b>
                effective
                <b>{{ \Carbon\Carbon::parse($offerLetter->joining_date)->format('d-m-Y') }}</b> on the
                following terms & conditions
        </p>

        <ol type="1">

            <li>
                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    <span style="">
                        <b>Posting</b><br /><br />
                        We would like you to depute you to the office of the Client on immediate basis and your initial
                        posting will be at <b>{{ $offerLetter->location }}</b>

                </p>
            </li>
            <li>
                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    <span style="">
                        <b>Probation</b><br /><br />
                        You will be under probation for a period of 3 months from the effective date of your appointment
                        and shall be confirmed based on satisfactory performance during the said period.
                </p>
                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    <span style="">
                        Your probation may be extended for another period of 3 months on sole discretion of the Client.
                        Unless communicated otherwise in writing by the Client, your employment shall stand confirmed on
                        completion of the probation period.
                </p>
                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    <span style="">
                        During the probation period, anyone can terminate the employment agreement by giving 7 days’
                        prior written notice or by paying monthly gross salary in lieu of unnerved notice period.
                </p>
            </li>
            <li>
                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    <span style="">
                        <b>Duty & Working days</b><br /><br />
                        You shall be required to work from Monday to Saturday. Leaves can be taken as per the Company
                        policy.
                </p>
                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    <span style="">
                        You shall devote your time, attention and ability towards Client and shall perform such duties
                        and exercise assigned to you from time to time by the Client. You shall also comply with
                        instructions, directions, and rules as laid by the Client and your reporting manager at work
                        location.
                </p>
                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    <span style="">
                        You are required to be flexible and to undertake all duties associated with your role
                        diligently. You are also expected to undertake reasonable alternative duties in addition to your
                        normal duties that may be associated with your role and as may be assigned to you by the Client,
                        from time to time. The Client’s decision in this regard would stand final and abiding.
                </p>
                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    <span style="">
                        Your Services may be transferred/ deputed either part time or full time to any other client,
                        section, and subsidiary or associated firm by giving you a prior written notice.
                </p>
            </li>
            <li>
                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    <span style="">
                        <b>Compensation</b><br /><br />
                        Details of your salary breakup will be as per the Annexure attached herein. You hereby authorize
                        <b>Fretus Folks India Pvt Ltd</b> to make all salary payments required to be made to you by
                        Fretus Folks India Pvt Ltd including all reimbursements either by way of directly crediting the
                        amounts to your bank account or DD / Cheque.
                </p>
            </li>
            <li>
                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    <span style="">
                        <b>Period of services and Notice period</b><br /><br />
                        During the period of your employment with us for the first three months, your employment shall
                        be terminated by you or by us, after giving seven days’ notice or compensation in lieu thereof.
                        On successful completion of three months’ service your employment shall be terminated by either
                        you or by us, after giving fifteen days’ notice or compensation in lieu thereof.
                </p>
                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    <span style="">
                        Were serves the right to terminate your employment on grounds of performance or misconduct not
                        being up to expected standards without any notice period or pay. Should you be placed on
                        Performance Improvement Plan, hereinafter referred to as “PIP”, the starting date of PIP will
                        serve as the beginning of your notice period. Should you not perform as per the expectation and
                        we decide that your performance during PIP period was not satisfactory we shall terminate your
                        employment without giving any further notice or compensation.
                </p>
                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    <span style="">
                        In case of notice pay recovery, the same will be recovered if you leave the client before
                        completion of the notice period.
                </p>
                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    <span style="">
                        You shall retire on your 60th birthday or the day immediately preceding such date, if your
                        birthday does not fall on a working day.
                </p>
            </li>
            <li>
                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    <span style="">
                        <b>Recovery of Assets</b><br /><br />
                        You shall be provided with an IT Asset or IT login credentials for your allotted work at the
                        Client’s location. Upon termination of your engagement with the Client, you need to return the
                        IT Asset to the Client. In case of any damage to the IT Asset, we shall be entitled to recover
                        the cost of damage or loss of the IT Asset from you or deduct cost of such damaged or lost IT
                        Asset from the full and final settlement amount payable to you. In case the full and final
                        settlement amount falls short of the amount to be recovered, you shall remain solely liable to
                        pay the balance amount pending to be recovered.
                </p>
                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    <span style="">
                        You shall remain solely liable to pay any cash or cash equivalent which may have been handed
                        over to you by the Client at any time during your deputation with the Client or after the
                        termination of your engagement with the Client.
                </p>
            </li>
            <li>
                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    <span style="">
                        <b>Service rules, Discipline and Code of conduct</b><br /><br />
                        During your employment with us, you will not associate yourself with such activities, as in the
                        opinion of theClient or will be harmful or detrimental to the interest of the Client. Your
                        employment may be terminated without notice if you are found to be in violation of any rules,
                        discipline and code of conduct that may be communicated to you by us or by the Client. We
                        further reserve our right to terminate or suspend your employment with us upon being intimated
                        about your violation of any rules, discipline or code of conduct or any other policies
                        applicable in our client’s work location where you have been deputed for work. by the Client.
                        You shall always abide the rules, Code of Conduct and any other regulations related to workplace
                        discipline applicable to the employees of Client where you have been deputed.
                </p>
            </li>
        </ol>
        <pagebreak />

        <ol start="8">
            <li>
                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    <span style="">
                        <b>Background verification and other obligations</b><br /><br />
                        Your engagement with us is contingent upon completion of a background verification, including
                        but not limited to confirmation of prior employment, educational background, criminal history
                        check, to our satisfaction. Client may also conduct your background verification and your
                        deputation with the Client shall be subject to satisfactory completion of your verification
                        check by the Client or any third party that may be engaged by the Company and Client for the
                        said purpose. Notwithstanding any provisions to contrary contained in this Letter, the Company
                        Client reserves the right to terminate You, in the event the background check conducted by
                        Client or any third party engaged by Client for the purposes of background verification, is
                        found not to be satisfactory to the Client is the Company’s & Client's sole discretion.
                </p>

                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    <span style="">
                        You agree and acknowledge that your personal details may be shared by us with the Client and any
                        third party that may engaged by the Client for the purposes of conducting your background
                        verification and you further consent to such disclosure by us in this regard.
                </p>

                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    <span style="">
                        If any time it should emerge that the details provided by you are false / incorrect, or if any
                        material or relevant information has been suppressed or concealed, this appointment will be
                        considered ineffective and would be liable to be terminated immediately without notice.
                </p>

                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    <span style="">
                        If you are at any time found to be guilty of misconduct, commit any breach of this Agreement, or
                        refuse or wilfully neglect to perform to the satisfaction of the Client or any of the associated
                        companies in connection with whose business you may be engaged, the Company client may at once,
                        without any previous notice, terminate your appointment. Unless in case of earlier termination
                        of this appointment due to a plausible cause, During the course of your employment with the
                        client or at any time after termination of your services, you shall comply with all
                        confidentiality obligations imposed by the client and/or the Client and shall in this respect
                        not disclose to any person, firm, the affairs of the Client, their customers or any classified
                        and confidential information.

                </p>

                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    <span style="">
                        Nothing contained herein constitutes a guarantee of employment. Company may amend the provisions
                        of this agreement from time to time, provided that such amendments to the Agreement are in
                        accordance with the applicable law.
                </p>

                <p style="font-size:12px;line-height:1.5;text-align:justify;">
                    <span style="">
                        Please note that upon your acceptance of this offer, this appointment letter shall supersede all
                        prior, oral or written agreements, commitments, understanding or communications either formally
                        or informally, in regard to the subject matter. Any variations of the above terms and conditions
                        will not be valid until expressly made in writing by the client.
                </p>
            </li>
        </ol>
        <table width="100%" border="0">
            <tbody>
                <tr>
                    <td colspan="3" style="font-size:14px;text-align:left;">
                        <p style="line-height:1.8;">
                            <b>For Fretus Folks India Pvt Ltd.</b> <br><br>
                            <b>&nbsp;&nbsp;&nbsp;Authorized Signatory</b> <br>
                        </p><img src="{{ public_path('admin/images/seal.png') }}" style="" width="100"><br>


                    </td>
                </tr>
            </tbody>
        </table>
        <pagebreak />
        <p style="font-size:12px;line-height:1.5;text-align:justify;">
            <span style="">
                <b>DECLERATION</b><br /><br />
                I have been explained/read/understood/the above terms & conditions and agree to abide by
                them.<br /><br /><br />
                Signature of employee<br /><br />
                Name of the employee<br />
                {{ $offerLetter->emp_name }}<br />
                {{ $offerLetter->ffi_emp_id }}

        </p>

        <h1 style="font-size:20px;text-decoration:underline;text-align:center;font-weight:bold">Annexure</h1>

        <table cellpadding="8px" class="table table1" border="1"
            style="border-collapse:collapse; width:80%;font-size: 10px;margin-left:auto;margin-right:auto;">
            <tbody>
                <tr>
                    <th style="font-size:12px;text-align:left;padding:7px;border-top: 1px solid #000;">
                        Particulars
                    </th>
                    <th style="font-size:12px;text-align:left;padding:7px;width:30%;border-top: 1px solid #000;">
                        Monthly (INR)
                    </th>
                    <th style="font-size:12px;text-align:left;padding:7px;width:30%;border-top: 1px solid #000;">
                        Annual (INR)
                    </th>
                </tr>
                <tr>
                    <td>Basic + DA </td>
                    <td>{{ $offerLetter->basic_salary }}</td>
                    <td>{{ $offerLetter->basic_salary * 12 }}</td>
                </tr>
                <tr>
                    <td>HRA</td>
                    <td>{{ $offerLetter->hra }}</td>
                    <td>{{ $offerLetter->hra * 12 }}</td>
                </tr>
                <tr>
                    <td>Special Allowance</td>
                    <td>{{ $offerLetter->special_allowance }}</td>
                    <td>{{ $offerLetter->special_allowance * 12 }}</td>
                </tr>
                <tr>
                    <td>Statutory Bonus</td>
                    <td>{{ $offerLetter->st_bonus }}</td>
                    <td>{{ $offerLetter->st_bonus * 12 }}</td>
                </tr>
                <tr class="gross" style="background: #ecbfbf;">
                    <td>Gross Salary</td>
                    <td>{{ $offerLetter->gross_salary }}</td>
                    <td>{{ $offerLetter->gross_salary * 12 }}</td>
                </tr>
                <tr>
                    <td>Employer PF</td>
                    <td>{{ $offerLetter->employer_pf }}</td>
                    <td>{{ $offerLetter->employer_pf * 12 }}</td>
                </tr>
                <tr>
                    <td>Employer ESIC</td>
                    <td>{{ $offerLetter->employer_esic }}</td>
                    <td>{{ $offerLetter->employer_esic * 12 }}</td>
                </tr>
                <tr class="gross" style="background: #ecbfbf;">
                    <td>Cost to Client</td>
                    <td>{{ $offerLetter->ctc }}</td>
                    <td>{{ $offerLetter->ctc * 12 }}</td>
                </tr>
                <tr class="gross" style="background: #ecbfbf;">
                    <td colspan="3">Deduction</td>
                </tr>
                <tr>
                    <td>Employee PF</td>
                    <td>{{ $offerLetter->emp_pf }}</td>
                    <td>{{ $offerLetter->emp_pf * 12 }}</td>
                </tr>
                <tr>
                    <td>Employee ESIC</td>
                    <td>{{ $offerLetter->emp_esic }}</td>
                    <td>{{ $offerLetter->emp_esic * 12 }}</td>
                </tr>
                <tr class="gross" style="background: #ecbfbf;">
                    <td>Take-home</td>
                    <td>{{ $offerLetter->take_home }}</td>
                    <td>{{ $offerLetter->take_home * 12 }}</td>
                </tr>
            </tbody>
        </table><br>
        <p style="font-size:10px;line-height:1.5;text-align:justify;">
            <span style="">
                <b><u>Note:</u></b><br />
                <ul>
                    <li style="font-size:12px;">Profession tax and LWF will be deducted as per the statutory laws
                        prevailing at the location of work.</li>
                    <li style="font-size:12px;">Employers contribution to Provident Fund (maximum 12% on 1,80,000/- of
                        Basic Salary per annum).</li>
                    <li style="font-size:12px;">Income tax liability arising out of these allowances, perquisites and
                        reimbursements will be borne by the employees.
                    </li>
                    <li style="font-size:12px;">Gratuity is at 4.81% of your basic salary and its payable on
                        separation, subject to completion of 4 years and eight months of service in the client location
                        with the prevailing acts.</li>
                    <li style="font-size:10px;">Medical insurance, Group Personal Accidental, ESIC will be applicable
                        as per eligibility.</li>
                    <li style="font-size:12px;">Incentives, Travel & Daily allowance and reimbursements will be
                        applicable as per role and schemes prevailing from time to time as per policy.
                    </li>
                </ul>
        </p>
    </div>
</body>

</html>
