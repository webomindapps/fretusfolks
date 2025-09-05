<x-applayout>
    <x-admin.breadcrumb title=" ADMS PIP Letters" :create="route('admin.pip_letter.create')" />
    <div class="row mt-2">
        <div class="d-flex justify-content-end align-items-center">
            <div class="d-flex gap-3">
                <a href="{{ asset('admin/letters/pip_letter.xlsx') }}" download="Performance_Improvement_Letter.xlsx"
                    class="btn btn-primary text-white">
                    <i class='bx bxs-download'></i> Download Sample
                </a>

                <form action="{{ route('admin.pip_letter.bulkimport') }}" method="POST"
                    enctype="multipart/form-data" class="d-flex align-items-center">
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
                    ['label' => 'From Name', 'column' => 'from_name', 'sort' => true],
                    ['label' => 'Emp Id', 'column' => 'emp_id', 'sort' => true],
                    ['label' => 'To', 'column' => 'emp_name', 'sort' => false],
                    ['label' => 'Date', 'column' => 'date', 'sort' => true],
                    ['label' => 'Phone', 'column' => 'phone1', 'sort' => false],
                    ['label' => 'Designation', 'column' => 'designation', 'sort' => false],
                    ['label' => 'Actions', 'column' => 'action', 'sort' => false],
                ];
            @endphp
            <x-table :columns="$columns" :data="$pip" :checkAll=false :bulk="route('admin.ffi_pip_letter.bulk')" :route="route('admin.pip_letter')">
                @foreach ($pip as $key => $item)
                    <tr>
                        <td>{{ $pip->firstItem() + $key }}</td>
                        <td>{{ $item->from_name }}</td>
                        <td>{{ $item->emp_id }}</td>
                        <td>{{ $item->pip_letters ? $item->pip_letters->emp_name : 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                        <td>{{ $item->pip_letters ? $item->pip_letters->phone1 : 'N/A' }}</td>
                        <td>{{ $item->pip_letters ? $item->pip_letters->designation : 'N/A' }}</td>
                        <td>
                            <div class="dropdown pop_Up dropdown_bg">
                                <div class="dropdown-toggle" id="dropdownMenuButton-{{ $item->id }}"
                                    data-bs-toggle="dropdown" aria-expanded="true">
                                    Action
                                </div>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <a href="{{ route('admin.pip_letter.viewpdf', ['id' => $item->id]) }}"
                                            target="_blank" class="dropdown-item">
                                            <i class="bx bx-link-alt"></i> View Details
                                        </a>
                                        <a href="{{ route('admin.pip_letter.edit', $item->id) }}"
                                            class="dropdown-item">
                                            <i class="bx bx-edit-alt" aria-hidden="true"></i> Edit
                                        </a>
                                        <a href="{{ route('admin.pip_letter.delete', $item) }}" class="dropdown-item"
                                            onclick="return confirm('Are you sure to delete this?')">
                                            <i class="bx bx-trash-alt"></i> Delete
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
