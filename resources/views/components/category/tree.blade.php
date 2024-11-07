<div class="{{ $attributes->get('size') }}">
    <div class="form-group border p-2 mt-3">
        <label for="">Select category</label>
        <hr class="my-1">
        <div class="row">
            <div class="col-lg-12 mb-2">
                <div class="">
                    <a data-toggle="collapse" data-target="#collapse-root" aria-expanded="true"
                        aria-controls="collapse-root">
                    </a>
                    <input class="form-check-input" type="radio" id="root" name="parent_id" value=""
                        @if (isset($category) && is_null($category->parent_id)) checked @endif>
                    <label for="root">Root</label>
                </div>
            </div>

            @foreach ($all as $cate)
                @if (isset($category))
                    @if ($category->id != $cate->id)
                        <div class="col-lg-4 my-2">
                            <x-category.category :cate="$cate" :category="$category" />
                        </div>
                    @endif
                @else
                    <div class="col-lg-4">
                        <x-category.category :cate="$cate" />
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
