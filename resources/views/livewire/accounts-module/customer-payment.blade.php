@push('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
<style>
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

    .customer-payment-modal {
        position: relative;
        left: 87px;
    }
</style>
@endpush
<div>
    <x-slot name="title">CUSTOMER PAYMENT</x-slot>
    <x-slot name="header">CUSTOMER PAYMENT</x-slot>
    <div class="row mb-4">
        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <div class="search-box mr-2 mb-2 d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title mb-3">Receive</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form wire:submit.prevent="CustomerPayementSave">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-search-input" class="col-16 col-form-label">Vouchar
                                                No</label>
                                            <div class="col-16">
                                                <input wire:model.lazy='code' class="form-control">
                                            </div>
                                            @error('code') <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-search-input" class="col-16 col-form-label">Transaction
                                                Date</label>
                                            <div class="col-16">
                                                <input type="date" wire:model.lazy='date' class="form-control">
                                            </div>
                                            @error('date') <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div wire:ignore class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-search-input" class="col-16 col-form-label">Search
                                                Contact</label>
                                            <select class="form-control form-select select2"
                                                wire:model.lazy="contact_id" id="contact_id">
                                                <option value="">Select Contact</option>
                                                @foreach ($contacts as $contact)
                                                <option value="{{ $contact->id }}">{{ $contact->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('contact_id') <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-search-input" class="col-16 col-form-label">Payment
                                                Method
                                                &nbsp
                                                &nbsp &nbsp
                                                If Check:
                                                <input type="checkbox" id="requiringCheck" wire:model="ifCheque">
                                            </label>
                                            <div class="col-16">
                                                <select class="form-control" wire:model.lazy="chart_of_account_id">
                                                    <option>Slect Payment Method</option>
                                                    @foreach ($chartofaccounts as $chartofaccount)
                                                    <option value="{{$chartofaccount->id}}">
                                                        {{ $chartofaccount->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @error('chart_of_account_id') <span class="error text-danger">{{
                                                    $message }}</span> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">

                                    @if ($ifCheque)
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-search-input" class="col-16 col-form-label">Transaction
                                                Cheque Date</label>
                                            <div class="col-16">
                                                <input type="date" wire:model.lazy="due_date" class="form-control">
                                            </div>
                                            @error('due_date') <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    @endif

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-search-input" class="col-16 col-form-label">Invoice
                                                No</label>
                                            <div class="col-16">
                                                {{-- <input type="" name="" class="form-control"
                                                    wire:model.debounce.150ms='invoice_code' placeholder="Invoice No">
                                                --}}
                                                <select multiple class="form-control"
                                                    wire:model.lazy="selected_invoice_code">
                                                    @foreach ($invoice_no as $invoice_code)
                                                    <option value="{{$invoice_code->code}}">{{$invoice_code->code}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('invoice_code') <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="example-search-input" class="col-16 col-form-label">Selected
                                            Invoice</label>
                                        <textarea>
                                            {{$InvoiceCodes}}
                                        </textarea>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-search-input" class="col-16 col-form-label">Invoice
                                                Current Due</label>
                                            <div class="col-16">
                                                <input type="" name="" class="form-control"
                                                    wire:model.debounce.150ms='invoice_due' placeholder="Invoice No"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-search-input" class="col-16 col-form-label">
                                                Paid Amount</label>
                                            <div class="col-16">
                                                <input type="text" wire:model.lazy='amount' class="form-control"
                                                    placeholder="Enter amount">
                                            </div>
                                            @error('invoice_id') <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    @if (isset($invoice_setting->note))
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="example-search-input" class="col-16 col-form-label">Note</label>
                                            <div class="col-16">
                                                <textarea style="height: 40px;" cols="0" name="note" rows="1"
                                                    class="form-control" wire:model.lazy='note'></textarea>
                                            </div>
                                            @error('note') <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                <center class="mt-3">
                                    <button type="submit" class="btn btn-danger">Cancelled</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </center>
                            </div>
                        </div>
                    </form>

                    <div wire:ignore class="table-responsive">
                        <table class="display table table-striped table-bordered" id="CustomerPaymentTable"
                            style="width:100%"></table>
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
                    @if($transaction)
                    <div>
                        <x-slot name="title">CUSTOMER PAYMENT RECEIPT</x-slot>
                        <x-slot name="header">CUSTOMER PAYMENT RECEIPT</x-slot>

                        <center>
                            <table style="width:100%;">
                                <tr>
                                    <td style="width: 40px;height:50px;vertical-align: super;"
                                        class="customer-payment-modal" style="padding: 0px;margin: 0px;">
                                        <img src="@if ($invoice_setting){{ asset('storage/photo/' . $invoice_setting->logo) }}@endif"
                                            style="width: 40px;height: 40px;padding: 0px;margin: 0px;vertical-align: super;"
                                            alt="ZainSoft">
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
                            <table style="width:80%;">
                                <tr>
                                    <td>
                                        <p style="margin-top: 20px; font-weight:bold;">No. : @if($transaction->Invoice)
                                            {{$transaction->Invoice->code}} @endif </p>
                                        <p style="font-weight:bold;">Dated : {{ date("d-m-Y") }}</p>
                                    </td>
                                    <td></td>
                                </tr>
                            </table>

                            <table class="payment stylefortable" style="width:80%;">
                                <tr>
                                    <th class="styleforth">Particulars</th>
                                    <th class="styleforth">Amount</th>
                                </tr>
                                {{-- <tr>
                                    <td class="stylefortd font-weight-bold">Account : </td>
                                    <td class="stylefortd">0</td>
                                </tr> --}}
                                <tr>
                                    <td class="stylefortd">@if($transaction->Contact) {{$transaction->Contact->name}}
                                        @endif- Cr
                                        {{-- <p class="ml-5">Agst Ref <strong>@if(isset($transaction->Invoice))
                                                {{$transaction->Invoice->code}}
                                                {{$transaction->amount}} Dr @endif</strong></p> --}}

                                                 <p class="ml-5">Agst Ref <strong>@if(isset($transaction->InvoiceId))
                                                    @if($InvoiceCodesByTransaction) [ @endif
                                                @foreach ($InvoiceCodesByTransaction as $invoice_code_tran)
                                                   {{$invoice_code_tran->code}}
                                                @endforeach
                                                @if($InvoiceCodesByTransaction) ] @endif
                                                {{$transaction->amount}} Dr @endif</strong></p>


                                    </td>
                                    <td class="stylefortd">
                                        @if(isset($transaction->amount)){{$transaction->amount}}@endif
                                    </td>
                                </tr>

                                <tr>
                                    <td class="stylefortd font-weight-bold">Amounts (In Words): {{$total}}</td>
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
                            {{--
                            <table style="width:80%; margin-top:40px;">
                                <tr>
                                    <td>Receiver’s Signature</td>
                                    <td style="float: right;">Authorised Signatory</td>
                                </tr>
                            </table> --}}
                        </center>
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    @if($transaction)
                    <button type="submit" class="btn btn-dark" wire:click="InvoicePrint({{$transaction->id}})">
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
    // jQuery('option').mousedown(function(e) {
//     e.preventDefault();
//     console.log(this);
//     jQuery(this).toggleClass('selected');

//     jQuery(this).prop('selected', !jQuery(this).prop('selected'));
//     return false;
// });

    function callInvoice(id) {
            @this.call('InvoiceModal', id);
        }
        function callEdit(id) {
            @this.call('CustomerPaymentEdit', id);
        }
        function callDelete(id) {
            @this.call('CustomerPaymentDelete', id);
        }

        $(document).ready(function() {

            var datatable = $('#CustomerPaymentTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('data.customer-payment-table') }}",
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
                        title: 'Vouchar No',
                        data: 'code',
                        name: 'code'
                    },
                    {
                        title: 'Payment Method',
                        data: 'chart_of_account_id',
                        name: 'chart_of_account_id'
                    },

                    {
                        title: 'Invoice',
                        data: 'invoice_id',
                        name: 'invoice_id'
                    },

                    {
                        title: 'Amount',
                        data: 'amount',
                        name: 'amount'
                    },

                    {
                        title: 'Contact',
                        data: 'contact_id',
                        name: 'contact_id'
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
<script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
<script>
    // Start Select2
        // $(document).ready(function() {
        //     $('.select2').select2({
        //         placeholder: '{{ __('Select Customer') }}',
        //         allowClear: true
        //     });
        //     $('.select2').on('change', function(e) {
        //         let elementName = $(this).attr('id');
        //         var data = $(this).select2("val");
        //         @this.set(elementName, data);
        //     });
        // });
        //    End Select2
</script>
@endpush
