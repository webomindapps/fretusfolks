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
                            <a href="{{ asset('admin/fffi_payslip_format.csv') }}"
                                class="btn btn-info text-white ms-3" download="fffi_payslip_format.csv">
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
            <form id="my_form" method="GET" action="{{ route('admin.search.ffi_payslips') }}">
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h5 class="card-title">Search FFI Payslips</h5>
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
                                    <option value="{{ $month }}" {{ request('month')==$month ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($month)->format('F') }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="year" id="year" class="form-control">
                                    <option value="">Select Year</option>
                                    @foreach (range(2018, now()->year) as $year)
                                    <option value="{{ $year }}" {{ request('year')==$year ? 'selected' : '' }}>
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
                ['label' => 'EMP Name', 'column' => 'employee_name', 'sort' => false],
                ['label' => 'Designation', 'column' => 'designation', 'sort' => true],
                ['label' => 'Department', 'column' => 'department', 'sort' => true],
                ['label' => 'Date', 'column' => 'month,year', 'sort' => true],
                ['label' => 'Actions', 'column' => 'action', 'sort' => false],
                ];
                @endphp

                <x-table :columns="$columns" :data="$payslips" :checkAll=false :bulk="route('admin.cms.esic')"
                    :route="route('admin.search.ffi_payslips')">
                    @foreach ($payslips as $key => $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->emp_id }}</td>
                        <td>{{ $item->employee_name }}</td>
                        <td>{{ $item->designation }}</td>
                        <td>{{ $item->department }}</td>
                        <td>{{ \DateTime::createFromFormat('!m', $item->month)->format('F') }}-{{ $item->year }}
                        </td>
                        <td>

                            <div class="dropdown pop_Up dropdown_bg">
                                <div class="dropdown-toggle" id="dropdownMenuButton-{{ $item->id }}"
                                    data-bs-toggle="dropdown" aria-expanded="true">
                                    Action
                                </div>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1"
                                    style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(-95px, -25.4219px);"
                                    data-popper-placement="top-end">
                                    <li>
                                        <a href="{{ route('admin.ffi_generate.payslips', ['id' => $item->id]) }}"
                                            target="_blank" class="dropdown-item">
                                            <i class='bx bx-link-alt'></i>
                                            View Details
                                        </a>
                                        <a class="dropdown-item"
                                            onclick="return confirm('Are you sure to delete this ?')"
                                            href="{{ route('admin.ffi_payslips.delete', $item) }}">
                                            <i class='bx bx-trash-alt'></i>
                                            Delete
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
    </div>
    @else
    @if (isset($payslips))
    <div class="alert alert-warning">No records found</div>
    @endif
    @endif


    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = document.querySelectorAll('#myTab .nav-link');
            const tabContents = document.querySelectorAll('.tab-pane');

            tabs.forEach(tab => {
                tab.addEventListener('click', function (e) {
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
    @endpush
</x-applayout>