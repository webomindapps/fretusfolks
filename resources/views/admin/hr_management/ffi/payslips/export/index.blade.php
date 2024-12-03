<table>
    <thead>
        <tr>
            <th>Employee ID</th>
            <th>Employee Name</th>
            <th>Designation</th>
            <th>Date of Joining</th>
            <th>Department</th>
            <th>UAN No</th>
            <th>PF No</th>
            <th>ESI No</th>
            <th>Bank Name</th>
            <th>Account No</th>
            <th>IFSC Code</th>
            <th>Month Days</th>
            <th>Pay Days</th>
            <th>Leave Days</th>
            <th>LOP Days</th>
            <th>Arrear Days</th>
            <th>OT Hours</th>
            <th>Fixed Basic</th>
            <th>Fixed HRA</th>
            <th>Fixed Conveyance Allowance</th>
            <th>Fixed Education Allowance</th>
            <th>Fixed Medical Reimbursement</th>
            <th>Fixed Special Allowance</th>
            <th>Fixed Other Allowance</th>
            <th>Fixed ST Bonus</th>
            <th>Fixed Leave Wages</th>
            <th>Fixed Holiday Wages</th>
            <th>Fixed Attendance Bonus</th>
            <th>Fixed OT Wages</th>
            <th>Fixed Incentive</th>
            <th>Fixed Arrear Wages</th>
            <th>Fixed Other Wages</th>
            <th>Fixed Gross</th>
            <th>Earned Basic</th>
            <th>Earned HRA</th>
            <th>Earned Conveyance Allowance</th>
            <th>Earned Education Allowance</th>
            <th>Earned Medical Reimbursement</th>
            <th>Earned Special Allowance</th>
            <th>Earned Other Allowance</th>
            <th>Earned ST Bonus</th>
            <th>Earned Leave Wages</th>
            <th>Earned Holiday Wages</th>
            <th>Earned Attendance Bonus</th>
            <th>Earned OT Wages</th>
            <th>Earned Incentive</th>
            <th>Earned Arrear Wages</th>
            <th>Earned Other Wages</th>
            <th>Earned Gross</th>
            <th>EPF</th>
            <th>ESIC</th>
            <th>Professional Tax</th>
            <th>Income Tax</th>
            <th>LWF</th>
            <th>Salary Advance</th>
            <th>Other Deductions</th>
            <th>Total Deductions</th>
            <th>Net Salary</th>
            <th>In Words</th>
            <th>Month</th>
            <th>Year</th>
            <th>Location</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($employees as $employee)
            <tr>
                <td>{{ $employee->emp_id }}</td>
                <td>{{ $employee->employee_name }}</td>
                <td>{{ $employee->designation }}</td>
                <td>{{ \Carbon\Carbon::parse($employee->date_of_joining)->format('d-m-Y') }}</td>
                <td>{{ $employee->department }}</td>
                <td>{{ $employee->uan_no }}</td>
                <td>{{ $employee->pf_no }}</td>
                <td>{{ $employee->esi_no }}</td>
                <td>{{ $employee->bank_name }}</td>
                <td>{{ $employee->account_no }}</td>
                <td>{{ $employee->ifsc_code }}</td>
                <td>{{ $employee->month_days }}</td>
                <td>{{ $employee->pay_days }}</td>
                <td>{{ $employee->leave_days }}</td>
                <td>{{ $employee->lop_days }}</td>
                <td>{{ $employee->arrear_days }}</td>
                <td>{{ $employee->ot_hours }}</td>
                <td>{{ $employee->fixed_basic }}</td>
                <td>{{ $employee->fixed_hra }}</td>
                <td>{{ $employee->fixed_con_allow }}</td>
                <td>{{ $employee->fixed_edu_allowance }}</td>
                <td>{{ $employee->fixed_med_reim }}</td>
                <td>{{ $employee->fixed_spec_allow }}</td>
                <td>{{ $employee->fixed_oth_allow }}</td>
                <td>{{ $employee->fixed_st_bonus }}</td>
                <td>{{ $employee->fixed_leave_wages }}</td>
                <td>{{ $employee->fixed_holidays_wages }}</td>
                <td>{{ $employee->fixed_attendance_bonus }}</td>
                <td>{{ $employee->fixed_ot_wages }}</td>
                <td>{{ $employee->fixed_incentive }}</td>
                <td>{{ $employee->fixed_arrear_wages }}</td>
                <td>{{ $employee->fixed_other_wages }}</td>
                <td>{{ $employee->fixed_gross }}</td>
                <td>{{ $employee->earned_basic }}</td>
                <td>{{ $employee->earned_hra }}</td>
                <td>{{ $employee->earned_con_allow }}</td>
                <td>{{ $employee->earned_education_allowance }}</td>
                <td>{{ $employee->earned_med_reim }}</td>
                <td>{{ $employee->earned_spec_allow }}</td>
                <td>{{ $employee->earned_oth_allow }}</td>
                <td>{{ $employee->earned_st_bonus }}</td>
                <td>{{ $employee->earned_leave_wages }}</td>
                <td>{{ $employee->earned_holiday_wages }}</td>
                <td>{{ $employee->earned_attendance_bonus }}</td>
                <td>{{ $employee->earned_ot_wages }}</td>
                <td>{{ $employee->earned_incentive }}</td>
                <td>{{ $employee->earned_arrear_wages }}</td>
                <td>{{ $employee->earned_other_wages }}</td>
                <td>{{ $employee->earned_gross }}</td>
                <td>{{ $employee->epf }}</td>
                <td>{{ $employee->esic }}</td>
                <td>{{ $employee->pt }}</td>
                <td>{{ $employee->it }}</td>
                <td>{{ $employee->lwf }}</td>
                <td>{{ $employee->salary_advance }}</td>
                <td>{{ $employee->other_deduction }}</td>
                <td>{{ $employee->total_deductions }}</td>
                <td>{{ $employee->net_salary }}</td>
                <td>{{ $employee->in_words }}</td>
                <td>{{ \Carbon\Carbon::create()->month((int) $employee->month)->format('F') }}</td>
                <td>{{ $employee->year }}</td>
                <td>{{ $employee->location }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
