<x-applayout>
    @if (session('complete'))
        <div class="alert alert-success">

            {{ session('complete') }}
            

            @if (session('zip_file'))
                <br>
                <a class="btn btn-sm btn-primary mt-2" href="{{ route('admin.download.zip', session('zip_file')) }}">
                    Click here to download
                </a>
            @endif
        </div>
    @endif

    <x-admin.breadcrumb title="Offer cum Appointment Letter" :create="route('admin.offer_letter.create')">
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-info ms-2 mt-2" data-bs-toggle="modal"
                data-bs-target="#bulkDownloadModal">
                Bulk Download
            </button>
        </div>
    </x-admin.breadcrumb>

    <div class="row mt-2">
        <div class="d-flex justify-content-end align-items-center">
            <div class="d-flex gap-3">
                <a href="{{ asset('admin/letters/offer_letter.xlsx') }}" download="Offer_Letter.xlsx"
                    class="btn btn-primary text-white">
                    <i class='bx bxs-download'></i> Download Sample
                </a>

                <form action="{{ route('admin.offer_letter.bulkimport') }}" method="POST" enctype="multipart/form-data"
                    class="d-flex align-items-center">
                    @csrf
                    <input type="file" class="form-control form-control-sm me-2" name="file" required>
                    <button type="submit" class="add-btn bg-success text-white">Import</button>
                </form>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            @php
                $columns = [
                    ['label' => 'SL No', 'column' => 'id', 'sort' => true],
                    ['label' => 'Employee ID', 'column' => 'employee_id', 'sort' => true],
                    ['label' => 'Emp Name', 'column' => 'emp_name', 'sort' => true],
                    ['label' => 'Client Id', 'column' => 'client_emp_id', 'sort' => false],
                    ['label' => 'Client Name', 'column' => 'entity_name', 'sort' => true],
                    ['label' => 'Offer Letter Created On', 'column' => 'date', 'sort' => true],
                    ['label' => 'Phone', 'column' => 'phone1', 'sort' => true],
                    ['label' => 'Email', 'column' => 'email', 'sort' => true],
                    ['label' => 'Actions', 'column' => 'action', 'sort' => false],
                ];
            @endphp
            <x-table :columns="$columns" :data="$offer" :checkAll=false :bulk="route('admin.ffi_offer_letter.bulk')" :route="route('admin.offer_letter')">
                @foreach ($offer as $key => $item)
                    <tr>

                        <td>{{ $offer->firstItem() + $key }}</td>
                        <td>{{ $item->employee_id ?? 'N/A' }}</td>
                        <td>{{ $item->emp_name }}</td>
                        <td>{{ $item->employee ? $item->employee->client_emp_id : 'N/A' }}</td>
                        <td>{{ $item->entity_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                        <td>{{ $item->phone1 }}</td>
                        <td>{{ $item->email }}</td>
                        <td>
                            <div class="dropdown pop_Up dropdown_bg">
                                <div class="dropdown-toggle" id="dropdownMenuButton-{{ $item->id }}"
                                    data-bs-toggle="dropdown" aria-expanded="true">
                                    Action
                                </div>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <a href="{{ route('admin.generate.offer.letter', ['id' => $item->id]) }}"
                                            target="_blank" class="dropdown-item">
                                            <i class="bx bx-link-alt"></i> View Details
                                        </a>

                                        <a class="dropdown-item"
                                            onclick="return confirm('Are you sure to delete this?')"
                                            href="{{ route('admin.offer_letter.delete', $item) }}">
                                            <i class='bx bx-trash-alt'></i> Delete
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-table>
        </div>
    </div>
    <div class="modal fade" id="bulkDownloadModal" tabindex="-1" aria-labelledby="bulkDownloadModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.offer_letter.bulk_download') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="bulkDownloadModalLabel">Bulk Download Filters</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <!-- From Date -->
                            <div class="col-lg-6 mb-3">
                                <label for="fromdate">From Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="fromdate" id="fromdate" required>
                            </div>

                            <!-- To Date -->
                            <div class="col-lg-6 mb-3">
                                <label for="todate">To Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="todate" id="todate" required>
                            </div>

                            <!-- Client Dropdown (Your Existing Code) -->

                            <div class="col-lg-6 mt-4" id="form-group-state">
                                <label for="clientDropdown">Select Client <span style="color: red">*</span></label>

                                <div class="dropdown">
                                    <input type="text" class="form-select dropdown-toggle text-start"
                                        id="clientDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                                        type="button" readonly value="{{ old('client_name', 'Select') }}">

                                    <ul class="dropdown-menu p-2 w-100" aria-labelledby="clientDropdown"
                                        style="max-height: 300px; overflow-y: auto; min-width: 100%;">

                                        <!-- Search input -->
                                        <li class="mb-2">
                                            <input type="text" class="form-control" placeholder="Search..."
                                                onkeyup="filterClientList(this)">
                                        </li>

                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>

                                        <!-- Client options -->
                                        @foreach ($clients as $client)
                                            <li class="client-option">
                                                <div class="form-check">
                                                    <input class="form-check-input client-radio" type="radio"
                                                        name="client_radio" id="client_{{ $client->id }}"
                                                        value="{{ $client->id }}"
                                                        data-name="{{ $client->client_name }}"
                                                        onchange="selectClient(this)"
                                                        {{ old('client_id') == $client->id ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="client_{{ $client->id }}">
                                                        {{ $client->client_name }}
                                                    </label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <!-- Hidden input for selected client ID -->
                                <input type="hidden" name="client_id" id="selected_client_id"
                                    value="{{ old('client_id') }}" required>
                            </div>


                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Download</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function selectClient(radio) {
                const clientName = radio.getAttribute('data-name');
                const clientId = radio.value;

                document.getElementById('clientDropdown').value = clientName;
                document.getElementById('selected_client_id').value = clientId;

                // Close the dropdown manually
                const dropdown = bootstrap.Dropdown.getOrCreateInstance(document.getElementById('clientDropdown'));
                dropdown.hide();
            }

            function filterClientList(input) {
                const filter = input.value.toLowerCase();
                const options = document.querySelectorAll('.client-option');

                options.forEach(option => {
                    const label = option.innerText.toLowerCase();
                    option.style.display = label.includes(filter) ? '' : 'none';
                });
            }
        </script>
    @endpush
</x-applayout>
