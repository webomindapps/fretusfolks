<x-applayout>
    <x-admin.breadcrumb title="New CMS LWF Challan" />
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
        <form method="POST" class="formSubmit" action="{{ route('admin.cms.lwf.create') }}" enctype="multipart/form-data">
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
                <div class="mb-4">
                    <x-forms.select label="State" name="state_id" id="state" :required="true" size="col-lg-6 mt-4"
                        :options="FretusFolks::getStates()" :value="old('state_id')" />
                </div>
                <div class="col-12">
                    <table class="w-100 table-bordered" id="dynamicTable">
                        <thead>
                            <tr>
                                <td>Month</td>
                                <td>Year</td>
                                <td>Document</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select name="months[]" id="month" required>
                                        <option value="">Select Month</option>
                                        @foreach (range(1, 12) as $month)
                                            <option value="{{ $month }}">
                                                {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="years[]" id="year" required>
                                        <option value="">Select Year</option>
                                        @php
                                            $currentYear = now()->year;
                                        @endphp
                                        @foreach (range($currentYear, $currentYear - 6) as $year)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="file" name="files[]" multiple required>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info" onclick="addRow()">+</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
                monthSelect.required = true;

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
                yearSelect.required = true;

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
                fileInput.required = true;
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
