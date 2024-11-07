<div class="form-contents">
    <div class="row mb-2">
        <x-additional.form-title title="Search Engine Optimization" size="col-lg-12" />

        <x-forms.input label="Meta title" name="meta_title" id="title" :required="false" size="col-lg-12"
            :value="isset($title) ? $title : old('meta_title')" />

        <x-forms.textarea label="Meta description" name="meta_description" id="description" :required="false"
            size="col-lg-12" :value="isset($description) ? $description : old('meta_description')" :editor="true" />

        <x-forms.textarea label="Meta keywords" name="keywords" id="keywords" :required="false"
            size="col-lg-12" :value="isset($keywords) ? $keywords : old('keywords')" />
    </div>
</div>
