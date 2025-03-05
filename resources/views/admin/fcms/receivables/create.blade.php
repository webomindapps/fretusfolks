<x-applayout>
    <x-admin.breadcrumb title="New Receipts Details" />
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
        <form method="POST" class="formSubmit" action="{{ route('admin.fcms.receivable.create') }}"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-6 mt-4" id="form-group-state">
                    <label for="client">Client Name
                        <span style="color: red">*</span>
                    </label>
                    <select class="form-select" id="client" name="client_id" onchange="get_client_invoices();"
                        required>
                        <option value="">Select</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                {{ $client->client_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('client_id')
                        <span>{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-lg-6 mt-4" id="form-group-state">
                    <label for="client">Invoice
                        <span style="color: red">*</span>
                    </label>
                    <select class="form-select" name="invoice_id" id="invoices" onchange="get_invoice_amount();"
                        required>
                        <option value="">Select Invoice</option>
                    </select>
                    @error('invoice_id')
                        <span>{{ $message }}</span>
                    @enderror
                </div>
                <x-forms.input label="Total Amount(Without GST)" type="number" name="total_gst" id="total_gst"
                    :required="true" size="col-lg-6 mt-2" :value="old('total_gst')" />
                <x-forms.input label="Total Amount(With GST)" type="number" name="total_amt" id="total_amount"
                    :required="true" size="col-lg-6 mt-2" :value="old('total_amount')" />
                <x-forms.input label="Previous Amount Received" type="number" name="amt_received" id="amt_received"
                    :required="true" size="col-lg-6 mt-2" :value="old('amt_received')" />
                <x-forms.input label="Balance Amount" type="number" name="amount_balanced" id="amount_balanced"
                    :required="true" size="col-lg-6 mt-2" :value="old('amount_balanced')" />
                <x-forms.input label="Payment Received Date" type="date" name="payment_date" id="payment_date"
                    :required="true" size="col-lg-6 mt-2" :value="old('payment_date')" />
                <div class="col-lg-6 mt-2" id="form-group-state">
                    <label for="client">For the month
                        <span style="color: red">*</span>
                    </label>
                    <select class="form-select" name="month" required data-fouc>
                        <option value="">Select Month</option>
                        @foreach (range(1, 12) as $month)
                            @php
                                $monthName = \Carbon\Carbon::create()->month($month)->format('F');
                            @endphp
                            <option value="{{ $monthName }}">
                                {{ $monthName }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-6 mt-2" id="form-group-state">
                    <label for="client">TDS Code
                        <span style="color: red">*</span>
                    </label>
                    <select class="form-select" name="tds_code" id="tds_code" required data-fouc>
                        <option value="">Select</option>
                        @foreach ($tds_codes as $code)
                            <option value="{{ $code->id }}">{{ $code->code }}</option>
                        @endforeach
                    </select>
                </div>
                <x-forms.input label="TDS(%)" type="number" name="tds_percentage" id="tds_percentage"
                    :required="true" size="col-lg-6 mt-2" :value="old('tds_percentage')" />
                <x-forms.input label="TDS Amount" type="number" name="tds_amount" id="tds_amount" :required="true"
                    size="col-lg-6 mt-2" :value="old('tds_amount')" />
                <x-forms.input label="Amount Received" type="number" name="amount_paid" id="amount_paid"
                    :required="true" size="col-lg-6 mt-2" :value="old('amount_paid')" />
                <x-forms.input label="Balance Amount" type="number" name="balance_amount" id="balance_amount"
                    :required="true" size="col-lg-6 mt-2" :value="old('balance_amount')" readonly />
            </div>
            <button type="submit" class="submit-btn submitBtn" id="submitButton">Submit</button>
        </form>
    </div>
    @push('scripts')
        <script>
            $('#tds_percentage').on('change', function() {
                get_tds_amount();
            });
            $('#amount_paid').on('change', function() {
                get_balance_amount();
            });

            function get_client_invoices() {
                let client = $("#client").val();
                jQuery.ajax({
                    type: "get",
                    url: "{{ route('admin.get.client.invoices', ':client') }}".replace(':client', client),
                    datatype: "text",
                    success: function(response) {
                        $('#invoices').empty();
                        $('#invoices').append(response);
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.error(thrownError);
                    }
                });
            }

            function get_invoice_amount() {
                let invoice = $("#invoices").val();
                jQuery.ajax({
                    type: "get",
                    url: "{{ route('admin.get.invoice.details', ':invoice') }}".replace(':invoice', invoice),
                    datatype: "text",
                    success: function(response) {
                        console.log(response);
                        let total_gst = (Number(response.gross_value) || 0) + (Number(response.source_value) || 0) + (Number(response.service_value) || 0);
                        $('#total_gst').val(total_gst);
                        $('#total_amount').val(response.total_value);
                        $('#amt_received').val(response.amount_received);
                        $('#amount_balanced').val(response.balance_amount);
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.error(thrownError); // Log errors for debugging
                    }
                });
            }

            function get_tds_amount() {
                var amount = isNaN(parseInt($("#total_gst").val())) ? 0 : parseInt($("#total_gst").val());
                var tds = isNaN(parseInt($("#tds_percentage").val())) ? 0 : parseInt($("#tds_percentage").val());

                tds_amount = (amount * tds) / 100;
                $("#tds_amount").val(tds_amount);

            }

            function get_balance_amount() {
                var amount = isNaN(parseInt($("#amount_balanced").val())) ? 0 : parseInt($("#amount_balanced").val());
                var tds = isNaN(parseInt($("#tds_amount").val())) ? 0 : parseInt($("#tds_amount").val());
                var paid = isNaN(parseInt($("#amount_paid").val())) ? 0 : parseInt($("#amount_paid").val());
                balance_amount = (amount - tds) - paid;
                $("#balance_amount").val(balance_amount);
            }
        </script>
    @endpush
</x-applayout>
