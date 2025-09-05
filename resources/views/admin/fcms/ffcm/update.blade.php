<x-applayout>
    <x-admin.breadcrumb title="Fetus Folks Cost Management" isBack="{{ true }}" />

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
            <form action="{{ route('admin.fcms.ffcm.edit', $expenses->id) }}" method="POST" id="pendingDetailsForm">
                @csrf
                <div class="card mt-3">
                    <div class="card-header header-elements-inline d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Update Expenses Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-contents">
                            <div class="row">
                                <x-forms.input label=" Date: " type="date" name="date" id="date"
                                    :required="true" size="col-lg-6 mt-2" :value="old('date', $expenses->date)" />
                                <div class="col-lg-6 mt-2">
                                    <label for="month">Month</label>
                                    <select name="month" id="month">
                                        <option value="">Select Month</option>
                                        @foreach (range(1, 12) as $month)
                                            <option value="{{ $month }}"
                                                {{ old('month', $expenses->month) == $month ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-forms.select label="Nature Of Expenses:" name="nature_expenses" id="nature_expenses"
                                    :required="true" size="col-lg-6 mt-2" :options="FretusFolks::getExpenses()" :value="old('nature_expenses', $expenses->nature_expenses)" />
                                <x-forms.input label="Amount: " type="number" name="amount" id="amount"
                                    :required="true" size="col-lg-6 mt-2" :value="old('amount', $expenses->amount)" />
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mt-4">
                                    <x-forms.button type="submit" label="Update" class="btn btn-primary" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-applayout>
