<table>
    <thead>
        <tr>
            @foreach ($fields as $field)
                <th>{{ ucwords(str_replace('_', ' ', $field)) }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($receivables as $recive)
            <tr>
                @foreach ($fields as $field)
                    <td>
                        @switch($field)
                            @case('invoice_no')
                                {{ $recive->invoice->invoice_no }}
                            @break

                            @case('state_name')
                                {{ $recive->invoice->state?->state_name }}
                            @break

                            @case('client_name')
                                {{ $recive->client?->client_name }}
                            @break

                            @case('code')
                                {{ $recive->tds?->code }}
                            @break

                            @case('payment_received_date')
                                {{ \Carbon\Carbon::parse($recive->payment_received_date)->format('d-m-Y') }}
                            @break

                            @case('date')
                                {{ \Carbon\Carbon::parse($recive->invoice?->dat)->format('d-m-Y') }}
                            @break

                            @default
                                {{ $recive->$field }}
                        @endswitch
                    </td>
                @endforeach
            </tr>
        @endforeach

    </tbody>
</table>
