@props(['title', 'create' => null])
<div class="page-header px-0">
    <div class="row">
        <div class="col-lg-4 d-flex align-items-center ">
            <h3>{{ $title }}</h3>
        </div>
        <div class="col-lg-8">
            <div class="row d-flex justify-content-end">
                @if ($create)
                    <div class="col-lg-2">
                        <a href="{{ $create }}" class="add-btn bg-success text-white">Add</a>
                    </div>
                @endif
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
