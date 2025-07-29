<x-applayout>
    <x-admin.breadcrumb title="ADMS Trashed Details" />

    <div class="row">
        <div class="col-lg-12">
            @php
                $columns = [
                    ['label' => 'SL No', 'column' => 'id', 'sort' => true],
                    ['label' => 'FFI Employee ID', 'column' => 'ffi_emp_id', 'sort' => true],
                    ['label' => 'Client id', 'column' => 'client_emp_id', 'sort' => true],
                    ['label' => 'Client Name', 'column' => 'entity_name', 'sort' => true],
                    ['label' => 'Employee Name', 'column' => 'emp_name', 'sort' => true],
                    ['label' => 'Phone', 'column' => 'phone1', 'sort' => true],
                    ['label' => 'Status', 'column' => 'status', 'sort' => true],
                    ['label' => 'Actions', 'column' => 'action', 'sort' => false],
                ];
            @endphp
            <x-table :columns="$columns" :data="$candidate" :checkAll=false :bulk="route('admin.cfis.bulk')" :route="route('admin.dcs_approval.trashed')">

                @foreach ($candidate as $key => $item)
                    <tr>
                        {{-- <td>
                            <input type="checkbox" name="selected_items[]" class="single-item-check"
                                value="{{ $item->id }}">
                        </td> --}}
                        <td>{{ $candidate->firstItem() + $key }}</td>
                        <td>{{ $item->ffi_emp_id === null || $item->ffi_emp_id === '' ? 'N/A' : $item->ffi_emp_id }}
                        <td>{{ $item->client_emp_id === null || $item->client_emp_id === '' ? 'N/A' : $item->client_emp_id }}
                        </td>
                        <td>
                            {{ $item->entity_name }}
                        </td>
                        <td>
                            {{ trim("{$item->emp_name} {$item->middle_name} {$item->last_name}") ?: 'N/A' }}
                        </td>
                        <td> {{ $item->phone1 }}</td>
                        <td>
                            @if ($item->status == 0)
                                <span class="badge rounded-pill deactive">In-Active</span>
                            @else
                                <span class="badge rounded-pill sactive">Active</span>
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

                                        <a href="{{ route('admin.dcs_approval.restore', $item) }}"
                                            class="dropdown-item"><i class='bx bx-transfer'></i>Restore</a>
                                        <a class="dropdown-item"
                                            onclick="return confirm('Are you sure to permanently delete this ?')"
                                            href="{{ route('admin.dcs_approval.forceDelete', $item) }}">
                                            <i class='bx bx-trash-alt'></i>
                                            Permanently Delete
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
