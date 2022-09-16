@push('css')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
@endpush

<div>
    <x-slot name="title">SUPPLIER LEDGER REPORT</x-slot>
    <x-slot name="header">SUPPLIER LEDGER REPORT</x-slot>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="search-box mr-2  d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title" id="header-text-design">Supplier Leadger Report</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">Start Date</label>
                                <input type="date" wire:model.lazy="start_date" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">End Date</label>
                                <input type="date" wire:model.lazy="end_date" class="form-control" />
                            </div>
                        </div>
                        <div wire:ignore class="col-md-3">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">Select Supplier</label>
                                <select wire:model.lazy="contact_id" id="chart_of_account_id"
                                    class="form-control form-select select2">
                                    <option value=""> Select One Option</option>
                                    @foreach ($ContactList as $contact)
                                    <option value="{{ $contact->id }}">{{ $contact->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-lg-3">
                            <div wire:ignore class="form-group">
                                <label for="basicpill-firstname-input">Select Company</label>
                                <select class="form-control form-select select2 updateTable"
                                    placeholder="Customer" name="" id="">
                                    <option value="">Select Company</option>
                                    {{-- @foreach ($CompanyInfo as $CompanyInfo)
                                    <option value="{{ $CompanyInfo->id }}">{{ $CompanyInfo->name }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Start Report --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable-buttons" class="table table-striped table-bordered nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead style="background-color: #06A5AA;font-weight: bold;">
                        <tr>
                            <th>SL</th>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>0</td>
                            <td colspan="2">Opening</td>
                            @php
                            $drOpening = $this->openingDateFilter($Contact->InvoicePaidAmount)->sum('amount');
                            $crOpening = $this->openingDateFilter($Contact->PurchaseInvoice)->sum('amount_to_pay');

                            $openingBalance = 0;
                            $openingBalance = $drOpening-$crOpening;
                            @endphp
                            <td>{{ $drOpening }}</td>
                            <td>{{ $crOpening }}</td>
                            <td>{{ $openingBalance }}</td>
                        </tr>
                        @php
                        $totalBalance = $openingBalance;
                        @endphp

                        @foreach ($this->dateFilter($Contact->InvoicePaidAmount) as $drItem)
                        @php
                        $totalBalance -= $drItem->amount;
                        @endphp
                        <tr>
                            <th>1</th>
                            <th>{{ $drItem->date }}</th>
                            <td>
                                @if($drItem->ChartOfAccountDr)
                                <button class="btn" wire:click="InvoiceModal({{$drItem->invoice_id}})">
                                    {{ $drItem->ChartOfAccountDr->name }}
                                </button>
                                @elseif($drItem->ChartOfAccountCr)
                                <button class="btn" wire:click="InvoiceModal({{$drItem->invoice_id}})">
                                    {{ $drItem->ChartOfAccountCr->name }}
                                </button>
                                @endif
                            </td>
                            <td>0</td>
                            <td>{{ $drItem->amount }}</td>
                            <td>{{ $totalBalance }}</td>
                        </tr>
                        @endforeach
                        @php
                        $crAmount = 0;
                        @endphp
                        @foreach ($this->dateFilter($Contact->PurchaseInvoice) as $crItem)
                        @php

                        $totalBalance -= $crItem->amount_to_pay;
                        @endphp
                        <tr>
                            <th>1</th>
                            <td>{{ $crItem->date }}</td>
                            <td>
                                <button class="btn" wire:click="InvoiceModal({{$crItem->id}})">
                                    {{ $crItem->code }}
                                </button>
                            </td>

                            <td>{{ $crItem->amount_to_pay }}</td>
                            <td>0</td>
                            <td>{{ $totalBalance }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <th colspan="5" style="text-align: center;">Closing</th>
                            <td>{{ $totalBalance }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- End Report --}}

    {{-- Start Invoice Modal --}}
    <div wire:ignore.self class="modal fade" id="InvoiceModal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Invoice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- Start General Ledger --}}
                    @if($invoice && ($invoice->type=="Sales" || $invoice->type=="Purchase"))
                    <div>
                        <x-slot name="title">@if($invoice->type=="Sales") SALES @elseif($invoice->type=="Purchase")
                            Purchase @endif INVOICE</x-slot>
                        <div id="invoice_page">
                            <div class="header">
                                <div style="overflow:hidden;">
                                    <div style="float:left;margin-top:0px;width: 74%;">
                                        <div class="row">
                                            <div style="float:left;width: 25%;">
                                                <span><img
                                                        style="width: 80px;height: 80px;border-radius: 50%;margin-left: 15px;"
                                                        src="@if($invoice_setting){{ asset('storage/photo/'.$invoice_setting->logo) }}@endif"
                                                        alt=""></span>
                                            </div>
                                            <div style="float:left; width: 75%;">
                                                <h1
                                                    style="margin:0px;padding:0px;font-size:30px;font-family:'Times New Roman';">
                                                    @if ($profile_setting){{$profile_setting->business_name}}@endif</h1>
                                                <p style="margin:0px;padding:0px;font-size:13px;font-weight:bold">
                                                    @if($profile_setting){{$profile_setting->address}}@endif
                                                    @if($profile_setting) {{$profile_setting->postal_code}}@endif
                                                    @if($profile_setting) {{$profile_setting->phone}}<br /> @endif
                                                    @if($profile_setting) {{$profile_setting->email}}<br /> @endif
                                                    @if($profile_setting) {{$profile_setting->website}} @endif
                                                </p>
                                            </div>
                                        </div>
                                        <p
                                            style="font-size:13px;margin:0px;padding:0px; lightskyblue;font-weight:bold;">
                                            Bill To</p>
                                        <h6><strong>@if($invoice->type=="Sales") Customer
                                                @elseif($invoice->type=="Purchase") Supplier @endif Name @php echo str_repeat('&nbsp;', 4); @endphp:
                                                </strong><strong>@if($invoice)
                                                {{$invoice->Contact->name}}@endif</strong></h6>
                                                <h6><strong>Contact Person @php echo str_repeat('&nbsp;', 3); @endphp:</strong> <strong>@if ($invoice) {{ $invoice->Contact->business_name }}@endif</strong> </h6>
                                                <h6><strong>Telephone @php echo str_repeat('&nbsp;', 10); @endphp</strong> :<strong>@if ($invoice) {{ $invoice->Contact->telephone }}@endif</strong></h6>
                                                <h6><strong>Mobile @php echo str_repeat('&nbsp;', 16); @endphp</strong> :<strong>@if ($invoice) {{ $invoice->Contact->mobile }} @endif</strong></h6>
                                                <h6><strong>TRN @php echo str_repeat('&nbsp;', 21); @endphp: </strong> <strong>@if ($invoice) {{ $invoice->Contact->trn_no }} @endif</strong></h6>
                                                <h6><strong>Email @php echo str_repeat('&nbsp;', 19); @endphp:</strong> <strong>@if ($invoice) {{ $invoice->Contact->email }} @endif</strong></h6>
                                                <h6><strong>Address @php echo str_repeat('&nbsp;', 15); @endphp:</strong> <strong>@if ($invoice) {{ $invoice->Contact->address }} @endif</strong> </h6>
                                                <h6><strong>Place of Supplier :</strong> <strong>{{ $invoice->Contact->division }}{{ $invoice->Contact->country }}</strong></h6>
                                        <!--h6>Delivery By &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp; Nazmul</h6-->
                                    </div>
                                    <div style="float:right;width: 25%;">
                                        <h3
                                            style="color:red;font-weight:bold;margin-left:0px;margin-top:20px;font-size:20px;">
                                            {{$invoice->payment_status}}</h3>
                                        <h6
                                            style="margin:0px;font-weight:bold;font-size:20px;margin-top:20px;color:lightskyblue">
                                            @if($invoice->type=="Sales") Sales @elseif($invoice->type=="Purchase")
                                            Purchase @endif Invoice</h6>
                                        <h6><strong>Invoice No : </strong><strong>{{$invoice->code}}</strong>
                                        </h6>
                                        <h6><strong>Date @php echo str_repeat('&nbsp;', 9); @endphp: {{date("Y/m/d")}}</strong></h6>
                                        <h6><strong>Sold By @php echo str_repeat('&nbsp;', 4); @endphp: {{Auth::user()->name}}</strong></h6>
                                    </div>
                                </div>
                                <br />
                            </div>
                            <div class="inv_body">
                                <table>
                                    <thead>
                                        <tr class="inv_item_row">
                                            <th align="center" style="border:1px solid black;width:40px;">Sl No.</th>
                                            <th align="center" style="border:1px solid black">Description of Goods</th>
                                            <th align="center" style="border:1px solid black; text-align:center;">
                                                Quantity</th>
                                            <th align="center" style="border:1px solid black; text-align:center;">Unit
                                                Price</th>
                                            <th align="center" style="border:1px solid black;text-align:center">VAT %
                                            </th>
                                            <th align="center" style="border:1px solid black;text-align:center">Rate
                                                (Incl.VAT) </th>
                                            <th align="center" style="border:1px solid black;text-align:center">Discount
                                            </th>
                                            <th align="center" style="border:1px solid black; text-align:right;">Amount
                                                (@if ($currencySymbol){{$currencySymbol->symbol}}@endif) </th>
                                            <th align="center" style="border:1px solid black; text-align:right;">Texable
                                                Value (@if ($currencySymbol){{$currencySymbol->symbol}}@endif) </th>
                                            <th align="center" style="border:1px solid black; text-align:right;">VAT
                                                (@if ($currencySymbol){{$currencySymbol->symbol}}@endif)</th>
                                            <th align="center" style="border:1px solid black; text-align:right;">Total
                                                Incl.VAT (@if ($currencySymbol){{$currencySymbol->symbol}}@endif) </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $i = 0;
                                        $include_vat_total=0;
                                        @endphp
                                        @foreach ($invoice->StockManager as $detail)
                                        <tr class="inv_item_row" id="64663">
                                            <td align="center" style="border:1px groove;">{{ ++$i }}</td>
                                            <td align="left" style="border:1px groove;">{{ $detail->Item->name }}</td>
                                            <td align="center" style="border:1px groove">{{$detail->quantity}}
                                                @if(isset($detail->Item->Unit)) {{$detail->Item->Unit->name}} @endif
                                            </td>
                                            <td align="center" style="border:1px groove">{{$detail->sale_price}}</td>
                                            <td align="center" style="border:1px groove">{{$detail->Item->Vat->name}}
                                            </td>
                                            <td align="center" style="border:1px groove">
                                                {{$detail->sale_price+$detail->sale_price *
                                                $detail->Item->Vat->rate_percent/100}}</td>
                                            <td align="center" style="border:1px groove"></td>
                                            <td align="right" style="text-align:right;border:1px groove">{{
                                                $detail->Item->sale_price * $detail->quantity }}</td>
                                            <td align="right" style="text-align:right;border:1px groove">
                                                {{$detail->sale_price*$detail->quantity}}</td>
                                            <td align="right" style="text-align:right;border:1px groove">
                                                {{($detail->sale_price *
                                                $detail->Item->Vat->rate_percent/100)*$detail->quantity}}</td>
                                            <td align="right" style="text-align:right;border:1px groove">
                                                {{($detail->sale_price+$detail->sale_price *
                                                $detail->Item->Vat->rate_percent/100)*$detail->quantity}}
                                                @php
                                                $include_vat_total += ($detail->sale_price+$detail->sale_price *
                                                $detail->Item->Vat->rate_percent/100)*$detail->quantity;
                                                @endphp
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="7" align="right" style="font-weight:bold;border:1px groove">Sub
                                                Total :</td>
                                            <td align="right" style="font-weight:bold;border:1px groove">
                                                {{$invoice->subtotal}}</td>
                                            <td align="right" style="font-weight:bold;border:1px groove">
                                                {{$invoice->subtotal}}</td>
                                            <td align="right" style="font-weight:bold;border:1px groove">
                                                {{$invoice->total_vat}}</td>
                                            <td align="right" style="font-weight:bold;border:1px groove">
                                                {{$include_vat_total}}</td>
                                        </tr>
                                        <tr class="inv_item_row">
                                            <td colspan="10" align="right">(-) Discount:</td>
                                            <td colspan="2" align="right">{{$invoice->discount_value}}</td>
                                        </tr>
                                        <tr class="inv_item_row">
                                            <td colspan="10" align="right" style="font-weight:bold;">Net Payable : </td>
                                            <td colspan="2" align="right" style="font-weight:bold;">
                                                {{$invoice->amount_to_pay}}</td>
                                        </tr>
                                        <tr class="inv_item_row">
                                            <td colspan="10" align="right" style="font-weight:bold;">Total Paid : </td>
                                            <td colspan="2" align="right" style="font-weight:bold;">
                                                {{$invoice->paid_amount}}</td>
                                        </tr>
                                        <tr class="inv_item_row">
                                            <td colspan="10" align="right" style="font-weight:bold;">Due Amount : </td>
                                            <td colspan="2" align="right" style="font-weight:bold;">
                                                {{$invoice->due_amount}}</td>
                                        </tr>
                                        {{-- <tr class="inv_item_row">
                                            <td colspan="10" align="right" style="font-weight:bold;">(+) Previous Due :
                                            </td>
                                            <td colspan="2" align="right" style="font-weight:bold;">
                                                {{$invoice->due_amount}}</td>
                                        </tr>
                                        <tr class="inv_item_row">
                                            <td colspan="10" align="right" style="font-weight:bold;"> Total Due : </td>
                                            <td colspan="2" align="right" style="font-weight:bold; color:red;">87,471.50
                                            </td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>
                            <div style="width: 500px; margin: 0 auto;padding: 10px;">
                                <table style="border:2px solid black; padding: 10px;">
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
                                                {{$invoicePaid->ChartOfAccountDr->name}}
                                                @elseif ($invoicePaid->ChartOfAccountCr)
                                                {{$invoicePaid->ChartOfAccountCr->name}}
                                                @endif
                                            </td>
                                            <td align="center" style="border:1px solid black">{{$invoicePaid->code}}
                                            </td>
                                            <td align="center" style="border:1px solid black">{{$invoicePaid->type}}
                                            </td>
                                            <td align="center" style="border:1px solid black">{{$invoicePaid->date}}
                                            </td>
                                            <td align="center" style="border:1px solid black">{{$invoicePaid->note}}
                                            </td>
                                            <td align="center" style="border:1px solid black">@if($currencySymbol)
                                                {{$currencySymbol->symbol}} @endif{{$invoicePaid->amount}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12 heading">
                                <div class="col-md-8" style="position:absolute">
                                    <table>
                                        <tr class="inv_item_row">
                                            {{-- <td>Amount Chargeable (In Words):<br> {{$numberToWordTotal}}</td> --}}
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
                                <p><strong><span style="color: #169179;">Thanks for your visit, and I hope to see you
                                            soon!</span></strong></p>
                                </p>
                                <p>
                                    @if($invoice_setting)
                                    {!! $invoice_setting->footer_title !!}
                                    @endif
                                </p>
                                <p>
                                    For any query, Please call @if($profile_setting) {{$profile_setting->mobile}} @endif
                                    <br>
                                    Powered by: <a href="https://shomikaron.com/" target="_blank">Shomikaron</a>
                                </p>
                            </div>
                            <div style="float:left;margin-top:70px;margin-left:100px;">
                                <hr />
                                {{-- <p>Customer’s Signature</p> --}}
                            </div>
                            <div style="float:right;margin-top:60px;">
                                <hr />
                                {{-- <p>Authorised Seal & Signature </p> --}}
                            </div>
                        </div>
                    </div>
                    @elseif($invoice && ($invoice->type=="Sales Return" || $invoice->type=="Purchase Return"))
                    {{-- Start Sales/Purchase Return Invoice --}}
                    <div>
                        <x-slot name="title">@if($invoice->type=="Sales Return") SALES @else PURCHASE @endif RETURN
                            INVOICE</x-slot>
                        <div id="invoice_page">
                            <div class="header">
                                <div style="overflow:hidden;">
                                    <div style="float:left;margin-top:0px;width: 74%;">
                                        <div class="row">
                                            <div style="float:left;width: 25%;">
                                                <span><img height=80px; width=80px;
                                                        src="@if($invoice_setting){{ asset('storage/photo/'.$invoice_setting->logo) }}@endif"
                                                        alt=""></span>
                                            </div>
                                            <div style="float:left; width: 75%;">
                                                <h1
                                                    style="margin:0px;padding:0px;font-size:30px;font-family:'Times New Roman';">
                                                    {{$profile_setting->business_name}}</h1>
                                                <p style="margin:0px;padding:0px;font-size:13px;font-weight:bold">
                                                    {{$profile_setting->address}}
                                                    {{$profile_setting->postal_code}}
                                                    {{$profile_setting->phone}}<br />
                                                    {{$profile_setting->email}}<br />
                                                    {{$profile_setting->website}}
                                                </p>
                                            </div>
                                        </div>
                                        <p
                                            style="font-size:13px;margin:0px;padding:0px; lightskyblue;font-weight:bold;">
                                            Bill To</p>
                                        <h6><strong>@if($invoice->type=="Sales Return") Customer @else Supplier @endif
                                                Name &nbsp;&nbsp;:&nbsp;&nbsp;</strong><strong>
                                                {{$invoice->Contact->name}}</strong></h6>
                                                <h6><strong>Contact Person @php echo str_repeat('&nbsp;',6); @endphp:</strong><strong>@if ($invoice) {{ $invoice->Contact->business_name }}@endif</strong> </h6>
                                                <h6><strong>Telephone @php echo str_repeat('&nbsp;', 14); @endphp:</strong><strong>@if ($invoice) {{ $invoice->Contact->telephone }}@endif</strong></h6>
                                                <h6><strong>Mobile @php echo str_repeat('&nbsp;', 20); @endphp:</strong><strong>@if ($invoice) {{ $invoice->Contact->mobile }} @endif</strong></h6>
                                                <h6><strong>TRN @php echo str_repeat('&nbsp;', 24); @endphp:</strong> <strong>@if ($invoice) {{ $invoice->Contact->trn_no }} @endif</strong></h6>
                                                <h6><strong>Email @php echo str_repeat('&nbsp;', 22); @endphp:</strong> <strong>@if ($invoice) {{ $invoice->Contact->email }} @endif</strong></h6>
                                                <h6><strong>Address @php echo str_repeat('&nbsp;', 18); @endphp:</strong> <strong>@if ($invoice) {{ $invoice->Contact->address }} @endif</strong> </h6>
                                                <h6><strong>Place of Supplier @php echo str_repeat('&nbsp;', 3); @endphp:</strong> <strong>{{ $invoice->Contact->division }}{{ $invoice->Contact->country }}</strong></h6>
                                    </div>
                                    <div style="float:right;width: 25%;">
                                        <h3
                                            style="color:red;font-weight:bold;margin-left:0px;margin-top:0px;font-size:20px;">
                                            {{$invoice->payment_status}}</h3>
                                        <h6 style="margin:0px;font-weight:bold;font-size:20px;color:lightskyblue">Sales
                                            Return Invoice</h6>
                                            <h6><strong>Invoice No @php echo str_repeat('&nbsp;',0); @endphp:</strong><strong>{{$invoice->code}}</strong></h6>
                                            <h6><strong>Date @php echo str_repeat('&nbsp;',10); @endphp:</strong> <strong>{{date("Y/m/d")}}</strong></h6>
                                            <h6><strong>Chalan No @php echo str_repeat('&nbsp;',1); @endphp:</strong><strong>{{$invoice->chalan_no}}</strong></h6>
                                            <h6><strong>Memo No @php echo str_repeat('&nbsp;',2); @endphp:</strong> <strong>{{$invoice->memo_no}}</strong></h6>
                                            <h6><strong>Sold By @php echo str_repeat('&nbsp;',6); @endphp:</strong> <strong>{{Auth::user()->name}}</strong></h6>
                                    </div>
                                </div>
                                <br />
                            </div>
                            <div class="inv_body">
                                <table>
                                    <thead>
                                        <tr class="inv_item_row">
                                            <th align="center" style="border:1px solid black;width:40px;">Sl No.</th>
                                            <th align="center" style="border:1px solid black">Description of Goods</th>
                                            <th align="center" style="border:1px solid black; text-align:center;">
                                                Quantity</th>
                                            <th align="center" style="border:1px solid black; text-align:center;">Unit
                                                Price</th>
                                            <th align="center" style="border:1px solid black;text-align:center">VAT %
                                            </th>
                                            <th align="center" style="border:1px solid black;text-align:center">Rate
                                                (Incl.VAT) </th>
                                            <th align="center" style="border:1px solid black;text-align:center">Discount
                                            </th>
                                            <th align="center" style="border:1px solid black; text-align:right;">Amount
                                                (@if ($currencySymbol){{$currencySymbol->symbol}}@endif) </th>
                                            <th align="center" style="border:1px solid black; text-align:right;">Texable
                                                Value (@if ($currencySymbol){{$currencySymbol->symbol}}@endif) </th>
                                            <th align="center" style="border:1px solid black; text-align:right;">VAT
                                                (@if ($currencySymbol){{$currencySymbol->symbol}}@endif)</th>
                                            <th align="center" style="border:1px solid black; text-align:right;">Total
                                                Incl.VAT(@if ($currencySymbol){{$currencySymbol->symbol}}@endif) </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $i = 0;
                                        $include_vat_total=0;
                                        @endphp
                                        @foreach ($invoice->StockManager as $detail)
                                        <tr class="inv_item_row" id="64663">
                                            <td align="center" style="border:1px groove;">{{ ++$i }}</td>
                                            <td align="left" style="border:1px groove;">{{ $detail->Item->name }}</td>
                                            <td align="center" style="border:1px groove">{{$detail->quantity}}
                                                @if(isset($detail->Item->Unit)) {{$detail->Item->Unit->name}} @endif
                                            </td>
                                            <td align="center" style="border:1px groove">{{$detail->sale_price}}</td>
                                            <td align="center" style="border:1px groove">{{$detail->Item->Vat->name}}
                                            </td>
                                            <td align="center" style="border:1px groove">
                                                {{$detail->sale_price+$detail->sale_price *
                                                $detail->Item->Vat->rate_percent/100}}</td>
                                            <td align="center" style="border:1px groove"></td>
                                            <td align="right" style="text-align:right;border:1px groove">{{
                                                $detail->Item->sale_price * $detail->quantity }}</td>
                                            <td align="right" style="text-align:right;border:1px groove">
                                                {{$detail->sale_price*$detail->quantity}}</td>
                                            <td align="right" style="text-align:right;border:1px groove">
                                                {{($detail->sale_price *
                                                $detail->Item->Vat->rate_percent/100)*$detail->quantity}}</td>
                                            <td align="right" style="text-align:right;border:1px groove">
                                                {{($detail->sale_price+$detail->sale_price *
                                                $detail->Item->Vat->rate_percent/100)*$detail->quantity}}
                                                @php
                                                $include_vat_total += ($detail->sale_price+$detail->sale_price *
                                                $detail->Item->Vat->rate_percent/100)*$detail->quantity;
                                                @endphp
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="7" align="right" style="font-weight:bold;border:1px groove">Sub
                                                Total :</td>
                                            <td align="right" style="font-weight:bold;border:1px groove">
                                                {{$invoice->subtotal}}</td>
                                            <td align="right" style="font-weight:bold;border:1px groove">
                                                {{$invoice->subtotal}}</td>
                                            <td align="right" style="font-weight:bold;border:1px groove">
                                                {{$invoice->total_vat}}</td>
                                            <td align="right" style="font-weight:bold;border:1px groove">
                                                {{$include_vat_total}}</td>
                                        </tr>
                                        <tr class="inv_item_row">
                                            <td colspan="10" align="right">(-) Discount:</td>
                                            <td colspan="2" align="right">{{$invoice->discount_value}}</td>
                                        </tr>
                                        <tr class="inv_item_row">
                                            <td colspan="10" align="right" style="font-weight:bold;">Net Payable : </td>
                                            <td colspan="2" align="right" style="font-weight:bold;">
                                                {{$invoice->amount_to_pay}}</td>
                                        </tr>
                                        <tr class="inv_item_row">
                                            <td colspan="10" align="right" style="font-weight:bold;">Total Paid : </td>
                                            <td colspan="2" align="right" style="font-weight:bold;">
                                                {{$invoice->paid_amount}}</td>
                                        </tr>
                                        <tr class="inv_item_row">
                                            <td colspan="10" align="right" style="font-weight:bold;">Due Amount : </td>
                                            <td colspan="2" align="right" style="font-weight:bold;">
                                                {{$invoice->due_amount}}</td>
                                        </tr>
                                        {{-- <tr class="inv_item_row">
                                            <td colspan="10" align="right" style="font-weight:bold;">(+) Previous Due :
                                            </td>
                                            <td colspan="2" align="right" style="font-weight:bold;">
                                                {{$invoice->due_amount}}</td>
                                        </tr>
                                        <tr class="inv_item_row">
                                            <td colspan="10" align="right" style="font-weight:bold;"> Total Due : </td>
                                            <td colspan="2" align="right" style="font-weight:bold; color:red;">87,471.50
                                            </td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>
                            <div style="width: 500px; margin: 0 auto;padding: 10px;">
                                <table style="border:2px solid black; padding: 10px;">
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
                                                {{$invoicePaid->ChartOfAccountDr->name}}
                                                @elseif ($invoicePaid->ChartOfAccountCr)
                                                {{$invoicePaid->ChartOfAccountCr->name}}
                                                @endif
                                            </td>
                                            <td align="center" style="border:1px solid black">{{$invoicePaid->code}}
                                            </td>
                                            <td align="center" style="border:1px solid black">{{$invoicePaid->type}}
                                            </td>
                                            <td align="center" style="border:1px solid black">{{$invoicePaid->date}}
                                            </td>
                                            <td align="center" style="border:1px solid black">{{$invoicePaid->note}}
                                            </td>
                                            <td align="center" style="border:1px solid black">@if($currencySymbol)
                                                {{$currencySymbol->symbol}} @endif{{$invoicePaid->amount}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12 heading">
                                <div class="col-md-8" style="position:absolute">
                                    <table>
                                        <tr class="inv_item_row">
                                            {{-- <td>Amount Chargeable (In Words):<br> {{$numberToWordTotal}}</td> --}}
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
                                <p><strong><span style="color: #169179;">Thanks for your visit, and I hope to see you
                                            soon!</span></strong></p>
                                </p>
                                <p>
                                    @if($invoice_setting)
                                    {!! $invoice_setting->footer_title !!}
                                    @endif
                                </p>
                                <p>
                                    For any query, Please call @if($profile_setting) {{$profile_setting->mobile}} @endif
                                    <br>
                                    Powered by: <b>Zain Technologies</b>
                                </p>
                            </div>
                            <div style="float:left;margin-top:70px;margin-left:100px;">
                                <hr />
                                <p>Customer’s Signature</p>
                            </div>
                            <div style="float:right;margin-top:60px;">
                                <hr />
                                <p>Authorised Seal & Signature </p>
                            </div>
                        </div>
                    </div>
                    {{-- End Sales/Purchase Return Invoice --}}
                    @elseif($ReceiptInvoice)
                    {{-- Start Receipt Invoice --}}
                    <div>
                        <x-slot name="title">
                            @if (isset($Receipt->EntryType->name)) {{ $Receipt->EntryType->name }} @endif
                        </x-slot>
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0 font-size-18">Detail</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Invoices</a></li>
                                            <li class="breadcrumb-item active">Detail</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="invoice-title">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <span><img
                                                            style="width: 80px;height: 80px;border-radius: 50%;margin-left: 15px;"
                                                            src="@if($invoice_setting){{ asset('storage/photo/'.$invoice_setting->logo) }}@endif"
                                                            alt=""></span>
                                                </div>
                                                <div class="col-sm-2">
                                                    <h4 class="font-size-18" align="center">
                                                        @if (isset($Receipt->EntryType->name))
                                                        {{ $Receipt->EntryType->name }}
                                                        @endif
                                                    </h4>
                                                </div>
                                                <div class="col-sm-5 text-sm-right">
                                                    <h4 class="font-size-16">{{ config('app.company_name') }}</h4>
                                                    <h4 class="font-size-12">{{ config('app.address') }}<br>
                                                        Email:{{ config('app.email') }} <br> Phone:{{
                                                        config('app.phone') }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <address>

                                                    Date: {{ $Receipt->date }}<br>
                                                    Code: {{ $Receipt->code }}<br>

                                                </address>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 70px; border:1px solid black">No.</th>
                                                        <th style="border:1px solid black">Particular</th>
                                                        <th style="border:1px solid black">Debit</th>
                                                        <th class="text-right" style="border:1px solid black">Credit
                                                        </th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($Receipt->AccountManager as $manager)
                                                    <tr>
                                                        <td style="border:1px solid black">01</td>
                                                        <td style="border:1px solid black">
                                                            @if($manager->dr_account_id)
                                                            {{ $manager->ChartOfAccountDr->name }}
                                                            @else
                                                            {{ $manager->ChartOfAccountCr->name }}
                                                            @endif</td>
                                                        <td class="text-right" style="border:1px solid black">
                                                            @if ($manager->dr_account_id){{ $manager->amount }}@endif
                                                        </td>
                                                        <td class="text-right" style="border:1px solid black">
                                                            @if ($manager->cr_account_id){{ $manager->amount }}@endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="2" class="text-right">Total</td>
                                                        <td class="text-right">{{ $Receipt->amount }}</td>
                                                        <td class="text-right"> {{ $Receipt->amount }}</td>

                                                    </tr>

                                                </tbody>

                                            </table>
                                        </div>
                                        <div style="margin-top:0px;margin-left:50px;">
                                            <p>In Word: {{ $NumberToWordView }} Only.</p>
                                        </div>
                                        <div style="margin-top:0px;margin-left:50px;">
                                            <p>Narration/Comments: {{ $Receipt->note }}</p>
                                        </div>

                                        <div style="float:left;margin-top:05px;margin-left:50px;">
                                            <hr />
                                            <p>Received By</p>
                                        </div>


                                        <div style="float:right;margin-top:05px;margin-right:100px;">
                                            <hr />
                                            <p>Authorized Signature</p>
                                        </div>
                                        <div class="d-print-none">
                                            <div class="float-right" style="margin-top:100px;">
                                                <a href="javascript:window.print()"
                                                    class="btn btn-success waves-effect waves-light mr-1"><i
                                                        class="fa fa-print"></i></a>
                                                <a href="{{ route('accounts-module.receipt-list') }}"
                                                    class="btn btn-primary w-md waves-effect waves-light">Go to List</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                    </div>

                    {{-- End Receipt Invoice --}}
                    @endif
                    {{-- End General Ledger --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    @if($invoice)
                    <button type="submit" class="btn btn-dark" wire:click="InvoicePrint({{$invoice->id}})">
                        Print
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{-- End Invoice Modal --}}

</div>

@push('scripts')
<!-- Sweet Alerts js -->
<script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<!-- Sweet alert init js -->
<script src="{{ URL::asset('assets/js/pages/sweet-alerts.init.js') }}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/tabletools/2.2.4/js/dataTables.tableTools.min.js">
</script>
<script type="text/javascript" src="https://cdn.datatables.net/tabletools/2.2.2/swf/copy_csv_xls_pdf.swf"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.print.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
            $('#datatable-buttons').DataTable({
                "pageLength": 50,
                dom: 'Bfrtip',
                buttons: ['copy','csv','excel','pdf','print']
            });
        });
        $(document).ready(function() {
            $('#FlagsExport').DataTable({
                "pageLength": 50,
                dom: 'Bfrtip',
                buttons: ['copy','csv','excel','pdf','print']
            });
        });
</script>
@endpush
