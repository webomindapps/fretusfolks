<x-applayout>
    <x-admin.breadcrumb title="Add Letter Content" />

    @if ($errors->any())
        <div class="col-lg-12 pb-4 px-2">
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
        <div class="form-card px-md-3 px-2">
            <form action="{{ route('admin.letter_content.create') }}" method="POST">
                @csrf
                <div class="form-contents">
                    <div class="row">
                        <x-forms.input label="Type" type="text" name="type" id="type" :required="true"
                            size="col-lg-6 mt-4" />
                        <x-forms.input label="Letter Type" type="text" name="letter_type" id="letter_type"
                            :required="true" size="col-lg-6 mt-4" />
                        <x-forms.textarea label="Content" type="text" name="content" id="content" :required="true"
                            size="col-lg-12" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <x-forms.button type="submit" label="Add" class="btn btn-primary" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-applayout>
