<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header bg-primary">
            <div class="modal-title">
                <h5 class="" id="paymentDetailsLabel">{{ $payment->client?->client_name }}</h5>
            </div>
            <!-- <button type="button" class="close" id="closeModalButton">×</button> -->
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <p><b>Invoice No :</b> <span> {{ $payment->invoice?->invoice_no }}</span></p>
                    <p><b>GST No :</b> <span> {{ $payment->invoice?->gst_no }}</span></p>
                    <p><b>Manpower Supply :</b> Rs. <span>{{ $payment->invoice?->gross_value ?? 0 }}</span></p>
                    <p><b>CGST (%) :</b><span> {{ $payment->invoice?->cgst ?? 0 }}</span></p>
                    <p><b>CGST Amount :</b> Rs. <span>{{ $payment->invoice?->cgst_amount ?? 0 }}</span></p>
                    <p><b>Total Tax :</b> Rs. <span>{{ $payment->invoice?->tax_amount ?? 0 }}</span></p>
                    <p><b>Credit Note :</b> Rs. <span> {{ $payment->invoice?->credit_note }}</span></p>
                </div>
                <div class="col-md-4 col-sm-6">
                    <p><b>Client Name :</b> <span> {{ $payment->client?->client_name }}</span></p>
                    <p>-</p>
                    <p><b>Service Fees :</b> Rs. <span>{{ $payment->invoice?->service_value ?? 0 }}</span></p>
                    <p><b>SGST (%) :</b><span> {{ $payment->invoice?->sgst ?? 0 }}</span></p>
                    <p><b>SGST Amount :</b> Rs. <span>{{ $payment->invoice?->sgst_amount ?? 0 }}</span></p>
                    <p><b>Total Amount (Without GST) :</b> Rs.
                        <span>{{ $payment->invoice?->gross_value + $payment->invoice?->service_value + $payment->invoice?->source_value }}</span>
                    </p>
                    <p><b>Debit Note :</b> Rs. <span> {{ $payment->invoice?->credit_note }}</span></p>
                </div>
                <div class="col-md-4 col-sm-6">
                    <p><b>Location :</b> <span> {{ $payment->invoice?->state?->state_name }}</span></p>
                    <p>-</p>
                    <p><b>Sourcing Fees :</b> Rs. <span>{{ $payment->invoice?->source_value ?? 0 }}</span></p>
                    <p><b>IGST (%) :</b><span> {{ $payment->invoice?->igst ?? 0 }}</span></p>
                    <p><b>IGST Amount :</b> Rs. <span>{{ $payment->invoice?->igst_amount ?? 0 }}</span></p>
                    <p><b>Grand Total :</b> Rs. <span>{{ $payment->invoice->total_value ?? 0 }}</span></p>
                    <p><b>Payable Amount :</b> Rs. <span> {{ $payment->invoice?->gross_value }}</span></p>
                </div>
                <hr>
                <div class="col-md-4 col-sm-6">
                    <p><b>TDS Code :</b> <span> {{ $payment?->tds?->code }}</span></p>
                    <p>
                        <b>Payable Amount :</b> Rs. <span>{{ $payment->invoice->total_value - $payment->tds_amount }}</span>
                    </p>
                    <p>
                        <b>Last Updated On :</b>
                        <span>{{ !empty($payment->date_time) ? date('d-m-Y h:i:s', strtotime($payment->date_time)) : 'N/A' }}</span>
                    </p>
                </div>
                <div class="col-md-4 col-sm-6">
                    <p><b>TDS % :</b> <span> {{ $payment->tds_percentage }}</span></p>
                    <p><b>Paid Amount :</b><span> {{ $payment->amount_received }}</span></p>
                </div>
                <div class="col-md-4 col-sm-6">
                    <p><b>TDS Amount :</b> Rs. <span> {{ $payment->tds_amount }}</span></p>
                    <p><b>Balance Amount :</b> Rs. <span> {{ $payment->balance_amount }}</span></p>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn bg-primary" id="closeModalButton">Close</button>
        </div>
    </div>
</div>
