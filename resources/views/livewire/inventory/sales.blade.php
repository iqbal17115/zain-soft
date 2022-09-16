@push('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

<div>
    <x-slot name="title">SALE</x-slot>
    <x-slot name="header">SALE</x-slot>
    <div class="row mb-4">
        <div class="col-md-12 mb-2">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="search-box mr-2 mb-2 d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title mb-3">New Sale</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                            <div class="text-sm-right">
                                <a href="{{ route('inventory.sale-list') }}"> <button type="button"
                                        style="float: right;"
                                        class="btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2"
                                        data-toggle="modal" data-target=".bd-example-modal-lg"><i
                                            class="mdi mdi-plus mr-1"></i>Sale List</button></a>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="example-search-input" class="form-label">Date</label>
                                        <input type="date" wire:model.lazy="date" name="date" class="form-control">
                                        @error('date') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-label">Sale Code</label>
                                        <input type="text" name="" wire:model.lazy="code" class="form-control"
                                            placeholder="Sale Code">
                                        @error('code') <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-1 mt-4 ">
                                    <button class="btn btn-outline-primary btn-round ml-2 CustomerAddButton"wire:click="ItemModal"
                                        type="button"><i class="fa fa-plus"></i></button>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Product/Material</label>
                                        <livewire:component.item-search-dropdown-name item_type="product" item_type="service"/>
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Barcode Scan</label>
                                        <livewire:component.item-search-dropdown item_type="product" />
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
                                        <th>SL.</th>
                                        <th>Item Code</th>
                                        <th>Product name</th>
                                        <th>Applicant name</th>
                                        <th>Passport No</th>
                                        <th>Nationality</th>
                                        <th>Serial</th>
                                        <th class="text-center">Quantity</th>
                                        <th>Unit</th>
                                        <th class="text-center">Sale Rate</th>
                                        <th class="text-center">Discount</th>
                                        <th>Vat(%)</th>
                                        <th>Amount</th>
                                        <th>Stock</th>
                                        {{-- <th>Batch No.</th>
                                        <th>Expired Date</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orderItemList as $key => $item)
                                    <tr>
                                        <td>1</td>
                                        <td>{{ $item['code'] }}</td>
                                        <td>{{ $item['name'] }}</td>
                                        <td>
                                            <center>
                                                <input type="text" class="form-control rounded" wire:model.debounce.120ms="applicant_name.{{ $key }}"
                                                    placeholder="Applicant Name" style="width: 100px;" />
                                            </center>
                                        </td>
                                        <td>
                                            <center>
                                                <input type="text" class="form-control rounded" wire:model.debounce.120ms="passport_no.{{ $key }}"
                                                    placeholder="Passport No" style="width: 100px;" />
                                            </center>
                                        </td>
                                        <td>
                                            <center>
                                                <input type="text" class="form-control rounded" wire:model.debounce.120ms="nationality.{{ $key }}"
                                                    placeholder="Nationality" style="width: 100px;" />
                                            </center>
                                        </td>
                                        <td>
                                            <center>
                                                <input type="text" class="form-control rounded" placeholder="Serial"
                                                    wire:model.debounce.120ms="serial_no.{{ $key }}"
                                                    placeholder="Serial" style="width: 100px;" />
                                            </center>
                                        </td>
                                        <td>
                                            <center>
                                                <input type="number" class="form-control rounded" placeholder="Quantity"
                                                    wire:model.debounce.120ms="item_quantity.{{ $key }}"
                                                    placeholder="Quantity" style="width: 100px;" />
                                            </center>
                                        </td>
                                        <td>
                                            {{ $item['unit']['name'] }}
                                        </td>
                                        <td>
                                            <center>
                                                <input type="text" class="form-control rounded" placeholder="Pur Rate"
                                                    wire:model.debounce.120ms="item_rate.{{ $key }}"
                                                    style="width: 100px;" />
                                            </center>
                                        </td>
                                        <td>
                                            <center>
                                                <input type="text" class="form-control rounded" placeholder="Discount"
                                                    wire:model.debounce.120ms="item_discount.{{ $key }}"
                                                    style="width: 100px;" />
                                            </center>
                                        </td>
                                        <td>
                                            @if (isset($item['vat']['rate_percent'])) {{ $item['vat']['rate_percent'] }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $item_subtotal[$key] }}
                                        </td>
                                        <td style="font-weight: bold;font-size: 18px; color: rgb(233, 49, 49);">
                                            @if($item['type']=="Service")
                                               0
                                            @else
                                               {{ $this->getStock(['item_id'=>$item['id']])->current_stock }}
                                            @endif
                                        </td>
                                        {{-- <td>
                                            <input type="text" class="form-control"
                                                wire:model.debounce.120ms="item_batch_no.{{ $key }}"
                                                placeholder="Batch No." />
                                        </td>
                                        <td>
                                            <input type="date" wire:model.debounce.120ms="item_expired_date.{{ $key }}"
                                                class="form-control" />
                                        </td> --}}
                                        <td>
                                            <button class="btn btn-danger btn-sm" wire:click="removeItem({{ $key }})">
                                                <i class="i-Close-Window"></i>
                                            </button>
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
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="example-search-input" class="col-16 col-form-label">Search Customer</label>
                        <div wire:ignore class="col-16">
                            <select class="form-control form-select select2" wire:model.lazy="contact_id"
                                id="contact_id" name="contact_id" style="width:100%;">
                                <option value="">--Select Customer--</option>
                                @foreach ($contacts as $contact)
                                <option value="{{ $contact->id }}">{{ $contact->name }}</option>
                                @endforeach
                            </select>
                            @error('contact_id') <span class="error text-danger">{{ $message
                            }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-1 mt-4 ">
                    <button class="btn btn-outline-primary btn-round ml-2 CustomerAddButton" wire:click="CustomerModal"
                        type="button"><i class="fa fa-plus"></i></button>
                </div>

                <div class="col-md-2 mt-2">
                    <div class="form-group">
                        <label>Due Date</label>
                        <input class="form-control" wire:model.lazy="sale_due_date" type="date"
                            placeholder="Enter Due Date" />
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="example-search-input" class="col-16 col-form-label">DO. No.</label>
                        <div class="col-16">
                            <input type="text" wire:model.lazy="do_no" name="do_no" class="form-control"
                                placeholder="Enter DO. No.">
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="example-search-input" class="col-16 col-form-label">LPON No.</label>
                        <div class="col-16">
                            <input type="text" wire:model.lazy="lpo_no" name="lpo_no" class="form-control"
                                placeholder="Enter LPON No.">
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="example-search-input" class="col-16 col-form-label">Note</label>
                        <div class="col-16">
                            <input type="text" wire:model.lazy="note" name="note" class="form-control"
                                placeholder="Enter Note.">
                        </div>
                    </div>
                </div>

                {{-- <div class="col-md-2">
                    <div class="form-group">
                        <label for="example-search-input" class="col-16 col-form-label"> Image/Attachment</label>
                        <div class="col-16">
                            <input type="file" class="form-control" placeholder="" name="image" value="">
                        </div>
                    </div>
                </div> --}}
            </div>

            <div class="table-responsive mt-1">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Bill Total</th>
                            <th>Discount</th>
                            <th>Vat</th>
                            <th>Shipping Charge</th>
                            <th>Amt to Pay</th>
                            <th>Paid Amount</th>
                            <th id="due_advance_show">Due</th>
                        </tr>

                    </thead>
                    <tbody>
                        <tr>
                            <td><input name="" wire:model.lazy="subtotal" style="min-width:100px;" type="number"
                                    class="form-control rounded" placeholder="Total Bill" readonly>
                            </td>
                            <td>
                                <input name="" value="" type="hidden">
                                <input name="" wire:model.debounce.150ms="discount_amount" style="min-width:100px;"
                                    type="text" class="form-control purchaseCalUpdate rounded" placeholder="Discount">
                            </td>
                            <td>
                                <input name="" wire:model.lazy="vat_total" style="min-width:100px;" type="number"
                                    class="form-control rounded" placeholder="Total Vat" readonly>
                            </td>
                            <td>
                                <input name="" value="" style="min-width:100px;" type="number"
                                    class="form-control purchaseCalUpdate rounded"
                                    wire:model.debounce.150ms="shipping_charge" placeholder="Shipping Charge">
                            </td>
                            <td>
                                <input name="" wire:model.lazy="grand_total" style="min-width:100px;" type="text"
                                    class="form-control rounded" placeholder="Amt to Pay" readonly>
                            </td>
                            <td>
                                <input type="number" step="any" class="form-control rounded" name="PaidAmount"
                                    placeholder="Paid Amount" wire:model.debounce.120ms="paid_amount" readonly>
                            </td>
                            <td>
                                <input type="number" step="any" class="form-control rounded" name="Due"
                                    wire:model.debounce.120ms="due" placeholder="Due/Advance" readonly>
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
                                            <center>Payment Date</center>
                                        </th>
                                        <th>
                                            <center>Due Date</center>
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
                                            @if(isset($item['sale_payment_date']))
                                            {{ $item['sale_payment_date'] }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $item['due_date'] }}
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
                                    <th>
                                        <div wire:ignore>
                                            <select class="form-control form-select select2"
                                                wire:model.lazy="payment_method_id" id="payment_method_id"
                                                name="payment_method_id" style="width:100%;">
                                                <option>--Select--</option>
                                                @foreach ($payments as $payment)
                                                <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
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
    </div>
    <div class="row mt-3">
        <div wire:ignore class="table-responsive">
            <table class="display table table-striped table-bordered" id="BarcodeGenerateTable" style="width:100%">
            </table>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="CustomerModalBox" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Customer Accounts</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="CustomerSave">
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-4 form-group mb-3">
                                <label>Customer Code</label>
                                <input class="form-control" type="text" wire:model.lazy="customer_code"
                                    placeholder="Contacts Code">
                                @error('code') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label>Customer Name</label>
                                <input class="form-control" type="text" wire:model.lazy="name"
                                    placeholder="Enter Customer Name">
                                @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>


                            <div class="col-md-4 form-group mb-3">
                                <label>Contact person</label>
                                <input class="form-control" wire:model.lazy="business_name" type="text"
                                    placeholder="Enter Contact Name" />
                            </div>


                            <div class="col-md-4 form-group mb-3">
                                <label>Mobile No</label>
                                <input class="form-control" wire:model.lazy="mobile" type="text"
                                    placeholder="Enter Mobile No" />
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label>Telephone</label>
                                <input class="form-control" wire:model.lazy="telephone" type="text"
                                    placeholder="Enter Telephone No" />
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label>Email</label>
                                <input class="form-control" wire:model.lazy="email" type="email"
                                    placeholder="Enter Email" />
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label>Website</label>
                                <input class="form-control" wire:model.lazy="website" type="text"
                                    placeholder="Website" />
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label>Address</label>
                                <input class="form-control" wire:model.lazy="address" type="text"
                                    placeholder="Enter Address" />
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label>Opening Balance</label>
                                <input class="form-control" wire:model.lazy="opening_balance" type="text"
                                    placeholder="Opening Balance" />
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label>Country</label>
                                <select style="min-width: 100%;" wire:model.lazy="country" class="form-control">
                                    <option value="">--Select--</option>
                                    <option value="UAE">UAE</option>
                                    <option value="BD">Bangladesh</option>
                                </select>
                                @error('country') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label>Division/Province/State</label>
                                <select style="min-width: 100%;" wire:model.lazy="division" class="form-control">
                                    <option value="">--Select--</option>
                                    <option value="Dhaka">Dhaka</option>
                                    <option value="Khulna">Khulna</option>
                                </select>
                                @error('division') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label>Credit Period(Days)</label>
                                <input class="form-control" wire:model.lazy="credit_period" type="number"
                                    placeholder="Credit Period(Days)" />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label>Credit Limit</label>
                                <input class="form-control" wire:model.lazy="credit_limit" type="text"
                                    placeholder="Enter Credit Limit" />
                            </div>


                            {{-- <div class="col-md-6 form-group mb-3">
                                <label>Due Date</label>
                                <input class="form-control" wire:model.lazy="due_date" type="date"
                                    placeholder="Enter Due Date" />
                            </div> --}}


                            {{-- <div class="col-md-4 form-group mb-3">
                                <label>Sale Commission</label>
                                <input class="form-control" wire:model.lazy="sale_commission" type="text"
                                    placeholder="Sale Comission" />
                            </div> --}}


                            <div class="@if ($vat_reg_type == 'Registered') col-md-6 @else col-md-6 @endif form-group mb-3">
                                <label>Vat Registration Type</label>
                                <select style="min-width: 100%;" wire:model.lazy="vat_reg_type" class="form-control">
                                    <option value="">--Select--</option>
                                    <option value="Registered">Registered</option>
                                    <option value="Unregistered">Unregistered</option>
                                </select>
                                @error('vat_reg_type') <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            @if ($vat_reg_type == 'Registered')
                                <div class="col-md-6 form-group mb-3">
                                    <label>Vat Registration Date</label>
                                    <input class="form-control" wire:model.lazy="vat_reg_date" type="date" />
                                    @error('vat_reg_date') <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif


                            {{-- <div class="@if ($vat_reg_type == 'Registered') col-md-4 @else col-md-6 @endif form-group mb-3">
                                <label>TIN/TRN No</label>
                                <input class="form-control" wire:model.lazy="trn_no" type="text"
                                    placeholder="Enter TIN/TRN" />
                                @error('trn_no') <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div> --}}


                            @if ($vat_reg_type == 'Registered')
                            <div class="col-md-6 form-group mb-3">
                                <label>TIN/TRN No</label>
                                <input class="form-control" wire:model.lazy="trn_no" type="text"
                                    placeholder="Enter TIN/TRN" />
                                @error('trn_no') <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            @endif

                            <div class="col-md-12 form-group mb-3">
                                <textarea class="form-control" wire:model.lazy="bank_details" type="text"
                                    placeholder="Bank Details"></textarea>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label>If Branch</label>
                                <select style="min-width: 100%;" wire:model.lazy="branch_id" class="form-control">
                                    <option value="">--Select--</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label>Status</label>
                                <select style="min-width: 100%;" wire:model.lazy="status" class="form-control">
                                    <option value="">--Status--</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                @error('status') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            {{-- <div class="col-md-3 form-group">
                                <label></label>
                                <div class="row  mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" wire:model.lazy='is_due_sale' type="checkbox"
                                            value="" id="PrevoiusDueHide">
                                        <label class="form-check-label mt-1" for="PrevoiusDueHide">
                                            Is Due Sale
                                        </label>
                                    </div>
                                    <div class="form-check ml-5">
                                        <input class="form-check-input" wire:model.lazy='is_default' type="checkbox"
                                            value="" id="DuePaidHide">
                                        <label class="form-check-label mt-1" for="DuePaidHide">
                                            Is Default
                                        </label>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="ItemModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Item Name</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="ItemSave">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label>Item Code</label>
                                <input class="form-control"  wire:model.lazy='item_code' type="text" placeholder="Enter code" />
                                @error('code') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label>Category</label>
                                <select style="min-width: 100%;" wire:model.lazy='category_id' class="form-control">
                                    <option value="">--Select Category--</option>
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                                @error('category_id') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label>Brand</label>
                                <select style="min-width: 100%;" wire:model.lazy='brand_id' class="form-control">
                                    <option value="">--Select Brand--</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{$brand->id}}">{{$brand->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label>Unit</label>
                                <select style="min-width: 100%;" wire:model.lazy='unit_id' class="form-control">
                                    <option value="">--Select Unit--</option>
                                    @foreach ($units as $unit)
                                        <option value="{{$unit->id}}">{{$unit->name}}</option>
                                    @endforeach
                                </select>
                                @error('unit_id') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label>Vat</label>
                                <select style="min-width: 100%;" wire:model.lazy='vat_id' class="form-control">
                                    <option value="">--Select Vat--</option>
                                    @foreach ($vats as $vat)
                                        <option value="{{$vat->id}}">{{$vat->name}}</option>
                                    @endforeach
                                </select>
                                @error('vat_id') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label>Item Name</label>
                                <input class="form-control" wire:model.lazy='name' type="text" placeholder="Enter item Name" />
                                @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label>Purchase Price</label>
                                <input class="form-control" wire:model.lazy='purchase_price' type="text" placeholder="Enter purchase price" />
                                @error('purchase_price') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label>Opening Stock</label>
                                <input class="form-control" wire:model.lazy='opening_stock' type="text" placeholder="Opening Stock" />
                            </div>

                            {{-- <div class="col-md-6 form-group mb-3">
                                <label>Discount</label>
                                <input class="form-control" wire:model.lazy='discount' type="text" placeholder="Enter Discount" />
                                @error('discount') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div> --}}

                            <div class="col-md-6 form-group mb-3">
                                <label>Sale Price</label>
                                <input class="form-control" wire:model.lazy='sale_price' type="text" placeholder="Enter Sale price" />
                                @error('sale_price') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label>Low Stock Alert</label>
                                <input class="form-control" wire:model.lazy='low_stock_alert' type="text" placeholder="Low Stock Alert"/>
                                @error('low_stock_alert') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label>Whole Sale Price</label>
                                <input class="form-control" wire:model.lazy='whole_sale_price' type="text" placeholder="Whole sale price"/>
                                @error('whole_sale_price') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label>Status</label>
                                <select style="min-width: 100%;" wire:model.lazy="status" class="form-control">
                                    <option value="">--Status--</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                @error('branch_id') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <div class="row ml-1">
                                    <div class="form-check">
                                        <input class="form-check-input" wire:model.lazy='is_stock_check' type="checkbox" value="" id="MemoNoHide">
                                        <label class="form-check-label" for="MemoNoHide">
                                           Is Stock Check
                                        </label>
                                    </div>
                                    {{-- <div class="form-check ml-2">
                                        <input class="form-check-input" wire:model.lazy='is_stock_check_disable' type="checkbox" value="" id="ChalanNoHide">
                                        <label class="form-check-label" for="ChalanNoHide">
                                           Is Stock Check Disable
                                        </label>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')

<script>
    // Start Select2
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: '{{ __('Select Customer') }}',
                allowClear: true
            });
            $('.select2').on('change', function(e) {
                let elementName = $(this).attr('id');
                var data = $(this).select2("val");
                @this.set(elementName, data);
            });
        });
        //    End Select2
</script>
<script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>

@endpush
