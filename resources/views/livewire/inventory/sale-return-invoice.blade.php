@push('css')

@endpush
<div>
    <x-slot name="title">SALES RETURN INVOICE</x-slot>
    <div id="invoice_page">
        <div class="header">
           <div style="overflow:hidden;">
                <div style="float:left;margin-top:0px;width: 74%;">
                 <div class="row">
                    <div style="float:left;width: 25%;">
                        <span><img height=60px; width=130px; src="@if($invoice_setting){{ asset('storage/photo/'.$invoice_setting->logo) }}@endif" alt=""></span>
                    </div>
                    <div style="float:left; width: 75%;" class="sale-purchase-position">
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
                 <p style="font-size:13px;margin:0px;padding:0px; lightskyblue;font-weight:bold;">Bill To</p>
                 <h6><strong>Customer Name @php echo str_repeat('&nbsp;', 5); @endphp: </strong><strong>@if ($invoice) {{ $invoice->Contact->name }}@endif</strong></h6>
                 <h6><strong>Contact Person @php echo str_repeat('&nbsp;',6); @endphp:</strong><strong>@if ($invoice) {{ $invoice->Contact->business_name }}@endif</strong> </h6>
                 <h6><strong>Telephone @php echo str_repeat('&nbsp;', 14); @endphp:</strong><strong>@if ($invoice) {{ $invoice->Contact->telephone }}@endif</strong></h6>
                 <h6><strong>Mobile @php echo str_repeat('&nbsp;', 20); @endphp:</strong><strong>@if ($invoice) {{ $invoice->Contact->mobile }} @endif</strong></h6>
                 <h6><strong>TRN @php echo str_repeat('&nbsp;', 24); @endphp:</strong> <strong>@if ($invoice) {{ $invoice->Contact->trn_no }} @endif</strong></h6>
                 <h6><strong>Email @php echo str_repeat('&nbsp;', 22); @endphp:</strong> <strong>@if ($invoice) {{ $invoice->Contact->email }} @endif</strong></h6>
                 <h6><strong>Address @php echo str_repeat('&nbsp;', 18); @endphp:</strong> <strong>@if ($invoice) {{ $invoice->Contact->address }} @endif</strong> </h6>
                </div>
              <div style="float:right;width: 25%; position: relative;">
                 <h3 style="color:red;font-weight:bold;margin-left:0px;margin-top:0px;font-size:20px;">{{$invoice->payment_status}}</h3>
                 <h6 style="margin:0px;font-weight:bold;font-size:20px;color:lightskyblue">Sales Return Invoice</h6>
                 <h6><strong>Invoice No @php echo str_repeat('&nbsp;',0); @endphp:</strong><strong>{{$invoice->code}}</strong></h6>
                 <h6><strong>Date @php echo str_repeat('&nbsp;',10); @endphp:</strong> <strong>{{date("Y/m/d")}}</strong></h6>
                 <h6><strong>Chalan No @php echo str_repeat('&nbsp;',1); @endphp:</strong><strong>{{$invoice->chalan_no}}</strong></h6>
                 <h6><strong>Memo No @php echo str_repeat('&nbsp;',2); @endphp:</strong> <strong>{{$invoice->memo_no}}</strong></h6>
                 <h6><strong>Sold By @php echo str_repeat('&nbsp;',6); @endphp:</strong> <strong>{{Auth::user()->name}}</strong></h6>
                 @if($invoice_setting->do_no)
                 <h6><strong>DO No: @php echo str_repeat('&nbsp;',6); @endphp:</strong> <strong>{{ $invoice->do_no }}</strong></h6>
                 @endif
                 @if($invoice_setting->lpo_no)
                 <h6><strong>LPO No @php echo str_repeat('&nbsp;',6); @endphp:</strong> <strong>{{ $invoice->lpo_no  }}</strong></h6>
                 @endif
              </div>
           </div>
           <br />
        </div>
        <div class="inv_body">
            @php
                $count = 0;
            @endphp
            <table>
                <thead>
                    <tr class="inv_item_row">
                        <th align="center" style="border:1px solid black;width:40px;">Sl No.
                        </th>
                        <th align="center" style="border:1px solid black">Description of Goods
                        </th>
                        <th align="center" style="border:1px solid black; text-align:center;">
                            Quantity</th>
                        <th align="center" style="border:1px solid black; text-align:center;">
                            Unit Price</th>
                            @if ($invoice_setting->vat)
                            <th align="center" style="border:1px solid black;text-align:center">VAT
                                %</th>
                                @else
                                @php
                                    $count++;
                                @endphp
                            @endif
                            @if ($invoice_setting->rate)
                            <th align="center" style="border:1px solid black;text-align:center">Rate
                                (Incl.VAT) </th>
                                @else
                                @php
                                    $count++;
                                @endphp
                            @endif
                         @if ($invoice_setting->discount)
                         <th align="center" style="border:1px solid black;text-align:center">
                            Discount</th>
                            @else
                            @php
                                $count++;
                            @endphp
                         @endif
                         @if ($invoice_setting->amount_aed)
                         <th align="center" style="border:1px solid black; text-align:right;">
                            Amount (@if ($currencySymbol){{ $currencySymbol->symbol }}@endif) </th>
                            @else
                            @php
                                $count++;
                            @endphp
                         @endif
                         @if ($invoice_setting->texable_value)
                         <th align="center" style="border:1px solid black; text-align:right;">
                            Texable Value (@if ($currencySymbol){{ $currencySymbol->symbol }}@endif) </th>
                            @else
                            @php
                                $count++;
                            @endphp
                         @endif
                         @if ($invoice_setting->vat_aed)
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
                            <td align="left" style="border:1px groove;">
                                {{ $detail->Item->name }}</td>
                            <td align="center" style="border:1px groove">
                                {{ $detail->quantity }} @if (isset($detail->Item->Unit)) {{ $detail->Item->Unit->name }} @endif</td>
                            <td align="center" style="border:1px groove">
                                {{ $detail->sale_price }}</td>
                                @if ($invoice_setting->vat)
                                <td align="center" style="border:1px groove">
                                    {{ $detail->Item->Vat->name }}</td>
                                @endif
                            @if ($invoice_setting->rate)
                            <td align="center" style="border:1px groove">
                                {{ $detail->sale_price + ($detail->sale_price * $detail->Item->Vat->rate_percent) / 100 }}
                            </td>
                            @endif
                            @if ($invoice_setting->discount)
                            <td align="center" style="border:1px groove"></td>
                            @endif
                            @if ($invoice_setting->amount_aed)
                            <td align="right" style="text-align:right;border:1px groove">
                                {{ $detail->Item->sale_price * $detail->quantity }}</td>
                            @endif
                            @if ($invoice_setting->texable_value)
                            <td align="right" style="text-align:right;border:1px groove">
                                {{ $detail->sale_price * $detail->quantity }}</td>
                            @endif
                            @if ($invoice_setting->vat_aed)
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
                        <td colspan="{{ 7 - $count}}" align="right"
                            style="font-weight:bold;border:1px groove">Sub Total :</td>
                        <td align="right" style="font-weight:bold;border:1px groove">
                            {{ $invoice->subtotal }}</td>
                        <td align="right" style="font-weight:bold;border:1px groove">
                            {{ $invoice->subtotal }}</td>
                        <td align="right" style="font-weight:bold;border:1px groove">
                            {{ $invoice->total_vat }}</td>
                        <td align="right" style="font-weight:bold;border:1px groove">
                            {{ $include_vat_total }}</td>
                    </tr>
                    <tr class="inv_item_row">
                        <td colspan="{{ 10 - $count}}" align="right">(-) Discount:</td>
                        <td colspan="2" align="right">{{ $invoice->discount_value }}</td>
                    </tr>
                    <tr class="inv_item_row">
                        <td colspan="{{ 10 - $count}}" align="right" style="font-weight:bold;">Net Payable :
                        </td>
                        <td colspan="{{ 2 - $count}}" align="right" style="font-weight:bold;">
                            {{ $invoice->amount_to_pay }}</td>
                    </tr>
                    <tr class="inv_item_row">
                        <td colspan="{{ 10 - $count}}" align="right" style="font-weight:bold;">Total Paid :
                        </td>
                        <td colspan="{{ 2 - $count}}" align="right" style="font-weight:bold;">
                            {{ $invoice->paid_amount }}</td>
                    </tr>
                    <tr class="inv_item_row">
                        <td colspan="{{ 10 - $count}}" align="right" style="font-weight:bold;">Due Amount :
                        </td>
                        <td colspan="{{ 2 - $count}}" align="right" style="font-weight:bold;">
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
        @if ($invoice_setting->transaction)
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
                     <td align="center" style="border:1px solid black">{{$invoicePaid->code}}</td>
                     <td align="center" style="border:1px solid black">{{$invoicePaid->type}}</td>
                     <td align="center" style="border:1px solid black">{{$invoicePaid->date}}</td>
                     <td align="center" style="border:1px solid black">{{$invoicePaid->note}}</td>
                     <td align="center" style="border:1px solid black">@if($currencySymbol) {{$currencySymbol->symbol}} @endif{{$invoicePaid->amount}}</td>
                 </tr>
                 @endforeach
               </tbody>
            </table>
         </div>
        @endif

        <div class="col-md-12 heading">
            <div class="col-md-8" style="position:absolute">
                <table>
                    <tr class="inv_item_row">
                        <td>Amount Chargeable (In Words):<br> {{$numberToWordTotal}}</td>
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
                <p><strong><span style="color: #169179;">Thanks for your visit, and I hope to see you soon!</span></strong></p>
           </p>
           <p>
                @if($invoice_setting)
                {!! $invoice_setting->footer_title !!}
                @endif
            </p>
           <p>
                For any query, Please call @if($profile_setting) {{$profile_setting->mobile}} @endif <br>
                Powered by: <b>Mathemacia</b>
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
    <div class="col-md-12" style="position: relative; top: 562px; left: 1209px;">
        <a href="{{ route('inventory.sale-return-list') }}">
            <button type="button" style="background-color: rgb(5 100 5); color:honeydew;"
                class="btn btn-success">Sale Return List</button>
        </a>
    </div>
</div>
@push('scripts')

@endpush
