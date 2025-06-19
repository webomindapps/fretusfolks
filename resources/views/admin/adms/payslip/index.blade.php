<x-applayout>
    <x-admin.breadcrumb title=" Payslips" />

    <div class="p-2">
        <p id="payslip-completed" class="text-success"></p>
        <div id="progress-bar-container" style="display: none;">
            <p id="progress-text"></p>
            <progress id="progress-bar" value="0" max="100" class="w-100"></progress>
        </div>
        <hr class="mt-2">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="upload-tab" data-toggle="tab" href="#upload" role="tab"
                    aria-controls="upload" aria-selected="true">Upload Payslips</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="download-tab" data-toggle="tab" href="#download" role="tab"
                    aria-controls="download" aria-selected="false">Download Payslips</a>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <!-- Upload Payslips Tab -->
            <div class="tab-pane fade show active" id="upload" role="tabpanel" aria-labelledby="upload-tab">
                <div class="card-header">
                    <h5 class="card-title">Download format</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.payslips') }}" method="GET">
                        <div class="row">
                            <div class="col-lg-3 mt-2">
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


                            <div class="col-lg-2 mt-4">
                                <a class="btn btn-info  w-20 text-white mt-3" id="downloadFilteredCSV"
                                    download="payslip_format.xlsx">
                                    Download Sample
                                </a>
                            </div>
                        </div>
                    </form>

                </div>

                <div class="card-header">
                    <h5 class="card-title">Upload Payslips</h5>
                </div>


                <form action="{{ route('admin.payslips.bulk.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5 ">
                                <div class="form-group">
                                    <label>Month <span class="text-danger">*</span></label>
                                    <select name="month" id="month" class="form-control" required>
                                        <option value="">Select Month</option>
                                        @foreach (range(1, 12) as $month)
                                            <option value="{{ $month }}">
                                                {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Year <span class="text-danger">*</span></label>
                                    <select name="year" id="year" class="form-control" required>
                                        <option value="">Select Year</option>
                                        @foreach (range(2018, now()->year) as $year)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-10">
                                <div class="form-group">
                                    <label>Upload File <span class="text-danger">*</span></label>
                                    <input type="file" name="file" id="file" class="form-control"
                                        required>
                                </div>
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary">Upload</button>

                        </div>
                    </div>
                </form>
            </div>

            <!-- Download Payslips Tab -->
            <div class="tab-pane fade" id="download" role="tabpanel" aria-labelledby="download-tab">
                <div class="card-header">
                    <h5 class="card-title">Download Payslips</h5>
                </div>

                <form id="payslipForm" action="{{ route('admin.payslips.export') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row align-items-end">
                            <!-- Multi-Select Client Dropdown -->
                            <div class="col-lg-3">
                                <label for="client">Client Name <span class="text-danger">*</span></label>
                                <div class="dropdown">
                                    <input type="text" class="btn dropdown-toggle text-start"
                                        id="dropdownMenuclient" data-bs-toggle="dropdown" aria-expanded="false"
                                        readonly value="Select Client" />
                                    <input type="hidden" name="client[]" id="selected_client_input" required />

                                    <ul class="dropdown-menu p-2"
                                        style="max-height: 300px; overflow-y: auto; min-width: 250px;">
                                        <li class="mb-2">
                                            <input type="text" class="form-control" placeholder="Search..."
                                                onkeyup="filterClient(this)">
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>

                                        @foreach (FretusFolks::getClientname() as $option)
                                            <li>
                                                <a href="#" class="dropdown-item"
                                                    onclick="selectClient('{{ $option['label'] }}')">
                                                    {{ $option['label'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>



                            {{-- <!-- Single-Select State Dropdown -->
                            <div class="col-lg-3">
                                <label for="service_state">State</label>
                                <div class="dropdown">
                                    <input type="text" class="btn btn-secondary dropdown-toggle"
                                        id="dropdownMenuButtonlocation" data-bs-toggle="dropdown" aria-expanded="false"
                                        readonly value="Select State" />
                                    <ul class="dropdown-menu ps-3" aria-labelledby="dropdownMenuButtonlocation">
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="select_all_location"
                                                    onchange="toggleSelectAll(this, '.state-checkbox', '#dropdownMenuButtonlocation', 'Select State')">
                                                <label class="form-check-label" for="select_all_location">Select
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
                                                    name="location[]" value="{{ $option['value'] }}"
                                                    id="location_{{ $loop->index }}"
                                                    onchange="updateSelectedCount('.state-checkbox', '#dropdownMenuButtonlocation', 'Select State')">
                                                <label class="form-check-label" for="location_{{ $loop->index }}">{{
                                                    $option['label'] }}</label>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div> --}}

                            <!-- Select Month -->
                            <div class="col-md-3">
                                <label>Month <span class="text-danger">*</span></label>
                                <select name="month" id="month" class="form-control" required>
                                    <option value="">Select Month</option>
                                    @foreach (range(1, 12) as $month)
                                        <option value="{{ $month }}">
                                            {{ \Carbon\Carbon::create()->month($month)->format('F') }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Select Year -->
                            <div class="col-md-3">
                                <label>Year <span class="text-danger">*</span></label>
                                <select name="year" id="year" class="form-control" required>
                                    <option value="">Select Year</option>
                                    @foreach (range(2018, now()->year) as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-lg-12 mt-2">
                            <div class="d-flex">
                                <input type="text" name="ademails" class="form-control"
                                    placeholder="Enter Email Addresses (Comma Separated)" required>
                                <button type="submit" class="btn btn-primary ms-2" id="dwnPayBtn">Download</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Search Payslips -->
    <div class="row">
        <div class="col-md-12">
            <form id="my_form" method="GET" action="{{ route('admin.search.payslips') }}">
                @csrf
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h5 class="card-title">Search Payslips</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" name="emp_id" id="emp_id" class="form-control"
                                    placeholder="Employee ID" value="{{ request()->emp_id }}">
                            </div>
                            <div class="col-lg-3">
                                {{-- <label for="client">Client Name <span class="text-danger">*</span></label> --}}
                                <div class="dropdown">
                                    <input type="text" class="btn dropdown-toggle text-start"
                                        id="dropdownSearchclient" data-bs-toggle="dropdown" aria-expanded="false"
                                        readonly value="{{ request('client_name') ?? 'Select Client' }}" />

                                    <input type="hidden" name="client_name" id="selected_client_search"
                                        value="{{ request('client_name') }}" />

                                    <ul class="dropdown-menu p-2"
                                        style="max-height: 300px; overflow-y: auto; min-width: 250px;">
                                        <li class="mb-2">
                                            <input type="text" class="form-control" placeholder="Search..."
                                                onkeyup="filterClientsearch(this)">
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>

                                        @foreach (FretusFolks::getClientname() as $option)
                                            <li>
                                                <a href="#" class="dropdown-sitem"
                                                    onclick="selectClientsearch('{{ $option['label'] }}')">
                                                    {{ $option['label'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <select name="month" id="month" class="form-control">
                                    <option value="">Select Month</option>
                                    @foreach (range(1, 12) as $month)
                                        <option value="{{ $month }}"
                                            {{ request('month') == $month ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create()->month($month)->format('F') }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="year" id="year" class="form-control">
                                    <option value="">Select Year</option>
                                    @foreach (range(2018, now()->year) as $year)
                                        <option value="{{ $year }}"
                                            {{ request('year') == $year ? 'selected' : '' }}>
                                            {{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if (isset($payslips) && count($payslips) > 0)
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Payslip Details</h5>
            </div>
            <div class="row mt-4">
                <div class="col-lg-12">
                    @php
                        $columns = [
                            ['label' => 'Id', 'column' => 'id', 'sort' => true],
                            ['label' => 'EMP ID', 'column' => 'emp_id', 'sort' => false],
                            ['label' => 'Client Name', 'column' => 'client_name', 'sort' => false],
                            ['label' => 'EMP Name', 'column' => 'emp_name', 'sort' => false],
                            ['label' => 'Designation', 'column' => 'designation', 'sort' => true],
                            ['label' => 'Department', 'column' => 'department', 'sort' => true],
                            ['label' => 'Date', 'column' => 'month,year', 'sort' => true],
                            ['label' => 'Actions', 'column' => 'action', 'sort' => false],
                        ];
                    @endphp

                    <x-table :columns="$columns" :data="$payslips" :checkAll=false :bulk="route('admin.cms.esic')" :route="route('admin.search.payslips')">
                        @foreach ($payslips as $key => $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->emp_id }}</td>
                                <td>{{ $item->client_name }}</td>
                                <td>{{ $item->emp_name }}</td>
                                <td>{{ $item->designation }}</td>
                                <td>{{ $item->department }}</td>
                                <td>{{ \DateTime::createFromFormat('!m', $item->month)->format('F') }}-{{ $item->year }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.generate.payslips', ['id' => $item->id]) }}"
                                        target="_blank" class="btn btn-sm btn-info">
                                        View Details
                                    </a>
                                    <a href="javascript:void(0);" class="btn btn-sm btn-danger delete-btn"
                                        data-id="{{ $item->id }}">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </x-table>
                </div>
            </div>
        </div>
    @else
        @if (isset($payslips))
            <div class="alert alert-warning">No records found</div>
        @endif
    @endif

    @push('scripts')
        <script>
            $(function() {
                $('.delete-btn').on('click', function(event) {
                    event.preventDefault(); // ⛔ prevent page navigation

                    if (!confirm('Are you sure to delete this?')) {
                        return;
                    }

                    const id = $(this).data('id');
                    const row = $('#row-' + id);

                    $.ajax({
                        url: 'hhttps://webominddev.co.in/fretusfolks/public/admin/payslips/' + id +
                            '/delete',
                        method: 'GET',
                        success: function(response) {
                            if (response.success) {
                                row.fadeOut(300, () => row.remove());
                                alert('Deleted successfully!');
                                window.location.reload();
                            } else {
                                alert('Failed to delete.');
                            }
                        },
                        error: function() {
                            alert('Error occurred while deleting.');
                        }
                    });
                });
            });
        </script>

        <script>
            function filterClient(input) {
                const filter = input.value.toLowerCase();
                document.querySelectorAll('.dropdown-menu .dropdown-item').forEach(item => {
                    item.style.display = item.textContent.toLowerCase().includes(filter) ? '' : 'none';
                });
            }

            function selectClient(name) {
                document.getElementById('dropdownMenuclient').value = name;
                document.getElementById('selected_client_input').value = name;
                bootstrap.Dropdown.getOrCreateInstance(document.getElementById('dropdownMenuclient')).hide();
            }
        </script>
        <script>
            function filterClientsearch(input) {
                const filter = input.value.toLowerCase();
                document.querySelectorAll('.dropdown-menu .dropdown-sitem').forEach(item => {
                    item.style.display = item.textContent.toLowerCase().includes(filter) ? '' : 'none';
                });
            }

            function selectClientsearch(name) {
                document.getElementById('dropdownSearchclient').value = name;
                document.getElementById('selected_client_search').value = name;
                bootstrap.Dropdown.getOrCreateInstance(document.getElementById('dropdownSearchclient')).hide();
            }
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const tabs = document.querySelectorAll('#myTab .nav-link');
                const tabContents = document.querySelectorAll('.tab-pane');

                tabs.forEach(tab => {
                    tab.addEventListener('click', function(e) {
                        e.preventDefault();

                        tabs.forEach(t => t.classList.remove('active'));
                        tabContents.forEach(content => content.classList.remove('show', 'active'));

                        this.classList.add('active');

                        const targetId = this.getAttribute('href').substring(1);
                        const targetContent = document.getElementById(targetId);
                        targetContent.classList.add('show', 'active');
                    });
                });
            });
        </script>
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
        </script>

        <script>
            $(document).on('click', '#downloadFilteredCSV', function() {
                let selectedClients = [];

                $('.data-checkbox:checked').each(function() {
                    selectedClients.push($(this).val());
                });

                if (selectedClients.length === 0) {
                    const link = document.createElement('a');
                    link.href =
                        'https://webominddev.co.in/fretusfolks/public/admin/payslip_format.xlsx'; // File must be in public/
                    link.download = 'payslip_format.xlsx';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    return;
                }

                // Construct the query parameters
                let queryParams = {
                    data: selectedClients,
                };

                let queryString = $.param(queryParams);

                // Redirect to download CSV
                window.location.href = `payslips/download-filtered?${queryString}`;
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/jquery"></script>
        <script>
            let progressInterval;

            $("#payslipForm").on("submit", function(event) {
                event.preventDefault();
                $('#dwnPayBtn').prop('disabled', true);
                $("#progress-bar-container").show();
                $("#progress-bar").val(0);
                $("#progress-text").text("Processing Payslips...");
                $("#payslip-completed").text("");

                $.ajax({
                    url: $(this).attr("action"),
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        startProgressCheck();
                    },
                    error: function(xhr) {
                        $("#progress-bar-container").hide();
                        alert("Something went wrong. Please try again.");
                    }
                });
            });

            function startProgressCheck() {
                progressInterval = setInterval(() => {
                    $.get("https://webominddev.co.in/fretusfolks/public/batch-status", function(data) {
                        if (data.status !== "not_found") {
                            $("#progress-bar").val(data.status);
                            $("#progress-text").text("Processing Payslips... " + data.status + "%");

                            if (data.status == 100) {
                                clearInterval(progressInterval);
                                $('#dwnPayBtn').prop('disabled', false);
                                $("#progress-bar-container").hide();
                                $("#payslip-completed").text("Payslip Zip has been sent to your email.");
                            } else {
                                $("#payslip-completed").text("");
                            }
                        }
                    });
                }, 3000);
            }
        </script>
    @endpush
</x-applayout>
