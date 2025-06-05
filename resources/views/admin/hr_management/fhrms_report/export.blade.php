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
            </tr>
        @endforeach
    </tbody>
</table>
