<x-applayout>
    <x-admin.breadcrumb title="User Masters" :create="route('admin.usermasters.create')" />
    @php

        $columns = [
            ['label' => 'Sl No', 'column' => 'id', 'sort' => true],
            ['label' => 'Name', 'column' => 'name', 'sort' => true],
            ['label' => 'Email Id', 'column' => 'email', 'sort' => true],
            ['label' => 'User Name', 'column' => 'username', 'sort' => true],
            ['label' => 'Date', 'column' => 'date', 'sort' => false],
            ['label' => 'User Type', 'column' => 'user_type', 'sort' => false],
            ['label' => 'Status', 'column' => 'status', 'sort' => false],
            ['label' => 'Actions', 'column' => 'actions', 'sort' => false],
        ];

        $bulkOptions = [
            [
                'label' => 'Status',
                'value' => '2',
                'options' => [
                    [
                        'label' => 'Active',
                        'value' => '0',
                    ],
                    [
                        'label' => 'Inactive',
                        'value' => '1',
                    ],
                ],
            ],
        ];
    @endphp
    <x-table :columns="$columns" :data="$users" checkAll="{{ false }}" :bulk="route('admin.usermasters.bulk')" :route="route('admin.usermasters')">
        <x-slot:filters>
            <a href="{{ route('admin.roles') }}" class="add-btn bg-success text-white">Roles & permissions</a>
        </x-slot:filters>
        @foreach ($users as $key => $item)
            <tr>
                {{-- <td>
                    <input type="checkbox" name="selected_items[]" class="single-item-check" value="{{ $item->id }}">
                </td> --}}
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->username }}</td>
                <td>{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                <td>{{ $item->getRoleNames()->first() ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('admin.user.status', $item->id) }}">
                        @if ($item->status)
                            <i class="fa fa-toggle-off text-danger" aria-hidden="true"
                                style="font-size: 24px;"></i>
                        @else
                            <i class="fa fa-toggle-on text-success" aria-hidden="true"
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
                                <a class="dropdown-item" href="{{ route('admin.usermasters.edit', $item->id) }}">
                                    <i class='bx bx-edit-alt'></i>
                                    Edit
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" onclick="return confirm('Are you sure you want to delete?')"
                                    href="{{ route('admin.usermasters.delete', $item->id) }}">
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
</x-applayout>
