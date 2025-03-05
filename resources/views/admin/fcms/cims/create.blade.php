<x-applayout>
    <x-admin.breadcrumb title="New Invoice Details" />
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
        <form method="POST" class="formSubmit" action="{{ route('admin.fcms.cims.create') }}"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-6 mt-4" id="form-group-state">
                    <label for="client">Client Name
                        <span style="color: red">*</span>
                    </label>
                    <select class="form-select" id="client" name="client_id" onchange="get_client_location();"
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
                    <label for="client">Client Location
                        <span style="color: red">*</span>
                    </label>
                    <select class="form-select" name="service_location" id="location" onchange="get_client_gst();"
                        required>
                        <option value="">Select Location</option>
                    </select>
                    @error('service_location')
                        <span>{{ $message }}</span>
                    @enderror
                </div>
                <x-forms.input label="GST No" type="text" name="gst_no" id="gst_no" :required="true"
                    size="col-lg-6 mt-2" :value="old('gst_no')" />
                <x-forms.input label="Invoice No" type="text" name="invoice_no" id="invoice_no" :required="true"
                    size="col-lg-6 mt-2" :value="old('invoice_no')" />
                <x-forms.input label="Gross Value" type="number" name="gross_value" id="gross_value" :required="true"
                    size="col-lg-6 mt-2" :value="old('gross_value')" />
                <x-forms.input label="Service Fees" type="number" name="service_value" id="service_value"
                    :required="true" size="col-lg-6 mt-2" :value="old('service_value')" />
                <x-forms.input label="Sourcing Fees" type="number" name="source_value" id="source_value"
                    :required="true" size="col-lg-6 mt-2" :value="old('source_value')" />
                <x-forms.input label="Total" type="number" name="total" id="total" :required="true"
                    size="col-lg-6 mt-2" :value="old('total')" />
                <x-forms.input label="CGST" type="number" name="cgst" id="cgst" :required="true"
                    size="col-lg-3 mt-2" :value="old('cgst')" />
                <x-forms.input label="CGST Amt" type="number" name="cgst_amount" id="cgst_amt" :required="true"
                    size="col-lg-3 mt-2" :value="old('cgst_amount')" />
                <x-forms.input label="SGST" type="number" name="sgst" id="sgst" :required="true"
                    size="col-lg-3 mt-2" :value="old('sgst')" />
                <x-forms.input label="SGST Amt" type="number" name="sgst_amount" id="sgst_amt" :required="true"
                    size="col-lg-3 mt-2" :value="old('sgst_amount')" />
                <x-forms.input label="IGST" type="number" name="igst" id="igst" :required="true"
                    size="col-lg-3 mt-2" :value="old('igst')" />
                <x-forms.input label="IGST Amt" type="number" name="igst_amount" id="igst_amt" :required="true"
                    size="col-lg-3 mt-2" :value="old('igst_amount')" />
                <x-forms.input label="Total Tax" type="number" name="total_tax" id="total_tax" :required="true"
                    size="col-lg-3 mt-2" :value="old('total_tax')" />
                <x-forms.input label="Invoice Amount" type="number" name="inv_total" id="inv_total" :required="true"
                    size="col-lg-3 mt-2" :value="old('inv_total')" />
                <x-forms.input label="Credit Note" type="number" name="credit_note" id="credit_note"
                    :required="true" size="col-lg-4 mt-2" :value="old('credit_note', 0)" />
                <x-forms.input label="Debit Note" type="number" name="debit_note" id="debit_note"
                    :required="true" size="col-lg-4 mt-2" :value="old('debit_note', 0)" />
                <x-forms.input label="Grand Total" type="number" name="grand_total" id="grand_total"
                    :required="true" size="col-lg-4 mt-2" :value="old('grand_total')" />
                <x-forms.input label="Total No Of Employee" type="number" name="total_employee" id="total_employee"
                    :required="true" size="col-lg-3 mt-2" :value="old('total_employee')" />
                <x-forms.input label="Invoice Date" type="date" name="date" id="date" :required="true"
                    size="col-lg-3 mt-2" :value="old('date')" />
                <div class="col-lg-3 mt-2" id="form-group-state">
                    <label for="client">For the month
                        <span style="color: red">*</span>
                    </label>
                    <select class="form-select" name="inv_month" required data-fouc>
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
                <x-forms.input label="Attack File(Max file size 2mb)" type="file" name="file" id="file"
                    :required="false" size="col-lg-3 mt-2" :value="old('file')" />
            </div>
            <button type="submit" class="submit-btn submitBtn" id="submitButton">Submit</button>
        </form>
    </div>
    @push('scripts')
        <script>
            function get_client_location() {
                let client = $("#client").val();
                jQuery.ajax({
                    type: "get",
                    url: "{{ route('admin.get.client.location', ':client') }}".replace(':client', client),
                    datatype: "text",
                    success: function(response) {
                        $('#location').empty();
                        $('#location').append(response);
                        $('#gst_no').val("");
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.error(thrownError);
                    }
                });
            }

            function get_client_gst() {
                let client = $("#client").val();
                let client_location = $("#location").val();

                if (client != "" && client_location != "") {
                    let url = "{{ route('admin.get.client.gst', [':client', ':location']) }}";
                    url = url.replace(':client', client).replace(':location', client_location); // Replace placeholders

                    jQuery.ajax({
                        type: "get",
                        url: url,
                        datatype: "text",
                        data: {
                            client: client,
                            client_location: client_location,
                        },
                        success: function(response) {
                            console.log(response);
                            $('#gst_no').val(response); // Set GST number
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            console.error(thrownError); // Log errors for debugging
                        }
                    });
                }
            }
            $('#gross_value, #service_value, #source_value').on('change', function() {
                get_calculate_total();
            });
            $('#cgst, #sgst, #igst').on('change', function() {
                get_tax_amt();
            });
            $('#credit_note, #debit_note').on('change', function() {
                get_grand_total();
            });

            function get_calculate_total() {
                var gross_value = isNaN(parseInt($("#gross_value").val())) ? 0 : parseInt($("#gross_value").val());
                var service_fees = isNaN(parseInt($("#service_value").val())) ? 0 : parseInt($("#service_value").val());
                var source_fees = isNaN(parseInt($("#source_value").val())) ? 0 : parseInt($("#source_value").val());

                var total = gross_value + service_fees + source_fees;

                console.log(total, gross_value, service_fees, source_fees);

                $("#total").val(total);
                get_tax_amt();
            }


            function get_tax_amt() {
                var total = isNaN(parseInt($("#total").val())) ? 0 : parseInt($("#total").val());
                var cgst = isNaN(parseInt($("#cgst").val())) ? 0 : parseInt($("#cgst").val());
                var sgst = isNaN(parseInt($("#sgst").val())) ? 0 : parseInt($("#sgst").val());
                var igst = isNaN(parseInt($("#igst").val())) ? 0 : parseInt($("#igst").val());

                cgst_amt = (total * cgst) / 100;
                sgst_amt = (total * sgst) / 100;
                igst_amt = (total * igst) / 100;

                $("#cgst_amt").val("" + cgst_amt);
                $("#sgst_amt").val("" + sgst_amt);
                $("#igst_amt").val("" + igst_amt);

                total_tax = cgst_amt + sgst_amt + igst_amt;
                $("#total_tax").val("" + total_tax);
                get_inv_total();
            }

            function get_inv_total() {
                var total = isNaN(parseInt($("#total").val())) ? 0 : parseInt($("#total").val());
                var total_tax = isNaN(parseInt($("#total_tax").val())) ? 0 : parseInt($("#total_tax").val());

                inv_total = total + total_tax;
                $("#inv_total").val("" + inv_total);
                get_grand_total();
            }

            function get_grand_total() {
                var inv_total = isNaN(parseInt($("#inv_total").val())) ? 0 : parseInt($("#inv_total").val());
                var credit_amt = isNaN(parseInt($("#credit_note").val())) ? 0 : parseInt($("#credit_note").val());
                var debit_amt = isNaN(parseInt($("#debit_note").val())) ? 0 : parseInt($("#debit_note").val());

                total = inv_total - credit_amt;

                grand_total = total + debit_amt;
                $("#grand_total").val("" + grand_total);
            }
        </script>
    @endpush
</x-applayout>
