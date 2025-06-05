<x-applayout>
    <x-admin.breadcrumb title="Roles" />
    <div class="card" id="tds_table" style="display:block">
        <div class="row">
            @php
                $columns = [
                    ['label' => 'Id', 'column' => 'id', 'sort' => true],
                    ['label' => 'Role', 'column' => 'name ', 'sort' => true],
                    ['label' => 'Actions', 'column' => 'action', 'sort' => false],
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
            <x-table :columns="$columns" :data="$roles" :checkAll=false :bulk="route('admin.roles')" :route="route('admin.roles')">
                @foreach ($roles as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>
                            <a class="btn btn-sm btn-success" href="{{ route('admin.permission', $item->id) }}"
                                style="font-size: 10px;">
                                Permission
                            </a>
                        </td>
                    </tr>
                @endforeach
            </x-table>
        </div>
    </div>
</x-applayout>
