<x-applayout>
    <x-admin.breadcrumb title="FHRMS Trashed" />

    <div class="row">
        <div class="col-lg-12">
            @php
                $columns = [
                    ['label' => 'Id', 'column' => 'id', 'sort' => true],
                    ['label' => 'Employee Id', 'column' => 'ffi_emp_id', 'sort' => true],
                    ['label' => 'Emp Name', 'column' => 'emp_name', 'sort' => true],
                    ['label' => 'Joining date', 'column' => 'joining_date', 'sort' => true],
                    ['label' => 'Phone', 'column' => 'phone1', 'sort' => true],
                    ['label' => 'Email', 'column' => 'email', 'sort' => true],
                    ['label' => 'Status', 'column' => 'status', 'sort' => true],
                    ['label' => 'Actions', 'column' => 'action', 'sort' => false],
                ];
            @endphp
            <x-table :columns="$columns" :data="$employee" :checkAll=true :bulk="route('admin.fhrms.bulk')" :route="route('admin.fhrms.trashed')">

                @foreach ($employee as $key => $item)
                    <tr>
                        <td>
                            <input type="checkbox" name="selected_items[]" class="single-item-check"
                                value="{{ $item->id }}">
                        </td>
                        <td>{{ $employee->firstItem() + $key }}</td>
                        <td>{{ $item->ffi_emp_id }}</td>
                        <td> {{ $item->emp_name }}</td>
                        <td> {{ \Carbon\Carbon::parse($item->joining_date)->format('d-m-Y') }}</td>
                        <td> {{ $item->phone1 }}</td>
                        <td>
                            {{ $item->email }}
                        </td>
                        <td>
                            @if ($item->status)
                                <span class="badge rounded-pill sactive">Complected</span>
                            @else
                                <span class="badge rounded-pill deactive">Pending</span>
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

                                        <a href="{{ route('admin.fhrms.restore', $item) }}" class="dropdown-item"><i
                                                class='bx bx-transfer'></i>Restore</a>
                                        <a class="dropdown-item"
                                            onclick="return confirm('Are you sure to permanently delete this ?')"
                                            href="{{ route('admin.fhrms.forceDelete', $item) }}">
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
