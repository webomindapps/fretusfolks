<x-applayout>
    <x-admin.breadcrumb title=" FFI PIP Letters" :create="route('admin.ffi_pip_letter.create')"/>
   
    <div class="row">
        <div class="col-lg-12">
            @php
                $columns = [
                    ['label' => 'Id', 'column' => 'id', 'sort' => true],
                    ['label' => 'From Name', 'column' => 'from_name', 'sort' => true],
                    ['label' => 'Emp Id', 'column' => 'emp_id', 'sort' => true],
                    ['label' => 'To', 'column' => 'emp_name', 'sort' => true],
                    ['label' => 'Date', 'column' => 'date', 'sort' => true],
                    ['label' => 'Phone', 'column' => 'phone1', 'sort' => true],
                    ['label' => 'Designation', 'column' => 'designation', 'sort' => true],
                    ['label' => 'Actions', 'column' => 'action', 'sort' => false],
                ];
            @endphp
            <x-table :columns="$columns" :data="$pip" :checkAll=true :bulk="route('admin.ffi_pip_letter.bulk')" :route="route('admin.ffi_pip_letter')">
                @foreach ($pip as $key => $item)
                    <tr>
                        <td>
                            <input type="checkbox" name="selected_items[]" class="single-item-check"
                                value="{{ $item->id }}">
                        </td>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->from_name }}</td>
                        <td>{{ $item->emp_id }}</td>
                        <td>{{ $item->pip_letter ? $item->pip_letter->emp_name : 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                        <td>{{ $item->pip_letter ? $item->pip_letter->phone1 : 'N/A' }}</td>
                        <td>{{ $item->pip_letter ? $item->pip_letter->designation : 'N/A' }}</td>
                        <td>
                            <div class="dropdown pop_Up dropdown_bg">
                                <div class="dropdown-toggle" id="dropdownMenuButton-{{ $item->id }}"
                                    data-bs-toggle="dropdown" aria-expanded="true">
                                    Action
                                </div>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <a href="{{ route('admin.generate.pip.letter', ['id' => $item->id]) }}"
                                            target="_blank" class="dropdown-item">
                                            <i class="bx bx-link-alt"></i> View Details
                                        </a>
                                        <a href="{{ route('admin.ffi_pip_letter.edit', $item->id) }}"
                                            class="dropdown-item">
                                            <i class="bx bx-edit-alt" aria-hidden="true"></i> Edit
                                        </a>
                                        <a href="{{ route('admin.ffi_pip_letter.delete', $item) }}"
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
