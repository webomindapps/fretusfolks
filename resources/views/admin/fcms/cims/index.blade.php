<x-applayout>
    <x-admin.breadcrumb title="Client Invoice Management System" :create="route('admin.fcms.cims.create')" />
    <div class="row">
        <div class="col-lg-12">
            @php
            $columns = [
            ['label' => 'Id', 'column' => 'id', 'sort' => true],
            ['label' => 'Client Name', 'column' => 'client_name', 'sort' => false],
            ['label' => 'Invoice No', 'column' => 'invoice_no', 'sort' => false],
            ['label' => 'Location', 'column' => 'location', 'sort' => false],
            ['label' => 'GST No', 'column' => 'gst_no', 'sort' => true],
            ['label' => 'Grand Total', 'column' => 'grand_total', 'sort' => true],
            ['label' => 'Invoice Date', 'column' => 'date', 'sort' => true],
            ['label' => 'Actions', 'column' => 'action', 'sort' => false],
            ];
            @endphp
            <x-table :columns="$columns" :data="$invoices" :checkAll=false :bulk="route('admin.fcms.cims')"
                :route="route('admin.fcms.cims')">
                @foreach ($invoices as $key => $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>
                        {{ $item->client?->client_name }}
                    </td>
                    <td>{{ $item->invoice_no }}</td>
                    <td> {{ $item->state?->state_name }}</td>
                    <td>{{ $item->gst_no }}</td>
                    <td>{{ $item->grand_total }}</td>
                    <td>{{ !empty($item->date) ? date('d-m-Y', strtotime($item->date)) : 'N/A' }}</td>

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
                                        data-target="#client_details" onclick="showClientDetails({{ $item->id }})">
                                        <i class='bx bx-link-alt'></i>
                                        View Details
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.fcms.cims.edit', $item) }}">
                                        <i class='bx bx-pencil'></i>
                                        Edit
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" onclick="return confirm('Are you sure to delete this ?')"
                                        href="{{ route('admin.cms.esic.delete', $item) }}">
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
    <x-model1 />
    @push('scripts')
    <script>
        function showClientDetails(clientId) {
            fetch(`{{url('/')}}/admin/cims/show/${clientId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.html_content) {
                        document.querySelector('#client_details').innerHTML = data.html_content;
                        $('#client_details').modal('show');
                        const closeButton = document.querySelector('#closeModalButton');
                        if (closeButton) {
                            closeButton.addEventListener('click', function () {
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