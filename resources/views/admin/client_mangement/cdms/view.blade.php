<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header bg-primary">
            <div class="modal-title">
                <h5 class="" id="clientDetailsLabel">{{ $client->client_name }}</h5>
                <p><b>Client Code :</b> <span>{{ $client->client_code }}</span></p>
            </div>
            <button type="button" class="close" id="closeModalButton">×</button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <h6 class="font-weight-semibold">Client Details</h6>
                </div>
                <div class="col-md-4 col-sm-6">
                    <p><b>Client Name :</b> <span>{{ $client->client_name }}</span></p>
                    <p><b>Contact Person Name :</b> <span>{{ $client->contact_person }}</span></p>
                    <p><b>Contact Name (Comm) :</b> <span>{{ $client->contact_name_comm }}</span></p>
                    <p><b>PAN No :</b> <span>{{ $client->pan }}</span></p>
                    <p><b>Agreement Mode :</b> <span>{{ $client->mode_agreement == 1 ? 'LOI' : 'Agreement' }}</span></p>
                    <p><b>Registered Address :</b> <span>{{ $client->registered_address }}</span></p>
                </div>
                <div class="col-md-4 col-sm-6">
                    <p><b>Client Email :</b> <span>{{ $client->client_email }}</span></p>
                    <p><b>Email :</b> <span>{{ $client->contact_person_email }}</span></p>
                    <p><b>Contact Email (Comm) :</b> <span>{{ $client->contact_email_comm }}</span></p>
                    <p><b>TAN No :</b> <span>{{ $client->tan }}</span></p>
                    <p><b>Agreement Type :</b>
                        <span>{{ $client->agreement_type == 1 ? 'One Time Sourcing' : ($client->agreement_type == 2 ? 'Contractual' : 'Other') }}</span>
                    </p>
                    <p><b>Communication Address :</b> <span>{{ $client->communication_address }}</span></p>
                </div>
                <div class="col-md-4 col-sm-6">
                    <p><b>Phone No :</b> <span>{{ $client->contact_person_phone }}</span></p>
                    <p><b>Landline No :</b> <span>{{ $client->land_line }}</span></p>
                    <p><b>Contact Phone (Comm) :</b> <span>{{ $client->contact_phone_comm }}</span></p>
                    <p><b>Website URL :</b> <span>{{ $client->website_url }}</span></p>
                </div>
            </div>

            <hr>

            <h6 class="font-weight-semibold">Agreement Details</h6>

            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <p><b>Zone :</b> <span>{{ $client->region }}</span></p>
                    <p><b>Servicing State :</b> <span>{{ $client->state->state_name }}</span></p>
                    <p><b>Rate :</b> <span>{{ $client->rate }}</span></p>
                </div>
                <div class="col-md-4 col-sm-6">
                    <p><b>Contract Start :</b>
                        <span>{{ \Carbon\Carbon::parse($client->contract_start)->format('d-m-Y') }}</span>
                    </p>
                    <p><b>Commercial Type :</b> <span>{{ $client->commercial_type == 1 ? '%' : 'Rs' }}</span></p>
                </div>
                <div class="col-md-4 col-sm-6">
                    <p><b>Contract End :</b>
                        <span>{{ \Carbon\Carbon::parse($client->contract_end)->format('d-m-Y') }}</span>
                    </p>
                    <p><b>Remarks :</b> <span>{{ $client->remark }}</span></p>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <a href="{{ $client->agreement_doc }}"target="_blank">
                        <i class="fa fa-book"></i>
                        Agreement Document
                    </a>
                </div>
            </div>

            <hr>

            <h6 class="font-weight-semibold">GSTN Details</h6>

            <div class="row">
                <div class="col-md-12 col-sm-12">
                    @if ($clientgstn->isNotEmpty())
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Si No</th>
                                    <th>State</th>
                                    <th>GSTN No</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clientgstn as $gst)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $gst->state }}</td>
                                        <td>{{ $gst->gstn_no }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No GSTN details available for this client.</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn bg-primary" id="closeModalButton">Close</button>
        </div>
    </div>
</div>
