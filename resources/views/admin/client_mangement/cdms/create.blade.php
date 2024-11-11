<x-applayout>
    <x-admin.breadcrumb title=" Client Database Management System" />

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
            <form action="{{ route('admin.cdms.create') }}" method="POST">
                @csrf
                <div class="card mt-3">
                    <div class="card-header header-elements-inline d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">New TDS Code</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-contents">
                            <div class="row">
                                <x-forms.input label="Enter Client Code:" type="text" name="client_code"
                                    id="client_code" :required="true" size="col-lg-6 mt-2" />
                                <x-forms.input label="Enter Client Name:" type="text" name="client_name"
                                    id="client_name" :required="true" size="col-lg-6 mt-2" />
                                <x-forms.input label="Enter Office Land-line Number:" type="text" name="land_line"
                                    id="land_line" :required="true" size="col-lg-6 mt-2" />
                                <x-forms.input label="Enter Client Mail ID:" type="text" name="client_email"
                                    id="client_email" :required="true" size="col-lg-6 mt-2" />
                                <x-forms.input label="Enter Contact Person Name:" type="text" name="contact_person"
                                    id="contact_person" :required="true" size="col-lg-6 mt-2" />
                                <x-forms.input label="Enter Contact Person Mobile Number:" type="text"
                                    name="contact_person_phone" id="contact_person_phone" :required="true"
                                    size="col-lg-6 mt-2" />
                                <x-forms.input label="Enter Contact Person Mail ID: " type="text"
                                    name="contact_person_email" id="contact_person_email" :required="true"
                                    size="col-lg-6 mt-2" />
                                <x-forms.input label="Contact Person Name (Communication): : " type="text"
                                    name="contact_name_comm" id="contact_name_comm" :required="true"
                                    size="col-lg-6 mt-2" />
                                <x-forms.input label="Contact Person Phone (Communication): " type="text"
                                    name="contact_phone_comm" id="contact_phone_comm" :required="true"
                                    size="col-lg-6 mt-2" />
                                <x-forms.input label="Contact Person Mail (Communication): " type="text"
                                    name="contact_email_comm" id="contact_email_comm" :required="true"
                                    size="col-lg-6 mt-2" />
                                <x-forms.textarea label="Enter Registered Address:" type="text"
                                    name="registered_address" id="registered_address" :required="true"
                                    size="col-lg-6 mt-2" />
                                <x-forms.textarea label="Enter Communication Address:" type="text"
                                    name="communication_address" id="communication_address" :required="true"
                                    size="col-lg-6 mt-2" />
                                <x-forms.input label="Enter Client PAN Number: " type="text" name="pan"
                                    id="pan" :required="true" size="col-lg-6 mt-2" />
                                <x-forms.input label="Enter Client TAN Number: " type="text" name="tan"
                                    id="tan" :required="true" size="col-lg-6 mt-2" />

                                <table class="table table-bordered mt-4" style="border: 1px solid #ddd;">
                                    <thead style="background-color: transparent;">
                                        <tr>
                                            <th>State</th>
                                            <th>GSTN No</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="gstn_div">
                                        <tr id="row_1">
                                            <td>
                                                <select class="form-control required" name="state[]" id="state"
                                                    required>
                                                    <option value="">Select State</option>
                                                    @foreach ($states as $state)
                                                        <option value="{{ $state->id }}">{{ $state->state_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="gstn[]" id="gstn_1"
                                                    class="form-control required" maxlength="15"
                                                    style="text-transform:uppercase" autocomplete="off" required>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="add-btn btn btn-success"
                                                    style="cursor: pointer;">
                                                    <i class="fa fa-plus-square" aria-hidden="true"></i> Add Row
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>


                                <x-forms.input label="Enter Client website URL: " type="text" name="website_url"
                                    id="website_url" :required="true" size="col-lg-4 mt-2" />
                                <x-forms.select label="Service Location:" name="region" id="region"
                                    :required="true" size="col-lg-4 mt-2" :options="[
                                        [
                                            'label' => 'North',
                                            'value' => 1,
                                        ],
                                        [
                                            'label' => 'South',
                                            'value' => 2,
                                        ],
                                        [
                                            'label' => 'East',
                                            'value' => 3,
                                        ],
                                        [
                                            'label' => 'West',
                                            'value' => 4,
                                        ],
                                        [
                                            'label' => 'Pan India',
                                            'value' => 5,
                                        ],
                                    ]" :value="'North'" />

                                <x-forms.select label="State:" name="service_state" id="service_state"
                                    :required="true" size="col-lg-4 mt-2" :options="$states
                                        ->map(fn($state) => ['value' => $state->id, 'label' => $state->state_name])
                                        ->toArray()" :value="old('service_state')" />
                                <x-forms.radio label="Mode of Agreement:" :options="[
                                    ['value' => '1', 'label' => 'LOI'],
                                    ['value' => '2', 'label' => 'Agreement'],
                                ]" id="mode_agreement"
                                    name="mode_agreement" :required="true" size="col-lg-6 mt-2" />
                                <x-forms.radio label="Type of Agreement:" :options="[
                                    ['value' => '1', 'label' => 'One Time Sourcing'],
                                    ['value' => '2', 'label' => 'Contractual'],
                                    ['value' => '3', 'label' => 'Other'],
                                ]" id="agreement_type"
                                    name="agreement_type" :required="true" size="col-lg-6 mt-2" />

                                <div class="form-group col-lg-6 mt-2">
                                    <label for="file">Attach Agreement Documents:
                                        <span style="color: red">*</span>
                                        <span class="text-danger">(.doc, .jpg, .jpeg, .pdf)</span>
                                    </label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="agreement_doc"
                                            name="agreement_doc">
                                    </div>
                                    <span class="form-text text-muted">Max file size 5 MB</span>
                                    <small id="fileError" class="text-danger d-none">Invalid file type or size exceeds
                                        5 MB.</small>
                                </div>
                                <div class="form-group col-lg-6 mt-2">
                                    <label for="contract_start">Contract Start Date:</label>
                                    <span style="color: red">*</span>
                                    <input type="date" class="form-control" id="contract_start"
                                        name="contract_start" required>
                                </div>
                                <div class="form-group col-lg-6 mt-2">
                                    <label for="contract_end">Contract End Date:</label>
                                    <span style="color: red">*</span>
                                    <input type="date" class="form-control" id="contract_end" name="contract_end"
                                        required>
                                </div>
                                <div class="form-group col-md-12">
                                    <h5 class="card-title">Commercial</h5>
                                </div>
                                <x-forms.input label="Rate: " type="number" name="rate" id="rate"
                                    :required="true" size="col-lg-4 mt-2" />
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
                                    ]" :value="'%'" />
                                <x-forms.input label="Remark: " type="text" name="remark" id="remark"
                                    :required="true" size="col-lg-6 mt-2" />
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mt-4">
                                    <x-forms.button type="submit" label="Add" class="btn btn-primary" />
                                </div>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </div>
    @push('scripts')
        <script>
            let rowCount = 1;
            document.getElementById('gstn_div').addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('add-btn')) {
                    rowCount++;
                    const newRow = document.createElement('tr');
                    newRow.id = `row_${rowCount}`;
                    newRow.innerHTML = `
            <td>
                <select class="form-control required" name="state[]" id="state_${rowCount}" required>
                    <option value="">Select State</option>
                    @foreach ($states as $state)
                        <option value="{{ $state->id }}">{{ $state->state_name }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="text" name="gstn[]" id="gstn_${rowCount}" class="form-control required" maxlength="15" style="text-transform:uppercase" autocomplete="off" required>
            </td>
            <td class="text-center">
                <button type="button" class="remove-btn btn btn-danger" style="cursor: pointer; margin-left: 10px;">
                    <i class="fa fa-minus-square" aria-hidden="true"></i> Remove
                </button>
            </td>
        `;
                    document.getElementById('gstn_div').appendChild(newRow);
                }
                if (e.target && e.target.classList.contains('remove-btn')) {
                    const rowToRemove = e.target.closest('tr');
                    if (rowToRemove) {
                        console.log('Removing row:', rowToRemove);
                        rowToRemove.remove();
                    } else {
                        console.error('Row to remove not found');
                    }
                }
            });
        </script>
    @endpush
</x-applayout>
