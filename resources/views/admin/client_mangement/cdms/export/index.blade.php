<table>
    <thead>
        <tr>
            <th>Sl No</th>
            <th>Client Code</th>
            <th>Client Name</th>
            <th>Land Line</th>
            <th>Email</th>
            <th>Contact Person</th>
            <th>Contact Phone</th>
            <th>Contact Email</th>
            <th>Registered Address</th>
            <th>Communication Address</th>
            <th>PAN</th>
            <th>TAN</th>
            <th>Website URL</th>
            <th>Mode Agreement</th>
            <th>Agreement Type</th>
            <th>Agreement Document </th>
            <th>Region</th>
            <th>Service State</th>
            <th>Contract Start</th>
            <th>Contract End</th>
            <th>Rate</th>
            <th>Commercial Type</th>
            <th>Remark</th>
            <th>State Name</th>
            <th>GSTN</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($clients as $key => $client)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $client->client_code }}</td>
                <td>{{ $client->client_name }}</td>
                <td>{{ $client->land_line }}</td>
                <td>{{ $client->client_email }}</td>
                <td>{{ $client->contact_person }}</td>
                <td>{{ $client->contact_person_phone }}</td>
                <td>{{ $client->contact_person_email }}</td>
                <td>{{ $client->registered_address }}</td>
                <td>{{ $client->communication_address }}</td>
                <td>{{ $client->pan }}</td>
                <td>{{ $client->tan }}</td>
                <td>{{ $client->website_url }}</td>
                <td>{{ $client->mode_agreement == 1 ? 'LOI' : 'Agreement' }}</td>
                <td>{{ $client->agreement_type == 1 ? 'One Time Sourcing' : ($client->agreement_type == 2 ? 'Contractual' : 'Other') }}
                </td>
                <td>{{ $client->agreement_doc }}</td>
                <td>{{ $client->region }}</td>
                <td>{{ $client->state?->state_name }}</td>
                <td>{{ $client->contract_start }}</td>
                <td>{{ $client->contract_end }}</td>
                <td>{{ $client->rate }}</td>
                <td>{{ $client->commercial_type == 1 ? '%' : 'Rs' }}</td>
                <td>{{ $client->remark }}</td>

                <td>
                    @if ($client->gstn && $client->gstn->count())
                        @foreach ($client->gstn as $gst)
                            {{ $gst->states?->state_name ?? 'N/A' }} - {{ $gstn->gstn_no }}<br>
                        @endforeach
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
