<x-applayout>
    <x-admin.breadcrumb title="Update Letter Content" />

    @if ($errors->any())
        <div class="col-lg-12 pb-4">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif


    <div class="col-lg-12 pb-4">
        <div class="form-card px-3">
            <form method="POST" class="formSubmit" action="{{ route('admin.letter_content.edit', $letter_content->id) }}">
                @csrf
                <div class="row">
                    <x-forms.textarea label="Content" name="content" id="content" :required="false"
                        size="col-lg-12 mt-3" value="{!! $letter_content->content !!}" />
                </div>
                <button type="submit" class="submit-btn submitBtn" id="submitButton">Update</button>
            </form>
        </div>
    </div>
</x-applayout>
