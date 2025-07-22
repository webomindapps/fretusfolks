<x-applayout>
    <x-admin.breadcrumb title="CMS Labour Notice" :create="route('admin.cms.labour.create')" />
    <div class="form-card px-3 mt-4">
        <form action="{{ route('admin.cms.labour') }}">
            <div class="row">
                <div class="col-lg-4">
                    <label for="clientDropdown">Client Name</label>
                    <div class="dropdown">
                        <input type="text" class="btn dropdown-toggle text-start" id="clientDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false" readonly
                            value="{{ old('client_name', 'Select Client') }}">

                        <ul class="dropdown-menu p-2" aria-labelledby="clientDropdown"
                            style="max-height: 300px; overflow-y: auto; min-width: 250px;">

                            {{-- Search box --}}
                            <li class="mb-2">
                                <input type="text" class="form-control" placeholder="Search..."
                                    onkeyup="filterClientList(this)">
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            {{-- Client list - single selection --}}
                            @foreach ($clients as $client)
                                <li class="client-option">
                                    <div class="form-check">
                                        <input class="form-check-input client-radio" type="radio" name="client_radio"
                                            id="client_{{ $client->id }}" value="{{ $client->id }}"
                                            data-name="{{ $client->client_name }}" onchange="selectClient(this)">
                                        <label class="form-check-label" for="client_{{ $client->id }}">
                                            {{ $client->client_name }}
                                        </label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Hidden input to store selected client ID --}}
                    <input type="hidden" name="client_id" id="selected_client_id" required>
                </div>
            </div>
            <button type="submit" class="submit-btn submitBtn" id="submitButton">Search</button>
        </form>
    </div>
    <div class="row {{ count($notices) > 0 ? '' : 'd-none' }}">
        <div class="col-lg-12">
            @php
                $columns = [
                    ['label' => 'Id', 'column' => 'id', 'sort' => true],
                    ['label' => 'Client Name', 'column' => 'client_name', 'sort' => false],
                    ['label' => 'State name', 'column' => 'contact_person', 'sort' => false],
                    ['label' => 'Location', 'column' => 'month', 'sort' => true],
                    ['label' => 'Notice Date', 'column' => 'year', 'sort' => true],
                    ['label' => 'Notice Document', 'column' => 'year', 'sort' => true],
                    ['label' => 'Closure Document', 'column' => 'year', 'sort' => true],
                    ['label' => 'Closure Date', 'column' => 'year', 'sort' => true],
                    ['label' => 'Actions', 'column' => 'action', 'sort' => false],
                ];
            @endphp
            <x-table :columns="$columns" :data="$notices" :checkAll=false :bulk="route('admin.cms.labour')" :route="route('admin.cms.labour')">
                @foreach ($notices as $key => $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->client?->client_name }}</td>
                        <td>{{ $item->state?->state_name }}</td>
                        <td>{{ $item->location }}</td>
                        <td>{{ date('d-m-Y', strtotime($item->notice_received_date)) }}</td>
                        <td>
                            <a href="{{ asset('storage/' . $item->notice_document) }}">
                                <i class="fa fa-file" target="_blank"></i> Notice Document
                            </a>
                        </td>
                        <td>{{ date('d-m-Y', strtotime($item->closure_date)) }}</td>
                        <td>
                            <a href="{{ asset('storage/' . $item->closure_document) }}">
                                <i class="fa fa-file" target="_blank"></i> Closure Document
                            </a>
                        </td>

                        <td>
                            <div class="dropdown pop_Up dropdown_bg">
                                <div class="dropdown-toggle" id="dropdownMenuButton-{{ $item->id }}"
                                    data-bs-toggle="dropdown" aria-expanded="true">
                                    Action
                                </div>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1"
                                    style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(-95px, -25.4219px);"
                                    data-popper-placement="top-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.cms.labour.edit', $item) }}">
                                            <i class='bx bx-pencil'></i>
                                            Edit
                                        </a>
                                        <a class="dropdown-item"
                                            onclick="return confirm('Are you sure to delete this ?')"
                                            href="{{ route('admin.cms.labour.delete', $item) }}">
                                            <i class='bx bx-trash-alt'></i>
                                            Delete
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-table>
        </div>
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

                // Optionally close the dropdown after selection
                const dropdown = bootstrap.Dropdown.getInstance(document.getElementById('clientDropdown'));
                if (dropdown) dropdown.hide();
            }
        </script>
    @endpush
</x-applayout>
