@push('css')

<style>
    .supplier-payment-modal{
        position: relative;
        left: 87px;
    }

    .stylefortable {
        border: 1px solid black;
        border-collapse: collapse;
    }

    .styleforth {
        border: 1px solid black;
        border-collapse: collapse;
    }

    .stylefortd {
        border: 1px solid black;
        border-collapse: collapse;
    }

</style>

@endpush
<div>
    <x-slot name="title">SUPPLIER PAYMENT RECEIPT</x-slot>
    <x-slot name="header">SUPPLIER PAYMENT RECEIPT</x-slot>

    <center>
        <table style="width:100%;">
            <tr>
                <td style="width: 40px;height:50px;vertical-align: super;" style="padding: 0px;margin: 0px;">
                    <img src="@if ($invoice_setting){{ asset('storage/photo/' . $invoice_setting->logo) }}@endif"
                     style="width: 400px;height: 150px;padding: 0px;margin: 0px;vertical-align: super;" alt="ZainSoft">
                </td>
                <td>
                    <h3 style="text-align:center;margin:0px;">
                        @if(isset(Auth::user()->Company->name)) {{Auth::user()->Company->name}}@else
                                  {{ $profile_setting->name }}
                        @endif
                    </h3>
                    <p style="text-align:center;margin:0px;">
                        @if(isset(Auth::user()->Company->address)) {{Auth::user()->Company->address}}@else
                                {{ $profile_setting->address }}
                         @endif
                    </p>
                    <p style="text-align:center;margin:0px;">Country:
                        @if(isset(Auth::user()->Company->country)) {{Auth::user()->Compnay->country}}
                        @else
                        {{ $profile_setting->country }}
                        @endif
                    </p>
                    <p style="text-align:center;margin:0px;">Mobile:
                        @if(isset(Auth::user()->Company->mobile)) {{Auth::user()->Company->mobile}}
                        @else
                        {{ $profile_setting->mobile }}
                        @endif
                    </p>
                    <p style="text-align:center;margin:0px;">Telephone:
                        @if(isset(Auth::user()->Compnay->telephone)) {{Auth::user()->Company->telephone}}
                        @else
                        {{ $profile_setting->telephone }}
                        @endif
                    </p>
                    <p style="text-align:center;margin:0px;">
                        @if(isset(Auth::user()->Compnay->email)) {{Auth::user()->Compnay->email}}
                        @else
                        {{ $profile_setting->email }}
                        @endif
                    </p>

                    <h4 style="text-align:center;">Receipt Voucher</h4>
                </td>
            </tr>
        </table>
    </center>
    <center>
        <table style="width:100%;">
            <tr>
                <td>
                    <p style="margin-top: 20px; font-weight:bold;">No. : @if($transaction->Invoice)
                        {{$transaction->Invoice->code}} @endif </p>
                    <p style="font-weight:bold;">Dated : {{ date("d-m-Y") }}</p>
                </td>
                <td></td>
            </tr>
        </table>
        <?php
           $x = 0;
        ?>
        <table class="payment stylefortable" style="width:100%;">
            <tr>
                <th class="styleforth">Particulars</th>
                <th class="styleforth">Amount</th>
            </tr>
            {{-- <tr>
                <td class="stylefortd font-weight-bold">Account : </td>
                <td class="stylefortd">0</td>
            </tr> --}}
            <tr>
                <td class="stylefortd">@if($transaction->Contact) {{$transaction->Contact->name}} @endif- Cr
                    <p class="ml-5">Agst Ref <strong>@if($transaction->Invoice) {{$transaction->Invoice->code}}
                            {{$transaction->amount}} Dr @endif</strong></p>
                </td>
                <td class="stylefortd">{{$transaction->amount}}</td>
            </tr>

            <tr>
                <td class="stylefortd font-weight-bold">Amounts (In Words): {{$amount}}</td>
                <td class="stylefortd">
                    {{$transaction->amount}}
                </td>
            </tr>

            {{-- <tr>
                <td class="stylefortd ml-5">
                    {{$total}}
                </td>
                <td>AED: {{$transaction->Invoice->amount_to_pay}}</td>
            </tr> --}}
        </table>

        <table>
            <div style="margin-top: 30px;">
                <tr>
                    <td>Receiver’s Signature</td>
                </tr>
                <tr>
                    <td style="float: right;">Authorised Signatory</td>
                </tr>
            </div>
        </table>
    </center>
</div>
    @push('scripts')

    @endpush
