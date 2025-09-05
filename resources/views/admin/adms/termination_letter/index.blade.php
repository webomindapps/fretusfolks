<x-applayout>
    <x-admin.breadcrumb title=" ADMS Termination Letters" :create="route('admin.termination_letter.create')" />
    <div class="row mt-2">
        <div class="d-flex justify-content-end align-items-center">
            <div class="d-flex gap-3">
                <a href="{{ asset('admin/letters/termination_letter.xlsx') }}" download="Termination_Letter.xlsx"
                    class="btn btn-primary text-white">
                    <i class='bx bxs-download'></i> Download Sample
                </a>

                <form action="{{ route('admin.termination_letter.bulkimport') }}" method="POST"
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
            ['label' => 'Emp Id', 'column' => 'emp_id', 'sort' => true],
            ['label' => 'Client Id', 'column' => 'client_emp_id', 'sort' => true],
            ['label' => 'Client Name', 'column' => 'entity_name', 'sort' => true],
            ['label' => 'Emp Name', 'column' => 'emp_name', 'sort' => false],
            ['label' => 'Date', 'column' => 'date', 'sort' => true],
            ['label' => 'Phone', 'column' => 'phone1', 'sort' => false],
            ['label' => 'Designation', 'column' => 'designation', 'sort' => false],
            ['label' => 'Actions', 'column' => 'action', 'sort' => false],
            ];
            @endphp
            <x-table :columns="$columns" :data="$termination" :checkAll=false :bulk="route('admin.ffi_warning.bulk')"
                :route="route('admin.termination_letter')">
                @foreach ($termination as $key => $item)
                <tr>
                    {{-- <td>
                        <input type="checkbox" name="selected_items[]" class="single-item-check"
                            value="{{ $item->id }}">
                    </td> --}}
                    <td>{{ $termination->firstItem() + $key}}</td>
                    <td>{{ $item->emp_id }}</td>
                    <td>{{ $item->term_letter ? $item->term_letter->client_emp_id : 'N/A' }}</td>
                    <td>{{ $item->term_letter ? $item->term_letter->entity_name : 'N/A' }}</td>
                    <td>{{ $item->term_letter ? $item->term_letter->emp_name : 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                    <td>{{ $item->term_letter ? $item->term_letter->phone1 : 'N/A' }}</td>
                    <td>{{ $item->term_letter ? $item->term_letter->designation : 'N/A' }}</td>
                    <td>
                        <div class="dropdown pop_Up dropdown_bg">
                            <div class="dropdown-toggle" id="dropdownMenuButton-{{ $item->id }}"
                                data-bs-toggle="dropdown" aria-expanded="true">
                                Action
                            </div>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li>
                                    <a href="{{ route('admin.termination_letter.viewpdf', ['id' => $item->id]) }}"
                                        target="_blank" class="dropdown-item">
                                        <i class="bx bx-link-alt"></i> View Details
                                    </a>
                                    <a href="{{ route('admin.termination_letter.edit', ['id' => $item->id]) }}"
                                        class="dropdown-item">
                                        <i class="bx bx-edit-alt" aria-hidden="true"></i> Edit
                                    </a>
                                    <a href="{{ route('admin.termination_letter.delete', $item->id) }}"
                                        class="dropdown-item" onclick="return confirm('Are you sure to delete this?')">
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