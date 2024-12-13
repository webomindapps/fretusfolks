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
                    <td>
                        @switch($field)
                            @case('service_state')
                                {{ $client->state?->state_name }}
                            @break

                            @case('contract_start')
                                {{ \Carbon\Carbon::parse($client->contract_start)->format('d-m-Y') }}
                            @break

                            @case('contract_end')
                                {{ \Carbon\Carbon::parse($client->contract_date)->format('d-m-Y') }}
                            @break

                            @default
                                {{ $client[$field] ?? 'N/A' }}
                        @endswitch
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
