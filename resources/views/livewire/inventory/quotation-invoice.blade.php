@push('css')
@endpush
<div>
    <x-slot name="title">QUOTATION INVOICE</x-slot>
    <div id="invoice_page">
        <div class="header">
           <div style="overflow:hidden;">
                <div style="float:left;margin-top:0px;width: 74%;">
                 <div class="row">
                    <div style="float:left;width: 25%;">
                       <span><img height=60px; width=130px; src="@if($invoice_setting){{ asset('storage/photo/'.$invoice_setting->logo) }}@endif" alt=""></span>
                    </div>
                    <div style="float:left; width: 75%;" class="purchase-position">
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
                 <h6><strong>Supplier Name @php echo str_repeat('&nbsp;', 7); @endphp: </strong><strong>@if ($invoice) {{ $invoice->Contact->name }}@endif</strong></h6>
                    <h6><strong>Contact Person @php echo str_repeat('&nbsp;',6); @endphp:</strong><strong>@if ($invoice) {{ $invoice->Contact->business_name }}@endif</strong> </h6>
                    <h6><strong>Telephone @php echo str_repeat('&nbsp;', 14); @endphp:</strong><strong>@if ($invoice) {{ $invoice->Contact->telephone }}@endif</strong></h6>
                    <h6><strong>Mobile @php echo str_repeat('&nbsp;', 20); @endphp:</strong><strong>@if ($invoice) {{ $invoice->Contact->mobile }} @endif</strong></h6>
                    <h6><strong>TRN @php echo str_repeat('&nbsp;', 24); @endphp:</strong> <strong>@if ($invoice) {{ $invoice->Contact->trn_no }} @endif</strong></h6>
                    <h6><strong>Email @php echo str_repeat('&nbsp;', 22); @endphp:</strong> <strong>@if ($invoice) {{ $invoice->Contact->email }} @endif</strong></h6>
                    <h6><strong>Address @php echo str_repeat('&nbsp;', 18); @endphp:</strong> <strong>@if ($invoice) {{ $invoice->Contact->address }} @endif</strong> </h6>
                    <h6><strong>Place of Supplier @php echo str_repeat('&nbsp;', 3); @endphp:</strong> <strong>{{ $invoice->Contact->division }}{{ $invoice->Contact->country }}</strong></h6>
                 <!--h6>Delivery By &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp; Nazmul</h6-->
                </div>
              <div style="float:right;width: 25%; position: relative; bottom: 20px;">
                 {{-- <h3 style="color:red;font-weight:bold;margin-left:0px;margin-top:0px;font-size:20px;">{{$invoice->payment_status}}</h3> --}}
                 <h6 style="margin-top:50px;font-weight:bold;font-size:20px;color:lightskyblue">Quotation</h6>
                 <h6><strong>Quotation No @php echo str_repeat('&nbsp;', 1); @endphp:</strong><strong> {{ $invoice->code }}</strong></h6>
                 <h6><strong>Date @php echo str_repeat('&nbsp;', 11); @endphp:</strong> <strong>{{ date('Y/m/d') }}</strong></h6>
              </div>
           </div>
           <br />
        </div>
        <p>@if($invoice){!! $invoice->header_content !!}@endif</p>
        <div class="inv_body">
            <table style="width:100%;">
                <?php
                        $count = 0;
                    ?>
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
                            Texable Value (@if ($currencySymbol){{ $currencySymbol->symbol }}@endif)
                        </th>
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
                            Total Incl.VAT(@if ($currencySymbol){{ $currencySymbol->symbol }}@endif)
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $i = 0;
                    $include_vat_total = 0;
                    $total_vat = 0;
                    $texable_value = 0;
                    $amount = 0;
                    @endphp
                    @foreach ($invoice->StockItemInvoice as $detail)
                    <tr class="inv_item_row" id="64663">
                        <td align="center" style="border:1px groove;">{{ ++$i }}
                        </td>
                        <td align="left" style="border:1px groove;">
                            {{ $detail->Item->name }}</td>
                        <td align="center" style="border:1px groove">
                            {{ $detail->quantity }} @if (isset($detail->Item->Unit)) {{
                            $detail->Item->Unit->name }} @endif</td>
                        <td align="center" style="border:1px groove">
                            {{ $detail->sale_price }}</td>
                        @if ($invoice_setting->vat)
                        <td align="center" style="border:1px groove">
                            {{ $detail->Item->Vat->name }}</td>
                        @endif
                        @if ($invoice_setting->rate)
                        <td align="center" style="border:1px groove">
                            {{ $detail->sale_price + ($detail->sale_price *
                            $detail->Item->Vat->rate_percent) / 100 }}
                        </td>
                        @endif
                        @if ($invoice_setting->discount)
                        <td align="center" style="border:1px groove"></td>
                        @endif
                        @if ($invoice_setting->amount_aed)
                        <td align="right" style="text-align:right;border:1px groove">
                            {{ $detail->Item->sale_price * $detail->quantity }}
                            @php
                            $amount += $detail->Item->sale_price * $detail->quantity;
                            @endphp
                        </td>
                        @endif

                        @if ($invoice_setting->texable_value)
                        <td align="right" style="text-align:right;border:1px groove">
                            {{ $detail->sale_price * $detail->quantity }}
                            @php
                            $texable_value += $detail->sale_price * $detail->quantity;
                            @endphp
                        </td>
                        @endif

                        @if ($invoice_setting->vat_aed)
                        <td align="right" style="text-align:right;border:1px groove">
                            {{ (($detail->sale_price * $detail->Item->Vat->rate_percent) / 100) *
                            $detail->quantity }}
                            @php
                            $total_vat += (($detail->sale_price * $detail->Item->Vat->rate_percent)
                            / 100) * $detail->quantity;
                            @endphp
                        </td>
                        @endif

                        <td align="right" style="text-align:right;border:1px groove">
                            {{ ($detail->sale_price + ($detail->sale_price *
                            $detail->Item->Vat->rate_percent) / 100) * $detail->quantity }}
                            @php
                            $include_vat_total += ($detail->sale_price + ($detail->sale_price *
                            $detail->Item->Vat->rate_percent) / 100) * $detail->quantity;
                            @endphp
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="{{ 7 - $count}}" align="right"
                            style="font-weight:bold;border:1px groove">Sub Total :</td>
                        <td align="right" style="font-weight:bold;border:1px groove">
                            {{ $amount }}</td>
                        <td align="right" style="font-weight:bold;border:1px groove">
                            {{ $texable_value }}</td>
                        <td align="right" style="font-weight:bold;border:1px groove">
                            {{ $total_vat }}</td>
                        <td align="right" style="font-weight:bold;border:1px groove">
                            {{ $include_vat_total }}</td>
                    </tr>
                    <tr class="inv_item_row">
                        <td colspan="{{ 10 - $count }}" align="right">(-) Discount:</td>
                        <td colspan="2" align="right">{{ $invoice->discount_value }}</td>
                    </tr>
                    <tr class="inv_item_row">
                        <td colspan="{{ 10 - $count}}" align="right" style="font-weight:bold;">Grand
                            Total :
                        </td>
                        <td colspan="{{ 2 - $count}}" align="right" style="font-weight:bold;">
                            {{ $invoice->amount_to_pay }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p>@if($invoice){!! $invoice->footer_content !!}@endif</p>
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
                Powered by: <a href="https://shomikaron.com/" target="_blank">Shomikaron</a>
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
@push('scripts')

@endpush
