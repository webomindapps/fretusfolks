<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header bg-primary">
            <div class="modal-title">
                <h5 class="" id="client_details">{{ $client->client_name }}</h5>
            </div>
            <button type="button" class="close" id="closeModalButton">×</button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <h6 class="font-weight-semibold">Invoice Details</h6>
                </div>
                <div class="col-md-4 col-sm-6">
                    <p><b>Invoice No :</b> <span>{{ $payments->invoice->invoice_no }}</span></p>
                    <p><b>Total Amount :</b> <span>{{ $payments->total_amt }}</span></p>
                    <p><b>Invoice Amount :</b> <span>{{ $payments->total_amt_gst }}</span></p>
                    <p><b>Payment Recived Date :</b> <span>{{ $payments->payment_received_date }}</span></p>
                </div>
                <div class="col-md-4 col-sm-6">
                    <p><b>Month :</b> <span>{{ $payments->month }}</span></p>
                    <p><b>TDS Code:</b> <span>{{ $tds_code->code }}</span></p>
                    <p><b>TDS Percentage :</b> <span>{{ $payments->tds_percentage }}</span></p>
                    <p><b>TDS Amount :</b> <span>{{ $payments->tds_amount }}</span></p>
                </div>
                <div class="col-md-4 col-sm-6">
                    <p><b>Amount Recived :</b> <span>{{ $payments->amount_received }}</span></p>
                    <p><b>Balance Amount:</b> <span>{{ $payments->balance_amount }}</span></p>
                    <p><b>Date :</b> <span>{{ \Carbon\Carbon::parse($payments->date_time)->format('d-m-Y') }}</span>
                    </p>
                    <p><b>TDS Amount :</b> <span>{{ $payments->tds_amount }}</span></p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <p><b>State :</b> <span>{{ $payments->invoice->service_location }}</span></p>
                    <p><b>GST NO:</b> <span>{{ $payments->invoice->gst_no }}</span></p>
                    {{-- <p><b>Invoice No :</b> <span>{{ $payments->invoice->invoice_no }}</span></p>
                    <p><b>Invoice No :</b> <span>{{ $payments->invoice->invoice_no }}</span></p> --}}

                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn bg-primary" id="closeModalButton">Close</button>
            </div>
        </div>
    </div>
