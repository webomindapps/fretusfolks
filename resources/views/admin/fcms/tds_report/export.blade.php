<table>
    <thead>
        <tr>
            @foreach ($fields as $field)
                <th>{{ ucwords(str_replace('_', ' ', $field)) }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($tds_code as $payment)
            <tr>
                @foreach ($fields as $field)
                    <td>
                        @switch($field)
                            @case('invoice_no')
                                {{ $payment->invoice->invoice_no ?? 'N/A' }}
                            @break

                            @case('service_location')
                                {{ $payment->invoice->state?->state_name ?? 'N/A' }}
                            @break

                            @case('client_id')
                                {{ $payment->client?->client_name }}
                            @break

                            @case('date_time')
                                {{ $payment->date_time }}
                            @break

                            @default
                                {{ $payment->$field ?? 'N/A' }}
                        @endswitch
                    </td>
                @endforeach
            </tr>
        @endforeach

    </tbody>
</table>
