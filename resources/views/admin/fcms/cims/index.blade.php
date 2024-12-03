<x-applayout>
    <x-admin.breadcrumb title="Client Invoice Management System" :create="route('admin.fcms.cims.create')" />
    <div class="row">
        <div class="col-lg-12">
            @php
                $columns = [
                    ['label' => 'Id', 'column' => 'id', 'sort' => true],
                    ['label' => 'Client Name', 'column' => 'client_name', 'sort' => false],
                    ['label' => 'Invoice No', 'column' => 'contact_person', 'sort' => false],
                    ['label' => 'Location', 'column' => 'month', 'sort' => true],
                    ['label' => 'GST No', 'column' => 'year', 'sort' => true],
                    ['label' => 'Grand Total', 'column' => 'year', 'sort' => true],
                    ['label' => 'Invoice Date', 'column' => 'year', 'sort' => true],
                    ['label' => 'Actions', 'column' => 'action', 'sort' => false],
                ];
            @endphp
            <x-table :columns="$columns" :data="$invoices" :checkAll=false :bulk="route('admin.cms.esic')" :route="route('admin.cms.esic')">
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
                                        <a class="dropdown-item"
                                            href="{{ route('admin.fcms.cims.edit', $item) }}">
                                            <i class='bx bx-pencil'></i>
                                            Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            onclick="return confirm('Are you sure to delete this ?')"
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
</x-applayout>
