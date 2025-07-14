<x-applayout>
    <x-admin.breadcrumb title="New CMS Labour Notice" isBack="{{ true }}" />
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

    <div class="form-card px-md-3 px-2">
        <form method="POST" class="formSubmit" action="{{ route('admin.cms.labour.create') }}"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-6 mt-4" id="form-group-state">
                    <label for="client">Select Client
                        <span style="color: red">*</span>
                    </label>
                    <select class="form-select" id="client" name="client_id" required="">
                        <option value="">Select</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                {{ $client->client_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <x-forms.select label="State" name="state_id" id="state" :required="true" size="col-lg-6 mt-4"
                    :options="FretusFolks::getStates()" :value="old('state_id')" />
                <x-forms.input label="Location: " type="text" name="location" id="location"
                    :required="true" size="col-lg-12 mt-2" :value="old('location')" />
                <x-forms.input label="Notice Received date: " type="date" name="notice_received_date" id="notice_received_date"
                    :required="true" size="col-lg-6 mt-2" :value="old('notice_received_date')" />
                <x-forms.input label="Notice Document: " type="file" name="notice_file" id="notice_file"
                    :required="true" size="col-lg-6 mt-2" :value="old('notice_file')" />
                <x-forms.input label="Closure Date: " type="date" name="closure_date" id="closure_date"
                    :required="true" size="col-lg-6 mt-2" :value="old('closure_date')" />
                <x-forms.input label="Closure Document: " type="file" name="closure_file" id="closure_file"
                    :required="true" size="col-lg-6 mt-2" :value="old('closure_file')" />
            </div>
            <button type="submit" class="submit-btn submitBtn" id="submitButton">Submit</button>
        </form>
    </div>
</x-applayout>
