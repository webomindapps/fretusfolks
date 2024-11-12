<x-applayout>
    <x-admin.breadcrumb title=" Client Database Management System" />
    <div class="col-lg-12 mt-4">
        <div class="form-card">
            <div class="row mb-2">
                <div class="col-lg-5 my-auto text-end ms-auto">
                    </a>
                    <a href="{{ route('admin.cdms.create') }}" class="add-btn bg-success text-white">
                        New Client
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
                    ['label' => 'Client Name', 'column' => 'client_name', 'sort' => true],
                    ['label' => 'Contact Person', 'column' => 'contact_person', 'sort' => true],
                    ['label' => 'Contact Person Phone', 'column' => 'contact_person_phone', 'sort' => true],
                    ['label' => 'Contact Person Email', 'column' => 'contact_person_email', 'sort' => true],
                    ['label' => 'Actions', 'column' => 'action', 'sort' => false],
                ];
            @endphp
            <x-table :columns="$columns" :data="$client" :checkAll=true :bulk="route('admin.cdms.bulk')" :route="route('admin.cdms')">
                @foreach ($client as $key => $item)
                    <tr>
                        <td>
                            <input type="checkbox" name="selected_items[]" class="single-item-check"
                                value="{{ $item->id }}">
                        </td>
                        <td>{{ $item->id }}</td>
                        <td>
                            {{ $item->client_name }}
                        </td>
                        <td> {{ $item->contact_person }}</td>
                        <td>{{ $item->contact_person_phone }}</td>
                        <td> {{ $item->contact_person_email }}</td>

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
    <div class="modal fade" id="client_details" tabindex="-1" role="dialog" aria-labelledby="clientDetailsLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="clientDetailsLabel">Client Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- The modal content will be dynamically inserted here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function showClientDetails(clientId) {
            // Send a request to fetch client details
            fetch(`/admin/cdms/show/${clientId}`)
                .then(response => response.json()) // Expecting JSON response
                .then(data => {
                    // Check if 'html_content' is in the response
                    if (data.html_content) {
                        // Insert the HTML content into the modal body
                        document.querySelector('#client_details .modal-body').innerHTML = data.html_content;
                        // Show the modal
                        $('#client_details').modal('show');
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
