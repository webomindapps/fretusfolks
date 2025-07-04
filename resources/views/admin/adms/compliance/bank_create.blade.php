<x-applayout>
    <x-admin.breadcrumb title="New Bank Details" />

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
            <form action="{{ route('admin.bankdetails.create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card mt-3">
                    <div class="card-header header-elements-inline d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Bank Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-contents">
                            {{-- {{ dd($candidate->id) }} --}}
                            <div class="row">
                                <x-forms.input label="Enter FFI Emp Id:" type="text" name="ffi_emp_id"
                                    id="ffi_emp_id" :required="true" size="col-lg-6 mt-2" :value="old('ffi_emp_id')" />
                                <x-forms.input label="Enter Bank Name:" type="text" name="bank_name" id="bank_name"
                                    :required="true" size="col-lg-6 mt-2" :value="old('bank_name')" />

                                <div class="form-group col-lg-6 mt-2">
                                    <label for="bank_document">Attach Bank Document: <span
                                            style="color: red;">*</span></label>
                                    <input type="file" name="bank_document" id="bank_document"
                                        accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/pdf"
                                        class="form-control" value="{{ old('bank_document') }}" required>
                                </div>
                                <x-forms.input label="Enter Bank Account No::" type="text" name="bank_account_no"
                                    id="bank_account_no" :required="true" size="col-lg-6 mt-2" :value="old('bank_account_no')" />
                                <x-forms.input label="Enter Bank IFSC CODE:" type="text" name="bank_ifsc_code"
                                    id="bank_ifsc_code" :required="true" size="col-lg-6 mt-2" :value="old('bank_ifsc_code')" />

                                <div class="form-group col-lg-6 mt-2">
                                    <label for="status">Status <span style="color: red">*</span></label>
                                    <select id="status" name="status" class="form-control" required
                                        onchange="toggleNotesField(this.value)">
                                        <option value="">Select Status</option>
                                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-12 mt-4">
                                    <x-forms.button type="submit" label="Submit" class="btn btn-primary" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</x-applayout>
