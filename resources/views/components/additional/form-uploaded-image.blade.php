@if ($attributes->get('multiple'))

    <div class="{{ $attributes->get('size') }}">
        <div class="form-group">
            <label class="form-label">{{ $label }}
            </label>
            <div class="row">
                @foreach ($attributes->get('images') as $image)
                    <div class="col-lg-4">
                        <img src="{{ asset("storage/$image->url") }}" height="100" />
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@else
    <div class="{{ $attributes->get('size') }}">
        <div class="form-group">
            <label class="form-label">{{ $label }}
            </label>
            <img src="{{ $attributes->get('src') }}" />
        </div>
    </div>

@endif
