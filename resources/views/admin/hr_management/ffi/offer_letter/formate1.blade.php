<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no">
    <title>Fretus Folks</title>
</head>

<style>
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

    .page-break {
        page-break-after: always;
    }

    body {
        padding: 0 !important;
        margin: 0 !important;
        display: block !important;
        /* background: red; */
        -webkit-text-size-adjust: none;
        font-family: times;
        font-size: 13px;
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
        border: 1px solid black;
        padding: 5px 8px;
    }
</style>
</head>

<body class="body">
    <x-letter-head />
    <div style="color:#000;font-size: 21px;margin-top: 0%;margin-bottom: 5%;padding: 0 10px;">
        <div
            style="color: #000;font-family: Tahoma;font-size: 17px;line-height: 18px;text-align: justify; padding-left: 0%;">
            <div><br>
                <table style="border-collapse:collapse;width:100%;margin-bottom:20px;">
                    <tbody>
                        <tr>
                            <td colspan="3" style="font-size:12px;text-align:left;padding:7px">
                                <p style="line-height:1.8;font-size:14px">
                                    <b>Mr. /Mrs. /Ms. : {{ $offerLetter->employee?->emp_name }}</b> <br>
                                    <b>Employee ID : {{ $offerLetter->employee?->ffi_emp_id }}</b> <br>
                                    <b>Place : {{ $offerLetter->employee?->location }}</b> <br>
                                </p>
                            </td>
                            <td style="font-size:12px;text-align:left;padding:7px;width:30%">
                                <p style="line-height:1.8;font-size:14px">
                                    <b>Date
                                        :{{ \Carbon\Carbon::parse($offerLetter->employee?->joining_date)->format('d-m-Y') }}</b>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div
            style="color: #000;font-family: Tahoma;font-size: 17px;line-height: 15px;text-align: justify; padding-left: 0%;">
            <h1 style="font-size:18px;text-align:center;text-decoration: underline;">Appointment Letter</h1>
            <br>
            <p style="font-size:12px;line-height:1.5;">
                <b>Dear Mr./Mrs./Ms {{ $offerLetter->employee?->emp_name }}</b><br>
                <span style="margin-left:0%;">
                    Further to your interview, we are pleased to inform you that you are hereby
                    appointed as
                    <b>{{ $offerLetter->employee?->designation }}</b> in the
                    <b>{{ $offerLetter->employee?->department }}</b> Department of our company
                    <b>Fretus Folks India Pvt Ltd (FFI)</b>. You are assigned to work at Bangalore as
                    per terms and conditions discussed and agreed upon as under :-
                </span>
            </p>
            <p style="font-size:12px;line-height:1.5;margin-left:3%;margin-top: 1% !important;">
            <ol type="1" style="font-size:12px;line-height:1.5;">
                <li>
                    This appointment is effective from
                    <b>{{ \Carbon\Carbon::parse($offerLetter->employee?->joining_date)->format('d-m-Y') }}</b>
                    the date of your joining our Organization.
                </li>
                <li>Your salary and other allowances shall be as per <b>Annexure-1</b>.</li>
                <li>
                    You will be placed on probation for a period of six months and the said period can
                    be extended by another three months.
                    On the expiry of the period of probation or extended period of probation, if you are
                    not confirmed in writing, your services shall be deemed to be automatically
                    terminated.
                    However, unless you are confirmed in writing, you shall not be deemed to be
                    permanent.
                </li>
                <li>
                    During probation, the notice period for termination/resignation will be 24 hours
                    from either side. After confirmation, the notice period required from either side is
                    one month.
                </li>
                <li>
                    After successful completion of your probation, you will be confirmed in writing as a
                    permanent employee of the Company.
                    You will be entitled to statutory and service benefits and be governed by discipline
                    and other rules existing or may come into existence from time to time, as and when
                    applicable as per rules of the Company and such other benefits as applicable to
                    employees in force from time to time to the location/place wherever you are working.
                    The company depending upon need shall take suitable cover of GPA to take care of
                    liability under Workmen Compensation Act provided you are not covered under ESI
                    Scheme.
                </li>
                <li>
                    Your future increments or promotion or any other salary increase shall be based on
                    merit considering your periodic and consistent overall performance, business
                    conditions, and other parameters fixed from time to time at the discretion of the
                    management and shall not be considered merely as a matter of right.
                </li>
                <li>
                    During the period of service with the company, you shall not indulge and/or take
                    part in any activity of formation of council and/or association or become a member
                    being part of management staff which are found to be detrimental in the interest of
                    the company in any way.
                    Such an action shall be deemed as infringement to service conditions of the company
                    and amount to causing damage to its interest and shall call for disciplinary action
                    being taken against you, as it may deem fit and appropriate.
                </li>
                <li>
                    During the tenure of your services, you will wholly devote yourself to the work
                    assigned to you and will not undertake any other employment either on full or
                    part-time basis without prior permission of the Company in writing.
                    Any contravention of this condition will entail termination of your services from
                    the Company.
                </li>
                <li>
                    <ol type="i">
                        <li>Your services are liable to be transferred or loaned or assigned
                            with/without transfer, wholly or partially, from one department
                            to another or to office/branch and vice-versa or office/branch
                            to another office/branch of an associate company, existing or to
                            come into existence in future or any of the Company’s branch
                            office or locations anywhere in India or abroad or any other
                            concern where this Company has any interest. In such case, you
                            will abide by responsibilities expressly vested or implied or
                            communicated and shall follow rules and regulations of the
                            department/office, establishment, jointly or separately, without
                            any compensation or extra remuneration or provision of
                            accommodation. You, thereupon, may be governed by service
                            conditions and other terms of the said concern as may be
                            applicable.
                        </li>
                        <li>The aforesaid Clause (i) will not give you any right to claim
                            employment in any associate or/sister concern or ask for a
                            common seniority with the employee of sister/associate concern.
                        </li>
                    </ol>
                </li>
                <li>In the event you are absent from duty without information or permission
                    of leave or you overstay your sanctioned leave, the Management will
                    treat you as having voluntarily abandoned the services of the Company.
                </li>
                <li>
                    <ol type="i">
                        <li>During your employment, in case you are found to be medically
                            unfit by the Company’s Authorized Medical practitioner, on
                            examination.</li>
                        <li>As and when the Company comes to know of any conviction by the
                            Court of Law during the tenure of your service with us or
                            conviction and/or any bad record in the past under the previous
                            employer, or because of your giving false information at the
                            time of your appointment or concealed any material information
                            or given any false details in the application form or otherwise
                            as regard age, education qualification, experience, salary etc.
                        </li>
                        <li>If you are found to be not possessing desired qualification
                            which do not conform to custom authority and/govt. regulation as
                            may be required from time to time and necessary for continuation
                            of business or its exigencies or on account of redundancy.</li>
                    </ol>
                </li>
                <li>You will keep the Company informed of any change in your residential
                    address that may happen during the course of employment of your service
                    with the company.
                </li>
                <li>All documents, plans, drawings, prints, trade secrets, technical
                    information, reports, statements, correspondence etc., written or
                    unwritten and also information and instructions that pass through you or
                    come to your knowledge shall be treated as confidential. You shall not
                    utilize them for your own use or disclose to other persons during or
                    after your employment. During the course of employment with the Company,
                    you will acquire, gain, generate, gather and develop knowledge of and be
                    given access to business information about products activities, know
                    how, methods or refinements and business plans and business secrets and
                    other information concerning the products/business of the Company,
                    hereinafter called the “SECRETS”. You will be liable for prosecution for
                    damages for divulgence, sharing or parting any of such information
                    during course of employment and on cessation for at least 2 years
                    period.
                </li>
                <li>You shall carry out the job of
                    <b>{{ $offerLetter->employee?->designation }}</b> and such other jobs
                    connected with or incidental to which is necessary for business of the
                    Company. You shall do any other work assigned to you, which you are
                    capable of doing or work at any other post which has been temporarily
                    assigned to you.
                </li>
                <li>Any balance of advance or loan taken by you from the Company, shall be
                    fully recovered from your salary and any other legal dues including
                    Gratuity, at the time of you’re leaving the services of the Company.
                </li>
                <li>
                    You shall faithfully and to the best of your ability perform your duties
                    that may be entrusted to you from time to time by the management. You
                    will be bound by rules, regulations, and orders promulgated by the
                    management in relation to conduct, discipline, and policy matters. You
                    will not seek membership of any local or public bodies without first
                    obtaining specific permission of the management. In the event of your
                    becoming a member without following due process, it shall amount to
                    contravention of the provisions of the employment condition and the
                    management reserves the right to take appropriate action including
                    dispensing with your services, as it may deem fit. You will not give out
                    to anyone, by word of mouth or otherwise, particulars of our business or
                    administrative or organizational matters of a confidential nature which
                    may be your privilege to know by virtue of your being our employee.
                </li>
                <li>
                    While you are in employment of the company, you may be given or handed
                    over company’s property and/or equipment for official use and you shall
                    take care of them including their upkeep. On cessation of employment
                    with the Company, you shall return all documents, books, papers relating
                    to the affairs of the Company, purchased with the Company’s money, which
                    may have come to you, and also any property of the Company in your
                    possession.
                </li>
                <li>
                    While working as an employee if you enter into any business transaction
                    with any party on behalf of the company within your permissible limits,
                    it shall be your responsibility to ensure recovery of outstanding. If
                    any outstanding remains at the time of leaving the services of the
                    company, it shall be your responsibility to recover for remittance to
                    the company before you proceed to settle your legal dues in full and
                    final settlement of your account.
                </li>
                <li>
                    The company is obliged to deduct Income Tax at source as per provision
                    of Income Tax Act/Rules. Accordingly, you are required to submit all
                    required proof of permitted savings/investments and other details from
                    time to time to enable the company to comply with the provisions of law.
                    In the event of non-compliance by you as aforesaid, if the company is
                    required to pay any interest or payment under the Income Tax Act, it
                    shall deduct the amount as may be paid or payable from your salary or
                    other payments, and you shall allow the company to comply with these
                    requirements without objection.
                </li>
                <li>
                    All disputes arising out of this letter will be subject to the
                    jurisdiction of the Bangalore Court. And that the courts, tribunals,
                    and/or authorities at Bangalore only shall have jurisdiction to
                    entertain, try, and decide such disputes or differences arising out of
                    or pertaining to this contract of employment, irrespective of your
                    working HQ being elsewhere at that time.
                </li>
            </ol>
            </p>
            <div style="color: #000; font-family: Tahoma; font-size: 17px; line-height: 18px; text-align: justify;">
                <p style="font-size:12px; line-height:1.8;">
                    <span>
                        You are requested to return the enclosed copy duly signed as a token of your acceptance of the
                        terms and conditions of your employment.
                    </span><br>
                    <span>
                        Hope that this will be the beginning of a long and successful career with us.
                    </span>
                </p>
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
                            <td style="font-size:12px; text-align:left; padding:7px; width:40%">
                                <p style="line-height:1.8; font-size:14px;">
                                    <b>I accept:</b><br><br><br>
                                    <b>(Signature of an Employee)</b>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div
        style="color: #000;font-family: Tahoma;font-size: 13px;line-height: 1.5;text-align: justify;padding-left: 0%; margin-top:100px;">
        <h1 style="font-size:17px;text-align:center;text-decoration: underline;"> Annexure - 1</h1>
        <center>
            <table class="table table1 annexure_table" border="1"
                style="border-collapse:collapse;width:80%;margin:20px auto;">
                <tbody>
                    <tr>
                        <th style="font-size:12px;text-align:left;padding:7px;border-top: 1px solid #000;">
                            Components</th>
                        <th style="font-size:12px;text-align:left;padding:7px;width:30%;border-top: 1px solid #000;">
                            Monthly salary</th>
                        <th style="font-size:12px;text-align:left;padding:7px;width:30%;border-top: 1px solid #000;">
                            Annual salary</th>
                    </tr>
                    <tr>
                        <td>Basic</td>
                        <td>{{ $offerLetter->basic_salary }}</td>
                        <td>{{ $offerLetter->basic_salary * 12 }}</td>
                    </tr>
                    <tr>
                        <td>HRA</td>
                        <td>{{ $offerLetter->hra }}</td>
                        <td>{{ $offerLetter->hra * 12 }}</td>
                    </tr>
                    <tr>
                        <td>ST Bonous</td>
                        <td>{{ $offerLetter->st_bonus }}</td>
                        <td>{{ $offerLetter->st_bonus * 12 }}</td>
                    </tr>

                    <tr>
                        <td>Special Allowance</td>
                        <td>{{ $offerLetter->special_allowance }}</td>
                        <td>{{ $offerLetter->special_allowance * 12 }}</td>
                    </tr>
                    <tr>
                        <td>Other Allowance</td>
                        <td>{{ $offerLetter->other_allowance }}</td>
                        <td>{{ $offerLetter->other_allowance * 12 }}</td>
                    </tr>
                    <tr class="gross" style="background: #ecbfbf;">
                        <td>Gross Salary</td>
                        <td>{{ $offerLetter->gross_salary }}</td>
                        <td>{{ $offerLetter->gross_salary * 12 }}</td>
                    </tr>
                    <tr>
                        <td>Employee PF @ {{ $offerLetter->pf_percentage }}%</td>
                        <td>{{ $offerLetter->emp_pf }}</td>
                        <td>{{ $offerLetter->emp_pf * 12 }}</td>
                    </tr>
                    <tr>
                        <td>Employee ESIC PF @ {{ $offerLetter->esic_percentage }}%
                        </td>
                        <td>{{ $offerLetter->emp_esic }}</td>
                        <td>{{ $offerLetter->emp_esic * 12 }}</td>
                    </tr>
                    <tr>
                        <td>PT</td>
                        <td>{{ $offerLetter->pt }}</td>
                        <td>{{ $offerLetter->pt * 12 }}</td>
                    </tr>
                    <tr>
                        <td>Total Deduction</td>
                        <td>{{ $offerLetter->total_deduction }}</td>
                        <td>{{ $offerLetter->total_deduction * 12 }}</td>
                    </tr>
                    <tr class="gross" style="background: #ecbfbf;">
                        <td>Take-home</td>
                        <td>{{ $offerLetter->gross_salary - $offerLetter->total_deduction }}
                        </td>
                        <td>{{ ($offerLetter->gross_salary - $offerLetter->total_deduction) * 12 }}
                        </td>
                    </tr>
                    <tr>
                        <td>Employer PF @ {{ $offerLetter->employer_pf_percentage }}%
                        </td>
                        <td>{{ $offerLetter->employer_pf }}</td>
                        <td>{{ $offerLetter->employer_pf * 12 }}</td>
                    </tr>
                    <tr>
                        <td>Employer ESIC PF @
                            {{ $offerLetter->employer_esic_percentage }}%</td>
                        <td>{{ $offerLetter->employer_esic }}</td>
                        <td>{{ $offerLetter->employer_esic * 12 }}</td>
                    </tr>
                    <tr class="gross" style="background: #ecbfbf;">
                        <td>CTC</td>
                        <td>{{ $offerLetter->ctc }}</td>
                        <td>{{ $offerLetter->ctc * 12 }}</td>
                    </tr>
                </tbody>
            </table>
        </center>
    </div>
</body>

</html>
