<x-applayout>
    <x-admin.breadcrumb title="Updating UAN and ESIC Number" />

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
        <div class="form-card px-3">
            <form action="{{ route('admin.candidatemaster.edit', $candidate->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="card mt-3">
                    <div class="card-header header-elements-inline d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Edit Candidate Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-contents">
                            <div class="row">
                                <x-forms.select label="Enter Client Name:" name="client_id" id="client_id"
                                    :required="true" size="col-lg-6 mt-2" :options="FretusFolks::getClientname()" :value="old('client_id', $candidate->client_id)"
                                    readonly />
                                    <x-forms.input label=" FFI Employee ID: " type="text" name="ffi_emp_id" id="ffi_emp_id"
                                    :required="true" size="col-lg-6 mt-2" :value="old('ffi_emp_id', $candidate->ffi_emp_id)" readonly />
                             
                                <x-forms.input label=" Employee Name: " type="text" name="emp_name" id="emp_name"
                                    :required="true" size="col-lg-6 mt-2" :value="old('emp_name', $candidate->emp_name)" readonly />
                                <x-forms.input label=" Employee Mobile: " type="number" name="phone1" id="phone1"
                                    :required="true" size="col-lg-6 mt-2" :value="old('phone1', $candidate->phone1)" readonly />


                                <x-forms.input label="Employee Email ID: " type="email" name="email" id="email"
                                    :required="true" size="col-lg-6 mt-2" :value="old('email', $candidate->email)" readonly />
                                <x-forms.input label="UAN No:" type="text" name="uan_no" id="uan_no"
                                    :required="true" size="col-lg-6 mt-2" :value="old('uan_no', $candidate->uan_no)" />
                                <x-forms.input label="ESIC No:" type="text" name="esic_no" id="esic_no"
                                    :required="true" size="col-lg-6 mt-2" :value="old('esic_no', $candidate->esic_no)" />
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
