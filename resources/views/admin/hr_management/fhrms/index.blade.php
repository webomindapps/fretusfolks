<x-applayout>
    <x-admin.breadcrumb title=" Fretus HR Management System" :create="route('admin.fhrms.create')" />
    <div class="col-lg-12 mt-4">
        <div class="form-card">
            <div class="row mb-2">
                <div class="col-lg-5 my-auto text-end ms-auto">
                    <a href="{{ asset('admin/FHRMS_Formate.xlsx') }}" class="btn btn-info text-white me-3">
                        Download Sample
                    </a>
                </div>
            </div>

        </div>
    </div>
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
            <x-table :columns="$columns" :data="$employee" :checkAll=true :bulk="route('admin.fhrms.bulk')" :route="route('admin.fhrms')">
                <x-slot:filters>
                    <div class="row px-2 align-items-center">
                        <!-- Export Form -->
                        <div class="col-lg-6 d-flex align-items-center">
                            <form action="{{ route('admin.fhrms.export') }}" method="POST" class="w-100">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4">
                                        <input type="date" class="form-control" name="from_date" id="from_date">
                                    </div>
                                    <div class="col-lg-1 text-center my-auto">
                                        <span class="fw-semibold fs-6">To</span>
                                    </div>
                                    <div class="col-lg-4">
                                        <input type="date" class="form-control" name="to_date" id="to_date">
                                    </div>
                                    <div class="col-lg-3">
                                        <button type="submit"
                                            class="add-btn bg-success text-white w-100">Export</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-lg-6 d-flex justify-content-end">
                            <form id="importForm" method="POST" action="{{ route('admin.fhrms.bulk.upload') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="import_file" id="importFile" class="d-none"
                                    accept=".xlsx,.csv,.txt">
                                <button type="button" class="add-btn bg-success text-white"
                                    id="importButton">Import</button>
                            </form>
                        </div>
                    </div>

                </x-slot:filters>
                @foreach ($employee as $key => $item)
                    <tr>
                        <td>
                            <input type="checkbox" name="selected_items[]" class="single-item-check"
                                value="{{ $item->id }}">
                        </td>
                        <td>{{ $item->id }}</td>
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
                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal"
                                            data-target="#client_details"
                                            onclick="showEmployeeDetails({{ $item->id }})">
                                            <i class='bx bx-link-alt'></i>
                                            View Details
                                        </a>

                                        <a class="dropdown-item" href="{{ route('admin.fhrms.edit', $item) }}">
                                            <i class='bx bx-edit-alt'></i>
                                            Edit
                                        </a>
                                        <a class="dropdown-item"
                                            onclick="return confirm('Are you sure to move to trash ?')"
                                            href="{{ route('admin.fhrms.delete', $item) }}">
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
    <x-model1 />
    @push('scripts')
        <script>
            function showEmployeeDetails(employeeId) {
                fetch(`/admin/fhrms/show/${employeeId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.html_content) {
                            document.querySelector('#client_details').innerHTML = data.html_content;
                            $('#client_details').modal('show');
                            const closeButton = document.querySelector('#closeModalButton');
                            if (closeButton) {
                                closeButton.addEventListener('click', function() {
                                    $('#client_details').modal('hide');
                                });
                            }
                        } else {
                            console.error('No HTML content found in the response');
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching client details:', error);
                    });
            }
            document.getElementById('importButton').addEventListener('click', function() {
                document.getElementById('importFile').click();
            });

            document.getElementById('importFile').addEventListener('change', function() {
                if (this.files.length > 0) {
                    document.getElementById('importForm').submit();
                }
            });
        </script>
    @endpush
</x-applayout>
