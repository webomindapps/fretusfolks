<x-applayout>
    <x-admin.breadcrumb title="Letter Content" :create="route('admin.letter_content.create')" />
    <div class="row">
        <div class="col-lg-12">
            @php
                $columns = [
                    ['label' => 'Id', 'column' => 'id', 'sort' => true],
                    ['label' => 'Letter Type', 'column' => 'letter_type', 'sort' => true],
                    ['label' => 'contents', 'column' => 'content', 'sort' => false],
                    ['label' => 'Actions', 'column' => 'action', 'sort' => false],
                ];
            @endphp
            <x-table :columns="$columns" :data="$letter_content" :bulk="route('admin.letter_content.bulk')" :checkAll=true :route="route('admin.letter_content')">
                @foreach ($letter_content as $key => $item)
                    <tr>
                        <td>
                            <input type="checkbox" name="selected_items[]" class="single-item-check"
                                value="{{ $item->id }}">
                        </td>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->letter_type }}</td>
                        <td>{{ \Illuminate\Support\Str::words($item->content, 15) }}</td>
                        <td>
                            <a href="{{ route('admin.letter_content.edit', $item->id) }}"><i class="fas fa-edit"
                                    aria-hidden="true"></i></a>
                        </td>
                    </tr>
                @endforeach
            </x-table>
        </div>
    </div>
</x-applayout>
