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
        <div class="form-card px-md-3 px-2">
            <form method="POST" class="formSubmit" action="{{ route('admin.usermasters.create') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <label for="user_type">User Type</label>
                        <select name="user_type" id="user_type" class="form-control col-lg-4 mt-4">
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}"
                                    {{ old('user_type') == $role->name ? 'selected' : '' }}>
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

                    <x-forms.select label="Status" name="status" id="status" :required="true" size="col-lg-6 mt-4"
                        :options="FretusFolks::getStatus()" :value="old('status')" />
                    <x-forms.input label="Email" type="email" name="email" id="email" :required="true"
                        size="col-lg-6 mt-4" :value="old('email')" />

                    <x-forms.input label="Password" type="password" name="password" id="password" :required="true"
                        size="col-lg-6 mt-4" />

                    <x-forms.input label="Confirm Password" type="password" name="enc_pass" id="enc_pass"
                        :required="true" size="col-lg-6 mt-4" :value="old('enc_pass')" />
                </div>
                <div id="assign_clients" class="col-lg-12 mt-4" style="display: none;">
                    <label>Assign Clients:</label>
                    <div class="row">
                        @foreach ($clients as $index => $client)
                            <div class="col-md-6 customer-item">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="clients[]"
                                        value="{{ $client->id }}"
                                        {{ in_array($client->id, $assignedClients ?? []) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $client->client_name }}</label>
                                </div>
                            </div>

                            @if (($index + 1) % 2 == 0 && !$loop->last)
                    </div>
                    <div class="row">
                        @endif
                        @endforeach
                    </div>
                </div>


                <button type="submit" class="submit-btn submitBtn" id="submitButton">Submit</button>

            </form>
        </div>
    </div>
    <script>
        document.getElementById('user_type').addEventListener('change', function() {
            const assignClientsDiv = document.getElementById('assign_clients');
            if (this.value === 'HR Operations') {
                assignClientsDiv.style.display = 'block';
            } else {
                assignClientsDiv.style.display = 'none';
            }
        });

        window.addEventListener('load', function() {
            const userTypeSelect = document.getElementById('user_type');
            if (userTypeSelect.value === 'HR Operations') {
                document.getElementById('assign_clients').style.display = 'block';
            }
        });
    </script>
</x-applayout>
