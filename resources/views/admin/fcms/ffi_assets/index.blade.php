<x-applayout>
    <x-admin.breadcrumb title="FFI Assets Management" :create="route('admin.fcms.ffi_assets.create')" />
    <div class="content">
        <div class="form-card px-3 mt-4">
            <form action="{{ route('admin.fcms.ffi_assets') }}" method="GET">
                <div class="row">

                    <x-forms.input label="From Date" type="date" name="from_date" id="from-date" :required="false"
                        size="col-lg-3 mt-2" :value="request()->from_date" />
                    <x-forms.input label="To Date" type="date" name="to_date" id="to-date" :required="false"
                        size="col-lg-3 mt-2" :value="request()->to_date" />
                    <div class="col-lg-4  mt-3">
                        <button type="submit" class="submit-btn submitBtn">Search</button>
                        <a href="{{ route('admin.fcms.ffi_assets.export') }}"
                            class="add-btn bg-success text-white" role="button">Export</a>
                    </div>
                </div>
            </form>

        </div>
        <hr>
        <div class="row">
            <div class="col-lg-12">
                @php
                    $columns = [
                        ['label' => 'Id', 'column' => 'id', 'sort' => true],
                        ['label' => 'Emp Name', 'column' => 'employee_id', 'sort' => false],
                        ['label' => 'Asset Name', 'column' => 'asset_name', 'sort' => false],
                        ['label' => 'Asset Code', 'column' => 'asset_code', 'sort' => true],
                        ['label' => 'Issued On', 'column' => 'issued_date', 'sort' => true],
                        ['label' => 'Returned On', 'column' => 'returned_date', 'sort' => true],
                        ['label' => 'Status', 'column' => 'status', 'sort' => true],
                        ['label' => 'Actions', 'column' => 'action', 'sort' => false],
                    ];
                @endphp
                <x-table :columns="$columns" :data="$issues" :checkAll="false" :bulk="route('admin.fcms.ffi_assets.bulk')" :route="route('admin.fcms.ffi_assets')">

                    @foreach ($issues as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->assets->emp_name }}</td>
                            <td>{{ $item->asset_name }}</td>
                            <td>{{ $item->asset_code }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->issued_date)->format('d-m-Y') }} </td>
                            <td>{{ \Carbon\Carbon::parse($item->returned_date)->format('d-m-Y') }} </td>
                            <td>
                                @if ($item->status)
                                    <span class="badge rounded-pill sactive">Issued</span>
                                @else
                                    <span class="badge rounded-pill deactive">Returned</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown pop_Up dropdown_bg">
                                    <div class="dropdown-toggle" id="dropdownMenuButton-{{ $item->id }}"
                                        data-bs-toggle="dropdown" aria-expanded="true">
                                        Action
                                    </div>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('admin.fcms.ffi_assets.edit', $item->id) }}">
                                                <i class='bx bx-pencil'></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                onclick="return confirm('Are you sure to delete this?')"
                                                href="{{ route('admin.fcms.ffi_assets.delete', $item->id) }}">
                                                <i class='bx bx-trash-alt'></i> Delete
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
    </div>
</x-applayout>
