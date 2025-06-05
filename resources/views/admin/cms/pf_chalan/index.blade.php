<x-applayout>
    <x-admin.breadcrumb title="CMS PF Challan" :create="route('admin.cms.pf.create')" />
    <div class="form-card px-3 mt-4">
        <form action="{{ route('admin.cms.pf') }}">
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
                <div class="col-lg-4">
                    <label for="month">Month</label>
                    <select name="month" id="month">
                        <option value="">Select Month</option>
                        @foreach (range(1, 12) as $month)
                            <option value="{{ $month }}" {{ request()->month == $month ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-4">
                    <label for="year">Year</label>
                    <select name="year" id="year">
                        <option value="">Select Year</option>
                        @php
                            $currentYear = now()->year;
                        @endphp
                        @foreach (range($currentYear, $currentYear - 6) as $year)
                            <option value="{{ $year }}" {{ request()->year == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="submit-btn submitBtn" id="submitButton">Search</button>
        </form>
    </div>
    <div class="row {{ count($challans) > 0 ? '' : 'd-none' }}">
        <div class="col-lg-12">
            @php
                $columns = [
                    ['label' => 'Id', 'column' => 'id', 'sort' => true],
                    ['label' => 'Client Name', 'column' => 'client_name', 'sort' => false],
                    ['label' => 'State name', 'column' => 'contact_person', 'sort' => false],
                    ['label' => 'Month', 'column' => 'month', 'sort' => true],
                    ['label' => 'year', 'column' => 'year', 'sort' => true],
                    ['label' => 'Actions', 'column' => 'action', 'sort' => false],
                ];
            @endphp
            <x-table :columns="$columns" :data="$challans" :checkAll=false :bulk="route('admin.cms.esic')" :route="route('admin.cms.esic')">
                @foreach ($challans as $key => $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>
                            {{ $item->client?->client_name }}
                        </td>
                        <td> {{ $item->state?->state_name }}</td>
                        <td>{{ \DateTime::createFromFormat('!m', $item->month)->format('F') }}</td>
                        <td> {{ $item->year }}</td>

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
                                        <a class="dropdown-item"
                                            onclick="return confirm('Are you sure to delete this ?')"
                                            href="{{ route('admin.cms.esic.delete', $item) }}">
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
