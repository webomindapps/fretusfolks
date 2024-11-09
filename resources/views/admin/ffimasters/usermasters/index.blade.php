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
                        'value' => '1',
                    ],
                    [
                        'label' => 'Inactive',
                        'value' => '0',
                    ],
                ],
            ],
        ];
    @endphp
    <x-table :columns="$columns" :data="$users" checkAll="{{ true }}" :bulk="route('admin.usermasters.bulk')" :route="route('admin.usermasters')">
        @foreach ($users as $key => $item)
            <tr>
                <td>
                    <input type="checkbox" name="selected_items[]" class="single-item-check" value="{{ $item->id }}">
                </td>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->username }}</td>
                <td>{{ $item->date }}</td>
                <td>{{ $item->role->name ?? 'N/A' }}</td>
                <td>
                    @if ($item->status)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">In-Active</span>
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
                                <a class="dropdown-item" href="{{ route('admin.usermasters.edit', $item->id) }}">
                                    <i class='bx bx-edit-alt'></i>
                                    Edit
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.usermasters.delete', $item->id) }}">
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
