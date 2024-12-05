<x-applayout>
    <x-admin.breadcrumb title="Fetus Folks Cost Management" :create="route('admin.fcms.ffcm.create')" />
    <div class="content">
        <div class="form-card px-3 mt-4">
            <form action="{{ route('admin.fcms.ffcm') }}" method="GET">
                <div class="row align-items-end">
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
                                    {{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <button type="submit" class="submit-btn submitBtn">Search</button>
                        <a href="{{ route('admin.fcms.ffcm.export', ['from_date' => request('from_date'), 'to_date' => request('to_date')]) }}"
                            class="add-btn bg-success text-white" role="button">Export</a>
                    </div>
                </div>
            </form>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-12">
                @php
                    $columns = [
                        ['label' => 'Id', 'column' => 'id', 'sort' => true],
                        ['label' => 'Date', 'column' => 'date', 'sort' => false],
                        ['label' => 'Nature OF Expenses', 'column' => 'nature_expenses', 'sort' => false],
                        ['label' => 'Month', 'column' => 'month', 'sort' => true],
                        ['label' => 'Amount', 'column' => 'amount', 'sort' => true],
                        ['label' => 'Actions', 'column' => 'action', 'sort' => false],
                    ];
                @endphp
                <x-table :columns="$columns" :data="$expenses" :checkAll="false" :bulk="route('admin.fcms.ffcm.bulk')" :route="route('admin.fcms.ffcm')">

                    @foreach ($expenses as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }} </td>
                            <td>{{ $item->nature_expenses }}</td>
                            <td>{{ \DateTime::createFromFormat('!m', $item->month)->format('F') }}</td>
                            <td>{{ $item->amount }}</td>
                            <td>
                                <div class="dropdown pop_Up dropdown_bg">
                                    <div class="dropdown-toggle" id="dropdownMenuButton-{{ $item->id }}"
                                        data-bs-toggle="dropdown" aria-expanded="true">
                                        Action
                                    </div>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.fcms.ffcm.edit', $item) }}">
                                                <i class='bx bx-pencil'></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                onclick="return confirm('Are you sure to delete this?')"
                                                href="{{ route('admin.fcms.ffcm.delete', $item) }}">
                                                <i class='bx bx-trash-alt'></i> Delete
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
    </div>
</x-applayout>
