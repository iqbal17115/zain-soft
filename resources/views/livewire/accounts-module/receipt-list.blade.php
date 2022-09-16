@push('css')
    <style>
        .receipt-right {
            position: relative;
            top: 34px;
            right: 40px;
            font-weight: 800;
            font-size: large;
        }

    </style>
@endpush
<div>
    <x-slot name="title">
        Receipt List
    </x-slot>

    <div class="row mb-4">
        <div class="col-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <div class="search-box mr-2 mb-2 d-inline-block">
                                <div class="position-relative">
                                    <h4>Receipt</h4>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-right">
                                <div class="btn-group open">
                                    <button type="button" class="btn btn-primary btn-default dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i
                                            class="fa fa-plus-square"></i> Add Entry </button>
                                    <ul class="dropdown-menu">
                                        @foreach ($EntryType as $entryType)
                                            <li style="font-size: 15px;"><a
                                                    href="{{ route('accounts-module.receipt', ['entry_type' => $entryType->id]) }}">{{ $entryType->name }}</a>
                                            </li><br>
                                        @endforeach
                                    </ul>
                                    {{-- <a href="{{route('accounts-module.receipt')}}"><button type="button" class="btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2">New Receipt </button></a> --}}
                                </div>

                            </div>
                        </div>
                    </div>
                    <div wire:ignore class="table-responsive">
                        <table class="table table-centered table-nowrap" id="dataTable"></table>
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
                    <h5 class="modal-title" id="exampleModalLabel">Invoice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($Receipt)
                        <div>
                            <x-slot name="title">
                                @if (isset($Receipt->EntryType->name)) {{ $Receipt->EntryType->name }} @endif
                            </x-slot>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="invoice-title">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <img src="@if ($invoice_setting){{ asset('storage/photo/' . $invoice_setting->logo) }}@endif" alt=""
                                                    style="height:80px;width:80px;" />
                                            </div>
                                            <div class="col-sm-7" style="position: relative; right: 71px;">
                                                <h1
                                                    style="margin:0px;padding:0px;font-size:30px;font-family:'Times New Roman';">
                                                    @if ($profile_setting){{ $profile_setting->business_name }}@endif</h1>
                                                <p style="margin:0px;padding:0px;font-size:13px;font-weight:bold">
                                                    Address: @if ($profile_setting){{ $profile_setting->address }}<br/>@endif
                                                    Postal Code: @if ($profile_setting) {{ $profile_setting->postal_code }}<br/>@endif
                                                    TRN NO: @if ($profile_setting) {{ $profile_setting->trn_no }}<br/>@endif
                                                    Mobile: @if ($profile_setting) {{ $profile_setting->mobile }}<br/> @endif
                                                    Email: @if ($profile_setting)  {{ $profile_setting->email }}<br/> @endif
                                                    Website: @if ($profile_setting)  {{ $profile_setting->website }} @endif
                                                </p>
                                            </div>
                                            <div class="col-sm-2 receipt-right">
                                                <h4 class="font-size-18" align="center">
                                                    @if (isset($Receipt->EntryType->name))
                                                        {{ $Receipt->EntryType->name }}
                                                    @endif
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
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

                                    <div class="table-responsive">
                                        <table class="table table-nowrap">
                                            <thead>
                                                <tr>
                                                    <th style="width: 70px; border:1px solid black">No.</th>
                                                    <th style="border:1px solid black">Particular</th>
                                                    <th style="border:1px solid black">Debit</th>
                                                    <th class="text-right" style="border:1px solid black">
                                                        Credit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i = 0;
                                                @endphp
                                                @foreach ($Receipt->AccountManager as $manager)
                                                    <tr>
                                                        <td style="border:1px solid black">{{ ++$i }}</td>
                                                        <td style="border:1px solid black">
                                                            @if ($manager->dr_account_id){{ $manager->ChartOfAccountDr->name }}@else{{ $manager->ChartOfAccountCr->name }}@endif</td>
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
                                    <div style="margin-top:0px;margin-left:0px;">
                                        <p>In Word: @if (isset($numberToWord)){{ $numberToWord }} Only.@endif</p>
                                    </div>
                                    <div style="margin-top:0px;margin-left:0px;">
                                        <p>Narration/Comments: {{ $Receipt->note }}</p>
                                    </div>

                                    {{-- <div style="float:left;margin-top:4px;margin-left:0px;">
                                        <hr />
                                        <p>Received By</p>
                                    </div>


                                    <div style="float:right;margin-top:05px;margin-right:0px;">
                                        <hr />
                                        <p>Authorized Signature</p>
                                    </div> --}}
                                    {{-- <div class="d-print-none">
                                                <div class="float-right" style="margin-top:100px;">
                                                    <a href="javascript:window.print()"
                                                        class="btn btn-success waves-effect waves-light mr-1"><i
                                                            class="fa fa-print"></i></a>
                                                    <a href="{{ route('accounts-module.receipt-list') }}"
                                                        class="btn btn-primary w-md waves-effect waves-light">Go to
                                                        List</a>
                                                </div>
                                          </div> --}}
                                </div>
                            </div>
                            <!-- end row -->
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    @if ($Receipt)
                        <button type="submit" class="btn btn-dark" wire:click="InvoicePrint({{ $Receipt->id }})">
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
    <script>
        function callInvoice(id) {
            @this.call('InvoiceModal', id);
        }

        function callEdit(id) {
            @this.call('orderEdit', id);
        }

        function callDelete(id) {
            @this.call('receiptDelete', id);
        }

        $(document).ready(function() {

            var datatable = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('data.receipt_list_table') }}",

                },
                columns: [{
                        title: 'ID',
                        data: 'id'
                    },
                    {
                        title: 'Type',
                        data: 'entry_type_id',
                        name: 'entry_type_id'
                    },
                    {
                        title: 'Code',
                        data: 'code',
                        name: 'code'
                    },
                    {
                        title: 'Date',
                        data: 'date',
                        name: 'date'
                    },
                    {
                        title: 'Total',
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        title: 'Added By',
                        data: 'user_id',
                        name: 'user_id'
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
