<x-applayout>
    <x-admin.breadcrumb title="Today's Birthday" />
    <div class="form-card px-3 mt-4">
        <form action="{{ route('admin.fhrms.ffi_birthday') }}" method="GET">
            <div class="row align-items-end">
                <x-forms.input label="Enter Date of Birth:" type="date" name="dob" id="dob" :required="false"
                    size="col-lg-3 mt-2" :value="request()->dob" />
                <div class="col-lg-4">
                    <button type="submit" class="submit-btn submitBtn">Search</button>
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
                    ['label' => 'Emp ID', 'column' => 'ffi_emp_id', 'sort' => true],
                    ['label' => 'Emp Name', 'column' => 'emp_name', 'sort' => true],
                    ['label' => 'Joining date', 'column' => 'joining_date', 'sort' => true],
                    ['label' => 'DOB', 'column' => 'dob', 'sort' => true],
                    ['label' => 'Phone', 'column' => 'phone1', 'sort' => true],
                    ['label' => 'Email', 'column' => 'email', 'sort' => true],
                    ['label' => 'Actions', 'column' => 'action', 'sort' => false],
                ];
            @endphp

            <x-table :columns="$columns" :data="$employee" :bulk="route('admin.fhrms.bulk')" :route="route('admin.fhrms.ffi_birthday')">
                @foreach ($employee as $key => $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->ffi_emp_id }}</td>
                        <td>{{ $item->emp_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->joining_date)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->dob)->format('d-m-Y') }}</td>
                        <td>{{ $item->phone1 }}</td>
                        <td>{{ $item->email }}</td>
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
        </script>
    @endpush
</x-applayout>
