<x-applayout>
    <x-admin.breadcrumb title="Documents Rejected "  />
    <div class="row">
        <div class="col-lg-12">
            @php
                $columns = [
                    ['label' => 'SL No', 'column' => 'id', 'sort' => true],
                    ['label' => 'FFI Employee ID', 'column' => 'ffi_emp_id', 'sort' => true],
                    ['label' => 'Client ID', 'column' => 'client_emp_id', 'sort' => true],
                    ['label' => 'Client Name', 'column' => 'entity_name', 'sort' => true],
                    ['label' => 'Employee Name', 'column' => 'emp_name', 'sort' => true],
                    ['label' => 'Phone', 'column' => 'phone1', 'sort' => true],
                    // ['label' => ' Status', 'column' => 'status', 'sort' => false],
                    ['label' => 'Actions', 'column' => 'action', 'sort' => false],
                ];
            @endphp
            <x-table :columns="$columns" :data="$candidate" :checkAll=true :bulk="route('admin.cfis.bulk')" :route="route('admin.doc_rejected')">

                @foreach ($candidate as $key => $item)
                    <tr>
                        <td>
                            <input type="checkbox" name="selected_items[]" class="single-item-check"
                                value="{{ $item->id }}">
                        </td>
                        <td>{{ $key + 1 }}</td>
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
                        </td> --}}
                        {{-- <td>
                            @if ($item->status == 2)
                                <span class="badge rounded-pill deactive">Rejected</span>
                            @endif
                        </td> --}}
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

                                        <a class="dropdown-item"
                                            href="{{ route('admin.dcs_approval.docedit', $item) }}">
                                            <i class='bx bx-edit-alt'></i>
                                            Edit
                                        </a>
                                        <a class="dropdown-item"
                                            onclick="return confirm('Are you sure to delete this ?')"
                                            href="{{ route('admin.dcs_approval.delete', $item) }}">
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
