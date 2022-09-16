@push('css')
    <style>
        .sale-modal {
            position: relative;
            top: 0px;
            left: 5px;
        }

    </style>
@endpush
<div>
    <x-slot name="title">SALE LIST</x-slot>
    <x-slot name="header">SALE LIST</x-slot>
    <div class="row mb-4">
        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="search-box mr-2 mb-2 d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title mb-3">Sale List</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                            <div class="text-sm-right">
                                <a href="{{ route('inventory.sales') }}">
                                    <button type="button" style="float: right;"
                                        class="btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2"
                                        data-toggle="modal" data-target=".bd-example-modal-lg">
                                        <i class="mdi mdi-plus mr-1"></i>New Sale
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div wire:ignore class="table-responsive">
                            <table class="display table table-striped table-bordered" id="SaleListTable"
                                style="width:100%"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Start Invoice Modal --}}
    <div wire:ignore.self class="modal fade" id="InvoiceModal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <h5 class="modal-title" id="exampleModalLabel">Invoice</h5> --}}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($invoice)
                    <div id="invoice_page1">
                        <div>
                            <x-slot name="title">@if ($invoice_setting->invoice_title){{$invoice_setting->invoice_title}}@else Sales Invoice @endif</x-slot>
                            <div id="invoice_page">
                                <div class="header">
                                    <div style="overflow:hidden;">
                                        <div style="float:left;margin-top:0px;width: 74%;">
                                            <div class="row">
                                                <div style="float:left;width: 25%;">
                                                    <span><img height=80px; width=130px; src="@if ($invoice_setting){{ asset('storage/photo/' . $invoice_setting->logo) }}@endif"
                                                            alt=""></span>
                                                </div>
                                                <div style="float:left; width: 75%;" class="sale-modal">
                                                    <h1 style="margin:0px;padding:0px;font-size:30px;font-family:'Times New Roman';">
                                                        @if(isset(Auth::user()->Company->name)) {{Auth::user()->Company->name}}@else
                                                        {{ $profile_setting->address }}
                                                        @endif
                                                    </h1>
                                                    <p style="margin:0px;padding:0px;font-size:13px;font-weight:bold">
                                                        Address: @if(isset(Auth::user()->Company->address)) {{Auth::user()->Company->address}}@else
                                                        {{ $profile_setting->address }}
                                                        @endif <br/>
                                                        Postal Code: @if(isset(Auth::user()->Company->postal_code)) {{Auth::user()->Company->postal_code}}@else
                                                        {{ $profile_setting->address }}
                                                        @endif <br/>

                                                        TRN NO: @if(isset(Auth::user()->Company->trn)) {{Auth::user()->Company->trn}}@else
                                                        {{ $profile_setting->address }}
                                                        @endif <br/>

                                                        Mobile: @if(isset(Auth::user()->Company->mobile)) {{Auth::user()->Company->mobile}}@else
                                                        {{ $profile_setting->address }}
                                                        @endif  <br/>

                                                        Telephone: @if(isset(Auth::user()->Company->telephone)) {{Auth::user()->Company->telephone}}@else
                                                        {{ $profile_setting->address }}
                                                        @endif  <br/>

                                                        Email: @if(isset(Auth::user()->Company->telephone)) {{Auth::user()->Company->telephone}}@else
                                                        {{ $profile_setting->address }}
                                                        @endif  <br/>

                                                        Website: @if(isset(Auth::user()->Company->web_address)) {{Auth::user()->Company->web_address}}@else
                                                        {{ $profile_setting->address }}
                                                        @endif  <br/>
                                                    </p>
                                                </div>
                                            </div>
                                            <p
                                                style="font-size:13px;margin:0px;padding:0px; lightskyblue;font-weight:bold;">
                                                 Bill To</p>
                                                <h6><strong>Customer Name @php echo str_repeat('&nbsp;', 5); @endphp: </strong><strong>@if ($invoice) {{ $invoice->Contact->name }}@endif</strong></h6>
                                                <h6><strong>Contact Person @php echo str_repeat('&nbsp;',6); @endphp:</strong><strong>@if ($invoice) {{ $invoice->Contact->business_name }}@endif</strong> </h6>
                                                <h6><strong>Telephone @php echo str_repeat('&nbsp;', 14); @endphp:</strong><strong>@if ($invoice) {{ $invoice->Contact->telephone }}@endif</strong></h6>
                                                <h6><strong>Mobile @php echo str_repeat('&nbsp;', 20); @endphp:</strong><strong>@if ($invoice) {{ $invoice->Contact->mobile }} @endif</strong></h6>
                                                <h6><strong>TRN @php echo str_repeat('&nbsp;', 24); @endphp:</strong> <strong>@if ($invoice) {{ $invoice->Contact->trn_no }} @endif</strong></h6>
                                                <h6><strong>Email @php echo str_repeat('&nbsp;', 22); @endphp:</strong> <strong>@if ($invoice) {{ $invoice->Contact->email }} @endif</strong></h6>
                                                <h6><strong>Address @php echo str_repeat('&nbsp;', 18); @endphp:</strong> <strong>@if ($invoice) {{ $invoice->Contact->address }} @endif</strong> </h6>
                                            <!--h6>Delivery By &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp; Nazmul</h6-->
                                        </div>
                                        <div style="float:right;width: 25%; position: relative; bottom: 17px;">
                                            <h3
                                                style="color:red;font-weight:bold;margin-left:0px;margin-top:20px;font-size:20px;">
                                                {{ $invoice->payment_status }}</h3>
                                                <h6 style="margin:0px;font-weight:bold;font-size:20px;margin-top:20px;color:lightskyblue">@if ($invoice_setting->invoice_title){{$invoice_setting->invoice_title}}@else Sales Invoice @endif</h6>
                                                <h6><strong>Invoice No @php echo str_repeat('&nbsp;',2); @endphp:</strong><strong>{{$invoice->code}}</strong></h6>
                                                <h6><strong>Date @php echo str_repeat('&nbsp;',11); @endphp:</strong> <strong>{{date("Y/m/d")}}</strong></h6>
                                                @if (isset($invoice_setting->do_no))
                                                <h6><strong>DO No @php echo str_repeat('&nbsp;',8); @endphp:</strong><strong>{{$invoice->do_no}}</strong></h6>
                                                @endif
                                                @if (isset($invoice_setting->lpo_no))
                                                <h6><strong>LPO No @php echo str_repeat('&nbsp;',6); @endphp:</strong> <strong>{{$invoice->lpo_no}}</strong></h6>
                                                @endif
                                                <h6><strong>Sold By @php echo str_repeat('&nbsp;',6); @endphp:</strong> <strong>{{Auth::user()->name}}</strong></h6>
                                        </div>
                                    </div>
                                    <br />
                                </div>
                                <div class="inv_body">
                                    @php
                                        $count = 0;
                                    @endphp
                                    <table style="width: 100%;">
                                        <thead>
                                            <tr class="inv_item_row">
                                                <th align="center" style="border:1px solid black;width:40px;">Sl No.</th>
                                                <th align="center" style="border:1px solid black">Description of Goods</th>
                                                <th align="center" style="border:1px solid black;width:40px;">Applicant Name</th>
                                                <th align="center" style="border:1px solid black;width:40px;">Passport No.</th>
                                                <th align="center" style="border:1px solid black;width:40px;">Nationality</th>
                                                <th align="center" style="border:1px solid black; text-align:center;">
                                                    Quantity</th>
                                                <th align="center" style="border:1px solid black; text-align:center;">
                                                    Unit Price</th>
                                                    @if (isset($invoice_setting->vat))
                                                    <th align="center" style="border:1px solid black;text-align:center">VAT
                                                        %</th>
                                                        @else
                                                        @php
                                                            $count++;
                                                        @endphp
                                                    @endif
                                                    @if (isset($invoice_setting->rate))
                                                    <th align="center" style="border:1px solid black;text-align:center">Rate
                                                        (Incl.VAT) </th>
                                                        @else
                                                        @php
                                                            $count++;
                                                        @endphp
                                                    @endif
                                                 @if (isset($invoice_setting->discount))
                                                 <th align="center" style="border:1px solid black;text-align:center">
                                                    Discount</th>
                                                    @else
                                                    @php
                                                        $count++;
                                                    @endphp
                                                 @endif
                                                 @if (isset($invoice_setting->amount_aed))
                                                 <th align="center" style="border:1px solid black; text-align:right;">
                                                    Amount (@if ($currencySymbol){{ $currencySymbol->symbol }}@endif) </th>
                                                    @else
                                                    @php
                                                        $count++;
                                                    @endphp
                                                 @endif
                                                 @if (isset($invoice_setting->texable_value))
                                                 <th align="center" style="border:1px solid black; text-align:right;">
                                                    Texable Value (@if ($currencySymbol){{ $currencySymbol->symbol }}@endif) </th>
                                                    @else
                                                    @php
                                                        $count++;
                                                    @endphp
                                                 @endif
                                                 @if (isset($invoice_setting->vat_aed))
                                                 <th align="center" style="border:1px solid black; text-align:right;">VAT
                                                    (@if ($currencySymbol){{ $currencySymbol->symbol }}@endif)</th>
                                                    @else
                                                    @php
                                                        $count++;
                                                    @endphp
                                                 @endif

                                                <th align="center" style="border:1px solid black; text-align:right;">
                                                    Total Incl.VAT (@if ($currencySymbol){{ $currencySymbol->symbol }}@endif) </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 0;
                                                $include_vat_total = 0;
                                            @endphp
                                            @foreach ($invoice->StockManager as $detail)
                                                <tr class="inv_item_row" id="64663">
                                                    <td align="center" style="border:1px groove;">{{ ++$i }}
                                                    </td>
                                                    <td align="left" style="border:1px groove;">{{ $detail->Item->name }}</td>
                                                    <td align="left" style="border:1px groove;">{{ $detail->applicant_name }}</td>
                                                    <td align="left" style="border:1px groove;">{{ $detail->passport_no }}</td>
                                                    <td align="left" style="border:1px groove;">{{ $detail->nationality }}</td>
                                                    <td align="center" style="border:1px groove">
                                                        {{ $detail->quantity }} @if (isset($detail->Item->Unit)) {{ $detail->Item->Unit->name }} @endif</td>
                                                    <td align="center" style="border:1px groove">
                                                        {{ $detail->sale_price }}</td>
                                                        @if (isset($invoice_setting->vat))
                                                        <td align="center" style="border:1px groove">
                                                            {{ $detail->Item->Vat->name }}</td>
                                                        @endif
                                                    @if (isset($invoice_setting->rate))
                                                    <td align="center" style="border:1px groove">
                                                        {{ $detail->sale_price + ($detail->sale_price * $detail->Item->Vat->rate_percent) / 100 }}
                                                    </td>
                                                    @endif
                                                    @if (isset($invoice_setting->discount))
                                                    <td align="center" style="border:1px groove"></td>
                                                    @endif
                                                    @if (isset($invoice_setting->amount_aed))
                                                    <td align="right" style="text-align:right;border:1px groove">
                                                        {{ $detail->Item->sale_price * $detail->quantity }}</td>
                                                    @endif
                                                    @if (isset($invoice_setting->texable_value))
                                                    <td align="right" style="text-align:right;border:1px groove">
                                                        {{ $detail->sale_price * $detail->quantity }}</td>
                                                    @endif
                                                    @if (isset($invoice_setting->vat_aed))
                                                   <td align="right" style="text-align:right;border:1px groove">
                                                    {{ (($detail->sale_price * $detail->Item->Vat->rate_percent) / 100) * $detail->quantity }}
                                                    </td>
                                                    @endif
                                                    <td align="right" style="text-align:right;border:1px groove">
                                                        {{ ($detail->sale_price + ($detail->sale_price * $detail->Item->Vat->rate_percent) / 100) * $detail->quantity }}
                                                        @php
                                                            $include_vat_total += ($detail->sale_price + ($detail->sale_price * $detail->Item->Vat->rate_percent) / 100) * $detail->quantity;
                                                        @endphp
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="{{ 10 - $count}}" align="right"
                                                    style="font-weight:bold;border:1px groove">Sub Total :</td>
                                                <td align="right" style="font-weight:bold;border:1px groove">
                                                    {{-- {{ $invoice->subtotal }} --}}
                                                </td>
                                                <td align="right" style="font-weight:bold;border:1px groove">
                                                    {{-- {{ $invoice->subtotal }} --}}
                                                </td>
                                                <td align="right" style="font-weight:bold;border:1px groove">
                                                    {{-- {{ $invoice->total_vat }} --}}
                                                </td>
                                                <td align="right" style="font-weight:bold;border:1px groove">
                                                    {{ $include_vat_total }}</td>
                                            </tr>
                                            <tr class="inv_item_row">
                                                <td colspan="{{ 13 - $count}}" align="right">(-) Discount:</td>
                                                <td colspan="2" align="right">{{ $invoice->discount_value }}</td>
                                            </tr>
                                            <tr class="inv_item_row">
                                                <td colspan="{{ 13 - $count}}" align="right" style="font-weight:bold;">Net Payable :
                                                </td>
                                                <td colspan="{{ 5 - $count}}" align="right" style="font-weight:bold;">
                                                    {{ $invoice->amount_to_pay }}</td>
                                            </tr>
                                            <tr class="inv_item_row">
                                                <td colspan="{{ 13 - $count}}" align="right" style="font-weight:bold;">Total Paid :
                                                </td>
                                                <td colspan="{{ 5 - $count}}" align="right" style="font-weight:bold;">
                                                    {{ $invoice->paid_amount }}</td>
                                            </tr>
                                            <tr class="inv_item_row">
                                                <td colspan="{{ 13 - $count}}" align="right" style="font-weight:bold;">Due Amount :
                                                </td>
                                                <td colspan="{{ 5 - $count}}" align="right" style="font-weight:bold;">
                                                    {{ $invoice->due_amount }}</td>
                                            </tr>
                                            {{-- <tr class="inv_item_row">
                                    <td colspan="10" align="right" style="font-weight:bold;">(+) Previous Due : </td>
                                    <td colspan="2" align="right" style="font-weight:bold;">{{$invoice->due_amount}}</td>
                                 </tr>
                                 <tr class="inv_item_row">
                                    <td colspan="10" align="right" style="font-weight:bold;"> Total Due : </td>
                                    <td colspan="2" align="right" style="font-weight:bold; color:red;">87,471.50</td>
                                 </tr> --}}
                                        </tbody>
                                    </table>
                                </div>
                                @if (isset($invoice_setting->transaction))
                                <div style="width: 500px; margin: 0 auto;padding: 10px;">
                                    <table
                                        style="border:2px solid black; padding: 10px; position: relative; left:58px;">
                                        <thead>
                                            <tr class="inv_item_row">
                                                <th align="center" style="border:1px solid black">Bank</th>
                                                <th align="center" style="border:1px solid black">Transaction ID</th>
                                                <th align="center" style="border:1px solid black">Type</th>
                                                <th align="center" style="border:1px solid black">Date</th>
                                                <th align="center" style="border:1px solid black">Note</th>
                                                <th align="center" style="border:1px solid black">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($invoice->InvoicePaidAmount as $invoicePaid)
                                                <tr class="inv_item_row">
                                                    <td align="center" style="border:1px solid black">
                                                        @if ($invoicePaid->ChartOfAccountDr)
                                                            {{ $invoicePaid->ChartOfAccountDr->name }}
                                                        @elseif ($invoicePaid->ChartOfAccountCr)
                                                            {{ $invoicePaid->ChartOfAccountCr->name }}
                                                        @endif
                                                    </td>
                                                    <td align="center" style="border:1px solid black">
                                                        {{ $invoicePaid->code }}</td>
                                                    <td align="center" style="border:1px solid black">
                                                        {{ $invoicePaid->type }}</td>
                                                    <td align="center" style="border:1px solid black">
                                                        {{ $invoicePaid->date }}</td>
                                                    <td align="center" style="border:1px solid black">
                                                        {{ $invoicePaid->note }}</td>
                                                    <td align="center" style="border:1px solid black">
                                                        @if ($currencySymbol) {{ $currencySymbol->symbol }} @endif{{ $invoicePaid->amount }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @endif

                                <div class="col-md-12 heading">
                                    <div class="col-md-12" style="position:absolute; right: 15px; top: 17px;">
                                        <table>
                                            <tr class="inv_item_row">
                                                <td>Amount Chargeable (In Words):@if(isset($numberToWordTotal)){{ $numberToWordTotal }}@endif</td>
                                            </tr>
                                            {{-- <tr>
                                        <td>VAT Amount (In Words):<br> {{$numberToWordVat}}</td>
                                    </tr> --}}
                                        </table>
                                    </div>
                                </div><br><br><br>
                                <div style="float:left;margin-top:30px;">
                                    <p style="font-weight:bold;"> Narration/Comments:</p>
                                    <p style="font-weight:bold;">
                                    <p><strong><span style="color: #169179;">Thanks for your visit, and I hope to see
                                                you soon!</span></strong></p>
                                    </p>
                                    <p>
                                        @if ($invoice_setting)
                                            {!! $invoice_setting->footer_title !!}
                                        @endif
                                    </p>
                                    <p>
                                        For any query, Please call @if ($profile_setting) {{ $profile_setting->mobile }} @endif <br>
                                        Powered by: <a href="https://mathemacia.com/" target="_blank">Mathemacia</a>
                                    </p>
                                </div>
                                {{-- <div style="float:left;margin-top:70px;margin-left:100px;">
                                    <hr />
                                    <p>Customer’s Signature</p>
                                </div>
                                <div style="float:right;margin-top:60px;">
                                    <hr />
                                    <p>Authorised Seal & Signature </p>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    @if ($invoice)
                        <button type="submit" class="btn btn-dark" wire:click="InvoicePrint({{ $invoice->id }})">
                            Print
                        </button>
                        <button type="submit" class="btn btn-info" onclick="generatePDF()">
                            PDF
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{-- End Invoice Modal --}}

</div>
@push('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="html2pdf.bundle.min.js"></script>


<script>
function generatePDF(id) {
    var element = document.getElementById('invoice_page');
    var opt = {
        margin: 1,
        filename: 'purchase-invoice.pdf',
        image: {
            type: 'jpeg',
            quality: 0.98
        },
        html2canvas: {
            scale: 2
        },
        jsPDF: {
            unit: 'in',
            format: 'letter',
            orientation: 'portrait'
        }
    };

    // New Promise-based usage:
    html2pdf().set(opt).from(element).save();

    // Old monolithic-style usage:
    // html2pdf(element, opt);

}
</script>

    <script>
        function callInvoice(id) {
            @this.call('InvoiceModal', id);
        }

        function callDelete(id) {
            @this.call('SaleListDelete', id);
        }
        $(document).ready(function() {
            var datatable = $('#SaleListTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('data.sale-list-table') }}",
                columns: [{
                        title: 'SL',
                        data: 'id'
                    },
                    {
                        title: 'Date',
                        data: 'date',
                        name: 'date'
                    },
                    {
                        title: 'Code',
                        data: 'code',
                        name: 'code'
                    },
                    {
                        title: 'Customer',
                        data: 'contact.name',
                        name: 'Contact.name'
                    },
                    {
                        title: 'Discount',
                        data: 'discount',
                        name: 'discount'
                    },
                    {
                        title: 'Total Vat',
                        data: 'total_vat',
                        name: 'total_vat'
                    },
                    {
                        title: 'Shipping charge',
                        data: 'shipping_charge',
                        name: 'shipping_charge'
                    },
                    {
                        title: 'Sub Total',
                        data: 'subtotal',
                        name: 'subtotal'
                    },
                    {
                        title: 'Amount To Pay',
                        data: 'amount_to_pay',
                        name: 'amount_to_pay'
                    },
                    {
                        title: 'Paid Amount',
                        data: 'paid_amount',
                        name: 'paid_amount'
                    },
                    {
                        title: 'Due Amount',
                        data: 'due_amount',
                        name: 'due_amount'
                    },
                    {
                        title: 'Action',
                        data: 'action',
                        name: 'action'
                    },
                ]
            });

            window.livewire.on('success', message => {
                datatable.draw(true);
            });
        });
    </script>
@endpush
