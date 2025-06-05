<x-applayout>
    <x-admin.breadcrumb title="Receivables" :create="route('admin.fcms.receivable.create')" />
    <div class="row">
        <div class="col-lg-12">
            @php
            $columns = [
            ['label' => 'Id', 'column' => 'id', 'sort' => true],
            ['label' => 'Client Name', 'column' => 'client_name', 'sort' => false],
            ['label' => 'Invoice No', 'column' => 'contact_person', 'sort' => false],
            ['label' => 'Invoice amount', 'column' => 'total_amt_gst', 'sort' => true],
            ['label' => 'Received Data', 'column' => 'payment_received_date', 'sort' => true],
            ['label' => 'Received Amount', 'column' => 'amount_received', 'sort' => true],
            ['label' => 'Balance Amount', 'column' => 'balance_amount', 'sort' => true],
            ['label' => 'Month', 'column' => 'month', 'sort' => true],
            ['label' => 'Actions', 'column' => 'action', 'sort' => false],
            ];
            @endphp
            <x-table :columns="$columns" :data="$recipts" :checkAll=false :bulk="route('admin.cms.esic')"
                :route="route('admin.fcms.receivables')">
                @foreach ($recipts as $key => $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        {{ $item->client?->client_name }}
                    </td>
                    <td>{{ $item->invoice?->invoice_no }}</td>
                    <td> {{ $item->total_amt_gst }}</td>
                    <td>{{ !empty($item->payment_received_date) ? date('d-m-Y', strtotime($item->payment_received_date))
                        : 'N/A' }}</td>
                    <td>{{ $item->amount_received }}</td>
                    <td>{{ $item->balance_amount }}</td>
                    <td>{{ $item->month }}</td>

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
                                    <a class="dropdown-item" onclick="return confirm('Are you sure to delete this ?')"
                                        href="{{ route('admin.receivable.delete', $item) }}">
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
            fetch(`{{url('/')}}/admin/receivable/show/${clientId}`)
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