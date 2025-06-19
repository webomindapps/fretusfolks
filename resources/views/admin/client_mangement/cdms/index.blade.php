<x-applayout>
    <x-admin.breadcrumb title=" Client Database Management System" :create="route('admin.cdms.create')" />
    <div class="row">
        <div class="col-lg-12">
            @php
                $columns = [
                    ['label' => 'Id', 'column' => 'id', 'sort' => true],
                    ['label' => 'Client Code', 'column' => 'client_code', 'sort' => true],
                    ['label' => 'Client Name', 'column' => 'client_name', 'sort' => true],
                    ['label' => 'Contact Person', 'column' => 'contact_person', 'sort' => true],
                    ['label' => 'Contact Person Phone', 'column' => 'contact_person_phone', 'sort' => true],
                    ['label' => 'Contact Person Email', 'column' => 'contact_person_email', 'sort' => true],
                    ['label' => 'Status', 'column' => 'active_status', 'sort' => true],
                    ['label' => 'Actions', 'column' => 'action', 'sort' => false],
                ];
            @endphp
            <x-table :columns="$columns" :data="$client" :checkAll=true :bulk="route('admin.cdms.bulk')" :route="route('admin.cdms')">
                <x-slot:filters>
                    <form action="{{ route('admin.cdms.export') }}" method="POST">
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
                @foreach ($client as $key => $item)
                    <tr>
                        <td>
                            <input type="checkbox" name="selected_items[]" class="single-item-check"
                                value="{{ $item->id }}">
                        </td>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->client_code }}</td>
                        <td>
                            {{ $item->client_name }}
                        </td>
                        <td> {{ $item->contact_person }}</td>
                        <td>{{ $item->contact_person_phone }}</td>
                        <td> {{ $item->contact_person_email }}</td>
                        <td>
                            @if ($item->active_status)
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
                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal"
                                            data-target="#client_details"
                                            onclick="showClientDetails({{ $item->id }})">
                                            <i class='bx bx-link-alt'></i>
                                            View Details
                                        </a>

                                        <a class="dropdown-item" href="{{ route('admin.cdms.edit', $item) }}">
                                            <i class='bx bx-edit-alt'></i>
                                            Edit
                                        </a>
                                        <a class="dropdown-item"
                                            onclick="return confirm('Are you sure to delete this ?')"
                                            href="{{ route('admin.cdms.delete', $item) }}">
                                            <i class='bx bx-trash-alt'></i>
                                            Delete
                                        </a>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.cdms.updateStatus', ['id' => $item->id, 'status' => 0]) }}">
                                            <i class='bx bx-check-circle'></i>
                                            Active
                                        </a><a class="dropdown-item"
                                            href="{{ route('admin.cdms.updateStatus', ['id' => $item->id, 'status' => 1]) }}">
                                            <i class='bx bx-x-circle'></i>
                                            In-Active
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
    <!-- Modal HTML -->
    <x-model1 />
    @push('scripts')
        <script>
            function showClientDetails(clientId) {
                fetch(`/admin/cdms/show/${clientId}`)
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
