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

        <div class="container-fluid">
            <div class="row pb-4 px-1">
                <div class="dashboard-stats">
                    <div class="row">
                        <h4 class="title_heading">Modules</h4>
                        <div class="col-lg-3">
                            <a href="">
                                <div class="dashboard-card">
                                    <div class="title">
                                        Orders
                                    </div>
                                    <div class="data">
                                        10
                                    </div>
                                    <div class="icon">
                                        <i class="fal fa-box-full"></i>
                                    </div>
                                </div>
                            </a>
                        </div>

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
