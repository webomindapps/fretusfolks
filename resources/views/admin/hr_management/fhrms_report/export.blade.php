<table>
    <thead>
        <tr>
            @foreach ($fields as $field)
                <th>{{ ucwords(str_replace('_', ' ', $field)) }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($clients as $client)
            <tr>
                @foreach ($fields as $field)
                    <td>{{ $client->$field }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
