<x-applayout>
    <x-admin.breadcrumb title="Search">
        <div class="text-end me-3">
            <form id="export-form" action="{{ route('admin.fhrms_report.export') }}" method="POST">
                @csrf
                <input type="hidden" name="fields" id="export-fields">
                <input type="hidden" name="from_date" id="export-from-date">
                <input type="hidden" name="to_date" id="export-to-date">
                <input type="hidden" name="state" id="export-states">
                <input type="hidden" name="pending_doc" id="export-document">
                <input type="hidden" name="location" id="export-location">
                <input type="hidden" name="status" id="export-status">
                <button type="submit" class="btn btn-success">Export to Excel</button>
            </form>
        </div>
    </x-admin.breadcrumb>
    <div class="content">
        <div class="row">
            <div class="col-lg-12 pb-4 ">
                <div class="form-card px-md-3 px-2">
                    <form id="my_form" action="{{ route('admin.fhrms_report') }}" method="GET"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <x-forms.input label="From Date" type="date" name="from_date" id="from-date"
                                :required="false" size="col-lg-3 mt-2" :value="request()->from_date" />
                            <x-forms.input label="To Date" type="date" name="to_date" id="to-date"
                                :required="false" size="col-lg-3 mt-2" :value="request()->to_date" />
                            <div class="col-lg-3 mt-2">
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
                                        @foreach (FretusFolks::getFHRMSData() as $option)
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

                            <div class="col-lg-3 mt-2">
                                <label for="state">State</label>
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
                                                        name="state[]" value="{{ $option['value'] }}"
                                                        id="state_{{ $loop->index }}"
                                                        onchange="updateSelectedCount('.state-checkbox', '#dropdownMenuButtonState', 'Select State')">
                                                    <label class="form-check-label"
                                                        for="state_{{ $loop->index }}">{{ $option['label'] }}</label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <x-forms.select label="Location" name="location" id="location" :required="false"
                                size="col-lg-4 mt-2" :options="FretusFolks::getLocation()" :value="old('location', request()->location)" />

                            <div class="col-lg-3 mt-2">
                                <label for="pending_doc">Pending Documents</label>
                                <div class="dropdown">
                                    <input type="text" class="btn dropdown-toggle" id="dropdownMenuButtonDocument"
                                        data-bs-toggle="dropdown" aria-expanded="false" readonly
                                        value="Select Document" />
                                    <ul class="dropdown-menu ps-3" aria-labelledby="dropdownMenuButtonDocument">
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select_all_pending_doc"
                                                    onchange="toggleSelectAll(this, '.document-checkbox', '#dropdownMenuButtonDocument', 'Select Document')">
                                                <label class="form-check-label" for="select_all_pending_doc">Select
                                                    All</label>
                                            </div>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        @foreach (FretusFolks::getDocuments() as $option)
                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input document-checkbox" type="checkbox"
                                                        name="pending_doc[]" value="{{ $option['value'] }}"
                                                        id="pending_doc_{{ $loop->index }}"
                                                        onchange="updateSelectedCount('.document-checkbox', '#dropdownMenuButtonDocument', 'Select Document')">
                                                    <label class="form-check-label"
                                                        for="pending_doc_{{ $loop->index }}">{{ $option['label'] }}</label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <x-forms.select label="Status:" name="status" id="status" :required="false"
                                size="col-lg-4 mt-2" :options="FretusFolks::getStatus()" :selected="request()->get('status')" :value="old('status', request()->status)" />
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
                                <th>Employee ID</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Department</th>
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
                                                @case('state')
                                                    {{ $result->stateRelation?->state_name }}
                                                @break

                                                @default
                                                    {{ $result->$field ?? 'N/A' }}
                                            @endswitch
                                        </td>
                                    @endforeach
                                    <td>
                                        <a href="javascript:void(0);" class="btn btn-info"
                                            data-target="#client_details"
                                            onclick="showEmployeeDetails({{ $result->id }})">
                                            <i class='bx bx-link-alt'></i> View
                                        </a>
                                    </td>
                                @else
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $result->ffi_emp_id }}</td>
                                    <td>{{ $result->emp_name }}</td>
                                    <td>{{ $result->designation }}</td>
                                    <td>{{ $result->department }}</td>
                                    <td> {{ ucfirst($result->status == 1 ? 'Active' : 'Inactive') }}
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);" class="btn btn-info"
                                            data-target="#client_details"
                                            onclick="showEmployeeDetails({{ $result->id }})">
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
                    const dropdown = selectAllCheckbox.closest('.dropdown-menu');
                    const checkboxes = dropdown.querySelectorAll(checkboxClass);
                    const isChecked = selectAllCheckbox.checked;

                    checkboxes.forEach(cb => cb.checked = isChecked);
                    updateSelectedCount(checkboxClass, dropdownInputId, defaultText);
                }


                function showEmployeeDetails(clientId) {
                    fetch(`/admin/fhrms/show/${clientId}`)
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

                document.getElementById('export-form').addEventListener('submit', function(e) {
                    const selectedFields = Array.from(document.querySelectorAll('.data-checkbox:checked'))
                        .map(checkbox => checkbox.value);
                    document.getElementById('export-fields').value = selectedFields.join(',');

                    document.getElementById('export-from-date').value = document.querySelector('#from-date').value;
                    document.getElementById('export-to-date').value = document.querySelector('#to-date').value;

                    const selectedStates = Array.from(document.querySelectorAll('.state-checkbox:checked'))
                        .map(checkbox => checkbox.value);
                    document.getElementById('export-states').value = selectedStates.join(',');

                    const selectedDocument = Array.from(document.querySelectorAll('.document-checkbox:checked'))
                        .map(checkbox => checkbox.value);
                    document.getElementById('export-document').value = selectedDocument.join(',');

                    document.getElementById('export-location').value = document.querySelector('#location').value;
                    document.getElementById('export-status').value = document.querySelector('#status').value;

                    if (selectedFields.length === 0) {
                        e.preventDefault();
                        alert('Please select at least one field for export.');
                    }
                });
            </script>
        @endpush
    </x-applayout>
