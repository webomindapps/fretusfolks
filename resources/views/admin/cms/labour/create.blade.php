<x-applayout>
    <x-admin.breadcrumb title="New CMS Labour Notice" />
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

    <div class="form-card px-3">
        <form method="POST" class="formSubmit" action="{{ route('admin.cms.formt.create') }}"
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
                <x-forms.input label="Notice Received date: " type="date" name="notice_date" id="notice_date"
                    :required="true" size="col-lg-6 mt-2" :value="old('notice_date')" />
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
    @push('scripts')
        <script>
            function addRow() {
                const tableBody = document.querySelector("#dynamicTable tbody");

                // Create the new row element
                const newRow = document.createElement("tr");

                // Create and append the "Month" column
                const monthCell = document.createElement("td");
                const monthSelect = document.createElement("select");
                monthSelect.name = "months[]";
                monthSelect.id = "month";

                // Add default option
                const defaultOptionMonth = document.createElement("option");
                defaultOptionMonth.value = "";
                defaultOptionMonth.textContent = "Select Month";
                monthSelect.appendChild(defaultOptionMonth);

                // Add months dynamically
                Array.from({
                    length: 12
                }, (_, i) => {
                    const monthOption = document.createElement("option");
                    monthOption.value = i + 1;
                    monthOption.textContent = new Date(0, i).toLocaleString("en", {
                        month: "long"
                    });
                    monthSelect.appendChild(monthOption);
                });

                monthCell.appendChild(monthSelect);
                newRow.appendChild(monthCell);

                // Create and append the "Year" column
                const yearCell = document.createElement("td");
                const yearSelect = document.createElement("select");
                yearSelect.name = "years[]";
                yearSelect.id = "year";

                // Add default option
                const defaultOptionYear = document.createElement("option");
                defaultOptionYear.value = "";
                defaultOptionYear.textContent = "Select Year";
                yearSelect.appendChild(defaultOptionYear);

                // Add years dynamically
                const currentYear = new Date().getFullYear();
                Array.from({
                    length: 7
                }, (_, i) => {
                    const yearOption = document.createElement("option");
                    yearOption.value = currentYear - i;
                    yearOption.textContent = currentYear - i;
                    yearSelect.appendChild(yearOption);
                });

                yearCell.appendChild(yearSelect);
                newRow.appendChild(yearCell);

                // Create and append the "File Input" column
                const fileCell = document.createElement("td");
                const fileInput = document.createElement("input");
                fileInput.type = "file";
                fileInput.name = "files[]";
                fileInput.multiple = true;
                fileCell.appendChild(fileInput);
                newRow.appendChild(fileCell);

                // Create and append the "Remove Button" column
                const buttonCell = document.createElement("td");
                const removeButton = document.createElement("button");
                removeButton.type = "button";
                removeButton.className = "btn btn-sm btn-danger";
                removeButton.textContent = "X";
                removeButton.onclick = () => removeRow(removeButton);
                buttonCell.appendChild(removeButton);
                newRow.appendChild(buttonCell);
                tableBody.appendChild(newRow);
            }

            function removeRow(button) {
                button.closest("tr").remove();
            }
        </script>
    @endpush
</x-applayout>
