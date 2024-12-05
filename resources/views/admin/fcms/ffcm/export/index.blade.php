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
                <th>Date</th>
                <th>Nature of Expenses</th>
                <th>Month</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($expenses as $expense)
                <tr>
                    <td>{{ $expense->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($expense->date)->format('d-m-Y') }}</td>
                    <td>{{ $expense->nature_expenses }}</td>
                    <td>{{ \DateTime::createFromFormat('!m', $expense->month)->format('F') }}</td>
                    <td>{{ $expense->amount }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
