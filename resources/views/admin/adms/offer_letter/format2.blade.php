<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta content="telephone=no" name="format-detection" />
    <title>Fretus Folks</title>
    <style>
        @page {
            margin: 200px 55px 120px 55px;
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

        .table1 {
            border-collapse: collapse;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
            font-size: 12px;
        }

        .table1 th,
        .table1 td {
            padding: 8px;
            border: 1px solid #000;
        }

        .table1 td:first-child {
            text-align: left;
        }

        .table1 td:nth-child(2),
        .table1 td:nth-child(3),
        .table1 th:nth-child(2),
        .table1 th:nth-child(3) {
            text-align: right;
        }

        h1 {
            font-size: 15px;
            text-align: center;
            text-decoration: underline;
            margin-bottom: 15px;
        }

        p,
        li {
            font-size: 12px;
            line-height: 1.5;
            text-align: justify;
        }

        .signature-table td {
            vertical-align: top;
            padding: 10px;
        }

        .seal {
            width: 100px;
            margin-top: 10px;
        }

        .header-row {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .header-row .left,
        .header-row .right {
            font-size: 14px;
        }
    </style>
</head>

<body>
    <x-letter-head />
    <div style="margin:0 35px">
        <table style="border-collapse:collapse;width:100%;margin-bottom:20px;">
            <tbody>
                <tr>
                    <td colspan="3" style="font-size:12px;text-align:left;padding:7px">
                        <p style="line-height:1.8;font-size:14px !important;">
                            <b>Offer No :</b> {{ $offerLetter->employee_id }} <br>
                        </p>

                    </td>
                    <td style="font-size:12px;text-align:right;padding:7px;width:30%">
                        <p style="line-height:1.8;font-size:14px">
                            <b>Date :</b>
                            {{ \Carbon\Carbon::parse($offerLetter->joining_date)->format('d-m-Y') }}
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <h4 style="text-align: center;text-decoration: underline;margin-bottom:30px;">Offer cum Appointment Letter</h4>
    <div style="margin:0 35px">
        <p style="line-height:1.8;font-size:13px;">
            <span><b>To,</b></span> <br>
            <span><b>/Mrs. /Ms. : {{ $offerLetter->emp_name }}</b></span> <br>
            <span> <b>
                    {{ $offerLetter->employee->gender == 'Male' ? 'S/o' : 'D/o' }}
                    {{ $offerLetter->father_name }}
                </b> </span><br>
            <span><b>Location : {{ $offerLetter->location }}</b></span> <br>
        </p>

        <p style="font-size:12px;line-height:1.8;">
            <span style="margin-left:0%;">
                We are pleased to offer you employment at <b>Fretus Folks India Pvt Ltd.</b> for a fixed period of
                employment as per the following terms:
            </span>
        </p>

        <p style="font-size:12px;line-height:1.8;">
            <span style="margin-left:0%;">
                <b style="text-decoration: underline;"> DEPUTATION: </b> You are deputed to
                <b> {{ $offerLetter->entity_name }}</b> under this contract. The terms of employment is
                exclusively with <b>Fretus Folks India Pvt Ltd.</b> which are summarised as under.
            </span>
        </p>

        <p style="font-size:12px;line-height:1.8;">
            <span style="margin-left:0%;">
                You will with effect from be deputed by <b>Fretus Folks India Pvt Ltd.</b> to work at client's
                office /
                premises at any of their locations.
            </span>
        </p>

        <p style="font-size:12px;line-height:1.8;">
            <span style="margin-left:0%;">
                <b style="text-decoration: underline;"> TENURE: </b> The term of your Contract will be valid till
                <b>{{ $offerLetter->tenure_month }}</b> months from the date of joining
            </span>
        </p>

        <p style="font-size:12px;line-height:1.8;">
            <span style="margin-left:0%;">
                <b style="text-decoration: underline;">POSITION: </b> You are appointed as
                <b>{{ $offerLetter->designation }}</b>.
            </span>
        </p>

        <p style="font-size:12px;line-height:1.8;">
            <span>
                <b style="text-decoration: underline;">REMUNERATION: </b> The details of your salary break up with
                components are as per the enclosure attached herewith in annexture – A.
            </span>
        </p>
        <p style="font-size:12px;line-height:1.8;">
            <span>
                <b style="text-decoration: underline;">EXTENSION: </b> Unless otherwise notified to you in writing
                this
                contract of employment would be valid till from the date of your joining <b>Fretus Folks India Pvt
                    Ltd.</b>
                This contract may be considered for an extension depending on the client and <b>Fretus Folks India
                    Pvt
                    Ltd.</b> requirements. The extension of contract period would be considered on fresh terms as
                agreed
                between you and Fretus <b>Fretus Folks India Pvt Ltd.</b> through a separate mutually executed
                contract
                of employment. <b>Fretus Folks India Pvt Ltd.</b> shall inform you in writing of the extension
                requirements, if any.

            </span>
        </p>

        <p style="font-size:12px;line-height:1.8;">
            <span>
                <b style="text-decoration: underline;">WORKING HOURS: </b> You will follow the working hours of the
                client where you will be deputed. You may have to work on shifts, based on the client's requirement.
                Your attendance will be maintained by the Reporting Officer of the client, who shall at the end of
                the
                month share the attendance with the contact person at <b>Fretus Folks India Pvt Ltd.</b> for
                pay-roll
                processing.
            </span>
        </p>
        <div style="page-break-after: always;"></div>
        <p style="font-size:12px;line-height:1.8;">
            <span>
                <b style="text-decoration: underline;">TERMINATION & SUSPENSION: </b> At the time of termination of
                the
                employment either due to termination by either you or the Company or upon the lapse of the term of
                employment, if there are any dues owing from you to the Company, the same may be adjusted against
                any
                money due to you by the Company on account of salary including bonus or any other payment owned to
                you
                under the terms of your employment.
            </span>
        </p>
        <p style="font-size:12px;line-height:1.8;">
            <span>
                During the tenure of your Contract, any deviation or misconduct in any form that were noticed by the
                company or if there are any breach of internal policies or any regulation that was mutually agreed
                to be
                complied with, <b>Fretus Folks India Pvt Ltd.</b> or principal employer has the rights and authority
                to
                suspend your services until you are notified to resume work in writing. <b>Fretus Folks India Pvt
                    Ltd.</b> reserves all such right to withheld full or a portion of your salary during such
                suspension
                period.
            </span>
        </p>

        <p style="font-size:12px;line-height:1.8;">
            <span>
                <b style="text-decoration: underline;">NOTICE PERIOD: </b> In the eventuality if you wish to
                separate
                from the organization you will need to serve 7day's notice in writing or 7 day's basic pay in lieu
                thereof. The Contract can be terminated at the discretion of , <b>Fretus Folks India Pvt Ltd.</b>
                subject to 7 day's noticeor basic pay in lieu thereof. However due to breach of code of conduct,
                misbehavior or indiscipline etc, then in such cases, <b>Fretus Folks India Pvt Ltd.</b> will have /
                reserve rights to terminate immediately without giving notice period.

            </span>
        </p>

        <p style="font-size:12px;line-height:1.8;">
            <span>
                <b style="text-decoration: underline;">INDEMNITY: </b> You shall be responsible for protecting any
                property of the Client entrusted to you in the due discharge of your duties and you shall indemnify
                the
                Client if there is a loss of any kind to the said property.To the fullest extent permitted by the
                Applicable Law, you shall hold the Client, its agents, employees and assigns, free and harmless and
                indemnify and defend Client from and against any and all suits, actions, proceedings, claims,
                demands,
                liabilities, costs and charges, legal expenses, damages or penalties of any nature actually or
                allegedly
                arising out of or related to your services at the Location or to any alleged actions or omissions by
                you, including, but not limited to, those resulting from, or claimed to result from injury, death or
                damage to you.
            </span>
        </p>

        <p style="font-size:12px;line-height:1.8;">
            <span>
                <b style="text-decoration: underline;">TRANSFER: </b> You are liable to be transferred to any other
                department of the Client or <b>Fretus Folks India Pvt Ltd.</b> or at any other branches across India
                in
                which the client or <b>Fretus Folks India Pvt Ltd</b> or any of the employer subsidiary company has
                any
                kind of interest. That also upon such transfer, the present terms and conditions shall be
                applicable, to
                such a post or at the place of transfer.
            </span>
        </p>

        <p style="font-size:12px;line-height:1.8;">
            <span>
                <b style="text-decoration: underline;">CODE OF CONDUCT: </b> You shall not engage in any act
                subversive
                of discipline in the course of your duty/ies for the Client either within the Client's organization
                or
                outside it, and if you were at any time found indulging in such act/s, the Company shall reserve the
                right to initiate disciplinary action as is deemed fit against you.
            </span>
        </p>
        <div style="page-break-after: always;"></div>
        <p style="font-size:12px;line-height:1.8;">
            <span>
                <b style="text-decoration: underline;">ADDRESS FOR COMMUNICATION: </b> The address of communication
                for
                the purpose of service of notice and other official communication to the company shall be the
                registered
                address of the company which is, <b>Fretus Folks India Pvt Ltd. No. M 20, 3rd Floor, UKS Heights,
                    Sector
                    XI, Jeevan Bhima Nagar,Bangalore-560075.</b> The address of communication and service of notice
                and
                other official communication is the address set out as above and your present residential address
                namely. In the event there is a change in your address, you shall inform the same in writing to the
                Management and that shall be the address last furnished by you, shall be deemed to be sufficient for
                communication and shall be deemed to be effective on you.
            </span>
        </p>


        <p style="font-size:12px;line-height:1.8;">
            <span>
                <b style="text-decoration: underline;">BACKGROUND VERIFICATION: </b> The company reserves the right
                to
                have your back ground verified directly or through an outside agency. If on such verification it is
                found that you have furnished wrong information or concealed any material information your services
                are
                liable to be terminated.
            </span>
        </p>
        <p style="font-size:12px;line-height:1.8;">
            <span>
                <b style="text-decoration: underline;">ABSENTEEISM: </b> You should be regular and punctual in your
                attendance. If you remain absent for 3 consecutive working days or more without sanction of leave or
                prior permission or if you over stay sanctioned leave beyond 3 consecutive working days or more it
                shall
                be deemed that you have voluntarily abandonment your employment with the company and your services
                are
                liable to be terminated accordingly.
            </span>
        </p>

        <p style="font-size:12px;line-height:1.8;">
            <span>
                <b style="text-decoration: underline;">RULES AND REGULATIONS: </b> You shall be bound by the Rules &
                Regulations framed by the company from time to time in relation to conduct, discipline and other
                service
                conditions which will be deemed as Rules, Regulation and order and shall form part and parcel of
                this
                letter of appointment.
            </span>
        </p>

        <p style="font-size:12px;line-height:1.8;">
            <span>
                <b style="text-decoration: underline;">OTHER TERMS OF CONTRACT: </b> In addition to the terms of
                appointment mentioned above, you are also governed by the standard employment rules of , <b>Fretus
                    Folks
                    India Pvt Ltd.</b> (as per Associate Manual). The combined rules and procedures as contained in
                this
                letter will constitute the standard employment rules and you are required to read both of them in
                conjunction.
            </span>
        </p>

        <p style="font-size:12px;line-height:1.8;">
            <span>
                <b style="text-decoration: underline;">JURISDICTION: </b> Notwithstanding the place of working or
                placement or the normal or usual residence of the employee concerned or the place where this
                instrument
                is signed or executed this Contract shall only be subject to the jurisdiction of the High Court of
                Judicature of <b>Delhi At Delhi</b> and its subordinate Courts.
            </span>
        </p>
        <p style="font-size:12px;line-height:1.8;">
            <span>
                <b style="text-decoration: underline;">DEEMED CANCELLATION OF CONTRACT: </b> The Contract stands
                cancelled and revoked if you do not report to duty within 3 days from the date of joining & your act
                will be construed as deemed and implied rejection of the offer of employment from your side; hence
                no
                obligation would arise on the part of the company in lieu of such Employment Contract issued.
            </span>
        </p>
        <div style="page-break-after: always;"></div>

        <p><b>You are requested to bring the following documents at the time of joining: </b> </p>
        <ol style="font-size:12px;line-height:1.8;">
            <li>Educational Certificates for 10th and 12 standard or the highest qualification held by you.</li>
            <li> Experience Letter / Relieving letter of the past company, if any.</li>
            <li> Latest month pay slip,if any</li>
            <li>Photo ID proof (Aadhar Card/Driving Licence/Election I-Card/Passport/Pan Card).</li>
            <li>Address Proof (Aadhar Card/Driving Licence/Election I-Card/Passport/Pan Card).</li>
            <li>5 passport size photographs</li>
            <li>PAN card, if any.</li>
            <li>UAN Card, if any.</li>
            <li>Aadhaar Card.</li>
        </ol>

        <p style="font-size:12px;line-height:1.8;"><br>
            <span style="margin-left:0%;">
                Here's wishing you the very best in your assignment with us and as a token of your understanding and
                accepting of the standard terms of employment, you are requested to sign the duplicate copy of this
                letter and return to us within a day.</span><br /><br />
            <span style="margin-left:0%;">With warm regards,
            </span>
        </p>

        <p style="line-height:1.8; font-size:14px; text-align:left;">
            <b>For: Fretus Folks India Pvt Ltd.</b><br><br>
            <img src="{{ public_path('admin/images/seal.png') }}" alt="Seal" style="margin: 10px 0;"
                width="100"><br><br>
            <b>Authorized Signatory</b>
        </p>


        <div style="page-break-after: always;"></div>

        <div style="color: #000;font-family: Tahoma;font-size: 12px;text-align: justify;">
            <h1>Annexure - A</h1>
            <p style="text-align: left;">
                <span style="text-decoration:underline;"><b>Compensation Sheet</b></span><br>
                Offer No: <b>{{ $offerLetter->ffi_emp_id }}</b><br>
                Associate Name: <b>{{ $offerLetter->emp_name }}</b><br>
                Designation: <b>{{ $offerLetter->designation }}</b><br>
                Location: <b>{{ $offerLetter->location }}</b><br>
            </p>

            <table class="table1">
                <thead>
                    <tr>
                        <th>Components</th>
                        <th>Monthly Salary</th>
                        <th>Annual Salary</th>
                    </tr>
                </thead>
                <tbody>
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
                        <td>Conveyance</td>
                        <td>{{ $offerLetter->conveyance }}</td>
                        <td>{{ $offerLetter->conveyance * 12 }}</td>
                    </tr>
                    <tr>
                        <td>St. Bonus</td>
                        <td>{{ $offerLetter->st_bonus }}</td>
                        <td>{{ $offerLetter->st_bonus * 12 }}</td>
                    </tr>
                    <tr style="background-color:#ecbfbf;">
                        <td><b>Gross Salary</b></td>
                        <td><b>{{ $offerLetter->gross_salary }}</b></td>
                        <td><b>{{ $offerLetter->gross_salary * 12 }}</b></td>
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
                    <tr>
                        <td>Employee LWF</td>
                        <td>{{ $offerLetter->lwf }}</td>
                        <td>{{ $offerLetter->lwf * 12 }}</td>
                    </tr>
                    <tr>
                        <td>PT</td>
                        <td>{{ $offerLetter->pt }}</td>
                        <td>{{ $offerLetter->pt * 12 }}</td>
                    </tr>
                    <tr style="background-color:#ecbfbf;">
                        <td><b>Total Deduction</b></td>
                        <td><b>{{ $offerLetter->total_deduction }}</b></td>
                        <td><b>{{ $offerLetter->total_deduction * 12 }}</b></td>
                    </tr>
                    <tr style="background-color:#ecbfbf;">
                        <td><b>Take-home</b></td>
                        <td><b>{{ $offerLetter->take_home }}</b></td>
                        <td><b>{{ $offerLetter->take_home * 12 }}</b></td>
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
                    <tr>
                        <td>Employer LWF</td>
                        <td>{{ $offerLetter->employer_lwf }}</td>
                        <td>{{ $offerLetter->employer_lwf * 12 }}</td>
                    </tr>
                    <tr style="background-color:#ecbfbf;">
                        <td><b>CTC</b></td>
                        <td><b>{{ $offerLetter->ctc }}</b></td>
                        <td><b>{{ $offerLetter->ctc * 12 }}</b></td>
                    </tr>
                </tbody>
            </table>


            <p style="margin-top:20px;"><b>Signature</b></p>
            <p><b>Name:</b> {{ $offerLetter->emp_name }}</p>
            <p><b>Designation:</b> {{ $offerLetter->designation }}</p>
        </div>

        <div style="page-break-after: always;"></div>

        <table style="border-collapse:collapse;width:100%;margin-bottom:20px;">
            <tbody>
                <tr>
                    <td colspan="3" style="font-size:12px;text-align:left;padding:7px">
                        <p><b>Ref.No. :</b> {{ $offerLetter->employee_id }}</p>

                    </td>
                    <td style="font-size:12px;text-align:right;padding:7px;width:30%">
                        <p><b>Date:</b> {{ \Carbon\Carbon::parse($offerLetter->joining_date)->format('d-m-Y') }}</p>

                    </td>
                </tr>
            </tbody>
        </table>
        <p style="font-size:12px;margin-top:30px;">
            <b style="font-size:13px">To,</b> <br>
            <b style="font-size:13px">Fretus Folks India Pvt Ltd.,</b><br>
            VBC Tower, #39,<br />
            1st Floor, CMH Road, Indiranagar,<br />
            Bangalore-560038. Ph- 080-43726370 <br>
        </p>

        <p style="font-size:13px">
            <b>Subject :- Acknowledgement and receipt of Offer Letter</b>
        </p>

        <p style="font-size:13px;margin-bottom:10px;">
            Dear Sir,<br /><br />
            I have read and understood the above mentioned terms and conditions of the Contract. I voluntarily
            accept the same. I have received <b>Fretus Folks India Pvt Ltd.</b> Associate Manual and I shall
            abide to the terms and conditions mentioned therein and any amendments from time to time.
            <br /><br />
            On receipt of the first salary, all terms & conditions in this fixed term employment contract would
            be deemed as acknowledged & accepted.
        </p>

        <p style="font-size:13px">
            <b>Name:</b> {{ $offerLetter->emp_name }}<br /><br />
            <b>Signature:</b> <span
                style="text-decoration:underline;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><br /><br />
            <b>Place:</b> {{ $offerLetter->location }}<br />
            <b>Date:</b> {{ \Carbon\Carbon::parse($offerLetter->joining_date)->format('d-m-Y') }}
        </p>

    </div>

</body>

</html>
