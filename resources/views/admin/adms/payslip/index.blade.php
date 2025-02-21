<x-applayout>
    <x-admin.breadcrumb title=" Payslips" />

    <div class="p-2">
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
                                    <input type="text" class="btn dropdown-toggle" id="dropdownMenuButton"
                                        data-bs-toggle="dropdown" aria-expanded="false" readonly
                                        value="Select Client" />
                                    <ul class="dropdown-menu ps-3" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="select_all_data"
                                                    onchange="toggleSelectAll(this, '.data-checkbox', '#dropdownMenuButton', 'Select Data')">
                                                <label class="form-check-label" for="select_all_data">Select All</label>
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

                            <!-- From Date -->
                            <div class="col-lg-2 mt-2">
                                <label for="from">From Date</label>
                                <input type="date" class="form-control" id="from" name="from">
                            </div>

                            <!-- To Date -->
                            <div class="col-lg-2 mt-2">
                                <label for="to">To Date</label>
                                <input type="date" class="form-control" id="to" name="to">
                            </div>

                            <div class="col-lg-2 mt-4">
                                <a class="btn btn-info  w-20 text-white mt-3" id="downloadFilteredCSV"
                                    download="payslip_format.csv">
                                    Download Sample
                                </a>
                            </div>
                        </div>
                    </form>

                </div>

                <div class="card-header">
                    <h5 class="card-title">Upload Payslips</h5>
                </div>

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('admin.payslips.bulk.upload') }}" method="POST"
                    enctype="multipart/form-data">
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

                <form action="{{ route('admin.payslips.export') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row align-items-end">
                            <!-- Multi-Select Client Dropdown -->
                            <div class="col-lg-3">
                                <label for="data">Client Name (Multi-Select)</label>
                                <div class="dropdown">
                                    <input type="text" class="btn dropdown-toggle" id="dropdownMenuButtonclient"
                                        data-bs-toggle="dropdown" aria-expanded="false" readonly
                                        value="Select Client" />
                                    <ul class="dropdown-menu ps-3" aria-labelledby="dropdownMenuButtonclient">
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select_all_client"
                                                    onchange="toggleSelectAll(this, '.client-checkbox', '#dropdownMenuButtonclient', 'Select client')">
                                                <label class="form-check-label" for="select_all_client">Select
                                                    All</label>
                                            </div>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        @foreach (FretusFolks::getClientname() as $option)
                                            <li>
                                                <div class="form-check">
                                                    <input class="form-check-input client-checkbox" type="checkbox"
                                                        name="client[]" value="{{ $option['value'] }}"
                                                        id="client_{{ $loop->index }}"
                                                        onchange="updateSelectedCount('.client-checkbox', '#dropdownMenuButtonclient', 'Select client')">
                                                    <label class="form-check-label"
                                                        for="client_{{ $loop->index }}">{{ $option['label'] }}</label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <!-- Single-Select State Dropdown -->
                            <div class="col-lg-3">
                                <label for="service_state">State</label>
                                <div class="dropdown">
                                    <input type="text" class="btn btn-secondary dropdown-toggle"
                                        id="dropdownMenuButtonlocation" data-bs-toggle="dropdown"
                                        aria-expanded="false" readonly value="Select State" />
                                    <ul class="dropdown-menu ps-3" aria-labelledby="dropdownMenuButtonlocation">
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="select_all_location"
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
                                                    <label class="form-check-label"
                                                        for="location_{{ $loop->index }}">{{ $option['label'] }}</label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

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


                        <div class="col-lg-3 mt-2">
                            <button type="submit" class="btn btn-primary">Download</button>
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
                            <div class="col-md-3">
                                <select name="month" id="month" class="form-control">
                                    <option value="">Select Month</option>
                                    @foreach (range(1, 12) as $month)
                                        <option value="{{ $month }}"
                                            {{ request('month') == $month ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create()->month($month)->format('F') }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="year" id="year" class="form-control">
                                    <option value="">Select Year</option>
                                    @foreach (range(2018, now()->year) as $year)
                                        <option value="{{ $year }}"
                                            {{ request('year') == $year ? 'selected' : '' }}>
                                            {{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
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
                                    <a href="{{ route('admin.payslips.delete', $item) }}"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure to delete this?')">
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

            //         document.querySelector('#searchBtn').addEventListener('click', async function(e) {
            //             e.preventDefault();
            //             const empId = document.querySelector('input[name="emp_id"]').value;
            //             const month = document.querySelector('select[name="month1"]').value;
            //             const year = document.querySelector('select[name="year1"]').value;

            //             if (!month || !year) {
            //                 alert('Please select both Month and Year');
            //                 return;
            //             }

            //             try {
            //                 const response = await fetch("{{ route('admin.search.ffi_payslips') }}", {
            //                     method: 'POST',
            //                     headers: {
            //                         'Content-Type': 'application/json',
            //                         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
            //                             'content')
            //                     },
            //                     body: JSON.stringify({
            //                         emp_id: empId,
            //                         month: month,
            //                         year: year
            //                     })
            //                 });

            //                 const data = await response.json();
            //                 const tableBody = document.getElementById('get_details');
            //                 tableBody.innerHTML = '';

            //                 if (data.success && Array.isArray(data.data) && data.data.length > 0) {
            //                     data.data.forEach((item, index) => {
            //                         tableBody.innerHTML += `
    //                <tr>
    // <td>${index + 1}</td>
    // <td>${item.emp_id}</td>
    // <td>${item.employee_name}</td>
    // <td>${item.designation}</td>
    // <td>${item.department}</td>
    // <td>${new Date(item.year, item.month - 1).toLocaleString('default', { month: 'long', year: 'numeric' })}</td>
    // <td class="text-center">
    //                                 <div class="dropdown pop_Up dropdown_bg">
    //                             <div class="dropdown-toggle" id="dropdownMenuButton-${item.id}"
    //                                 data-bs-toggle="dropdown" aria-expanded="true">
    //                                 Action
    //                             </div>
    //                             <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
    //                                 <li>
    //                                  <a href="{{ url('/') }}/admin/generate-payslips/${item.id}" target="_blank" class="dropdown-item">
    //                     <i class="bx bx-link-alt"></i> View Details
    //                 </a>
    //                 <a href="/admin/ffi-payslips/delete/${item.id}" class="dropdown-item" onclick="return confirm('Are you sure to delete this?')">
    //                     <i class="bx bx-trash-alt"></i> Delete
    //                 </a>
    //                                 </li>
    //                             </ul>
    //                         </div>
    //                             </td>
    //                             </tr>

    //             `;
            //                     });
            //                     document.getElementById('payslip_table').style.display = 'block';
            //                 } else {
            //                     tableBody.innerHTML = `<tr><td colspan="7" class="text-center">No records found</td></tr>`;
            //                     document.getElementById('payslip_table').style.display = 'block';
            //                 }
            //             } catch (error) {
            //                 console.error(error);
            //                 alert('An error occurred while fetching payslip details.');
            //             }
            //         });
        </script>
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
        </script>
        <script>
            $(document).on('click', '#downloadFilteredCSV', function() {
                let selectedClients = [];
                let selectedStates = [];

                $('.data-checkbox:checked').each(function() {
                    selectedClients.push($(this).val());
                });

                $('.state-checkbox:checked').each(function() {
                    selectedStates.push($(this).val());
                });

                let fromDate = $('#from').val();
                let toDate = $('#to').val();

                if (selectedClients.length === 0 || selectedStates.length === 0) {
                    alert("Please select at least one Client and one State.");
                    return;
                }

                // Construct the query parameters
                let queryParams = {
                    data: selectedClients,
                    service_state: selectedStates
                };

                if (fromDate) queryParams.from = fromDate;
                if (toDate) queryParams.to = toDate;

                let queryString = $.param(queryParams);

                // Redirect to download CSV
                window.location.href = `payslips/download-filtered?${queryString}`;
            });
        </script>
    @endpush
</x-applayout>
