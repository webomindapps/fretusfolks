<x-applayout>
    <x-admin.breadcrumb title="Edit CMS Labour Notice" isBack="{{ true }}" />
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
        <form method="POST" class="formSubmit" action="{{ route('admin.cms.labour.edit', $notice->id) }}"
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
                                            {{ old('client_id', $notice->client_id) == $client->id ? 'checked' : '' }}>
                                        <label class="form-check-label" for="client_{{ $client->id }}">
                                            {{ $client->client_name }}
                                        </label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Hidden field to store actual client_id --}}
                    <input type="hidden" name="client_id" id="selected_client_id"
                        value="{{ old('client_id', $notice->client_id) }}" required>
                </div>

                <x-forms.select label="State" name="state_id" id="state" :required="true" size="col-lg-6 mt-4"
                    :options="FretusFolks::getStates()" :value="$notice->state_id" />
                <x-forms.input label="Location: " type="text" name="location" id="location" :required="true"
                    size="col-lg-12 mt-2" :value="$notice->location" />
                <x-forms.input label="Notice Received date: " type="date" name="notice_received_date"
                    id="notice_received_date" :required="true" size="col-lg-6 mt-2" :value="$notice->notice_received_date" />
                <x-forms.input label="Notice Document: " type="file" name="notice_file" id="notice_file"
                    :required="false" size="col-lg-6 mt-2" :value="$notice->notice_file" />
                <x-forms.input label="Closure Date: " type="date" name="closure_date" id="closure_date"
                    :required="true" size="col-lg-6 mt-2" :value="$notice->closure_date" />
                <x-forms.input label="Closure Document: " type="file" name="closure_document" id="closure_document"
                    :required="false" size="col-lg-6 mt-2" :value="$notice->closure_document" />
            </div>
            <button type="submit" class="submit-btn submitBtn" id="submitButton">Update</button>
        </form>
    </div>
    @push('scripts')
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
