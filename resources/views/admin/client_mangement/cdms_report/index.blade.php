<x-applayout>
    <x-admin.breadcrumb title="Search">
        <div class="row text-end me-2">
            <form id="export-form" action="{{ route('admin.cdms_report.export') }}" method="POST">
                @csrf
                <input type="hidden" name="fields" id="export-fields">
                <input type="hidden" name="from_date" id="export-from-date">
                <input type="hidden" name="to_date" id="export-to-date">
                <input type="hidden" name="states" id="export-states">
                <input type="hidden" name="region" id="export-region">
                <input type="hidden" name="status" id="export-status">
                <button type="submit" class="btn btn-success">Export to Excel</button>

            </form>
        </div>
    </x-admin.breadcrumb>
    <div class="content">
        <div class="row">
            <div class="col-lg-12 pb-4 ">
                <div class="form-card px-md-3 px-2">
                    <form id="my_form" action="{{ route('admin.cdms_report') }}" method="GET"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <x-forms.input label="From Date" type="date" name="from_date" id="from-date"
                                :required="false" size="col-lg-4 mt-2" :value="request()->from_date" />

                            <x-forms.input label="To Date" type="date" name="to_date" id="to-date" :required="false"
                                size="col-lg-4 mt-2" :value="request()->to_date" />
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
                                        @foreach (FretusFolks::getData() as $option)
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input data-checkbox" type="checkbox"
                                                    name="data[]" value="{{ $option['value'] }}"
                                                    id="data_{{ $loop->index }}"
                                                    onchange="updateSelectedCount('.data-checkbox', '#dropdownMenuButton', 'Select Data')">
                                                <label class="form-check-label" for="data_{{ $loop->index }}">{{
                                                    $option['label'] }}</label>
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
                                                    name="service_state[]" value="{{ $option['value'] }}"
                                                    id="service_state_{{ $loop->index }}"
                                                    onchange="updateSelectedCount('.state-checkbox', '#dropdownMenuButtonState', 'Select State')">
                                                <label class="form-check-label"
                                                    for="service_state_{{ $loop->index }}">{{ $option['label']
                                                    }}</label>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <x-forms.select label="Region" name="region" id="region" :required="false"
                                size="col-lg-4 mt-2" :options="FretusFolks::getRegion()"
                                :value="old('region', request()->region)" />

                            <x-forms.select label="Status:" name="status" id="status" :required="false"
                                size="col-lg-4 mt-2" :options="FretusFolks::getStatus()"
                                :selected="request()->get('status')" :value="old('status', request()->status)" />
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
                            <th>{{ ucwords(str_replace('_', ' ', $field)) }}</th>
                            @endforeach
                            <th>Action</th>
                            @else
                            <th>Sl NO</th>
                            <th>Client ID</th>
                            <th>Client Name</th>
                            <th>Email</th>
                            <th>Contact Person</th>
                            <th>Status</th>
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
                                @case('service_state')
                                {{ $result->state?->state_name }}
                                @break

                                @case('contract_start')
                                {{ \Carbon\Carbon::parse($result->contract_start)->format('d-m-Y') }}
                                @break

                                @case('contract_end')
                                {{ \Carbon\Carbon::parse($result->contract_date)->format('d-m-Y') }}
                                @break

                                @default
                                {{ $result->$field ?? 'N/A' }}
                                @endswitch
                            </td>
                            @endforeach
                            <td>
                                <a href="javascript:void(0);" class="btn btn-info" data-target="#client_details"
                                    onclick="showClientDetails({{ $result->id }})">
                                    <i class='bx bx-link-alt'></i> View
                                </a>
                            </td>
                            @else
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $result->client_code }}</td>
                            <td>{{ $result->client_name }}</td>
                            <td>{{ $result->client_email }}</td>
                            <td>{{ $result->contact_person }}</td>
                            <td>{{ ucfirst($result->status == 1 ? 'In-Active' : 'Active') }}</td>
                            <td>
                                <a href="javascript:void(0);" class="btn btn-info" data-target="#client_details"
                                    onclick="showClientDetails({{ $result->id }})">
                                    <i class='bx bx-link-alt'></i> View
                                </a>
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
            </div>
        </div>
        <div class="mt-3">
            {{ $results->withQueryString()->links() }}
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

        function showClientDetails(clientId) {
            fetch(`{{url('/')}}/admin/cdms/show/${clientId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.html_content) {
                        document.querySelector('#client_details').innerHTML = data.html_content;
                        $('#client_details').modal('show');
                        const closeButton = document.querySelector('#closeModalButton');
                        if (closeButton) {
                            closeButton.addEventListener('click', function () {
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

        document.getElementById('export-form').addEventListener('submit', function (e) {
            // Get selected fields from checkboxes with class 'data-checkbox'
            const selectedFields = Array.from(document.querySelectorAll('.data-checkbox:checked'))
                .map(checkbox => checkbox.value);
            document.getElementById('export-fields').value = selectedFields.join(',');

            document.getElementById('export-from-date').value = document.querySelector('#from-date').value;
            document.getElementById('export-to-date').value = document.querySelector('#to-date').value;

            const selectedStates = Array.from(document.querySelectorAll('.state-checkbox:checked'))
                .map(checkbox => checkbox.value);
            document.getElementById('export-states').value = selectedStates.join(',');

            document.getElementById('export-region').value = document.querySelector('#region').value;
            document.getElementById('export-status').value = document.querySelector('#status').value;

            if (selectedFields.length === 0) {
                e.preventDefault();
                alert('Please select at least one field for export.');
            }
        });
    </script>
    @endpush
</x-applayout>