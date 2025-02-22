<table>
    <thead>
        <tr>
            @foreach ($fields as $field)
                <th>{{ ucwords(str_replace('_', ' ', $field)) }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($payments as $payment)
            <tr>
                @foreach ($fields as $field)
                    <td>
                        @switch($field)
                            @case('invoice_no')
                                {{ $payment->invoice->invoice_no }}
                            @break

                            @case('state_name')
                                {{ $payment->invoice->state?->state_name }}
                            @break

                            @case('client_name')
                                {{ $payment->client?->client_name }}
                            @break

                            @case('code')
                                {{ $payment->tds?->code }}
                            @break

                            @case('date_time')
                                {{ $payment->date_time }}
                            @break

                            @default
                                {{ $payment->$field }}
                        @endswitch
                    </td>
                @endforeach
            </tr>
        @endforeach

    </tbody>
</table>
