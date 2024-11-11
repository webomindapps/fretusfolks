<div class="{{ $attributes->get('size') }}" id="form-group-{{ $attributes->get('id') }}">

    <label>{{ $label }}@if ($attributes->get('required'))
            <span style="color: red">*</span>
        @endif
    </label>

    <div class="d-flex flex-row">
        @foreach ($options as $option)
            <div class="form-check me-4">
                <input class="form-check-input" type="radio" id="{{ $attributes->get('id') }}-{{ $loop->index }}"
                    name="{{ $attributes->get('name') }}" value="{{ $option['value'] }}"
                    @if ($attributes->get('value') == $option['value']) checked @endif @if ($attributes->get('required')) required @endif>
                <label class="form-check-label" for="{{ $attributes->get('id') }}-{{ $loop->index }}">
                    {{ $option['label'] }}
                </label>
            </div>
        @endforeach
    </div>

    @error($attributes->get('name'))
        <small id="error-{{ $attributes->get('id') }}" class="form-text text-danger">{{ $message }}</small>
    @enderror

</div>
