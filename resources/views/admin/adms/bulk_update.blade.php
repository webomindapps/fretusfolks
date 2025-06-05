<x-applayout>
    <x-admin.breadcrumb title="  Bulk Update">
        <button type="button" class="add-btn bg-success text-white" data-bs-toggle="modal" data-bs-target="#downloadModal"
            style="
        height: 40px;
        width: 88px;
        padding: 4px;
        margin-right: 50px;">
            Download
        </button>
    </x-admin.breadcrumb>
    <div class="row">
        <div class="d-flex justify-content-end align-items-center">
            <div class="d-flex gap-3">
                <a href='{{ asset('admin/cfis_bulkupdate.csv') }}' class="btn btn-primary text-white"
                    download="cfis_bulkupdate.csv">
                    <i class='bx bxs-download'></i> Download Sample
                </a>

                <form action="{{ route('admin.cfis.bulkimport') }}" method="POST" enctype="multipart/form-data"
                    class="d-flex align-items-center">
                    @csrf
                    <input type="file" class="form-control form-control-sm me-2" name="file" accept=".csv"
                        required>
                    <button type="submit" class="add-btn bg-success text-white">Import</button>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            @php
                $columns = [
                    ['label' => 'Id', 'column' => 'id', 'sort' => true],
                    ['label' => 'Client Name', 'column' => 'client_id', 'sort' => true],
                    ['label' => 'Employee ID', 'column' => 'ffi_emp_id', 'sort' => true],
                    ['label' => 'Employee Name', 'column' => 'emp_name', 'sort' => true],
                    ['label' => 'Date OF leave', 'column' => 'contract_date', 'sort' => true],
                    // ['label' => 'Approval Status', 'column' => 'dcs_approval', 'sort' => true],
                    // ['label' => 'Status', 'column' => 'data_status', 'sort' => true],
                    // ['label' => 'Actions', 'column' => 'action', 'sort' => false],
                ];
            @endphp
            <x-table :columns="$columns" :data="$candidate" :checkAll=false :bulk="route('admin.cfis.bulk')" :route="route('admin.cfisbulk')">
                {{-- <x-slot:filters>
                    <form action="{{ route('admin.cfis.export') }}" method="POST">
                        @csrf
                        <div class="row px-2">
                            <div class="col-lg-3">
                                <div class="cdate">
                                    <input type="date" class="form-control" name="from_date" id="from_date">
                                </div>
                            </div>
                            <div class="col-lg-1 text-center my-auto">
                                <span class="fw-semibold fs-6">To</span>
                            </div>
                            <div class="col-lg-3">
                                <div class="cdate">
                                    <input type="date" class="form-control" name="to_date" id="to_date">
                                </div>
                            </div>
                            <div class="col-3">
                                <button type="submit" class="add-btn bg-success text-white">Export</button>
                            </div>
                        </div>
                    </form>
                </x-slot:filters> --}}
                @foreach ($candidate as $key => $item)
                    <tr>
                        {{-- <td>
                            <input type="checkbox" name="selected_items[]" class="single-item-check"
                                value="{{ $item->id }}">
                        </td> --}}
                        <td>{{ $item->id }}</td>
                        <td>
                            {{ $item->client?->client_name }}
                        </td>
                        <td> {{ $item->ffi_emp_id }}</td>
                        <td> {{ $item->emp_name }}</td>
                        <td> {{ \Carbon\Carbon::parse(time: $item->contract_date)->format('d-m-Y') }}</td>


                        {{-- <td>
                            @if ($item->data_status == 1)
                                <span class="badge rounded-pill sactive">Complected</span>
                            @else
                                <span class="badge rounded-pill deactive">Pending</span>
                            @endif
                        </td> --}}

                    </tr>
                @endforeach
            </x-table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="downloadModal" tabindex="-1" aria-labelledby="downloadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.cfis.bulkdownload') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary">Download Employee Documents</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="client_id">Select Client</label>
                            <select name="client_id" class="form-control" required>
                                <option value="">-- Select Client --</option>
                                @foreach (FretusFolks::getClientname() as $client)
                                    <option value="{{ $client['value'] }}">{{ $client['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="date">Select Date OF leave</label>
                            <input type="date" name="date" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Download</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <style>
        /* Custom modal width */
        #downloadModal .modal-dialog {
            max-width: 450px;
            /* Adjust width as needed */
        }
    </style>
</x-applayout>
