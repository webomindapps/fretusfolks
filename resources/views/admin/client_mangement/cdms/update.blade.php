<x-applayout>
    <x-admin.breadcrumb title="Client Database Management System" />

    @if ($errors->any())
        <div class="col-lg-12 pb-4 px-2">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    <div class="col-lg-12 pb-4">
        <div class="form-card px-3">
            <form action="{{ route('admin.cdms.edit', $client->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card mt-3">
                    <div class="card-header header-elements-inline d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Edit Client</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-contents">
                            <div class="row">
                                <x-forms.input label="Enter Client Code:" type="text" name="client_code"
                                    id="client_code" :required="true" size="col-lg-6 mt-2" :value="old('client_code', $client->client_code)" />

                                <x-forms.input label="Enter Client Name:" type="text" name="client_name"
                                    id="client_name" :required="true" size="col-lg-6 mt-2" :value="old('client_name', $client->client_name)" />
                                <x-forms.input label="Enter Client Id:" type="text" name="client_ffi_id"
                                    id="client_ffi_id" :required="true" size="col-lg-6 mt-2" :value="old('client_ffi_id', $client->client_ffi_id)" />

                                <x-forms.input label="Enter Office Land-line Number:" type="number" name="land_line"
                                    id="land_line" :required="true" size="col-lg-6 mt-2" :value="old('land_line', $client->land_line)" />

                                <x-forms.input label="Enter Client Mail ID:" type="email" name="client_email"
                                    id="client_email" :required="true" size="col-lg-6 mt-2" :value="old('client_email', $client->client_email)" />

                                <x-forms.input label="Enter Contact Person Name:" type="text" name="contact_person"
                                    id="contact_person" :required="true" size="col-lg-6 mt-2" :value="old('contact_person', $client->contact_person)" />

                                <x-forms.input label="Enter Contact Person Mobile Number:" type="number"
                                    name="contact_person_phone" id="contact_person_phone" :required="true"
                                    size="col-lg-6 mt-2" :value="old('contact_person_phone', $client->contact_person_phone)" />

                                <x-forms.input label="Enter Contact Person Mail ID:" type="email"
                                    name="contact_person_email" id="contact_person_email" :required="true"
                                    size="col-lg-6 mt-2" :value="old('contact_person_email', $client->contact_person_email)" />

                                <x-forms.input label="Contact Person Name (Communication):" type="text"
                                    name="contact_name_comm" id="contact_name_comm" :required="true"
                                    size="col-lg-6 mt-2" :value="old('contact_name_comm', $client->contact_name_comm)" />

                                <x-forms.input label="Contact Person Phone (Communication):" type="number"
                                    name="contact_phone_comm" id="contact_phone_comm" :required="true"
                                    size="col-lg-6 mt-2" :value="old('contact_phone_comm', $client->contact_phone_comm)" />

                                <x-forms.input label="Contact Person Mail (Communication):" type="email"
                                    name="contact_email_comm" id="contact_email_comm" :required="true"
                                    size="col-lg-6 mt-2" :value="old('contact_email_comm', $client->contact_email_comm)" />

                                <x-forms.textarea label="Enter Registered Address:" name="registered_address"
                                    id="registered_address" :required="true" size="col-lg-6 mt-2"
                                    :value="old('registered_address', $client->registered_address)" />

                                <x-forms.textarea label="Enter Communication Address:" name="communication_address"
                                    id="communication_address" :required="true" size="col-lg-6 mt-2"
                                    :value="old('communication_address', $client->communication_address)" />

                                <x-forms.input label="Enter Client PAN Number:" type="text" name="pan"
                                    id="pan" :required="true" size="col-lg-6 mt-2" :value="old('pan', $client->pan)"
                                    style="text-transform:uppercase" />

                                <x-forms.input label="Enter Client TAN Number:" type="text" name="tan"
                                    id="tan" :required="true" size="col-lg-6 mt-2" :value="old('tan', $client->tan)"
                                    style="text-transform:uppercase" />

                                <x-forms.input label="Enter Client website URL: " type="url" name="website_url"
                                    id="website_url" :required="true" size="col-lg-4 mt-2" :value="old('website_url', $client->website_url)" />

                                <x-forms.select label="Service Location:" name="region" id="region"
                                    :required="true" size="col-lg-4 mt-2" :options="FretusFolks::getRegion()" :value="old('region', $client->region)" />

                                <x-forms.select label="State:" name="service_state" id="service_state"
                                    :required="true" size="col-lg-4 mt-2" :options="FretusFolks::getStates()" :value="old('service_state', $client->service_state)" />

                                <x-forms.radio label="Mode of Agreement:" :options="[
                                    ['value' => '1', 'label' => 'LOI'],
                                    ['value' => '2', 'label' => 'Agreement'],
                                ]" id="mode_agreement"
                                    name="mode_agreement" :required="true" size="col-lg-6 mt-2"
                                    :value="old('mode_agreement', $client->mode_agreement)" />

                                <x-forms.radio label="Type of Agreement:" :options="[
                                    ['value' => '1', 'label' => 'One Time Sourcing'],
                                    ['value' => '2', 'label' => 'Contractual'],
                                    ['value' => '3', 'label' => 'Other'],
                                ]" id="agreement_type"
                                    name="agreement_type" :required="true" size="col-lg-6 mt-2"
                                    :value="old('agreement_type', $client->agreement_type)" />
                                <div class="form-group col-lg-6 mt-3">
                                    <label class="required">Upload Agreement Document</label>
                                    <input type="file" class="form-control" name="agreement_document"
                                        id="agreement_document" />
                                    @if ($client->agreement_document)
                                        <div class="mt-2">
                                            <a href="{{ asset('storage/clients/' . $client->agreement_document) }}"
                                                target="_blank">View Document</a>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group col-lg-6 mt-2">
                                    <label for="contract_start">Contract Start Date:</label>
                                    <span style="color: red">*</span>
                                    <input type="date" class="form-control" id="contract_start"
                                        name="contract_start" required
                                        value="{{ old('contract_start', $client->contract_start) }}">
                                </div>
                                <div class="form-group col-lg-6 mt-2">
                                    <label for="contract_end">Contract End Date:</label>
                                    <span style="color: red">*</span>
                                    <input type="date" class="form-control" id="contract_end" name="contract_end"
                                        required value="{{ old('contract_end', $client->contract_end) }}">
                                </div>
                                <x-forms.select label="Status:" name="status" id="status" :required="true"
                                    size="col-lg-6 mt-2" :options="FretusFolks::getStatus()" :value="old('status', $client->status)" />

                                <div class="form-group col-md-12">
                                    <h5 class="card-title">Commercial</h5>
                                </div>
                                <x-forms.input label="Rate: " type="number" name="rate" id="rate"
                                    :required="true" size="col-lg-4 mt-2" :value="old('rate', $client->rate)" />
                                <x-forms.select label="Commercial Type:" name="commercial_type" id="commercial_type"
                                    :required="true" size="col-lg-2 mt-2" :options="[
                                        [
                                            'label' => '%',
                                            'value' => 1,
                                        ],
                                        [
                                            'label' => 'Rs',
                                            'value' => 2,
                                        ],
                                    ]" :value="old('commercial_type', $client->commercial_type)" />
                                <x-forms.input label="Remark: " type="text" name="remark" id="remark"
                                    :required="true" size="col-lg-6 mt-2" :value="old('remark', $client->remark)" />
                            </div>

                            <div class="row">
                                <div class="col-lg-12 mt-4">
                                    <x-forms.button type="submit" label="Update" class="btn btn-primary" />
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="content">
        <div class="row">
            <div class="col-lg-12 pb-4">
                <div class="form-card px-3">
                    <form action="{{ route('admin.cdms.gststore', $client->id) }}" method="POST">
                        @csrf
                        <div class="card">
                            <div
                                class="card-header header-elements-inline d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Add GST Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-end">
                                    <x-forms.select label="State:" name="state" id="state" :required="true"
                                        size="col-lg-4 mt-2" :options="$states
                                            ->map(
                                                fn($state) => [
                                                    'value' => $state->id,
                                                    'label' => $state->state_name,
                                                ],
                                            )
                                            ->toArray()" />
                                    <x-forms.input label="GST NO" name="gstn_no" id="gstn_no" :required="true"
                                        style="text-transform:uppercase" size="col-lg-4 mt-2" />
                                    <x-forms.button type="submit" label="Save" class="btn btn-primary col-1" />
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <table class="table table-bordered mt-4" style="border: 1px solid #ddd;">
                            <thead style="background-color: transparent;" class="text-center">
                                <tr>
                                    <th>ID</th>
                                    <th>State</th>
                                    <th>GSTN No</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="gstn_div" class="text-center">
                                @foreach ($clientGstns as $key => $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>
                                            <select class="form-control" name="state[{{ $item->id }}]"
                                                id="state_{{ $item->id }}"
                                                onchange="updateState(this, {{ $item->id }})">
                                                @foreach ($states as $state)
                                                    <option value="{{ $state->id }}"
                                                        {{ old('state.' . $item->id, $item->state) == $state->id ? 'selected' : '' }}>
                                                        {{ $state->state_name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </td>

                                        <td>
                                            <input class="form-control" type="text" value="{{ $item->gstn_no }}"
                                                onchange="updateCode(this, {{ $item->id }})"
                                                style="text-transform:uppercase; width:100%; background:transparent;"
                                                id="gstn_{{ $item->id }}" />
                                        </td>
                                        <td>
                                            <a onclick="return confirm('Are you sure you want to delete this?')"
                                                href="{{ route('admin.cdms.gstdelete', $item->id) }}">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function updateCode(element, itemId) {
                const gstn_no = element.value.trim();
                window.location.href = `/admin/cdms/update_gst/${itemId}?gstn_no=${encodeURIComponent(gstn_no)}`;
            }

            function updateState(element, itemId) {
                const selectedStateId = element.value;
                window.location.href = `/admin/cdms/update_state/${itemId}?state=${encodeURIComponent(selectedStateId)}`;
            }
        </script>
    @endpush
</x-applayout>
