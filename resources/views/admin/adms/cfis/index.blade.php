<x-applayout>
    <x-admin.breadcrumb title="  Candidate First Information System" :create="route('admin.cfis.create')" />
    <div class="row">
        <div class="col-lg-12">
            @php
                $columns = [
                    ['label' => 'Id', 'column' => 'id', 'sort' => true],
                    ['label' => 'Client Name', 'column' => 'client_id', 'sort' => true],
                    ['label' => 'Employee Name', 'column' => 'emp_name', 'sort' => true],
                    ['label' => 'Joining date', 'column' => 'joining_date', 'sort' => true],
                    ['label' => 'Phone', 'column' => 'phone1', 'sort' => true],
                    ['label' => 'Approval Status', 'column' => 'data_status', 'sort' => true],
                    ['label' => 'Status', 'column' => 'status', 'sort' => true],
                    ['label' => 'Actions', 'column' => 'action', 'sort' => false],
                ];
            @endphp
            <x-table :columns="$columns" :data="$candidate" :checkAll=true :bulk="route('admin.cfis.bulk')" :route="route('admin.cfis')">
                <x-slot:filters>
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
                </x-slot:filters>
                @foreach ($candidate as $key => $item)
                    <tr>
                        <td>
                            <input type="checkbox" name="selected_items[]" class="single-item-check"
                                value="{{ $item->id }}">
                        </td>
                        <td>{{ $item->id }}</td>
                        <td>
                            {{ $item->client_id }}
                        </td>
                        <td> {{ $item->emp_name }}</td>
                        <td> {{ \Carbon\Carbon::parse($item->joining_date)->format('d-m-Y') }}</td>
                        <td> {{ $item->phone1 }}</td>
                        <td>
                            <a href="{{ route('admin.cfis.data_status', $item->id) }}">
                                @if ($item->data_status)
                                    <i class="fa fa-toggle-on text-success" aria-hidden="true"
                                        style="font-size: 24px;"></i>
                                @else
                                    <i class="fa fa-toggle-off text-danger" aria-hidden="true"
                                        style="font-size: 24px;"></i>
                                @endif
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('admin.cfis.status', $item->id) }}">
                                @if ($item->status)
                                    <i class="fa fa-toggle-on text-success" aria-hidden="true"
                                        style="font-size: 24px;"></i>
                                @else
                                    <i class="fa fa-toggle-off text-danger" aria-hidden="true"
                                        style="font-size: 24px;"></i>
                                @endif
                            </a>
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
                                    </a>

                                    <a class="dropdown-item" href="{{ route('admin.cdms.edit', $item) }}">
                                        <i class='bx bx-edit-alt'></i>
                                        Edit
                                    </a> --}}
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
