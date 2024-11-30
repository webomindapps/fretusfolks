<x-applayout>
    <x-admin.breadcrumb title="CMS Labour Notice" :create="route('admin.cms.labour.create')" />
    <div class="form-card px-3 mt-4">
        <form action="{{ route('admin.cms.labour') }}">
            <div class="row">
                <div class="col-lg-4">
                    <label for="client">Select Client
                        <span style="color: red">*</span>
                    </label>
                    <select class="form-select" id="client" name="client_id" required="">
                        <option value="">Select</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}"
                                {{ request()->client_id == $client->id ? 'selected' : '' }}>
                                {{ $client->client_name }}
                            </option>
                        @endforeach
                    </select>
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
</x-applayout>
