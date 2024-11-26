<x-applayout>
    <x-admin.breadcrumb title="Candidate First Information System" />

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
            <form action="{{ route('admin.cfis.create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card mt-3">
                    <div class="card-header header-elements-inline d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">New Candidate Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-contents">
                            <div class="row">
                                <x-forms.select label="Enter Client Name:" name="client_id" id="client_id"
                                    :required="true" size="col-lg-6 mt-2" :options="FretusFolks::getClientname()" :value="old('client_id')" />
                                <x-forms.input label="Enter Associate Name: " type="text" name="emp_name"
                                    id="emp_name" :required="true" size="col-lg-6 mt-2" :value="old('emp_name')" />
                                <x-forms.input label="Employee Mobile: " type="number" name="phone1" id="phone1"
                                    :required="true" size="col-lg-6 mt-2" :value="old('phone1')" />
                                <x-forms.input label="Employee Email ID: " type="email" name="email" id="email"
                                    :required="true" size="col-lg-6 mt-2" :value="old('email')" />
                                <x-forms.select label="State:" name="state" id="state" :required="true"
                                    size="col-lg-6 mt-2" :options="FretusFolks::getStates()" :value="old('state')" />
                                <x-forms.input label="Location: " type="text" name="location" id="location"
                                    :required="true" size="col-lg-6 mt-2" :value="old('location')" />
                                <x-forms.input label="Enter Designation: " type="text" name="designation"
                                    id="designation" :required="true" size="col-lg-6 mt-2" :value="old('designation')" />
                                <x-forms.input label="Enter Department: " type="text" name="department"
                                    id="department" :required="true" size="col-lg-6 mt-2" :value="old('department')" />
                                <x-forms.input label="Date of Interview  " type="date" name="interview_date"
                                    id="interview_date" :required="true" size="col-lg-6 mt-2" :value="old('interview_date')" />
                                <x-forms.input label="Date of Joining: " type="date" name="joining_date"
                                    id="joining_date" :required="true" size="col-lg-6 mt-2" :value="old('joining_date')" />
                                <x-forms.input label="Enter Adhar Card No:" type="number" name="aadhar_no"
                                    id="aadhar_no" :required="true" size="col-lg-6 mt-2" :value="old('aadhar_no')" />
                                <x-forms.input label="Attach Adhaar Card:" type="file" name="aadhar_path"
                                    id="aadhar_path" :required="true" size="col-lg-6 mt-2" :value="old('aadhar_path')" />
                                <x-forms.input label="Enter Driving License No:" type="text"
                                    name="driving_license_no" id="driving_license_no" :required="true"
                                    size="col-lg-6 mt-2" :value="old('driving_license_no')" />
                                <x-forms.input label="Attach Driving License:" type="file"
                                    name="driving_license_path" id="driving_license_path" :required="true"
                                    size="col-lg-6 mt-2" :value="old('driving_license_path')" />
                                <x-forms.input label="Photo:" type="file" name="photo" id="photo"
                                    :required="true" size="col-lg-6 mt-2" :value="old('photo')" />
                                <x-forms.input label="Resume:" type="file" name="resume" id="resume"
                                    :required="true" size="col-lg-6 mt-2" :value="old('resume')" />
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
