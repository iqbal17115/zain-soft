@push('css')
@endpush
<div>
    <x-slot name="title">SALE RETURN</x-slot>
    <x-slot name="header">SALE RETURN</x-slot>
    <div class="row mb-4">
        <div class="col-md-12 mb-2">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="search-box mr-2 mb-2 d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title mb-3">Sale Return</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                            <div class="text-sm-right">
                                <a href="{{ route('inventory.sale-return-list') }}">
                                    <button type="button" style="float: right;" class="btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2" data-toggle="modal" data-target=".bd-example-modal-lg">
                                        <i class="mdi mdi-plus mr-1"></i>Sale Return List
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="example-search-input" class="form-label">Sale Date</label>
                                        <input type="date" wire:model.lazy="date" name="date" class="form-control" readonly>
                                        @error('date') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Customer</label>
                                        <div wire:ignore class="col-16">
                                            <select class="form-control form-select select2" wire:model.lazy="contact_id"
                                                id="contact_id" name="contact_id" style="width:100%;" readonly>
                                                <option value="">--Customer--</option>
                                                @foreach ($contacts as $contact)
                                                <option value="{{ $contact->id }}">{{ $contact->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('contact_id') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Sale Code/Invoice No</label>
                                        <input type="text" name="" wire:keydown.enter="GetData($event.target.value)" class="form-control" placeholder="Sale Code/Invoice No">
                                        @error('code') <span class="error text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="example-search-input" class="form-label">Return Date</label>
                                        <input type="date" wire:model.lazy="return_date" name="return_date" class="form-control">
                                        @error('return_date') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Item Code</th>
                                        <th>Product name</th>
                                        <th>Quantity</th>
                                        <th>Unit</th>
                                        <th>Sale Rate</th>
                                        <th>Discount</th>
                                        <th>Vat(%)</th>
                                        <th>Amount</th>
                                        <th>Return Qty</th>
                                        <th>Return Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($SaleInvoice)
                                    @foreach ($SaleInvoice->StockManager as $key => $item)
                                    <tr>
                                        <td>{{ $item->Item->code }}</td>
                                        <td>{{ $item->Item->name }}</td>
                                        <td>
                                            {{ $item->quantity }}
                                        </td>
                                        <td>
                                            {{ $item->Item->Unit->name }}
                                        </td>
                                        <td>
                                            {{ $item->sale_price }}
                                        </td>
                                        <td>
                                            {{ $item->discount_value }}
                                        </td>
                                        <td>
                                            {{ $item->Item->Vat->name }}
                                        </td>
                                        <td>
                                            {{ $item->subtotal }}
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" wire:model.debounce.500ms="return_quantity.{{ $item->id }}" placeholder="Return Quantity"/>
                                        </td>
                                        <td>
                                            <input type="text" wire:model.debounce.500ms="item_return_amount.{{ $item->id }}" class="form-control" placeholder="Return Amount" readonly/>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-body">
            <div class="table-responsive mt-1">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Total Sale Amount</th>
                            <th>Sales Return Subtotal</th>
                            <th>Sale Return Vat</th>
                            <th>Total Return Amount</th>
                            <th>Return Paid Amount</th>
                            <th id="due_advance_show">Due</th>
                        </tr>

                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                @if($SaleInvoice)
                               {{$SaleInvoice->amount_to_pay}}
                                {{-- <input name="" wire:model.lazy="grand_total" style="min-width:100px;" type="number" class="form-control" placeholder="Total Sale Amount" readonly> --}}
                                @endif
                            </td>
                            <td>
                                <input name="" wire:model.debounce.150ms="return_subtotal" style="min-width:100px;" type="number" class="form-control" placeholder="Sale Return Subtotal" readonly>
                            </td>
                            <td>
                                <input name="" wire:model.lazy="return_vat_total" style="min-width:100px;" type="number" class="form-control" placeholder="Sale Return Vat" readonly>
                            </td>
                            <td>
                                <input name="" style="min-width:100px;" type="number" class="form-control" wire:model.debounce.150ms="return_grand_total" placeholder="Total Return Amount" readonly>
                            </td>
                            <td>
                                <input name="" wire:model.lazy="paid_amount" style="min-width:100px;" type="text" class="form-control" placeholder="Return Paid Amount" readonly>
                            </td>
                            <td>
                                <input type="number" step="any" class="form-control" name="Due" wire:model.debounce.500ms="return_due" placeholder="Due/Advance" readonly>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>
                                            <center>Txn Id</center>
                                        </th>
                                        <th>
                                            <center>Payment Method</center>
                                        </th>
                                        <th>
                                            <center>Cheque Receipt No</center>
                                        </th>
                                        <th>
                                            <center>Date</center>
                                        </th>
                                        <th>
                                            <center>Amount</center>
                                        </th>

                                        <th>
                                            <center>Action</center>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($paymentMethodList as $key => $item)
                                    <tr>
                                        <td>
                                            {{ $item['transaction_id'] }}
                                        </td>
                                        <th scope="row">
                                            <center>{{ $item['payment_method_name'] }}</center>
                                        </th>
                                        <td>
                                            @if(isset($item['receipt_code']))
                                            {{ $item['receipt_code'] }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $item['sale_payment_date'] }}
                                        </td>
                                        <td>
                                            {{ $item['payment_amount'] }}
                                        </td>

                                        <td>
                                            <center><button class="btn btn-danger btn-sm"
                                                    wire:click="removePaymentList({{$key}},{{ $item['payment_method_id'] }},{{$item['id']}})"><i
                                                        class="i-Close-Window"></i></button></center>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Add Payment</h4>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <tbody>
                                <tr>
                                    <td>Payment Date</td>
                                    <th>
                                        <input type="date" wire:model.lazy="sale_payment_date" class="form-control">
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="example-search-input" class="col-16 col-form-label">Payment Method
                                            <input type="checkbox" wire:model="ifCheque" id="ifCheque" name="ifCheque">
                                            Cheque
                                        </label>
                                    </td>
                                    <th wire:ignore>
                                        <select class="form-control form-select select2"
                                            wire:model.lazy="payment_method_id" id="payment_method_id"
                                            name="payment_method_id" style="width:100%;">
                                            <option>--Select--</option>
                                            @foreach ($payments as $payment)
                                            <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('payment_method_id') <span class="error text-danger">{{ $message
                                            }}</span> @enderror
                                    </th>
                                </tr>
                                @if ($ifCheque)
                                <tr>
                                    <td>
                                        Cheque Date
                                    </td>
                                    <td>

                                        <input type="date" wire:model.lazy="cheque_payment_date" class="form-control">
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td>Transaction Id</td>
                                    <th>
                                        <input type="text" class="form-control" placeholder="Transaction Id"
                                            wire:model.lazy="transaction_id">
                                    </th>
                                </tr>
                                <tr>
                                    <td>Receipt No.</td>
                                    <th>
                                        <input type="text" class="form-control" placeholder="Receipt No."
                                            wire:model.lazy="receipt_code">
                                    </th>
                                </tr>
                                <tr>
                                    <th>Amount</th>
                                    <th>
                                        <input type="text" class="form-control" name="Amount" placeholder="Amount"
                                            wire:model.lazy="payment_amount">

                                    </th>
                                </tr>
                            </tbody>
                        </table>
                        <center>
                            <button class="btn btn-warning" type="submit" wire:click="AddPaymentMethod()">Add
                                Payment</button>
                            <button type="submit" class="btn btn-primary" wire:click="SaleSave">Submit</button>
                        </center>
                    </div>
                    <!-- end table-responsive -->
                </div>
            </div>
            <!-- end card -->
        </div>
    </div><br>
</div>
@push('scripts')

@endpush
