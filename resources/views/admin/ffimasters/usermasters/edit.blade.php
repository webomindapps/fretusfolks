<x-applayout>
    <x-admin.breadcrumb title="Update User Masters" />

    @if ($errors->any())
        <div class="col-lg-12 pb-4">
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
            <form method="POST" class="formSubmit" action="{{ route('admin.usermasters.edit',$users->id) }}"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <label for="user_type">User Type</label>
                        <select name="user_type" id="user_type" class="form-control col-lg-4 mt-4">
                            @foreach ($roles as $id => $name)
                                <option value="{{ $id }}" {{ old('user_type',$users->user_type) == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <x-forms.input label="Employee ID" type="text" name="emp_id" id="emp_id" :required="true"
                        size="col-lg-6 mt-4" :value="old('emp_id', $users->emp_id)" />

                    <x-forms.input label="Name" type="text" name="name" id="name" :required="true"
                        size="col-lg-6 mt-4" :value="old('name', $users->name)" />


                    <x-forms.input label="Username" type="text" name="username" id="username" :required="true"
                        size="col-lg-6 mt-4" :value="old('username', $users->username)" />

                    <x-forms.select label="Status" name="status" id="status" :required="true" size="col-lg-6 mt-4"
                        :options="FretusFolks::getStatus()" :value="old('status', $users->status)" />
                    <x-forms.input label="Email" type="email" name="email" id="email" :required="true"
                        size="col-lg-6 mt-4" :value="old('email', $users->email)" />


                </div>

                <button type="submit" class="submit-btn submitBtn" id="submitButton">Submit</button>

            </form>
        </div>
    </div>

</x-applayout>