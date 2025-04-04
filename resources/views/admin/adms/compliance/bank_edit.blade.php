<x-applayout>
    <x-admin.breadcrumb title="Updating Bank Details" />
    <style>
        .btn-custom {
            background-color: #067e1a;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-custom:hover {
            background-color: #067e1a;
        }
    </style>
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
            <form action="{{ route('admin.bankdetails.edit', $bankdetails->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="card mt-3">
                    <div class="card-header header-elements-inline d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Edit Bank Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-contents">
                            <div class="row">
                                <x-forms.input label="Enter Bank Name:" type="text" name="bank_name" id="bank_name"
                                    :required="true" size="col-lg-6 mt-2" :value="old('bank_name', $bankdetails->bank_name ?? '')" />

                              
                                <div class="form-group col-lg-6 mt-2">
                                    <label for="bank_document">Attach Bank Document:</label>
                                    <input type="file" name="bank_document" id="bank_document"
                                        accept="application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/pdf"
                                        class="form-control">
                                        @if ($bankdetails && $bankdetails->bank_document)
                                        <div id="image-preview-container" class="d-flex mt-2">
                                            <a href="{{ asset('storage/' . $bankdetails->bank_document) }}" target="_blank"
                                               class="btn btn-custom mt-2">
                                                View
                                            </a>
                                        </div>
                                    @endif
                                    

                                </div>
                                <x-forms.input label="Enter Bank Account No::" type="text" name="bank_account_no"
                                    id="bank_account_no" :required="true" size="col-lg-6 mt-2" :value="old('bank_account_no', $bankdetails->bank_account_no ?? '')" />
                                <x-forms.input label="Enter Bank IFSC CODE:" type="text" name="bank_ifsc_code"
                                    id="bank_ifsc_code" :required="true" size="col-lg-6 mt-2" :value="old('bank_ifsc_code', $bankdetails->bank_ifsc_code ?? '')" />
                                <div class="form-group col-lg-6 mt-2">
                                    <label for="bank_status">Status <span style="color: red">*</span></label>
                                    <select id="bank_status" name="bank_status" class="form-control" required
                                        onchange="toggleNotesField(this.value)">
                                        <option value="">Select Status</option>
                                        <option value="1"
                                            {{ old('bank_status', $bankdetails->bank_status ?? '') == '1' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="0"
                                            {{ old('bank_status', $bankdetails->bank_status ?? '') == '0' ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
                                </div>

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
