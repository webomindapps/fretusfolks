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
                <td>{{ $candidate->entity_name }}</td>
                <td>{{ $candidate->emp_name }}</td>
                <td>{{ $candidate->phone1 }}</td>
                <td>{{ $candidate->email }}</td>
                <td>{{ $candidate->state }}</td>
                <td>{{ $candidate->location }}</td>
                <td>{{ $candidate->designation }}</td>
                <td>{{ $candidate->department }}</td>
                <td>{{ $candidate->interview_date }}</td>
                <td>{{ $candidate->joining_date }}</td>
                <td>{{ $candidate->aadhar_no }}</td>
                <td>
                    <a href="{{ asset($candidate->aadhar_path) }}" target="_blank">View Document</a>
                </td>
                <td>{{ $candidate->driving_license_no }}</td>
                <td>
                    <a href="{{ asset($candidate->driving_license_path) }}" target="_blank">View Document</a>
                </td>
                <td>
                    <img src="{{ asset($candidate->photo) }}" alt="Photo" width="50" height="50">
                </td>
                <td>
                    <a href="{{ asset($candidate->resume) }}" target="_blank">View Resume</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
