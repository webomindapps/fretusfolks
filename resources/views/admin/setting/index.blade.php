<x-applayout>
    <x-admin.breadcrumb title="Setting" />

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
            <form action="{{ route('admin.settings') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card mt-3">
                    <div class="card-header header-elements-inline d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Setting</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-contents">
                            <div class="row">
                                <x-forms.input label="Company Name: " type="text" name="company_name" id="company"
                                    :required="true" size="col-lg-4 mt-2" :value="$setting->company_name" />
                                <x-forms.input label="Phone: " type="text" name="phone" id="phone"
                                    :required="true" size="col-lg-4 mt-2" :value="$setting->phone" />
                                <x-forms.input label="Email: " type="email" name="email" id="email"
                                    :required="true" size="col-lg-4 mt-2" :value="$setting->email" />
                                <x-forms.input label="Logo: " type="file" name="logo" id="logo"
                                    :required="false" size="col-lg-4 mt-2" :value="$setting->logo" />
                                <x-forms.input label="Pan No: " type="text" name="pan_no" id="pan_no"
                                    :required="false" size="col-lg-4 mt-2" :value="$setting->pan_no" />
                                <x-forms.input label="GST No: " type="text" name="gst_no" id="gst_no"
                                    :required="false" size="col-lg-4 mt-2" :value="$setting->gst_no" />
                                <x-forms.input label="Website: " type="text" name="website" id="website"
                                    :required="true" size="col-lg-12 mt-2" :value="$setting->website" />
                                <x-forms.textarea label="Address (One)" name="addr_line1" id="addr_line1"
                                    :required="true" size="col-lg-6 mt-2" :value="old('addr_line1', $setting->addr_line1)" />
                                <x-forms.textarea label="Address (Two)" name="addr_line2" id="addr_line2"
                                    :required="false" size="col-lg-6 mt-2" :value="old('addr_line2', $setting->addr_line2)" />
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mt-4">
                                    <x-forms.button type="submit" label="Save" class="btn btn-primary" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-applayout>
