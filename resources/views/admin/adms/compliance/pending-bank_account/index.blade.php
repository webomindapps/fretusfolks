<x-applayout>
    <x-admin.breadcrumb title="Bank Details" :create="route('admin.bankdetails.create')" />
    <div class="d-flex justify-content-end align-items-center">
        <div class="d-flex gap-3">
            <form action="{{ route('admin.candidatemaster.bankform') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-primary text-white">
                    <i class='bx bxs-download'></i> Download
                </button>
            </form>

            <form action="{{ route('admin.candidatemaster.bankimport') }}" method="POST" enctype="multipart/form-data"
                class="d-flex align-items-center">
                @csrf
                <input type="file" class="form-control form-control-sm me-2" name="file" required>
                <button type="submit" class="add-btn bg-success text-white">Import</button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            @php
                $columns = [
                    ['label' => 'SL No', 'column' => 'id', 'sort' => true],
                    ['label' => 'Employee ID', 'column' => 'emp_id', 'sort' => true],
                    ['label' => 'Client ID', 'column' => 'client_emp_id', 'sort' => true],
                    ['label' => 'Client Name', 'column' => 'entity_name', 'sort' => true],
                    ['label' => 'Employee Name', 'column' => 'emp_name', 'sort' => true],
                    ['label' => 'Bank Name', 'column' => 'bank_name', 'sort' => true],
                    ['label' => 'Bank Account Number', 'column' => 'bank_account_no', 'sort' => true],
                    ['label' => 'Bank IFSC Code', 'column' => 'bank_ifsc_code', 'sort' => true],
                    // ['label' => 'Approval Status', 'column' => 'bank_status', 'sort' => true],
                    ['label' => 'Actions', 'column' => 'action', 'sort' => false],
                ];
            @endphp
            <x-table :columns="$columns" :data="$pendingbank" :checkAll=false :bulk="route('admin.cfis.bulk')" :route="route('admin.pendingbankapprovals')">

                <x-slot:filters>

                    <form action="" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-3">
                                <input type="date" class="form-control" name="from_date" id="from_date">
                            </div>
                            <div class="col-lg-1 text-center my-auto">
                                <span class="fw-semibold fs-6">To</span>
                            </div>
                            <div class="col-lg-3">
                                <input type="date" class="form-control" name="to_date" id="to_date">
                            </div>
                        </div>
                    </form>

                </x-slot:filters>
                @foreach ($pendingbank as $key => $item)
                    <tr>

                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->clients?->ffi_emp_id }}</td>
                        <td>{{ $item->clients?->client_emp_id }}</td>
                        <td>{{ $item->clients?->entity_name }}</td>
                        <td>{{ $item->clients?->emp_name }}</td>

                        <td>
                            {{ $item->bank_name }}
                        </td>
                        <td> {{ $item->bank_account_no }}</td>
                        <td> {{ $item->bank_ifsc_code }}</td>
                        {{-- <td>
                            @if ($item->bank_status == 0)
                                <span class="badge rounded-pill deactive">Pending</span>
                            @else
                                <span class="badge rounded-pill sactive">Complected</span>
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
                                        <a class="dropdown-item"
                                            href="{{ route('admin.pendingbankapprovals.edit', $item->id) }}">
                                            <i class='bx bx-edit-alt'></i>
                                            Edit
                                        </a>
                                        <a href="{{ route('admin.pendingbankapprovals.delete', $item->id) }}"
                                            class="dropdown-item"
                                            onclick="return confirm('Are you sure to delete this?')">
                                            <i class="bx bx-trash-alt"></i>
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
