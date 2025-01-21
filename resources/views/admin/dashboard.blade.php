<x-applayout>
    <div class="main">
        <div class="container-fluid">
            <div class="row pt-3 pb-2 border-bottom">
                <div class="col-lg-4">
                    <h3>Dashboard</h3>
                </div>
                <div class="col-lg-8 text-end ms-auto ">
                    <form class="row justify-content-end" id="filterFrom">
                        <div class="col-lg-3">
                            <div class="cdate">
                                <input type="date" class="form-control filter" name="from_date"
                                    value="{{ request()->from_date }}">
                            </div>
                        </div>
                        <div class="col-lg-1 text-center my-auto">
                            <span class="fw-semibold fs-6">To</span>
                        </div>
                        <div class="col-lg-3">
                            <div class="cdate">
                                <input type="date" class="form-control filter" name="to_date"
                                    value="{{ request()->to_date ?? date('Y-m-d') }}">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-2">
            <div class="col-xl-8">
                <!-- Dashboard content -->
                <div class="card" style="padding: 2%;">
                    <div class="card-header header-elements-inline">
                        <h6 class="card-title">CDMS Reports</h6>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-4">
                            <div class="card bg-teal-400" style="zoom: 1;">
                                <div class="card-body">
                                    <div class="dashboard-card">
                                        <div class="data">
                                            <h3 class="font-weight-semibold mb-0">
                                                <div class="data">
                                                    {{ $cdms->count() }}
                                                </div>
                                            </h3>
                                        </div>
                                    </div>
                                    <div>
                                        Total Client
                                        <div class="font-size-sm opacity-75">In CDMA</div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card bg-pink-400">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <h3 class="font-weight-semibold mb-0">
                                            <div class="data">
                                                {{ $cdms->where('active_status', '0')->count() }}
                                            </div>
                                        </h3>
                                        <div class="list-icons ml-auto">

                                        </div>
                                    </div>
                                    <div>
                                        Active Client
                                        <div class="font-size-sm opacity-75">In CDMA</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card bg-blue-400">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <h3 class="font-weight-semibold mb-0">
                                            <div class="data">
                                                {{ $cdms->where('active_status', '1')->count() }}
                                            </div>
                                        </h3>

                                    </div>
                                    <div>
                                        Inactive Client
                                        <div class="font-size-sm opacity-75">In CDMA</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Marketing campaigns -->

                @php
                    // $active = $cfis
                    //     ->where('client_id', $cfis->client_id)
                    //     ->where('emp_name', '!=', '')
                    //     ->where('active_status', '0')
                    //     ->where('status', '0')
                    //     ->where('dcs_approval', '1')
                    //     ->count();

                    // $inactive = $cfis
                    //     ->where('client_id', $cfis->client_id)
                    //     ->where('active_status', '1')
                    //     ->where('status', '1')
                    //     ->where('dcs_approval', '1')
                    //     ->count();

                    $inactiveCount = $cfis
                        ->where('emp_name', '!=', '')
                        ->where('active_status', '0')
                        ->where('status', '0')
                        ->where('dcs_approval', '1')
                        ->count();

                    $activeCount = $cfis
                        ->where('emp_name', '!=', '')
                        ->where('active_status', '1')
                        ->where('dcs_approval', '1')
                        ->count();

                    $totalCount = $inactiveCount + $activeCount;
                @endphp
                <div class="card" style="height: 360px;">
                    <div class="card-header header-elements-sm-inline">
                        <h6 class="card-title">Company Details</h6>
                        <div class="header-elements">
                            <span class="badge bg-success badge-pill">Total Employee :
                                {{ $totalCount }} </span>
                            <div class="list-icons ml-3">
                                <div class="list-icons-item dropdown">
                                    <a class="list-icons-item" data-action="reload" contenteditable="false"
                                        style="cursor: pointer;"></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead>
                                <tr>
                                    <th>Company Name</th>
                                    <th>Total Employee</th>
                                    <th>Active Employee</th>
                                    <th>Inactive Employee</th>
                                </tr>
                            </thead>
                            @foreach ($cfis->unique('client_id') as $cfi)
                                <tr>
                                    <td>{{ $cfi->client?->client_name }}</td>
                                    {{-- <td>{{ $inactive + $active }}</td> --}}
                                    {{-- <td>{{ $active }}</td>
                                    <td>{{ $inactive }}</td> --}}
                                </tr>
                            @endforeach

                        </table>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card" style="height: 275px;">
                    <div class="card-header header-elements-inline">
                        <h6 class="card-title">SLA Ending</h6>
                        <div class="header-elements">
                            <span class="font-weight-bold text-danger-600 ml-2">Max 30 Days</span>
                            <div class="list-icons ml-3">
                                <a class="list-icons-item" data-action="reload" contenteditable="false"
                                    style="cursor: pointer;"></a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead>
                                <tr>
                                    <th class="w-100">Client Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Agreement Type</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Progress counters -->
                <div class="card mt-4" style="background: none;border: none;margin-top: -6%;box-shadow: none;">
                    <div class="card-header header-elements-inline">
                        <h6 class="card-title">FHRMS Details</h6>
                        <div class="header-elements">
                            <span class="font-weight-bold text-danger-600 ml-2">Total Employee : {{ $fhrms->count() }}
                            </span>
                            <div class="list-icons ml-3">
                                <a class="list-icons-item" data-action="reload" contenteditable="false"
                                    style="cursor: pointer;"></a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="svg-center position-relative" id="hours-available-progress1">
                                        <h2 class="pt-1 mt-2 mb-1"> {{ $fhrms->where('active_status', '0')->count() }}
                                        </h2><i class="icon-watch text-pink-400 counter-icon" style="top: 22px"></i>
                                        <div>Active Employee</div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card text-center">
                                <div class="card-body">
                                    <div class="svg-center position-relative" id="goal-progress1">
                                        <h2 class="pt-1 mt-2 mb-1"> {{ $fhrms->where('active_status', '1')->count() }}
                                        </h2><i class="icon-trophy3 text-indigo-400 counter-icon"
                                            style="top: 22px"></i>
                                        <div>Inactive Employee</div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="row mt-2 g-3">
            <div class="col-xl-8">
                <div class="card" style="height: 400px;">
                    <div class="card-header header-elements-sm-inline">
                        <h6 class="card-title">CFIS Details</h6>
                        <div class="header-elements">
                            <div class="list-icons ml-3">
                                <div class="list-icons-item dropdown">
                                    <a class="list-icons-item" data-action="reload" contenteditable="false"
                                        style="cursor: pointer;"></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead>
                                <tr>
                                    <th>Company Name</th>
                                    <th>Total Lineups</th>
                                    <th>Selected</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card" style="height: 275px;">
                    <div class="card-header header-elements-inline">
                        <h6 class="card-title">Today's Birthday</h6>
                        <div class="header-elements">
                            <span class="font-weight-bold text-danger-600 ml-2"></span>
                            <div class="list-icons ml-3">
                                <a class="list-icons-item" data-action="reload" contenteditable="false"
                                    style="cursor: pointer;"></a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        @foreach ($birthdays as $fhrm)
                            <div class="card card-body bg-blue-400 has-bg-image">
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="mb-0">{{ $fhrm->emp_name }}</h5>
                                        <span class="text-uppercase font-size-xs">{{ $fhrm->phone1 }}</span><br>
                                        <span
                                            class="text-uppercase font-size-xs">{{ Carbon\Carbon::parse($fhrm->dob)->format('d-m-Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-xl-12">
                <div class="card" style="height: 400px;">
                    <div class="card-header header-elements-sm-inline">
                        <h6 class="card-title">Labour Notice Details</h6>
                        <div class="header-elements">
                            <div class="list-icons ml-3">
                                <div class="list-icons-item dropdown">
                                    <a class="list-icons-item" data-action="reload" contenteditable="false"
                                        style="cursor: pointer;"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead>
                                <tr>
                                    <th>Si No</th>
                                    <th>Client Name</th>
                                    <th>State Name</th>
                                    <th>Notice Date</th>
                                    <th>Closure Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($labour as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->client?->client_name ?? 'N/A' }}</td>
                                        <td>{{ $item->state?->state_name ?? 'N/A' }}</td>
                                        <td>{{ $item->notice_received_date ? date('d-m-Y', strtotime($item->notice_received_date)) : 'N/A' }}
                                        </td>
                                        <td>{{ $item->closure_date ? date('d-m-Y', strtotime($item->closure_date)) : 'N/A' }}
                                        </td>
                                        <td>{{ $item->status == 1 ? 'Completed' : 'Pending' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $('.filter').change(function() {
                $('#filterFrom').submit();
            })
        </script>
    @endpush
</x-applayout>
