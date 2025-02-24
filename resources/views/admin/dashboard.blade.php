<x-applayout>
    <div class="main">
        <div class="container-fluid">
            @if ($userRole === 'HR Operations')
                <div class="col-lg-4">
                    <h3> HR Dashboard</h3>
                </div>
                <div class="card mb-2" style="padding: 2%;">
                    <div class="card-header header-elements-inline">
                        <h6 class="card-title">Onboardings For Clients</h6>
                    </div>
                    <div class="row my-1">
                        <div class="col-lg-3">
                            <div class="card bg-teal-400" style="zoom: 1;">
                                <div class="card-body">
                                    <div class="dashboard-card">
                                        <div class="data">
                                            <h3 class="font-weight-semibold mb-0">
                                                <div class="data">
                                                    {{ $onboardingCount }}
                                                </div>
                                            </h3>
                                        </div>
                                    </div>
                                    <div>
                                        No Of Onboardings <div class="font-size-sm opacity-75">For Clients</div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card bg-pink-400">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <h3 class="font-weight-semibold mb-0">
                                            <div class="data">
                                                {{ $offerlettercount }}
                                            </div>
                                        </h3>
                                        <div class="list-icons ml-auto">

                                        </div>
                                    </div>
                                    <div>
                                        Offer Letters Released <div class="font-size-sm opacity-75">For Employees</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card bg-blue-400">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <h3 class="font-weight-semibold mb-0">
                                            <div class="data">
                                                {{ $esicNumbers }}
                                            </div>
                                        </h3>

                                    </div>
                                    <div>
                                        Eisc's Generated <div class="font-size-sm opacity-75">For Employess</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 mt-2">
                            <div class="card bg-pink-400">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <h3 class="font-weight-semibold mb-0">
                                            <div class="data">
                                                {{ $uanNumbers }}
                                            </div>
                                        </h3>
                                        <div class="list-icons ml-auto">

                                        </div>
                                    </div>
                                    <div>
                                        Uan's Generated <div class="font-size-sm opacity-75">For Employees</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-2" style="padding: 2%;">
                    <div class="card-header header-elements-inline">
                        <h6 class="card-title">Pending For Employees</h6>
                    </div>
                    <div class="row my-1">
                        <div class="col-lg-3">
                            <div class="card bg-teal-400" style="zoom: 1;">
                                <div class="card-body">
                                    <div class="dashboard-card">
                                        <div class="data">
                                            <h3 class="font-weight-semibold mb-0">
                                                <div class="data">
                                                    {{ $onboardingCount }}
                                                </div>
                                            </h3>
                                        </div>
                                    </div>
                                    <div>
                                        Bank Accounts<div class="font-size-sm opacity-75">pending for verification</div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card bg-pink-400">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <h3 class="font-weight-semibold mb-0">
                                            <div class="data">
                                                {{ $pendingdocumentscount }}
                                            </div>
                                        </h3>
                                        <div class="list-icons ml-auto">

                                        </div>
                                    </div>
                                    <div>
                                        Documents Pending <div class="font-size-sm opacity-75"> For Verification</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card bg-blue-400">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <h3 class="font-weight-semibold mb-0">
                                            <div class="data">
                                                {{ $pendingdocumentscount }}
                                            </div>
                                        </h3>

                                    </div>
                                    <div>
                                        Offer Letter Pending <div class="font-size-sm opacity-75">For
                                            Employees</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-xl-6">
                        <!-- Dashboard content -->
                        <div class="card mb-2" style="padding: 2%;">
                            <div class="card-header header-elements-inline">
                                <h6 class="card-title"> HR CDMS Details</h6>
                            </div>
                            <div class="row my-1">
                                <div class="col-lg-4">
                                    <div class="card bg-teal-400" style="zoom: 1;">
                                        <div class="card-body">
                                            <div class="dashboard-card">
                                                <div class="data">
                                                    <h3 class="font-weight-semibold mb-0">
                                                        <div class="data">
                                                            {{ $hrtotalclients }}
                                                        </div>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div>
                                                Total Clients
                                                <div class="font-size-sm opacity-75">Under HR</div>
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
                                                        {{ $hractiveclient }}
                                                    </div>
                                                </h3>
                                                <div class="list-icons ml-auto">

                                                </div>
                                            </div>
                                            <div>
                                                Active Client
                                                <div class="font-size-sm opacity-75">Under HR</div>
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
                                                        {{ $hrinactiveclient }}
                                                    </div>
                                                </h3>

                                            </div>
                                            <div>
                                                Inactive Client
                                                <div class="font-size-sm opacity-75">Under HR</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card" style="height: 260px;">
                            <div class="card-header header-elements-sm-inline">
                                <h6 class="card-title">Company Details</h6>
                                <div class="header-elements">
                                    {{-- <span class="badge bg-success badge-pill">Total Employee :</span> --}}
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
                                    @foreach ($hrclients as $hrclient)
                                        <tr>
                                            <td>{{ $hrclient->client_name }}</td>
                                            <td>{{ $hrclient->active_employees + $hrclient->inactive_employees }}</td>
                                            <td>{{ $hrclient->active_employees }}</td>
                                            <td>{{ $hrclient->inactive_employees }}</td>
                                        </tr>
                                    @endforeach

                                </table>
                            </div>
                        </div>
                    </div>



                </div>
            @else
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
                                                            {{ $clients->count() }}
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
                                                        {{ $clients->where('active_status', '0')->count() }}
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
                                                        {{ $clients->where('active_status', '1')->count() }}
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

                    </div>


                </div>
            @endif
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
