<div class="{{ $attributes->get('size') }}">
    <div class="form-group border p-2">
        <label for="">Select category</label>
        <hr class="my-1">
        <div class="row">
            @foreach ($all as $cate)
                @if (isset($category))
                    <div class="col-lg-4 my-2">
                        <x-utility.category.products.category :cate="$cate" :category="$category" />
                    </div>
                @else
                    <div class="col-lg-4">
                        <x-utility.category.products.category :cate="$cate" />
                    </div>
                @endif
            @endforeach
        </div>
        @error('category_id')
            <span style="color: red; font-size:13px;">{{ $message }}</span>
        @enderror
    </div>
</div>
