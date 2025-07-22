<x-applayout>
    <x-admin.breadcrumb title=" ADMS Increment Letters" :create="route('admin.increment_letter.create')" />
    <div class="row mt-2">
        <div class="d-flex justify-content-end align-items-center">
            <div class="d-flex gap-3">
                <a href="{{ asset('admin/letters/increment_letter.xlsx') }}" download="Increment_Letter.xlsx"
                    class="btn btn-primary text-white">
                    <i class='bx bxs-download'></i> Download Sample
                </a>

                <form action="{{ route('admin.increment_letter.bulkimport') }}" method="POST"
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
                    ['label' => 'Employee ID', 'column' => 'employee_id', 'sort' => true],
                    ['label' => 'Client ID', 'column' => 'employee_id', 'sort' => true],
                    ['label' => 'Client Name', 'column' => 'entity_name', 'sort' => true],
                    ['label' => 'Employee Name', 'column' => 'emp_name', 'sort' => true],
                    ['label' => 'Increment Letter Created On', 'column' => 'date', 'sort' => true],
                    ['label' => 'Designation', 'column' => 'designation', 'sort' => true],
                    ['label' => 'CTC', 'column' => 'ctc', 'sort' => true],
                    ['label' => 'Actions', 'column' => 'action', 'sort' => false],
                ];
            @endphp
            <x-table :columns="$columns" :data="$increment" :checkAll=false :bulk="route('admin.ffi_increment_letter.bulk')" :route="route('admin.increment_letter')">
                @foreach ($increment as $key => $item)
                    <tr>
                        {{-- <td>
                            <input type="checkbox" name="selected_items[]" class="single-item-check"
                                value="{{ $item->id }}">
                        </td> --}}
                        {{-- {{ dd($item->incrementdata );}} --}}
                        <td>{{ $increment->firstItem() + $key }}</td>
                        <td>{{ $item->employee_id ?? 'N/A' }}</td>
                        <td>{{ $item->incrementdata->client_emp_id ?? 'N/A' }}</td>
                        <td>{{ $item->client->client_name ?? 'N/A' }}</td>
                        <td>{{ $item->emp_name ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                        <td>{{ $item->designation ?? 'N/A' }}</td>
                        <td>{{ number_format($item->ctc, 2) ?? 'N/A' }}</td>
                        <td>
                            <div class="dropdown pop_Up dropdown_bg">
                                <div class="dropdown-toggle" id="dropdownMenuButton-{{ $item->id }}"
                                    data-bs-toggle="dropdown" aria-expanded="true">
                                    Action
                                </div>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <a href="{{ route('admin.increment_letter.viewpdf', $item->id) }}"
                                            target="_blank" class="dropdown-item">
                                            <i class="bx bx-link-alt"></i> View Details
                                        </a>

                                        <a class="dropdown-item"
                                            onclick="return confirm('Are you sure to delete this?')"
                                            href="{{ route('admin.increment_letter.delete', $item->id) }}">
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
