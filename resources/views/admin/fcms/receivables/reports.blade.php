<x-applayout>
    <x-admin.breadcrumb title="Search">
        <div class="row text-end me-2">
            <form id="export-form" action="{{ route('admin.receivable.export') }}" method="POST">
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
                            <x-forms.input label="From Date" type="date" name="from_date" id="from-date"
                                :required="false" size="col-lg-4 mt-2" :value="request()->from_date" />
                            <x-forms.input label="To Date" type="date" name="to_date" id="to-date"
                                :required="false" size="col-lg-4 mt-2" :value="request()->to_date" />
                            <div class="col-lg-4 mt-2">
                                <label for="client">Client Name</label>
                                <div class="dropdown">
                                    <input type="text" class="btn dropdown-toggle" id="dropdownMenuButtonclient"
                                        data-bs-toggle="dropdown" aria-expanded="false" readonly
                                        value="Select client" />
                                    <ul class="dropdown-menu ps-3" aria-labelledby="dropdownMenuButtonclient">
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="select_all_client"
                                                    onchange="toggleSelectAll(this, '.client-checkbox', '#dropdownMenuButtonclient', 'Select client')">
                                                <label class="form-check-label" for="select_all_client">Select
                                                    All</label>
                                            </div>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        @foreach ($clients as $client)
                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input client-checkbox" type="checkbox"
                                                        name="client_id[]" value="{{ $client->id }}"
                                                        id="client_{{ $loop->index }}"
                                                        onchange="updateSelectedCount('.client-checkbox', '#dropdownMenuButtonclient', 'Select client')">

                                                    <label class="form-check-label"
                                                        for="client_{{ $loop->index }}">{{ $client->client_name }}</label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
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
                                        @foreach (FretusFolks::getReciveablesdata() as $option)
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
                                <label for="service_location">State</label>
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
                                <th>Invoice Amount</th>
                                <th>TDS Amount</th>
                                <th>Total Amount</th>
                                <th>Payment Date</th>
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
                                                @case('client_name')
                                                    {{ $result->client?->client_name }}
                                                @break

                                                @case('date')
                                                    {{ !empty($result->invoice?->date) ? date('d-m-Y', strtotime($result->invoice?->date)) : 'N/A' }}
                                                @break

                                                @case('invoice_no')
                                                    {{ $result->invoice?->invoice_no ?? 'N/A' }}
                                                @break

                                                @case('state_name')
                                                    {{ $result->invoice?->state?->state_name }}
                                                @break

                                                @case('code')
                                                    {{ $result->tds?->code ?? 'N/A' }}
                                                @break

                                                @default
                                                    {{ $result->$field ?? 'N/A' }}
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
                                                    <a href="javascript:void(0);" class="dropdown-item"
                                                        data-toggle="modal" data-target="#client_details"
                                                        onclick="showClientDetails({{ $result->id }})">
                                                        <i class='bx bx-link-alt'></i>
                                                        View Details
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>
                                    </td>
                                @else
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $result->client?->client_name }}</td>
                                    <td>{{ $result->invoice?->invoice_no ?? 'N/A' }}</td>
                                    <td>{{ $result->total_amt_gst }}</td>
                                    <td>{{ $result->tds_amount }}</td>
                                    <td>{{ $result->amount_received }}</td>
                                    <td>{{ $result->payment_received_date }}</td>

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
                                                    <a href="javascript:void(0);" class="dropdown-item"
                                                        data-toggle="modal" data-target="#client_details"
                                                        onclick="showClientDetails({{ $result->id }})">
                                                        <i class='bx bx-link-alt'></i>
                                                        View Details
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No records found.</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                    {{ $results->withQueryString()->links() }}
                </div>
            </div>
        </div>
        <x-model1 />

        @push('scripts')
            <script>
                function updateSelectedCount(checkboxClass, dropdownInputId, defaultText) {
                    const checkboxes = document.querySelectorAll(checkboxClass);
                    const dropdownInput = document.querySelector(dropdownInputId);
                    const selectedCount = Array.from(checkboxes).filter(cb => cb.checked).length;

                    dropdownInput.value = selectedCount > 0 ? `${selectedCount} selected` : defaultText;

                    const selectAllCheckbox = document.querySelector('#select_all_client');
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

                function showClientDetails(clientId) {
                    fetch(`/admin/receivable/show/${clientId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.html_content) {
                                document.querySelector('#client_details').innerHTML = data.html_content;
                                $('#client_details').modal('show');
                                const closeButton = document.querySelector('#closeModalButton');
                                if (closeButton) {
                                    closeButton.addEventListener('click', function() {
                                        $('#client_details').modal('hide');
                                    });
                                }
                            } else {
                                console.error('No HTML content found in the response');
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching client details:', error);
                        });
                }
            </script>
        @endpush
    </x-applayout>
