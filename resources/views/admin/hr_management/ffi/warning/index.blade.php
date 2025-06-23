<x-applayout>
    <x-admin.breadcrumb title=" FFI Warning Letters" :create="route('admin.ffi_warning.create')"/>
   
    <div class="row">
        <div class="col-lg-12">
            @php
                $columns = [
                    ['label' => 'Id', 'column' => 'id', 'sort' => true],
                    ['label' => 'Emp Id', 'column' => 'emp_id', 'sort' => true],
                    ['label' => 'Emp Name', 'column' => 'emp_name', 'sort' => false],
                    ['label' => 'Date', 'column' => 'date', 'sort' => false],
                    ['label' => 'Phone', 'column' => 'phone1', 'sort' => false],
                    ['label' => 'Designation', 'column' => 'designation', 'sort' => false],
                    ['label' => 'Actions', 'column' => 'action', 'sort' => false],
                ];
            @endphp
            <x-table :columns="$columns" :data="$warning" :checkAll=false :bulk="route('admin.ffi_warning.bulk')" :route="route('admin.ffi_warning')">
                @foreach ($warning as $key => $item)
                    <tr>
                        {{-- <td>
                            <input type="checkbox" name="selected_items[]" class="single-item-check"
                                value="{{ $item->id }}">
                        </td> --}}
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->emp_id }}</td>
                        <td>{{ $item->warning_letter ? $item->warning_letter->emp_name : 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                        <td>{{ $item->warning_letter ? $item->warning_letter->phone1 : 'N/A' }}</td>
                        <td>{{ $item->warning_letter ? $item->warning_letter->designation : 'N/A' }}</td>
                        <td>
                            <div class="dropdown pop_Up dropdown_bg">
                                <div class="dropdown-toggle" id="dropdownMenuButton-{{ $item->id }}"
                                    data-bs-toggle="dropdown" aria-expanded="true">
                                    Action
                                </div>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <a href="{{ route('admin.generate.warning.letter', ['id' => $item->id]) }}"
                                            target="_blank" class="dropdown-item">
                                            <i class="bx bx-link-alt"></i> View Details
                                        </a>
                                        <a href="{{ route('admin.ffi_warning.edit', $item->id) }}"
                                            class="dropdown-item">
                                            <i class="bx bx-edit-alt" aria-hidden="true"></i> Edit
                                        </a>
                                        <a href="{{ route('admin.ffi_warning.delete', $item) }}"
                                            class="dropdown-item"
                                            onclick="return confirm('Are you sure to delete this?')">
                                            <i class="bx bx-trash-alt"></i> Delete
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
