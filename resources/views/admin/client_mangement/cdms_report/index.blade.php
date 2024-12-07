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
                    <form id="my_form" action="{{ route('admin.cdms_report') }}" method="GET"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <x-forms.input label="From Date" type="date" name="from-date" id="from-date"
                                :required="false" size="col-lg-4 mt-2" :value="request()->fromdate" />

                            <x-forms.input label="To Date" type="date" name="to-date" id="to-date"
                                :required="false" size="col-lg-4 mt-2" :value="request()->todate" />
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
                                                        name="service_state[]" value="{{ $option['value'] }}"
                                                        id="service_state_{{ $loop->index }}"
                                                        onchange="updateSelectedCount('.state-checkbox', '#dropdownMenuButtonState', 'Select State')">
                                                    <label class="form-check-label"
                                                        for="service_state_{{ $loop->index }}">{{ $option['label'] }}</label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <x-forms.select label="Region" name="region" id="region" :required="false"
                                size="col-lg-4 mt-2" :options="FretusFolks::getRegion()" :value="old('region', request()->region)" />

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
                                        <td>{{ $result->$field }}</td>
                                    @endforeach
                                    <td>
                                        <a href="javascript:void(0);" class="btn btn-info"
                                            data-target="#client_details"
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
                                        <a href="javascript:void(0);" class="btn btn-info"
                                            data-target="#client_details"
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
                fetch(`/admin/cdms/show/${clientId}`)
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
                if (selectedFields.length === 0) {
                    e.preventDefault();
                    alert('Please select at least one field for export.');
                }
            });
        </script>
    @endpush
</x-applayout>
