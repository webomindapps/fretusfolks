<x-applayout>
    <x-admin.breadcrumb title="Candidate Lifecycle">
        <div class="text-end me-3">
            <form id="export-form" action="{{ route('admin.exportFilteredReport') }}" method="GET">
                @csrf
                <input type="hidden" name="from_date" value="{{ $fromDate }}">
                <input type="hidden" name="to_date" value="{{ $toDate }}">
                <input type="hidden" name="search_query" value="{{ $search_query }}">
                @foreach ($selectedData as $id)
                    <input type="hidden" name="data[]" value="{{ $id }}">
                @endforeach
                <button type="submit" class="btn btn-success">Export to Excel</button>
            </form>
        </div>
    </x-admin.breadcrumb>

    <div class="content">
        <div class="row">
            <div class="col-lg-12 pb-4 ">
                <div class="form-card px-md-3 px-2">
                    <form id="my_form" action="{{ route('admin.candidatelifecycle') }}" method="GET"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <x-forms.input label="From Date" type="date" name="from_date" id="from-date"
                                :required="false" size="col-lg-2 mt-2" :value="request()->from_date" />
                            <x-forms.input label="To Date" type="date" name="to_date" id="to-date"
                                :required="false" size="col-lg-2 mt-2" :value="request()->to_date" />
                            <div class="col-lg-4 mt-2">
                                <label for="data">Client Name</label>
                                <div class="dropdown">
                                    <input type="text" class="btn dropdown-toggle text-start" id="dropdownMenuButton"
                                        data-bs-toggle="dropdown" aria-expanded="false" readonly
                                        value="Select Client" />

                                    <ul class="dropdown-menu p-2" aria-labelledby="dropdownMenuButton"
                                        style="max-height: 300px; overflow-y: auto; min-width: 250px;">
                                        {{-- Search box --}}
                                        <li class="mb-2">
                                            <input type="text" class="form-control" placeholder="Search..."
                                                onkeyup="filterClientList(this)">
                                        </li>

                                        {{-- Select All --}}
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="select_all_data"
                                                    onchange="toggleSelectAll(this, '.data-checkbox', '#dropdownMenuButton', 'Select Client')">
                                                <label class="form-check-label" for="select_all_data">Select All</label>
                                            </div>
                                        </li>

                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>

                                        {{-- Client list --}}
                                        @foreach (FretusFolks::getClientname() as $option)
                                            <li class="client-option">
                                                <div class="form-check">
                                                    <input class="form-check-input data-checkbox" type="checkbox"
                                                        name="data[]" value="{{ $option['value'] }}"
                                                        id="data_{{ $loop->index }}" data-name="{{ $option['label'] }}"
                                                        onchange="updateSelectedNames('.data-checkbox', '#dropdownMenuButton', 'Select Client')">
                                                    <label class="form-check-label"
                                                        for="data_{{ $loop->index }}">{{ $option['label'] }}</label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-3 mt-2">
                                <label for="search_query">Search</label>
                                <input type="text" class="form-control" name="search_query" id="search_query"
                                    placeholder="Enter Name, FFI Emp ID, Phone, or Email"
                                    value="{{ request()->search_query }}">
                            </div>

                            <div class="row">
                                <div class="col-lg-4 mt-4">
                                    <x-forms.button type="submit" label="Search" class="btn btn-primary"
                                        size="col-lg-4 mt-2" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table datatable-basic table-bordered table-striped table-hover dataTable no-footer"
                id="get_details">
                <thead>
                    <tr>
                        <th>Sl NO</th>
                        <th>Client Name</th>
                        <th>Client ID</th>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($results as $key=>$result)
                        <tr>
                            {{-- {{ dd($result) }} --}}
                            <td>{{ $results->firstItem() + $key }}</td>
                            <td>{{ $result->entity_name }}</td>
                            <td>{{ $result->client_emp_id }}</td>
                            <td>{{ $result->ffi_emp_id }}</td>
                            <td>
                                {{ trim("{$result->emp_name} {$result->middle_name} {$result->last_name}") ?: 'N/A' }}
                            </td>
                            <td>{{ $result->phone1 }}</td>
                            <td>{{ $result->email }}</td>

                            <td>
                                <div class="dropdown pop_Up dropdown_bg">
                                    <div class="dropdown-toggle" id="dropdownMenuButton-{{ $result->id }}"
                                        data-bs-toggle="dropdown" aria-expanded="true">
                                        Action
                                    </div>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1"
                                        style=" inset: auto auto 0px 0px; margin: 0px; transform: translate(-95px, -25.4219px);"
                                        data-popper-placement="top-end">
                                        <li>
                                            <a href="{{ route('admin.candidatelifecycle.view', $result->id) }}"
                                                class="dropdown-item">
                                                <i class='bx bx-link-alt'></i> View
                                            </a>
                                            <a class="dropdown-item"
                                                href="{{ route('admin.candidatemaster.download', $result->id) }}">
                                                <i class='bx bxs-download'></i>
                                                Download pdf
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No records found.</td>
                        </tr>
                    @endforelse
                </tbody>


            </table>
        </div>

        <div class="mt-3">
            {{ $results->withQueryString()->links() }}
        </div>
    </div>
    <x-model1 />
    @push('scripts')
        <script>
            function updateSelectedNames(checkboxClass, dropdownInputId, defaultText) {
                const checkboxes = document.querySelectorAll(checkboxClass);
                const dropdownInput = document.querySelector(dropdownInputId);

                const selectedLabels = Array.from(checkboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.getAttribute('data-name'));

                dropdownInput.value = selectedLabels.length > 0 ? selectedLabels.join(', ') : defaultText;

                // Handle Select All
                const selectAllCheckbox = document.querySelector('#select_all_data');
                selectAllCheckbox.checked = selectedLabels.length === checkboxes.length;
            }

            function toggleSelectAll(selectAllCheckbox, checkboxClass, dropdownInputId, defaultText) {
                const dropdown = selectAllCheckbox.closest('.dropdown-menu');
                const checkboxes = dropdown.querySelectorAll(checkboxClass);
                const isChecked = selectAllCheckbox.checked;

                checkboxes.forEach(cb => cb.checked = isChecked);
                updateSelectedNames(checkboxClass, dropdownInputId, defaultText);
            }

            function filterClientList(input) {
                const filter = input.value.toLowerCase();
                const items = document.querySelectorAll('.client-option');

                items.forEach(item => {
                    const label = item.textContent.toLowerCase();
                    item.style.display = label.includes(filter) ? '' : 'none';
                });
            }


            // function showCandidateDetails(employeeId) {
            //     fetch(`/admin/candidatelifecycle/view/${employeeId}`)
            //         .then(response => response.json())
            //         .then(data => {
            //             if (data.html_content) {
            //                 document.querySelector('#client_details').innerHTML = data.html_content;
            //                 $('#client_details').modal('show');
            //                 const closeButton = document.querySelector('#closeModalButton');
            //                 if (closeButton) {
            //                     closeButton.addEventListener('click', function() {
            //                         $('#client_details').modal('hide');
            //                     });
            //                 }
            //             } else {
            //                 console.error('No HTML content found in the response');
            //             }
            //         })
            //         .catch(error => {
            //             console.error('Error fetching client details:', error);
            //         });
            // }

            document.getElementById('export-form').addEventListener('submit', function(e) {
                const selectedFields = Array.from(document.querySelectorAll('.data-checkbox:checked'))
                    .map(checkbox => checkbox.value);
                document.getElementById('export-fields').value = selectedFields.join(',');

                document.getElementById('export-from-date').value = document.querySelector('#from-date').value;
                document.getElementById('export-to-date').value = document.querySelector('#to-date').value;

            });
        </script>
    @endpush
    <style>
        .table-responsive {
            max-height: 500px;
            /* Adjust height as needed */
        }

        .table-responsive thead th {
            position: sticky;
            top: 0;
            background-color: #fff;
            /* Ensure background covers content below */
            z-index: 10;
        }
    </style>
</x-applayout>
