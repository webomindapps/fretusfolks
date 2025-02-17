<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header bg-primary">
            <div class="modal-title">
                <h5 class="" id="invoiceDetailsLabel">{{ $invoice->client?->client_name }}</h5>
            </div>
            <button type="button" class="close" id="closeModalButton">×</button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <p><b>invoice No :</b> <span> {{ $invoice->invoice_no }}</span></p>
                    <p><b>GST No :</b> <span> {{ $invoice->gst_no }}</span></p>
                    <p><b>Gross Value :</b> Rs. <span>{{ $invoice->gross_value ?? 0 }}</span></p>
                    <p><b>CGST (%) :</b><span> {{ $invoice->cgst ?? 0 }}</span></p>
                    <p><b>CGST Amount :</b> Rs. <span>{{ $invoice->cgst_amount ?? 0 }}</span></p>
                    <p><b>Total Tax :</b> Rs. <span>{{ $invoice->tax_amount ?? 0 }}</span></p>
                </div>
                <div class="col-md-4 col-sm-6">
                    <p><b>Client Name :</b> <span> {{ $invoice->client?->client_name }}</span></p>
                    <p>-</p>
                    <p><b>Service Fees :</b> Rs. <span>{{ $invoice->service_value ?? 0 }}</span></p>
                    <p><b>SGST (%) :</b><span> {{ $invoice->sgst ?? 0 }}</span></p>
                    <p><b>SGST Amount :</b> Rs. <span>{{ $invoice->sgst_amount ?? 0 }}</span></p>
                    <p><b>Total Amount :</b> Rs. <span>{{ $invoice->total_value ?? 0 }}</span></p>
                </div>
                <div class="col-md-4 col-sm-6">
                    <p><b>Location :</b> <span> {{ $invoice->state?->state_name }}</span></p>
                    <p>-</p>
                    <p><b>Sourcing Fees :</b> Rs. <span>{{ $invoice->source_value ?? 0 }}</span></p>
                    <p><b>IGST (%) :</b><span> {{ $invoice->igst ?? 0 }}</span></p>
                    <p><b>IGST Amount :</b> Rs. <span>{{ $invoice->igst_amount ?? 0 }}</span></p>
                </div>
                <div class="col-md-12">
                    <p>
                        <a href="{{ asset('storage/' . $invoice->file_path) }}">
                            <i class="fa fa-book"></i>Invoice Document
                        </a>
                    </p>
                </div>
                <div class="col-md-4 col-sm-6">
                    <p><b>Credit Note :</b> Rs. <span> {{ $invoice->credit_note }}</span></p>
                    <p><b>Balance Amount :</b> Rs. <span> {{ $invoice->balance_amount }}</span></p>
                    <p><b>Invoice Generated On :</b>
                        {{ !empty($invoice->date) ? date('d-m-Y', strtotime($invoice->date)) : 'N/A' }}</span></p>
                </div>
                <div class="col-md-4 col-sm-6">
                    <p><b>Debit Note :</b> Rs. <span> {{ $invoice->credit_note }}</span></p>
                    <p><b>TDS Amount :</b> Rs. <span> {{ $invoice->tds_amount }}</span></p>
                    <p><b>For the month :</b><span> {{ $invoice->inv_month }}</span></p>
                </div>
                <div class="col-md-4 col-sm-6">
                    <p><b>Grand Total :</b> Rs. <span> {{ $invoice->grand_total }}</span></p>
                    <p><b>Amount Received :</b> Rs. <span> {{ $invoice->amount_received }}</span></p>
                </div>
            </div>
        </div>
        {{-- <div class="modal-footer">
            <button type="button" class="btn bg-primary" id="closeModalButton">Close</button>
        </div> --}}
    </div>
</div>
