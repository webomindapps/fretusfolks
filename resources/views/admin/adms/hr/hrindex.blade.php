<x-applayout>
    <x-admin.breadcrumb title="HR Approved Candidates" />
    <div class="row">
        <div class="col-lg-12">
            @php
                $columns = [
                    ['label' => 'SL No', 'column' => 'id', 'sort' => true],
                    ['label' => 'FFI Employee ID', 'column' => 'ffi_emp_id', 'sort' => true],
                    ['label' => 'Client ID', 'column' => 'client_emp_id', 'sort' => true],
                    ['label' => 'Client Name', 'column' => 'client_id', 'sort' => true],
                    ['label' => 'Employee Name', 'column' => 'emp_name', 'sort' => true],
                    ['label' => 'Phone', 'column' => 'phone1', 'sort' => true],
                    // ['label' => 'Approval Status', 'column' => 'data_status', 'sort' => true],
                    ['label' => 'HR Approval Status', 'column' => 'data_status', 'sort' => false],
                    ['label' => 'Actions', 'column' => 'action', 'sort' => false],
                ];
            @endphp
            <x-table :columns="$columns" :data="$candidates" :checkAll=false :bulk="route('admin.cfis.bulk')" :route="route('admin.hrindex')">
                {{-- <x-slot:filters>
                    <form action="{{ route('admin.dcs_approval.export') }}" method="POST">
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
                @foreach ($candidates as $key => $item)
                    <tr>
                        {{-- <td>
                            <input type="checkbox" name="selected_items[]" class="single-item-check"
                                value="{{ $item->id }}">
                        </td> --}}
                        <td>{{ $candidates->firstItem() + $key }}</td>
                        <td>{{ $item->ffi_emp_id === null || $item->ffi_emp_id === '' ? 'N/A' : $item->ffi_emp_id }}
                        </td>
                        <td>{{ $item->client_emp_id === null || $item->client_emp_id === '' ? 'N/A' : $item->client_emp_id }}
                        </td>
                        <td>
                            {{ $item->entity_name }}
                        </td>
                        <td> {{ trim("{$item->emp_name} {$item->middle_name} {$item->last_name}") ?: 'N/A' }}
                        </td>
                        <td> {{ $item->phone1 }}</td>
                        {{-- <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                    id="statusDropdown{{ $item->id }}" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    {{ $item->data_status == 0 ? 'Pending' : ($item->data_status == 1 ? 'Approved' : 'Rejected') }}
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="statusDropdown{{ $item->id }}">
                                    <li><a class="dropdown-item"
                                            href="{{ route('admin.cfis.data_status', ['id' => $item->id, 'newStatus' => 0]) }}">Pending</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('admin.cfis.data_status', ['id' => $item->id, 'newStatus' => 1]) }}">Approved</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('admin.cfis.data_status', ['id' => $item->id, 'newStatus' => 2]) }}">Rejected</a>
                                    </li>
                                </ul>
                            </div>
                        </td> --}}
                        <td>
                            @if ($item->hr_approval == 1)
                                <span class="badge rounded-pill sactive">Approved</span>
                            @elseif ($item->hr_approval == 0)
                                <span class="badge rounded-pill deactive">Pending</span>
                            @else
                                <span class="badge rounded-pill deactive">Rejected</span>
                            @endif
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
                                        {{-- <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal"
                                        data-target="#client_details"
                                        onclick="showClientDetails({{ $item->id }})">
                                        <i class='bx bx-link-alt'></i>
                                        View Details
                                    </a> --}}

                                        <a class="dropdown-item" href="{{ route('admin.hr.hredit', $item) }}">
                                            <i class='bx bx-edit-alt'></i>
                                            Edit
                                        </a>
                                        {{-- <a class="dropdown-item"
                                            onclick="return confirm('Are you sure to delete this ?')"
                                            href="{{ route('admin.dcs_approval.delete', $item) }}">
                                            <i class='bx bx-trash-alt'></i>
                                            Delete
                                        </a> --}}
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
