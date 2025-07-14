<x-applayout>
    <x-admin.breadcrumb title="FFI Assets Management - Update" isBack="{{ true }}" />

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
            <form action="{{ route('admin.fcms.ffi_assets.edit', $issues->id) }}" method="POST" id="updateDetailsForm">
                @csrf
                <div class="card mt-3">
                    <div class="card-header header-elements-inline d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Employee Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-contents">
                            <div class="row">
                                <x-forms.input label="Asset Name: " type="text" name="asset_name" id="asset_name"
                                    :required="true" size="col-lg-6 mt-2" :value="$issues->asset_name" />
                                <x-forms.input label="Asset Code: " type="text" name="asset_code" id="asset_code"
                                    :required="true" size="col-lg-6 mt-2" :value="$issues->asset_code" />
                                <div class="col-lg-6 mt-1">
                                    <label for="employee_id" class="form-label">Employee name: <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="client" name="employee_id"
                                        onchange="get_client_location();">
                                        <option value="">Select</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}"
                                                {{ $employee->id == $issues->employee_id ? 'selected' : '' }}>
                                                {{ $employee->emp_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('employee_id')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>
                                <x-forms.input label="Date of Issued: " type="date" name="issued_date"
                                    id="issued_date" :required="true" size="col-lg-6 mt-2" :value="$issues->issued_date" />
                                <x-forms.input label="Date of Returned: " type="date" name="returned_date"
                                    id="returned_date" :required="true" size="col-lg-6 mt-2" :value="$issues->returned_date" />
                                <x-forms.textarea label="Damage/Recovery: " name="damage_recover" id="damage_recover"
                                    :required="true" size="col-lg-6 mt-2" :value="$issues->damage_recover" />
                                <x-forms.select label="Status: " :options="[
                                    ['value' => '1', 'label' => 'Issued'],
                                    ['value' => '0', 'label' => 'Returned'],
                                ]" id="status" name="status"
                                    :required="true" size="col-lg-6 mt-2 mr-2" :value="$issues->status" />
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mt-4">
                                    <x-forms.button type="submit" label="Update" class="btn btn-primary" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-applayout>
