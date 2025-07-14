<x-applayout>
    <x-admin.breadcrumb title="  Offer Letters" :create="route('admin.offer_letter.create')" />
    <div class="row mt-2">
        <div class="d-flex justify-content-end align-items-center">
            <div class="d-flex gap-3">
                <a href="{{ asset('admin/letters/offer_letter.xlsx') }}" download="Offer_Letter.xlsx"
                    class="btn btn-primary text-white">
                    <i class='bx bxs-download'></i> Download Sample
                </a>

                <form action="{{ route('admin.offer_letter.bulkimport') }}" method="POST" enctype="multipart/form-data"
                    class="d-flex align-items-center">
                    @csrf
                    <input type="file" class="form-control form-control-sm me-2" name="file" required>
                    <button type="submit" class="add-btn bg-success text-white">Import</button>
                </form>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            @php
            $columns = [
            ['label' => 'SL No', 'column' => 'id', 'sort' => true],
            ['label' => 'Employee ID', 'column' => 'employee_id', 'sort' => true],
            ['label' => 'Emp Name', 'column' => 'emp_name', 'sort' => true],
            ['label' => 'Client Id', 'column' => 'client_emp_id', 'sort' => true],
            ['label' => 'Client Name', 'column' => 'entity_name', 'sort' => true],
            ['label' => 'Offer Letter Created On', 'column' => 'date', 'sort' => true],
            ['label' => 'Phone', 'column' => 'phone1', 'sort' => true],
            ['label' => 'Email', 'column' => 'email', 'sort' => true],
            ['label' => 'Actions', 'column' => 'action', 'sort' => false],
            ];
            @endphp
            <x-table :columns="$columns" :data="$offer" :checkAll=false :bulk="route('admin.ffi_offer_letter.bulk')"
                :route="route('admin.offer_letter')">
                @foreach ($offer as $key => $item)
                <tr>

                    <td>{{$key + 1 }}</td>
                    <td>{{ $item->employee_id ?? 'N/A' }}</td>
                    <td>{{ $item->emp_name }}</td>
                    <td>{{ $item->employee ? $item->employee->client_emp_id : 'N/A' }}</td>
                    <td>{{ $item->entity_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                    <td>{{ $item->phone1 }}</td>
                    <td>{{ $item->email }}</td>
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

                                    <a class="dropdown-item" onclick="return confirm('Are you sure to delete this?')"
                                        href="{{ route('admin.offer_letter.delete', $item) }}">
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