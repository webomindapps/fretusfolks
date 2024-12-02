<table>
    <thead>
        <tr>
            <th>Sl No</th>
            <th>Client Name</th>
            <th>Associate Name</th>
            <th>Employee Mobile</th>
            <th>Employee Email ID</th>
            <th>State</th>
            <th>Location</th>
            <th>Designation</th>
            <th>Department</th>
            <th>Date of Interview</th>
            <th>Date of Joining</th>
            <th>Adhar Card No</th>
            <th>Adhaar Card Document</th>
            <th>Driving License No</th>
            <th>Driving License Document</th>
            <th>Photo</th>
            <th>Resume</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($candidates as $key => $candidate)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $candidate->client_id }}</td>
                <td>{{ $candidate->emp_name }}</td>
                <td>{{ $candidate->phone1 }}</td>
                <td>{{ $candidate->email }}</td>
                <td>{{ $candidate->state }}</td>
                <td>{{ $candidate->location }}</td>
                <td>{{ $candidate->designation }}</td>
                <td>{{ $candidate->department }}</td>
                <td>{{ \Carbon\Carbon::parse($candidate->interview_date)->format('d-m-Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($candidate->joining_date)->format('d-m-Y') }}</td>
                <td>{{ $candidate->aadhar_no }}</td>
                <td>{{ $candidate->aadhar_path }}</td>
                <td>{{ $candidate->driving_license_no }}</td>
                <td>{{ $candidate->driving_license_path }} </td>
                <td>{{ $candidate->photo }} </td>
                <td>{{ $candidate->resume }} </td>
            </tr>
        @endforeach
    </tbody>
</table>
