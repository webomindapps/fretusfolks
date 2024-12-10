<table>
    <thead>
        <tr>
            @if (!empty($fields) && is_array($fields))
                @foreach ($fields as $field)
                    <th>{{ ucwords(str_replace('_', ' ', $field)) }}</th>
                @endforeach
            @else
                <th>No Fields Available</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @if (!empty($clients) && is_iterable($clients))
            @foreach ($clients as $client)
                <tr>
                    @if (!empty($fields) && is_array($fields))
                        @foreach ($fields as $field)
                            <td>{{ data_get($client, $field, 'N/A') }}</td>
                        @endforeach
                    @else
                        <td>No Data</td>
                    @endif
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="{{ !empty($fields) && is_array($fields) ? count($fields) : 1 }}">No Clients Available</td>
            </tr>
        @endif
    </tbody>
</table>
