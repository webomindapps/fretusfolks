<x-applayout>
    <x-admin.breadcrumb title="New CMS Others " isBack="{{ true }}" />
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
        <form method="POST" class="formSubmit" action="{{ route('admin.cms.others.create') }}"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-6 mt-4" id="form-group-state">
                    <label for="clientDropdown">Select Client <span style="color: red">*</span></label>
                    <div class="dropdown">
                        <input type="text" class="form-select dropdown-toggle text-start" id="clientDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false" readonly
                            value="{{ old('client_name', 'Select') }}">

                        <ul class="dropdown-menu p-2 w-100" aria-labelledby="clientDropdown"
                            style="max-height: 300px; overflow-y: auto; min-width: 100%;">

                            {{-- Search input --}}
                            <li class="mb-2">
                                <input type="text" class="form-control" placeholder="Search..."
                                    onkeyup="filterClientList(this)">
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            {{-- Client options as radio-style --}}
                            @foreach ($clients as $client)
                                <li class="client-option">
                                    <div class="form-check">
                                        <input class="form-check-input client-radio" type="radio" name="client_radio"
                                            id="client_{{ $client->id }}" value="{{ $client->id }}"
                                            data-name="{{ $client->client_name }}" onchange="selectClient(this)"
                                            {{ old('client_id') == $client->id ? 'checked' : '' }}>
                                        <label class="form-check-label" for="client_{{ $client->id }}">
                                            {{ $client->client_name }}
                                        </label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Hidden field to store actual client_id --}}
                    <input type="hidden" name="client_id" id="selected_client_id" value="{{ old('client_id') }}"
                        required>
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
        <script>
            function filterClientList(input) {
                const filter = input.value.toLowerCase();
                const items = document.querySelectorAll('.client-option');

                items.forEach(item => {
                    const label = item.textContent.toLowerCase();
                    item.style.display = label.includes(filter) ? '' : 'none';
                });
            }

            function selectClient(radio) {
                const label = radio.getAttribute('data-name');
                const value = radio.value;

                document.getElementById('clientDropdown').value = label;
                document.getElementById('selected_client_id').value = value;

                // Auto close dropdown (Bootstrap 5)
                const dropdownEl = document.getElementById('clientDropdown');
                const dropdown = bootstrap.Dropdown.getOrCreateInstance(dropdownEl);
                dropdown.hide();
            }

            // If prefilled, update display text on load
            document.addEventListener('DOMContentLoaded', function() {
                const selectedRadio = document.querySelector('.client-radio:checked');
                if (selectedRadio) {
                    document.getElementById('clientDropdown').value = selectedRadio.getAttribute('data-name');
                }
            });
        </script>
    @endpush
</x-applayout>
