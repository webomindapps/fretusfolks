<x-applayout>
    <x-admin.breadcrumb title="TDS Code" />
    <div class="content">
        <div class="form-card px-md-3 px-2 mt-2">
            <form action="{{ route('admin.tds_code.store') }}" method="POST">
                @csrf
                <div class="row align-items-end">
                    <x-forms.input label="New TDS Code" type="text" name="code" id="code" size="col-lg-4" />
                    <x-forms.button type="submit" label="Save" class="btn btn-primary col-1" />
                </div>
            </form>
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
            <x-table :columns="$columns" :data="$tds_code" :checkAll=false :bulk="route('admin.tds_code.bulk')" :route="route('admin.tds_code')">
                @foreach ($tds_code as $key => $item)
                    <tr>
                        {{-- <td>
                            <input type="checkbox" name="selected_items[]" class="single-item-check"
                                value="{{ $item->id }}">
                        </td> --}}
                        <td>{{ $item->id }}</td>
                        <td>
                            <input type="text" onblur="updateCode(this, {{ $item->id }})"
                                id="{{ $item->id }}" value="{{ $item->code }}">
                        </td>
                        <td>
                            <a href="{{ route('admin.tds_code.status', $item->id) }}">
                                @if ($item->status)
                                    <i class="fa fa-toggle-off text-danger" aria-hidden="true"
                                        style="font-size: 24px;"></i>
                                @else
                                    <i class="fa fa-toggle-on text-success" aria-hidden="true"
                                        style="font-size: 24px;"></i>
                                @endif
                            </a>
                        </td>
                        <td>
                            <a onclick="return confirm('Are you sure you want to delete this?')"
                                href="{{ route('admin.tds_code.delete', $item->id) }}">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </x-table>
        </div>

    </div>
    @push('scripts')
        <script>
            function updateCode(element, itemId) {
                const code = element.value;
                window.location.href = "{{ url('/') }}" +
                    `/admin/tds_code/update_code/${itemId}?code=${encodeURIComponent(code)}`;
            }
        </script>
    @endpush
</x-applayout>
