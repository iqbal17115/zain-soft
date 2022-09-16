@push('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

<div>
    <x-slot name="title">PURCHASE</x-slot>
    <x-slot name="header">PURCHASE</x-slot>
    <div class="row mb-4">
        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="search-box mr-2 mb-2 d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title mb-3">New Purchase</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                            <div class="text-sm-right">
                                <a href="{{ route('inventory.purchase-list') }}"> <button type="button"
                                        style="float: right;"
                                        class="btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2"
                                        data-toggle="modal" data-target=".bd-example-modal-lg"><i
                                            class="mdi mdi-plus mr-1"></i>Purchase List</button></a>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row mt-3">
                                <div class="col-md-12"></div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Date</label>
                                        <input type="date" wire:model.lazy="date" name="date" class="form-control">
                                  @error('date') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-label">Purchase Code</label>
                                        <input type="text" name="" wire:model.lazy="code" class="form-control"
                                            placeholder="Purchase Code">
                                        @error('code') <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Product/Material</label>
                                        <livewire:component.item-search-dropdown-name item_type="product" />
                                    </div>
                                </div>
                                <div class="col-md-1" style="margin-top: 25px;">
                                    <button class="btn btn-info btn-round ml-2  CustomerAddButton" type="button"
                                    wire:click="ItemModal" title="Add Item/Product"><i class="fas fa-plus"></i> Add<button>
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
                                        <th>Serial</th>
                                        <th class="text-center">Quantity</th>
                                        <th>Unit</th>
                                        <th class="text-center">Pur Rate</th>
                                        <th class="text-center">Discount</th>
                                        <th>Vat(%)</th>
                                        <th>Amount</th>
                                        {{-- {{-- <th>Batch No.</th> --}}
                                        {{-- <th>Stock</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i=0;
                                    @endphp
                                    @foreach ($orderItemList as $key => $item)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>{{$item['code']}}</td>
                                        <td>{{$item['name']}}</td>
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
                                                wire:model.debounce.120="item_quantity.{{$key}}"
                                                placeholder="Quantity" style="width: 100px;"/>
                                            </center>
                                        </td>
                                        <td>
                                            {{$item['unit']['name']}}
                                        </td>
                                        <td>
                                            <center>
                                            <input type="number" class="form-control rounded" placeholder="Pur Rate"
                                                wire:model.debounce.120="item_rate.{{$key}}" style="width: 100px;"/>
                                            </center>
                                        </td>
                                        <td>
                                            <center>
                                            <input type="text" class="form-control rounded" placeholder="Discount"
                                                wire:model.debounce.120="item_discount.{{$key}}" style="width: 100px;"/>
                                            </center>
                                        </td>
                                        <td>
                                            @if(isset($item['vat']['rate_percent'])) {{$item['vat']['rate_percent']}}
                                            @endif
                                        </td>
                                        <td>
                                            {{$item_subtotal[$key]}}
                                        </td>

                                        {{-- <td>
                                            <input type="text" class="form-control"
                                                wire:model.debounce.120="item_batch_no.{{$key}}"
                                                placeholder="Batch No." />
                                        </td>
                                        <td>
                                            <input type="date" wire:model.debounce.120="item_expired_date.{{$key}}"
                                                class="form-control" />
                                        </td> --}}
                                        <td>
                                            <button class="btn btn-danger btn-sm" wire:click="removeItem({{$key}})">
                                                <i class="i-Close-Window"></i>
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

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="example-search-input" class="col-16 col-form-label">Search Supplier</label>
                        <div wire:ignore class="col-16">
                            <select class="form-control form-select select2" placeholder="Customer"
                                wire:model.lazy="contact_id" id="contact_id" name="contact_id" style="width:100%;">
                                <option value="">--Select Supplier--</option>
                                @foreach ($contacts as $contact)
                                <option value="{{ $contact->id }}">{{ $contact->name }}</option>
                                @endforeach
                            </select>
                            @error('contact_id') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-1" style="margin-top: 35px;">
                    <label for="example-search-input" class="col-16 col-form-label"></label>
                    <button class="btn btn-outline-primary btn-round ml-2  CustomerAddButton" type="button"
                        wire:click="SupplierModal"><i class="nav-icon i-Add"></i></button>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="example-search-input" class="col-16 col-form-label">DO. No.</label>
                        <div class="col-16">
                            <input type="text" wire:model.lazy="chalan_no" name="" class="form-control"
                                placeholder="Enter DO. No.">
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="example-search-input" class="col-16 col-form-label">LPON No.</label>
                        <div class="col-16">
                            <input type="text" wire:model.lazy="memo_no" name="" class="form-control"
                                placeholder="Enter LPON No.">
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="example-search-input" class="col-16 col-form-label"> Image/Attachment</label>
                        <div class="col-16">
                            <input type="file" class="form-control" placeholder="" name="image" value="">
                        </div>
                    </div>
                </div>
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
                                    class="form-control purchaseCalUpdate rounded" wire:model.debounce.150ms="shipping_charge"
                                    placeholder="Shipping Charge">
                            </td>
                            <td>
                                <input name="" wire:model.lazy="grand_total" style="min-width:100px;" type="text"
                                    class="form-control rounded" placeholder="Amt to Pay" readonly>
                            </td>
                            <td>
                                <input type="number" step="any" class="form-control rounded" name="PaidAmount"
                                    placeholder="Paid Amount" wire:model.debounce.120="paid_amount" readonly>
                            </td>
                            <td>
                                <input type="number" step="any" class="form-control rounded" name="Due"
                                    wire:model.debounce.120="due" placeholder="Due/Advance" readonly>
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
                                            <center>Cheque Date</center>
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
                                            {{ $item['purchase_payment_date'] }}
                                        </td>
                                        <td>
                                            {{ $item['due_date'] }}
                                        </td>

                                        <td>
                                            {{ $item['payment_amount'] }}
                                        </td>

                                        <td>
                                            <center><button class="btn btn-danger btn-sm"
                                                wire:click="removePaymentList({{$key}},{{ $item['payment_method_id'] }},{{$item['id']}})" ><i
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
                                        <input type="date" wire:model.lazy="purchase_payment_date" class="form-control">
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="example-search-input" class="col-16 col-form-label">Payment Method
                                            <input type="checkbox" wire:model="ifCheque" id="ifCheque" name="ifCheque">
                                           If Cheque
                                        </label>
                                    </td>
                                    <th>
                                        <div wire:ignore>
                                        <select class="form-control form-select select2"
                                            wire:model.lazy="payment_method_id" id="payment_method_id"
                                            name="payment_method_id" style="width:100%;">
                                            <option>Select Method</option>
                                            @foreach ($payments as $payment)
                                            <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                        @error('payment_method_id') <span class="error text-danger">{{ $message
                                            }}</span> @enderror
                                    </th>
                                </tr>
                                @if($ifCheque)
                                <tr>
                                    <td>
                                       Cheque Date
                                    </td>
                                    <td>
                                       <input type="date" wire:model.lazy="cheque_payment_date" class="form-control">
                                       @error('cheque_payment_date') <span class="error text-danger">{{ $message
                                    }}</span> @enderror
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
                                    <td>Cheque/Receipt No.</td>
                                    <th>
                                        <input type="text" class="form-control" placeholder="Cheque/Receipt No."
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
                            <button type="submit" class="btn btn-primary" wire:click="PurchaseSave">Submit</button>
                        </center>
                    </div>
                    <!-- end table-responsive -->
                </div>
            </div>
            <!-- end card -->
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="SupplierModalBox" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Supplier Accounts</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="SupplierSave">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label>Supplier Code</label>
                                <input class="form-control" type="text" wire:model.lazy="supplier_code"
                                    placeholder="Supplier Code">
                                @error('supplier_code') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label>Supplier Name</label>
                                <input class="form-control" type="text" wire:model.lazy="name"
                                    placeholder="Enter Supplier Name">
                                @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label>Email</label>
                                <input class="form-control" wire:model.lazy="email" type="email"
                                    placeholder="Enter Email" />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label>Mobile No</label>
                                <input class="form-control" wire:model.lazy="mobile" type="text"
                                    placeholder="Enter Mobile No" />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label>Business Name</label>
                                <input class="form-control" wire:model.lazy="business_name" type="text"
                                    placeholder="Enter Business Name" />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label>TIN/TRN No</label>
                                <input class="form-control" wire:model.lazy="trn_no" type="text"
                                    placeholder="Enter TIN/TRN" />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label>Opening Balance</label>
                                <input class="form-control" wire:model.lazy="opening_balance" type="text"
                                    placeholder="Opening Balance" />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label>If Branch</label>
                                <select style="min-width: 100%;" wire:model.lazy="branch_id" class="form-control">
                                    <option value="">Select Branch</option>
                                    @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 form-group mb-3">
                                <label>Address</label>
                                <input class="form-control" wire:model.lazy="address" type="text"
                                    placeholder="Enter Address" />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label>Credit Limit</label>
                                <input class="form-control" wire:model.lazy="credit_limit" type="text"
                                    placeholder="Enter Credit Limit" />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label>Due Date</label>
                                <input class="form-control" wire:model.lazy="due_date" type="date"
                                    placeholder="Enter Due Date" />
                            </div>


                            <div class="col-md-6 form-group mb-3">
                                <label>Sale Commission</label>
                                <input class="form-control" wire:model.lazy="sale_commission" type="text"
                                    placeholder="Sale Comission" />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label>Status</label>
                                <select style="min-width: 100%;" wire:model.lazy="status" class="form-control">
                                    <option value="">Status</option>
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
     {{-- Start Item Modal --}}
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
                                @error('item_code') <span class="error">{{ $message }}</span> @enderror
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
                                <input class="form-control" wire:model.lazy='item_name' type="text" placeholder="Enter item Name" />
                                @error('item_name') <span class="error text-danger">{{ $message }}</span> @enderror
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
     {{-- End Item Modal --}}
    <div wire:ignore class="table-responsive">
        <table class="display table table-striped table-bordered" id="BarcodeGenerateTable" style="width:100%"></table>
    </div>
</div>
@push('scripts')
<script>
    // Start Select2
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: '{{ __('Select Supplier') }}',
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
