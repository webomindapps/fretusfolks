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
                <div class="form-card px-3">
                    <form id="my_form" action="{{ route('admin.candidatelifecycle') }}" method="GET"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <x-forms.input label="From Date" type="date" name="from_date" id="from-date"
                                :required="false" size="col-lg-3 mt-2" :value="request()->from_date" />
                            <x-forms.input label="To Date" type="date" name="to_date" id="to-date"
                                :required="false" size="col-lg-3 mt-2" :value="request()->to_date" />
                            <div class="col-lg-3 mt-2">
                                <label for="data">Client Name</label>
                                <div class="dropdown">
                                    <input type="text" class="btn dropdown-toggle" id="dropdownMenuButton"
                                        data-bs-toggle="dropdown" aria-expanded="false" readonly
                                        value="Select Client" />
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
                                        @foreach (FretusFolks::getClientname() as $option)
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
        <div class="datatable-scroll">
            <div class="table-responsive">
                <table class="table datatable-basic table-bordered table-striped table-hover dataTable no-footer"
                    id="get_details">
                    <thead>
                        <tr>
                            <th>Sl NO</th>
                            <th>Client Name</th>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($results as $result)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $result->entity_name }}</td>
                                <td>{{ $result->ffi_emp_id }}</td>
                                <td>{{ $result->emp_name }}</td>
                                <td>{{ $result->phone1 }}</td>
                                <td>{{ $result->email }}</td>
                                <td>
                                    <a href="{{ route('admin.candidatelifecycle.view', $result->id) }}"
                                        class="btn btn-info">
                                        <i class='bx bx-link-alt'></i> View
                                    </a>
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
                const selectAllCheckbox = document.querySelector('#select_all_data');
                selectAllCheckbox.checked = selectedCount === checkboxes.length;
            }

            function toggleSelectAll(selectAllCheckbox, checkboxClass, dropdownInputId, defaultText) {
                const dropdown = selectAllCheckbox.closest('.dropdown-menu');
                const checkboxes = dropdown.querySelectorAll(checkboxClass);
                const isChecked = selectAllCheckbox.checked;

                checkboxes.forEach(cb => cb.checked = isChecked);
                updateSelectedCount(checkboxClass, dropdownInputId, defaultText);
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
</x-applayout>
