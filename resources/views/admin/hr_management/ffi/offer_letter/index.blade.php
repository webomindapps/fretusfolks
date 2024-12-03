<x-applayout>
    <x-admin.breadcrumb title=" FFI Offer Letters" :create="route('admin.ffi_offer_letter.create')" />
   
    <div class="row">
        <div class="col-lg-12">
            @php
                $columns = [
                    ['label' => 'Id', 'column' => 'id', 'sort' => true],
                    ['label' => 'Emp Name', 'column' => 'emp_name', 'sort' => true],
                    ['label' => 'Offer Letter Created On', 'column' => 'date', 'sort' => true],
                    ['label' => 'Phone', 'column' => 'phone1', 'sort' => true],
                    ['label' => 'Email', 'column' => 'email', 'sort' => true],
                    ['label' => 'Actions', 'column' => 'action', 'sort' => false],
                ];
            @endphp
            <x-table :columns="$columns" :data="$offer" :checkAll=true :bulk="route('admin.ffi_offer_letter.bulk')" :route="route('admin.ffi_offer_letter')">
                @foreach ($offer as $key => $item)
                    <tr>
                        <td>
                            <input type="checkbox" name="selected_items[]" class="single-item-check"
                                value="{{ $item->id }}">
                        </td>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->employee ? $item->employee->emp_name : 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                        <td>{{ $item->employee ? $item->employee->phone1 : 'N/A' }}</td>
                        <td>{{ $item->employee ? $item->employee->email : 'N/A' }}</td>
                        <td>
                            <div class="dropdown pop_Up dropdown_bg">
                                <div class="dropdown-toggle" id="dropdownMenuButton-{{ $item->id }}"
                                    data-bs-toggle="dropdown" aria-expanded="true">
                                    Action
                                </div>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <a href="{{ route('admin.generate.offer.letter', ['id' => $item->id]) }}"
                                            target="_blank" class="dropdown-item">
                                            <i class="bx bx-link-alt"></i> View Details
                                        </a>

                                        <a class="dropdown-item"
                                            onclick="return confirm('Are you sure to delete this?')"
                                            href="{{ route('admin.ffi_offer_letter.delete', $item) }}">
                                            <i class='bx bx-trash-alt'></i> Delete
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
