<x-applayout>
    <x-admin.breadcrumb title="TDS Code" />
    <div class="content">
        <div class="row">
            <div class="col-lg-12 pb-4">
                <div class="form-card px-3">
                    <form action="{{ route('admin.tds_code.store') }}" method="POST">
                        @csrf
                        <div class="card">
                            <div
                                class="card-header header-elements-inline d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">New TDS Code</h5>
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
            </div>
            <div class="row">
                @php
                    $columns = [
                        ['label' => 'Id', 'column' => 'id', 'sort' => true],
                        ['label' => 'TDS Code', 'column' => 'code ', 'sort' => true],
                        ['label' => 'Status', 'column' => 'status', 'sort' => true],
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
                <x-table :columns="$columns" :data="$tds_code" :checkAll=true :bulk="route('admin.tds_code.bulk')" :route="route('admin.tds_code')">
                    @foreach ($tds_code as $key => $item)
                        <tr>
                            <td>
                                <input type="checkbox" name="selected_items[]" class="single-item-check"
                                    value="{{ $item->id }}">
                            </td>
                            <td>{{ $item->id }}</td>
                            <td contenteditable="true" onblur="updateCode(this, {{ $item->id }})"
                                id="{{ $item->id }}">
                                {{ $item->code }}
                            </td>
                            <td>
                                <a href="{{ route('admin.tds_code.status', $item->id) }}">
                                    @if ($item->status)
                                        <i class="fa fa-toggle-on text-success" aria-hidden="true"
                                            style="font-size: 24px;"></i>
                                    @else
                                        <i class="fa fa-toggle-off text-danger" aria-hidden="true"
                                            style="font-size: 24px;"></i>
                                    @endif
                                </a>
                            </td>
                            <td>
                                <a onclick="return confirm('Are you sure you want to delete this?')"
                                    href="{{ route('admin.tds_code.delete', $item->id) }}"><i class="fa fa-trash"
                                        aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </x-table>
            </div>
        </div>

    </div>
    @push('scripts')
        <script>
            function updateCode(element, itemId) {
                const code = element.innerText.trim();
                window.location.href = `/admin/tds_code/update_code/${itemId}?code=${encodeURIComponent(code)}`;
            }
        </script>
    @endpush
</x-applayout>
