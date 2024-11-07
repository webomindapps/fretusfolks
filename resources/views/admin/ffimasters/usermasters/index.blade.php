<x-applayout>
    <x-admin.breadcrumb title="User Masters"  />
    @php

        $columns = [
            ['label' => 'Sl No', 'column' => 'id', 'sort' => true],
            ['label' => 'Name', 'column' => 'name', 'sort' => true],
            ['label' => 'Email Id', 'column' => 'email', 'sort' => true],
            ['label' => 'Password', 'column' => 'Password', 'sort' => true],
            ['label' => 'Date', 'column' => 'date', 'sort' => false],
            ['label' => 'User Type', 'column' => 'user_type', 'sort' => false],
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
    <x-table :columns="$columns" :data="$users" checkAll="{{ true }}" :bulk="route('admin.usermasters')" :route="route('admin.usermasters')">
        <x-slot:filters>
            <form action="" method="POST">
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
        @foreach ($users as $key => $item)
            <tr>
                <td>
                    <input type="checkbox" name="selected_items[]" class="single-item-check"
                        value="{{ $item->id }}">
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
                                <a class="dropdown-item" href="">
                                    <i class='bx bx-edit-alt'></i>
                                    Edit
                                </a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        @endforeach
    </x-table>
</x-applayout>
