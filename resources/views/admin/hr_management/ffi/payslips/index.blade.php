<x-applayout>
    <x-admin.breadcrumb title=" FFI Payslips" />

    <div class="p-2">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="upload-tab" data-toggle="tab" href="#upload" role="tab"
                    aria-controls="upload" aria-selected="true">Upload FFI Payslips</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="download-tab" data-toggle="tab" href="#download" role="tab"
                    aria-controls="download" aria-selected="false">Download FFI Payslips</a>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <!-- Upload Payslips Tab -->
            <div class="tab-pane fade show active" id="upload" role="tabpanel" aria-labelledby="upload-tab">
                <div class="card-header">
                    <h5 class="card-title">Upload FFI Payslips</h5>
                </div>

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('admin.ffi_payslips.bulk.upload') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Month <span class="text-danger">*</span></label>
                                    <select name="month" id="month" class="form-control" required>
                                        <option value="">Select Month</option>
                                        @foreach (range(1, 12) as $month)
                                            <option value="{{ $month }}">
                                                {{ \Carbon\Carbon::create()->month($month)->format('F') }}</option>
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
                        </div>

                        <div class="row">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label>Upload File <span class="text-danger">*</span></label>
                                    <input type="file" name="file" id="file" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary">Upload</button>
                            <a href="{{ asset('admin/fffi_payslip_formate.xlsx') }}"
                                class="btn btn-info text-white ms-3">
                                Download Sample
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Download Payslips Tab -->
            <div class="tab-pane fade" id="download" role="tabpanel" aria-labelledby="download-tab">
                <div class="card-header">
                    <h5 class="card-title">Download FFI Payslips</h5>
                </div>

                <form action="{{ route('admin.ffi_payslips.export') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Month <span class="text-danger">*</span></label>
                                    <select name="month" id="month" class="form-control" required>
                                        <option value="">Select Month</option>
                                        @foreach (range(1, 12) as $month)
                                            <option value="{{ $month }}">
                                                {{ \Carbon\Carbon::create()->month($month)->format('F') }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
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
                        </div>

                        <div>
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
            <form id="my_form" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h5 class="card-title">Search FFI Payslips</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" name="emp_id" id="emp_id" class="form-control"
                                    placeholder="Employee ID" required>
                            </div>
                            <div class="col-md-3">
                                <select name="month1" id="month" class="form-control" required>
                                    <option value="">Select Month</option>
                                    @foreach (range(1, 12) as $month)
                                        <option value="{{ $month }}">
                                            {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="year1" id="year" class="form-control" required>
                                    <option value="">Select Year</option>
                                    @foreach (range(2018, now()->year) as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-primary" id="searchBtn">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card" id="payslip_table" style="display:none">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Payslip Details</h5>
        </div>
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Si No</th>
                    <th>EMP ID</th>
                    <th>EMP Name</th>
                    <th>Designation</th>
                    <th>Department</th>
                    <th>Date</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody id="get_details"></tbody>
        </table>
    </div>


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

            document.querySelector('#searchBtn').addEventListener('click', async function(e) {
                e.preventDefault();
                const empId = document.querySelector('input[name="emp_id"]').value;
                const month = document.querySelector('select[name="month1"]').value;
                const year = document.querySelector('select[name="year1"]').value;

                if (!month || !year) {
                    alert('Please select both Month and Year');
                    return;
                }

                try {
                    const response = await fetch("{{ route('admin.search.ffi_payslips') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            emp_id: empId,
                            month: month,
                            year: year
                        })
                    });

                    const data = await response.json();
                    const tableBody = document.getElementById('get_details');
                    tableBody.innerHTML = '';

                    if (data.success && Array.isArray(data.data) && data.data.length > 0) {
                        data.data.forEach((item, index) => {
                            tableBody.innerHTML += `
                   <tr>
    <td>${index + 1}</td>
    <td>${item.emp_id}</td>
    <td>${item.employee_name}</td>
    <td>${item.designation}</td>
    <td>${item.department}</td>
    <td>${new Date(item.year, item.month - 1).toLocaleString('default', { month: 'long', year: 'numeric' })}</td>
    <td class="text-center">
                                    <div class="dropdown pop_Up dropdown_bg">
                                <div class="dropdown-toggle" id="dropdownMenuButton-${item.id}"
                                    data-bs-toggle="dropdown" aria-expanded="true">
                                    Action
                                </div>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                     <a href="{{url('/')}}/admin/generate-payslips/${item.id}" target="_blank" class="dropdown-item">
                        <i class="bx bx-link-alt"></i> View Details
                    </a>
                    <a href="/admin/ffi-payslips/delete/${item.id}" class="dropdown-item" onclick="return confirm('Are you sure to delete this?')">
                        <i class="bx bx-trash-alt"></i> Delete
                    </a>
                                    </li>
                                </ul>
                            </div>
                                </td>
                                </tr>

                `;
                        });
                        document.getElementById('payslip_table').style.display = 'block';
                    } else {
                        tableBody.innerHTML = `<tr><td colspan="7" class="text-center">No records found</td></tr>`;
                        document.getElementById('payslip_table').style.display = 'block';
                    }
                } catch (error) {
                    console.error(error);
                    alert('An error occurred while fetching payslip details.');
                }
            });
        </script>
    @endpush
</x-applayout>
