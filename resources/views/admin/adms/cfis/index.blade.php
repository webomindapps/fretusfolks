<x-applayout>
    <x-admin.breadcrumb title="  Candidate First Information System" :create="route('admin.cfis.create')" />
    <div class="row">
        <div class="d-flex justify-content-end align-items-center">
            <div class="d-flex gap-3">
                <button onclick="window.location.href='{{ asset('admin/cfis_formate.csv') }}'"
                    class="btn btn-primary text-white">
                    <i class='bx bxs-download'></i> Download Sample
                </button>

                <form action="{{ route('admin.cfis.import') }}" method="POST" enctype="multipart/form-data"
                    class="d-flex align-items-center">
                    @csrf
                    <input type="file" class="form-control form-control-sm me-2" name="file" accept=".csv" required>
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
                    ['label' => 'Employee Name', 'column' => 'emp_name', 'sort' => true],
                    ['label' => 'Interview date', 'column' => 'interview_date', 'sort' => true],
                    ['label' => 'Phone', 'column' => 'phone1', 'sort' => true],
                    ['label' => 'Approval Status', 'column' => 'dcs_approval', 'sort' => true],
                    // ['label' => 'Status', 'column' => 'data_status', 'sort' => true],
                    ['label' => 'Actions', 'column' => 'action', 'sort' => false],
                ];
            @endphp
            <x-table :columns="$columns" :data="$candidate" :checkAll=false :bulk="route('admin.cfis.bulk')" :route="route('admin.cfis')">
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
                        <td> {{ $item->emp_name }}</td>
                        <td> {{ \Carbon\Carbon::parse($item->interview_date)->format('d-m-Y') }}</td>
                        <td> {{ $item->phone1 }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                    id="statusDropdown{{ $item->id }}" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    {{ $item->dcs_approval == 0 ? 'Approved' : ($item->dcs_approval == 1 ? 'Pending' : 'Rejected') }}
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="statusDropdown{{ $item->id }}">
                                    <li><a class="dropdown-item"
                                            href="{{ route('admin.cfis.data_status', ['id' => $item->id, 'newStatus' => 0]) }}">Approved</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('admin.cfis.data_status', ['id' => $item->id, 'newStatus' => 1]) }}">Pending</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('admin.cfis.data_status', ['id' => $item->id, 'newStatus' => 2]) }}">Rejected</a>
                                    </li>
                                </ul>
                            </div>
                        </td>

                        {{-- <td>
                            @if ($item->data_status == 1)
                                <span class="badge rounded-pill sactive">Complected</span>
                            @else
                                <span class="badge rounded-pill deactive">Pending</span>
                            @endif
                        </td> --}}
                        <td>
                            <div class="dropdown pop_Up dropdown_bg">
                                <div class="dropdown-toggle" id="dropdownMenuButton-{{ $item->id }}"
                                    data-bs-toggle="dropdown" aria-expanded="true">
                                    Action
                                </div>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1"
                                    data-popper-placement="top-end">
                                    <li>
                                        {{-- <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal"
                                        data-target="#client_details"
                                        onclick="showClientDetails({{ $item->id }})">
                                        <i class='bx bx-link-alt'></i>
                                        View Details
                                    </a> --}}

                                        <a class="dropdown-item" href="{{ route('admin.cfis.edit', $item) }}">
                                            <i class='bx bx-edit-alt'></i>
                                            Edit
                                        </a>
                                        <a class="dropdown-item"
                                            onclick="return confirm('Are you sure to delete this ?')"
                                            href="{{ route('admin.cfis.delete', $item) }}">
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
</x-applayout>
