<x-applayout>
    <x-admin.breadcrumb title="Search">
        <div class="row text-end me-2">
            <form id="export-form" action="{{ route('admin.cdms_report.export') }}" method="POST">
                @csrf
                <input type="hidden" name="fields" id="export-fields">
                <button type="submit" class="btn btn-success">Export to Excel</button>
            </form>
        </div>
    </x-admin.breadcrumb>
    <div class="content">
        <div class="row">
            <div class="col-lg-12 pb-4 ">
                <div class="form-card px-3">
                    <form id="my_form" action="" method="get" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-4 mt-2" id="form-group-state">
                                <label for="client">Client Name
                                    <span style="color: red">*</span>
                                </label>
                                <select class="form-select" id="client" name="client_id"
                                    onchange="get_client_location();" required>
                                    <option value="">Select</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}"
                                            {{ request()->client_id == $client->id ? 'selected' : '' }}>
                                            {{ $client->client_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                    <span>{{ $message }}</span>
                                @enderror
                            </div>
                            <x-forms.input label="From Date" type="date" name="from_date" id="from-date"
                                :required="false" size="col-lg-4 mt-2" :value="request()->from_date" />
                            <x-forms.input label="To Date" type="date" name="to_date" id="to-date"
                                :required="false" size="col-lg-4 mt-2" :value="request()->to_date" />
                            <div class="col-lg-4 mt-2">
                                <label for="data">Data</label>
                                <div class="dropdown">
                                    <input type="text" class="btn dropdown-toggle" id="dropdownMenuButton"
                                        data-bs-toggle="dropdown" aria-expanded="false" readonly value="Select Data" />
                                    <ul class="dropdown-menu ps-3" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="select_all_data"
                                                    onchange="toggleSelectAll(this, '.data-checkbox', '#dropdownMenuButton', 'Select Data')">
                                                <label class="form-check-label" for="select_all_data">Select
                                                    All</label>
                                            </div>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        @foreach (FretusFolks::cimsData() as $option)
                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input data-checkbox" type="checkbox"
                                                        name="data[]" value="{{ $option['value'] }}"
                                                        id="data_{{ $loop->index }}"
                                                        onchange="updateSelectedCount('.data-checkbox', '#dropdownMenuButton', 'Select Data')">
                                                    <label class="form-check-label"
                                                        for="data_{{ $loop->index }}">{{ $option['label'] }}</label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="col-lg-4 mt-2">
                                <label for="service_state">State</label>
                                <div class="dropdown">
                                    <input type="text" class="btn btn-secondary dropdown-toggle"
                                        id="dropdownMenuButtonState" data-bs-toggle="dropdown" aria-expanded="false"
                                        readonly value="Select State" />
                                    <ul class="dropdown-menu ps-3" aria-labelledby="dropdownMenuButtonState">
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="select_all_states"
                                                    onchange="toggleSelectAll(this, '.state-checkbox', '#dropdownMenuButtonState', 'Select State')">
                                                <label class="form-check-label" for="select_all_states">Select
                                                    All</label>
                                            </div>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        @foreach (FretusFolks::getStates() as $option)
                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input state-checkbox" type="checkbox"
                                                        name="service_location[]" value="{{ $option['value'] }}"
                                                        id="service_location_{{ $loop->index }}"
                                                        onchange="updateSelectedCount('.state-checkbox', '#dropdownMenuButtonState', 'Select State')">
                                                    <label class="form-check-label"
                                                        for="service_location_{{ $loop->index }}">{{ $option['label'] }}</label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <x-forms.select label="Status:" name="status" id="status" :required="false"
                                size="col-lg-4 mt-2" :options="FretusFolks::getStatus()" :value="request()->status" />
                        </div>
                        <div class="row">
                            <div class="col-lg-4 mt-4">
                                <x-forms.button type="submit" label="Search" class="btn btn-primary"
                                    size="col-lg-4 mt-2" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="datatable-scroll">
            <div class="table-responsive">
                <table class="table datatable-basic table-bordered table-striped table-hover dataTable no-footer"
                    id="get_details">
                    <thead>
                        <tr>
                            @if (count($selectedData) > 0)
                                <th>Sl NO</th>
                                @foreach ($selectedData as $field)
                                    <th style="white-space: nowrap;">{{ ucwords(str_replace('_', ' ', $field)) }}</th>
                                @endforeach
                                <th>Action</th>
                            @else
                                <th>Sl NO</th>
                                <th>Client Name</th>
                                <th>Invoice No</th>
                                <th>Location</th>
                                <th>GST No</th>
                                <th>Grand Total</th>
                                <th>Invoice Date</th>
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($results as $result)
                            <tr>
                                @if (count($selectedData) > 0)
                                    <td>{{ $loop->iteration }}</td>
                                    @foreach ($selectedData as $field)
                                        <td style="white-space: nowrap;">
                                            @switch($field)
                                                @case('client_id')
                                                    {{ $result->client?->client_name }}
                                                @break

                                                @case('service_location')
                                                    {{ $result->state?->state_name }}
                                                @break

                                                @case('date')
                                                    {{ !empty($result->date) ? date('d-m-Y', strtotime($result->date)) : 'N/A' }}
                                                @break

                                                @default
                                                    {{ $result->$field }}
                                            @endswitch
                                        </td>
                                    @endforeach
                                    <td>
                                        <div class="dropdown pop_Up dropdown_bg">
                                            <div class="dropdown-toggle" id="dropdownMenuButton-{{ $result->id }}"
                                                data-bs-toggle="dropdown" aria-expanded="true">
                                                Action
                                            </div>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1"
                                                style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(-95px, -25.4219px);"
                                                data-popper-placement="top-end">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.fcms.cims.edit', $result) }}">
                                                        <i class='bx bx-pencil'></i>
                                                        Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        onclick="return confirm('Are you sure to delete this ?')"
                                                        href="{{ route('admin.cms.esic.delete', $result) }}">
                                                        <i class='bx bx-trash-alt'></i>
                                                        Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                @else
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $result->client?->client_name }}</td>
                                    <td>{{ $result->invoice_no }}</td>
                                    <td>{{ $result->state?->state_name }}</td>
                                    <td>{{ $result->gst_no }}</td>
                                    <td>{{ $result->grand_total }}</td>
                                    <td>
                                        {{ !empty($result->date) ? date('d-m-Y', strtotime($result->date)) : 'N/A' }}
                                    </td>
                                    <td>
                                        <div class="dropdown pop_Up dropdown_bg">
                                            <div class="dropdown-toggle" id="dropdownMenuButton-{{ $result->id }}"
                                                data-bs-toggle="dropdown" aria-expanded="true">
                                                Action
                                            </div>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1"
                                                style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(-95px, -25.4219px);"
                                                data-popper-placement="top-end">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.fcms.cims.edit', $result) }}">
                                                        <i class='bx bx-pencil'></i>
                                                        Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        onclick="return confirm('Are you sure to delete this ?')"
                                                        href="{{ route('admin.cms.esic.delete', $result) }}">
                                                        <i class='bx bx-trash-alt'></i>
                                                        Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No records found.</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                    {{ $results->withQueryString()->links() }}
                </div>
            </div>
        </div>
        @push('scripts')
            <script>
                function updateSelectedCount(checkboxClass, dropdownInputId, defaultText) {
                    const checkboxes = document.querySelectorAll(checkboxClass);
                    const dropdownInput = document.querySelector(dropdownInputId);
                    const selectedCount = Array.from(checkboxes).filter(cb => cb.checked).length;

                    dropdownInput.value = selectedCount > 0 ? `${selectedCount} selected` : defaultText;
                    const selectAllCheckbox = document.querySelector(checkboxClass.includes('data') ? '#select_all_data' :
                        '#select_all_states');
                    selectAllCheckbox.checked = selectedCount === checkboxes.length;
                }

                function toggleSelectAll(selectAllCheckbox, checkboxClass, dropdownInputId, defaultText) {
                    const checkboxes = document.querySelectorAll(checkboxClass);
                    const isChecked = selectAllCheckbox.checked;

                    checkboxes.forEach(cb => cb.checked = isChecked);
                    updateSelectedCount(checkboxClass, dropdownInputId, defaultText);
                }

                document.getElementById('export-form').addEventListener('submit', function(e) {
                    const selectedFields = Array.from(document.querySelectorAll('.data-checkbox:checked'))
                        .map(checkbox => checkbox.value);
                    document.getElementById('export-fields').value = selectedFields.join(',');
                    if (selectedFields.length === 0) {
                        e.preventDefault();
                        alert('Please select at least one field for export.');
                    }
                });
            </script>
        @endpush
    </x-applayout>
