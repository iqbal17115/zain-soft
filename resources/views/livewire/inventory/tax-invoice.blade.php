@push('css')
    <style>
        /* table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        } */
         /*
        .stylefortable{
            border: 1px solid black;
            border-collapse: collapse;
        }
        .styleforth{
            border: 1px solid black;
            border-collapse: collapse;
        }

        .stylefortd{
            border: 1px solid black;
            border-collapse: collapse;
        } */



        .move {
            position: absolute;
            right: 79px;
        }

    </style>
@endpush
<div>
    <x-slot name="title">TAX INVOICE</x-slot>
    <x-slot name="header">TAX INVOICE</x-slot>
    <table class="stylefortable" style="width: 100%;">
        <tr>
            <th class="styleforth" rowspan="4">
                <img src="@if($invoice_setting){{ asset('storage/photo/'.$invoice_setting->logo) }}@endif" />
                </br>
                @foreach ($profilesettings as $profilesetting)
                    <p>{{ $profilesetting->business_name }}</p>
                    <p>{{ $profilesetting->address }}</p>
                    <p>TRN : {{ $profilesetting->txn_no }}</p>
                    <p>E-Mail:{{ $profilesetting->email }}</p>
                @endforeach
                </br></br>
            </th>
        </tr>
        <tr>
            @foreach ($stockmanagers as $stockmanager)
                <td class="stylefortd">Invoice No
                    <br>{{ $stockmanager->invoice_id }}</br>
                </td>

                <td class="stylefortd">Dated
                    <br>{{ $stockmanager->Invoice->date }}</br>
                </td>
            @endforeach

        </tr>
        <tr>
            <td class="stylefortd">Delievery Note</td>
            <td class="stylefortd">Mode/Terms of Payment</td>
        </tr>
        <tr>
            <td class="stylefortd">Supplier References
                <br>226</br>
            </td>
            <td class="stylefortd">Others References</td>
        </tr>

        <tr>
            <th class="styleforth" rowspan="5">
                </br>
                @foreach ($invoices as $invoice)
                    <p>Name: {{ $invoice->Contact->name }}</p>
                    <p>Business Name: {{ $invoice->Contact->business_name }}</p>
                    <p>Address: {{ $invoice->Contact->address }}</p>
                    <p>Mobile: {{ $invoice->Contact->mobile }}</p>
                @endforeach
                </br>
            </th>
        </tr>
        <tr>
            @foreach ($invoices as $invoice)
                <td class="stylefortd">Buyer’s Order No: {{ $invoice->code }}</td>
                <td class="stylefortd">Dated: {{ $invoice->date }}</td>
            @endforeach
        </tr>
        <tr>
            <td class="stylefortd">Despatch Document No</td>
            <td class="stylefortd">Delivery Note Date</td>
        </tr>
        <tr>
            <td class="stylefortd">Despatched through</td>
            <td class="stylefortd">Destination</td>
        </tr>
        <tr>
            <td class="stylefortd" colspan="2">Terms & condition</td>
        </tr>

        <tr>
            <th class="styleforth" rowspan="4">
                </br>
                <p>Buyer (if other than consignee)</p>
                <p>MYZ Computers LLC</p>
                <p>Mr.Jahedul Alam</p>
                <p>Tel : +971 4 35511825</p>
                <p>Mob : +971 501508220</p>
                {{-- <p>Emirate : Dubai</p>
                <p>Country : UAE</p>
                <p>TRN : 100387580200003</p>
                <p>Place of supply : UAE, Dubai</p> --}}
                </br>
            </th>
        </tr>

        <tr>
            <th class="styleforth" colspan="2"></th>
        </tr>
    </table>
    <table class="stylefortable" style="width:100%">
        <tr>
            <th class="styleforth">Sl.
                <br>No</br>
            </th>
            <th class="styleforth">Description of Goods</th>
            <th class="styleforth">Quantity</th>
            <th class="styleforth">Rate</th>
            <th class="styleforth">Rate(Incl.VAT)</th>
            <th class="styleforth">per</th>
            <th class="styleforth">VAT%</th>
            <th class="styleforth">Amount</th>
            <th class="styleforth">Total</th>
        </tr>

        <tr>
            @php $i=0;  @endphp
            @foreach ($stockmanagers as $stockmanager)
                <td class="stylefortd">{{ ++$i }}</td>
                <td class="stylefortd">{{$stockmanager->Item['name']}}</td>
                <td class="stylefortd">{{$stockmanager->quantity}}</td>
                <td class="stylefortd">{{$stockmanager->sale_price}}</td>
                <td class="stylefortd">{{$stockmanager->sale_price}}</td>
                <td class="stylefortd">{{$stockmanager->sale_price}}</td>
                <td class="stylefortd">{{$stockmanager->vat}}</td>
                <td class="stylefortd">{{$stockmanager->subtotal}}</td>
                <td class="stylefortd">{{$stockmanager->subtotal}}</td>
            @endforeach
        </tr>

        <tr>
            <th  class="styleforth" colspan="2">Amount Chargeable (in words)
                <br>UAE Dirham Ten Thousand Ten Only (AED 10,010.00)
                </br>
            </th>
            <th class="styleforth" colspan="7">
                <p>Taxable value
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    10,010.00</p>
                <p>Value Added Tax</p>
                <p>Invoice Total
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;
                    10,010.00
                </p>
            </th>
        </tr>
        <tr>
            <th class="styleforth" colspan="9">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                E. & O.E
            </th>
        </tr>
        <tr>
            <th class="styleforth" colspan="2">
                <p>Declaration</p>
                <p>We declare that this invoice shows the actual price of the</p>
                <p>goods described and that all particulars are true and correct</p>
            </th>
            <td class="stylefortd" colspan="7" class="text-right">
                <p>for ZAIN TECHNOLOGIES LLC</p>
                <p>Authorised Signatory</p>
            </td>
        </tr>
    </table>
</div>


@push('scripts')

@endpush
