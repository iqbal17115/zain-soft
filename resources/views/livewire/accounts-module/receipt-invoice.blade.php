@push('css')

@endpush
<div>
    <x-slot name="title">RECEIPT INVOICE</x-slot>
    <div id="invoice_page">
        <div class="header">
            <div style="overflow:hidden;">
                <div style="float:left;margin-top:0px;width: 100%;">
                    <div class="row">
                        <div style="float:left;width: 30%;">
                            <img src="@if ($invoice_setting){{ asset('storage/photo/' . $invoice_setting->logo) }}@endif" alt="" style="height:80px;width:80px;" /><br />
                            <div style="position: relative; top: 55px; height: 132px;">
                                Name @php echo str_repeat('&nbsp;', 3); @endphp: @if (isset($Receipt->Contact->name))
                                    {{ $Receipt->Contact->name }}
                                @endif <br>
                                Tag @php echo str_repeat('&nbsp;', 6); @endphp: @if (isset($Receipt->Tag->name))
                                    {{ $Receipt->Tag->name }}
                                @endif <br>
                                Date @php echo str_repeat('&nbsp;', 4); @endphp: {{ $Receipt->date }}<br>
                                Code @php echo str_repeat('&nbsp;', 4); @endphp: {{ $Receipt->code }}<br>
                                Branch @php echo str_repeat('&nbsp;', 1); @endphp: @if (isset($Receipt->Branch->name))
                                    {{ $Receipt->Branch->name }}
                                @endif <br>
                            </div>

                        </div>

                        <div style="float:left; width: 50%; position: relative; right: 103px">
                            <h1 style="margin:0px;padding:0px;font-size:30px;font-family:'Times New Roman';">
                                @if(isset(Auth::user()->Company->name)) {{Auth::user()->Company->name}}@else
                                {{ $profile_setting->address }}
                                @endif</h1>
                            <p style="margin:0px;padding:0px;font-size:13px;font-weight:bold">
                                Address: @if (isset(Auth::user()->Company->address)) {{Auth::user()->Company->address}}
                                @else{{ $profile_setting->address }}@endif <br/>
                                Postal Code: @if (isset(Auth::user()->Compnay->postal_code)) {{Auth::user()->Company->postal_code}}
                                @else{{ $profile_setting->postal_code }}@endif <br/>
                                TRN NO: @if (isset(Auth::user()->Company->trn_no)) {{Auth::user()->Company->trn_no}}
                                @else{{ $profile_setting->trn_no }}@endif <br/>
                                Mobile NO: @if (isset(Auth::user()->Company->mobile)) {{Auth::user()->Company->mobile}}
                                @else{{ $profile_setting->mobile }}@endif <br/>
                                Email: @if (isset(Auth::user()->Company->email)) {{Auth::user()->Company->email}}
                                @else{{ $profile_setting->email }} @endif <br/>
                                Website: @if (isset(Auth::user()->Company->website)) {{Auth::user()->Company->website}}
                                @else{{ $profile_setting->website }} @endif
                            </p>
                        </div>

                        <div style="float:right;width: 20%;">
                            <h4 class="font-size-18 receipt" align="center">
                                @if (isset($Receipt->EntryType->name))
                                    {{ $Receipt->EntryType->name }}
                                @endif
                            </h4>
                        </div>

                    </div>
                </div>
            </div><br />
        </div>
        <div class="inv_body">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr class="inv_item_row">
                            <th align="center" style="border:1px solid black;width:60px;">No.</th>
                            <th align="center" style="border:1px solid black">Particular</th>
                            <th align="center" style="border:1px solid black;text-align:center">Debit</th>
                            <th align="center" style="border:1px solid black;text-align:center">Credit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 0;
                        @endphp
                    <tbody>
                        @foreach ($Receipt->AccountManager as $manager)
                            <tr>
                                <td style="border:1px solid black">{{ ++$i }}</td>
                                <td style="border:1px solid black">@if ($manager->dr_account_id){{ $manager->ChartOfAccountDr->name }}@else{{ $manager->ChartOfAccountCr->name }}@endif</td>
                                <td class="text-right" style="border:1px solid black">
                                    @if ($manager->dr_account_id){{ $manager->amount }}@endif</td>
                                <td class="text-right" style="border:1px solid black">
                                    @if ($manager->cr_account_id){{ $manager->amount }}@endif</td>
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
            <div style="margin-top:0px;">
                <p>In Word: {{ $numberToWord }} Only.</p>
            </div>
            <div style="margin-top:0px;">
                <p>Narration/Comments: {{ $Receipt->note }}</p>
            </div>

            <div style="float:left;margin-top:05px;">
                <hr />
                <p>Received By</p>
            </div>


            <div style="float:right;margin-top:05px;">
                <hr />
                <p>Authorized Signature</p>
            </div>
        </div>
    </div>
    @push('scripts')

    @endpush
