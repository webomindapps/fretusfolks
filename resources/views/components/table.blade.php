<div class="col-lg-12 mt-4 pb-4">
    <input type="hidden" id="current_route" value="{{ $route }}">
    <input type="hidden" id="bulk_route" value="{{ $bulk }}">
    <div class="row mb-2 px-2">
        <div class="col-md-9">
            @if (isset($filters))
                {{ $filters }}
            @endif
        </div>
        <div class="col-md-3">
            <form id="searchForm">
                <label class="search_sec">
                    Search:
                    <input type="search" id="searchBox" class="" placeholder="">
                </label>
                {{-- <div class="search-bar">
                    <input type="search" name="" id="searchBox" placeholder="Search here">
                    <i class="bx bx-search"></i>
                </div> --}}
            </form>
        </div>
        {{-- <div class="col-lg-2">
            <button type="button" class="clearSearch-btn" id="clearFilters">Clear Search</button>
        </div> --}}


    </div>
    <div class="row custom-table-scroll">
        <div class="col-lg-12">
            <table class="table">
                <thead>
                    <tr>
                        @if (isset($checkAll) && $checkAll)
                            <th>
                                <input type="checkbox" id="checkAll" class="checkALl">
                            </th>
                        @endif

                        <th colspan="{{ count($columns) }}" id="bulk-options" style="display: none;">
                            <div class="row">
                                <div class="col-lg-3">
                                    <select id="bulkOperation">
                                        <option value="">Select</option>
                                        <option value="1">Delete</option>
                                        <option value="2">Status Change</option>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <select name="" id="bulkStatus" style="display: none;">
                                        <option value="">Select</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </th>

                        @foreach ($columns as $column)
                            <th class="sorting" data-sort="{{ $column['sort'] }}" data-column="{{ $column['column'] }}"
                                scope="col">
                                {{ $column['label'] }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    {{ $slot }}
                </tbody>
            </table>
        </div>
    </div>
    <div class="row text-center">
        <div class="col-lg-12">
            {{ $data->onEachSide(0)->withQueryString()->links() }}
        </div>
    </div>

</div>
<style>
    .custom-table-scroll {
        height: 500px;
        overflow: auto;
        position: relative;
        /* Needed for absolute-positioned children */
        z-index: 1;
        /* Add z-index if needed */
    }

    .dropdown-menu {
        z-index: 1000;
        /* Bootstrap usually does this already */
    }

    .custom-table-scroll thead th {
        position: sticky;
        top: 0;
        background-color: #fff;
        z-index: 5;
    }

    /* Optional: If you want the checkbox/bulk row to stay fixed too */
    .custom-table-scroll thead th[colspan] {
        background-color: #f9f9f9;
        z-index: 6;
    }
</style>
