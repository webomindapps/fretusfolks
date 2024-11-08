<x-applayout>
    <x-admin.breadcrumb title="TDS Code" />
    <div class="content">
        <div class="row">
            <div class="col-lg-12 pb-4">
                <div class="form-card px-3">
                    <form action="{{ route('admin.tds_code.store') }}" method="POST" >
                        @csrf
                        <div class="card">
                            <div
                                class="card-header header-elements-inline d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">New TDS Code</h5>
                                <div class="header-elements">
                                    <div class="list-icons d-flex">
                                        <a class="list-icons-item" data-action="collapse" style="cursor: pointer;">
                                            <i class="bx bx-chevron-down"></i>
                                        </a>
                                        <a class="list-icons-item ml-2" data-action="reload" style="cursor: pointer;">
                                            <i class="bx bx-rotate-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <x-forms.input label="TDS Code" type="text" name="code" id="code"
                                            size="col-lg-12" />
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <x-forms.button type="submit" label="Save" class="btn btn-primary" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card" id="tds_table" style="display:block">
            <div class="card-header header-elements-inline d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">TDS Details</h5>
                <div class="header-elements">
                    <div class="list-icons d-flex">
                        <a class="list-icons-item ml-2" data-action="reload" style="cursor: pointer;">
                            <i class="bx bx-rotate-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                @php
                    $columns = [
                        ['label' => 'Id', 'column' => 'id', 'sort' => true],
                        ['label' => 'TDS Code', 'column' => 'code ', 'sort' => true],
                        ['label' => 'Status', 'column' => 'status', 'sort' => true],
                        ['label' => 'Actions', 'column' => 'action', 'sort' => false],
                    ];
                @endphp
                <x-table :columns="$columns" :data="$tds_code" :checkAll=true :bulk="route('admin.usermasters')" :route="route('admin.tds_code')">
                    @foreach ($tds_code as $key => $item)
                        <tr>
                            <td>
                                <input type="checkbox" name="" class="checkinput" value="{{ $item->id }}">
                            </td>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->code }}</td>
                            @if ($item->status)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">In-Active</span>
                            @endif
                            </td>
                            <td>
                                <a onclick="return confirm('Are you sure you want to delete this?')"
                                    href="{{ route('product.delete', $item->id) }}">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </x-table>
            </div>
        </div>

    </div>
</x-applayout>
