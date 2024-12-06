<!DOCTYPE html>
<html>

<head>
    <title>Expenses Export</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Empoyee Name</th>
                <th>Asset Name</th>
                <th>Asset Codee</th>
                <th>Issued Date</th>
                <th>Returned Date</th>

                <th>Damage/Recavery</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($issues as $key => $issue)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $issue->assets->emp_name }}</td>
                    <td>{{ $issue->asset_name }}</td>
                    <td>{{ $issue->asset_code }}</td>
                    <td>{{ \Carbon\Carbon::parse($issue->issued_date)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($issue->returned_date)->format('d-m-Y') }}</td>
                    <td>{{ $issue->damage_recover }}</td>
                    <td>{{ $issue->status == 1 ? 'Issued' : 'Returned' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
