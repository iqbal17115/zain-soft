@push('css')
    <style>

        /* style added in invoice master page */


        /* h6 {
            margin: 0px;
            padding: 0px;
            font-size: 16px;
            font-weight: normal;
        }

        body {
            font-family: tahoma;
            font-size: 16px;
            margin: 0px;
            padding: 0px;
        }

        #invoice_page {
            width: 100%;
        }

        table {
            font-size: 16px;
            border-collapse: collapse;
            width: 100%;
        }

        .inv_item_row {
            /*border-bottom:1px solid gray;*/
        }

        .inv_item_row td,
        .inv_item_row th {
            padding: 0.5px 0px;
        } */

    </style>
@endpush
<div>
    <x-slot name="title">VOUCHER</x-slot>
    <x-slot name="header">VOUCHER</x-slot>
    <div id="invoice_page" style="height:970px;">
        <div class="header">
            <div style="width:100%;overflow:hidden;">

                <div style="float:left;margin-top:0px;width: 74%;">

                    <div class="row">
                        <div style="float:left;width: 25%;">
                            <span><img height=80px; width=130px;
                                    src="@if($invoice_setting){{ asset('storage/photo/'.$invoice_setting->logo) }}@endif"
                                    alt=""></span>
                        </div>
                        <div style="float:left; width: 75%;">
                            <h1 style="margin:0px;padding:0px;font-size:30px;font-family:'Times New Roman';">ZainSoft
                            </h1>
                            <p style="margin:0px;padding:0px;font-size:13px;font-weight:bold">AAM Building, Shop No:06,
                                Al souq Al Kabeer, Al Refa St, Behind Farooq Mosque, Bur Dubai,UAE..<br /></p>
                            <p style="font-size:13px;margin:0px;padding:0px;font-weight:bold">01844509792<br /><a
                                    href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                    data-cfemail="ea9982858783818b988584aa8d878b8386c4898587">[email&#160;protected]</a><br />Zainsoft.com<br />
                            </p>
                        </div>
                    </div>

                    <h6 style="margin:5px 0px;">Name: <strong>Walking Customer</strong></h6>
                    <h6 style="margin:5px 0px">Address: <strong></strong></h6>
                    <h6 style="margin:5px 0px">Phone: <strong></strong></h6>
                </div><br />



                <div style="float:right;width: 25%;">
                    <h6 style="margin:0px;font-weight:bold;font-size:20px;color:lightskyblue"> Chalan No:</h6>
                    <h6 style="margin:5px 0px"><strong>Date:</strong> 18-Oct-2021</h6>
                    <h6 style="margin:5px 0px"><strong>Sold By :</strong> Masud Parvez</h6>
                </div>
            </div><br />

        </div>
        <div class="inv_body">
            <table border="0">
                <thead>
                    <tr class="inv_item_row">
                        <th align="left" style="border:1px solid gray">SL</th>
                        <th align="left" style="border:1px solid gray">Description of Goods</th>
                        <th style="border:1px solid gray;text-align:center">Unit</th>
                        <th style="border:1px solid gray;text-align:center">Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="inv_item_row">
                        <td align="left" style="border:1px solid gray">1</td>
                        <td style="border:1px solid gray">Zara 001</td>
                        <td align="center" style="border:1px solid gray">Pairs</td>
                        <td align="center" style="border:1px solid gray">1</td>
                    </tr>
                </tbody>
            </table>
            <div class="col-md-12" style="height:50px;">
                <div style="float:right; margin-top:70px;">
                    <hr />
                    <p>Authorize Signature</p>
                </div>
            </div>
            <p style="margin-top:20px;">
                Powered by: <a href="https://www.facebook.com/shomikaron/" target="_blank">ZainSoft.</a>
            </p>
        </div>
    </div>
</div>
@push('scripts')

@endpush
