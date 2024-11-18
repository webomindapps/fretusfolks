<x-applayout>
    <x-admin.breadcrumb title="CMS ESIC Challan" />
    <div class="form-card px-3 mt-4">
        <div class="row">
            <div class="col-lg-4">
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
            <div class="col-lg-4">
                <label for="month">Month</label>
                <select name="months[]" id="month">
                    <option value="">Select Month</option>
                    @foreach (range(1, 12) as $month)
                        <option value="{{ $month }}">
                            {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-4">
                <label for="year">Year</label>
                <select name="years[]" id="year">
                    <option value="">Select Year</option>
                    @php
                        $currentYear = now()->year;
                    @endphp
                    @foreach (range($currentYear, $currentYear - 6) as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="submit" class="submit-btn submitBtn" id="submitButton">Search</button>
    </div>
</x-applayout>
