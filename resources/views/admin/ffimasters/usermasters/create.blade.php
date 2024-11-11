<x-applayout>
    <x-admin.breadcrumb title="Add User Masters" />
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
            <form method="POST" class="formSubmit" action="{{ route('admin.usermasters.create') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <label for="user_type">User Type</label>
                        <select name="user_type" id="user_type" class="form-control col-lg-4 mt-4">
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ old('user_type') == $role->name ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <x-forms.input label="Employee ID" type="text" name="emp_id" id="emp_id" :required="true"
                        size="col-lg-6 mt-4" :value="old('emp_id')" />

                    <x-forms.input label="Name" type="text" name="name" id="name" :required="true"
                        size="col-lg-6 mt-4" :value="old('name')" />


                    <x-forms.input label="Username" type="text" name="username" id="username" :required="true"
                        size="col-lg-6 mt-4" :value="old('username')" />

                    <x-forms.input label="Password" type="password" name="password" id="password" :required="true"
                        size="col-lg-6 mt-4" />

                    <x-forms.input label="Confirm Password" type="password" name="enc_pass" id="enc_pass"
                        :required="true" size="col-lg-6 mt-4" :value="old('enc_pass')" />

                    <x-forms.select label="Status" name="status" id="status" :required="true" size="col-lg-6 mt-4"
                        :options="FretusFolks::getStatus()" :value="old('status')" />
                    <x-forms.input label="Email" type="email" name="email" id="email" :required="true"
                        size="col-lg-6 mt-4" :value="old('email')" />


                </div>

                <button type="submit" class="submit-btn submitBtn" id="submitButton">Submit</button>

            </form>
        </div>
    </div>

</x-applayout>
