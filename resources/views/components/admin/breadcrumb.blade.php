@props(['title', 'create' => null, 'isBack' => false, 'isBackLink' => url()->previous()])
<div class="page-header px-0">
    <div class="row">
        <div class="col-lg-6 d-flex align-items-center ">
            @if (!empty($isBack))
                <a href="{{ $isBackLink }}"
                    style="display: inline-flex; align-items: center; padding: 8px 12px; cursor: pointer; font-size: 16px; color: #333; border: 1px solid #ccc; border-radius: 4px; width: fit-content;">
                    <i class='bx bx-arrow-back' style="font-size: 20px; margin-right: 6px;"></i> Back
                </a>
            @endif
            <h3>{{ $title }}</h3>
        </div>
        <div class="col-lg-6">
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
