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
                            <td style="white-space: nowrap;">
                                @switch($field)
                                    @case('state')
                                        {{ $client->stateRelation?->state_name }}
                                    @break

                                    @default
                                        {{ $client->$field ?? 'N/A' }}
                                @endswitch
                            </td>
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
