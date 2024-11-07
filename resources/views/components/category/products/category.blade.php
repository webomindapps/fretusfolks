<div class="prod-sub-cat" style="margin-left: 30px">
    <a data-toggle="collapse" data-target="#collapse-{{ $cate->id }}" aria-expanded="true"
        aria-controls="collapse-{{ $cate->id }}">
    </a>
    <label class="" for="{{ $cate->id }}">
        <input type="checkbox" class="form-check-input me-2" id="{{ $cate->id }}" name="category_id[]"
            value="{{ $cate->id }}" @if (isset($category) && in_array($cate->id, $category)) checked @endif>
        {{ $cate->name }}
    </label>
    <div class="sub-cat-scroll">
        @foreach ($cate->children as $subcategory)
            @if (isset($category))
                <x-utility.category.products.category :cate="$subcategory" :category="$category" />
            @else
                <x-utility.category.products.category :cate="$subcategory" />
            @endif
        @endforeach
    </div>
</div>
