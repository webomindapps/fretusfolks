<div class="row">
    <div class="col-md-4 col-sm-6">
        <p><b>Client Name :</b> <span>{{ $client->client_name }}</span></p>
    </div>
    <div class="col-md-4 col-sm-6">
        <p><b>Client Email :</b> <span>{{ $client->client_email }}</span></p>
    </div>
    <div class="col-md-4 col-sm-6">
        <p><b>Landline No :</b> <span>{{ $client->land_line }}</span></p>
    </div>
</div>

<div class="row">
    <div class="col-md-4 col-sm-6">
        <p><b>Contact Person Name :</b> <span>{{ $client->contact_person }}</span></p>
    </div>
    <div class="col-md-4 col-sm-6">
        <p><b>Email :</b> <span>{{ $client->contact_person_email }}</span></p>
    </div>
    <div class="col-md-4 col-sm-6">
        <p><b>Phone No :</b> <span>{{ $client->contact_person_phone }}</span></p>
    </div>
</div>

<div class="row">
    <div class="col-md-4 col-sm-6">
        <p><b>Contact Name (Comm) :</b> <span>{{ $client->contact_name_comm }}</span></p>
    </div>
    <div class="col-md-4 col-sm-6">
        <p><b>Contact Email (Comm) :</b> <span>{{ $client->contact_email_comm }}</span></p>
    </div>
    <div class="col-md-4 col-sm-6">
        <p><b>Contact Phone (Comm) :</b> <span>{{ $client->contact_phone_comm }}</span></p>
    </div>
</div>

<div class="row">
    <div class="col-md-4 col-sm-6">
        <p><b>PAN No :</b> <span>{{ $client->pan }}</span></p>
        <p><b>Agreement Mode :</b> <span>{{ $client->agreement_mode }}</span></p>
    </div>
    <div class="col-md-4 col-sm-6">
        <p><b>TAN No :</b> <span>{{ $client->tan }}</span></p>
        <p><b>Agreement Type :</b> <span>{{ $client->other_agreement }}</span></p>
    </div>
    <div class="col-md-4 col-sm-6">
        <p><b>Website URL :</b> <span>{{ $client->website_url }}</span></p>
    </div>
</div>

<div class="row">
    <div class="col-md-4 col-sm-6">
        <p><b>Registered Address :</b> <span>{{ $client->registered_address }}</span></p>
    </div>
    <div class="col-md-4 col-sm-6">
        <p><b>Communication Address :</b> <span>{{ $client->communication_address }}</span></p>
    </div>
</div>

<hr>

<h6 class="font-weight-semibold">Agreement Details</h6>

<div class="row">
    <div class="col-md-4 col-sm-6">
        <p><b>Zone :</b> <span>{{ $client->region }}</span></p>
        <p><b>Servicing State :</b> <span>{{ $client->state ? $client->state->name : 'Not Available' }}</span></p>
        <p><b>Rate :</b> <span>{{ $client->rate }}</span></p>
    </div>
    <div class="col-md-4 col-sm-6">
        <p><b>Contract Start :</b> <span>{{ \Carbon\Carbon::parse($client->contract_start)->format('d-m-Y') }}</span>
        </p>
        <p><b>Commercial Type :</b> <span>{{ $client->commercial_type }}</span></p>
    </div>
    <div class="col-md-4 col-sm-6">
        <p><b>Contract End :</b> <span>{{ \Carbon\Carbon::parse($client->contract_end)->format('d-m-Y') }}</span></p>
        <p><b>Remarks :</b> <span>{{ $client->remark }}</span></p>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-md-4 col-sm-6">
        <p><b><a href="{{ $client->agreement_doc_url }}" target="_blank"><i class="fa fa-book"></i> Agreement
                    Document</a></b></p>
    </div>
</div>

<hr>

<h6 class="font-weight-semibold">GSTN Details</h6>

{{-- 
<div class="row">
    <div class="col-md-12 col-sm-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Si No</th>
                    <th>State</th>
                    <th>GSTN No</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($client->gstn as $gst)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $gst->state_name }}</td>
                        <td>{{ $gst->gstn_no }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div> --}}
