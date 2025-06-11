<x-applayout>
    <x-admin.breadcrumb title="Candidate Master">

        <div class="d-flex justify-content-end align-items-center">
            <div class="d-flex gap-3">
                <form action="{{ route('admin.candidatemaster.formdownload') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-primary text-white">
                        <i class='bx bxs-download'></i> Download
                    </button>
                </form>

                <form action="{{ route('admin.candidatemaster.import') }}" method="POST" enctype="multipart/form-data"
                    class="d-flex align-items-center">
                    @csrf
                    <input type="file" class="form-control form-control-sm me-2" name="file" 
                        required>
                    <button type="submit" class="add-btn bg-success text-white">Import</button>
                </form>
            </div>
        </div>

    </x-admin.breadcrumb>
    <div class="row">
        <div class="col-lg-12">
            @php
                $columns = [
                    ['label' => 'Id', 'column' => 'id', 'sort' => true],
                    ['label' => 'Client Name', 'column' => 'entity_name', 'sort' => true],
                    ['label' => 'Employee Name', 'column' => 'emp_name', 'sort' => true],
                    ['label' => 'Phone', 'column' => 'phone1', 'sort' => true],
                    ['label' => 'Actions', 'column' => 'action', 'sort' => false],
                ];
            @endphp
            <x-table :columns="$columns" :data="$candidate" :checkAll=false :bulk="route('admin.cfis.bulk')" :route="route('admin.candidatemaster')">

                <x-slot:filters>

                    <form action="{{ route('admin.candidatemaster.export') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-3">
                                <input type="date" class="form-control" name="from_date" id="from_date">
                            </div>
                            <div class="col-lg-1 text-center my-auto">
                                <span class="fw-semibold fs-6">To</span>
                            </div>
                            <div class="col-lg-3">
                                <input type="date" class="form-control" name="to_date" id="to_date">
                            </div>
                            <div class="col-3">
                                <button type="submit" class="add-btn bg-success text-white">Export</button>
                            </div>
                        </div>
                    </form>

                </x-slot:filters>
                @foreach ($candidate as $key => $item)
                    <tr>

                        <td>{{ $item->id }}</td>
                        <td>
                            {{ $item->entity_name }}
                        </td>
                        <td> {{ $item->emp_name }}</td>
                        <td> {{ $item->phone1 }}</td>

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
                                            href="{{ route('admin.candidatemaster.edit', $item) }}">
                                            <i class='bx bx-edit-alt'></i>
                                            Edit
                                        </a>

                                        <a href="{{ route('admin.candidatemaster.view', $item->id) }}"
                                            class="dropdown-item">
                                            <i class='bx bx-link-alt'></i> View
                                        </a>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.candidatemaster.download', $item->id) }}">
                                            <i class='bx bxs-download'></i>
                                            Download pdf
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
