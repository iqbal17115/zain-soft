@push('css')
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ URL::asset('assets/libs/tinymce/tinymce.min.js') }}"></script>
@endpush

<div>
    <x-slot name="title">Quotation</x-slot>
    <x-slot name="header">Quotation</x-slot>
    <div class="row mb-4">
        <div class="col-md-12 mb-2">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">

                        <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="search-box mr-2 mb-2 d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title mb-3">New Quotation</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                            <div class="text-sm-right">
                                <a href="{{ route('inventory.quotation-list') }}"> <button type="button"
                                        style="float: right;"
                                        class="btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2"
                                        data-toggle="modal" data-target=".bd-example-modal-lg"><i
                                            class="mdi mdi-plus mr-1"></i>Quotation List</button></a>
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <div wire:ignore class="form-group">
                                <label for="basicpill-lastname-input">Header Content</label>
                                <textarea class="form-control" id="header_content" rows="3"
                                    wire:model.lazy="header_content" placeholder="Header Content" rows="8"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Quotation Code</label>
                                        <input type="text" name="" wire:model.lazy="code" class="form-control"
                                            placeholder="Quotation Code">
                                        @error('code') <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                            <label class="form-label">Date</label>
                                            <input type="date" wire:model.lazy="date" name="date" class="form-control">
                                            @error('date') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                            <label class="form-label">Expire Date</label>
                                            <input type="date" wire:model.lazy="expired_date" name="date" class="form-control">
                                            @error('expired_date') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-1" style="margin-top: 25px;">
                                    <button class="btn btn-info btn-round ml-2  CustomerAddButton" type="button"
                                    wire:click="ItemModal" title="Add Item/Product"><i class="fas fa-plus"></i> Add<button>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="form-label">Product/Material</label>
                                        <livewire:component.item-search-dropdown-name item_type="product" />
                                    </div>
                                </div>

                                <div class="col-md-5">
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
                                        <th class="text-center">Quantity</th>
                                        <th>Unit</th>
                                        <th class="text-center">Sale Rate</th>
                                        <th class="text-center">Discount</th>
                                        <th>Vat(%)</th>
                                        <th>Amount</th>
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
                                                <input type="number" class="form-control rounded" placeholder="Quantity"
                                                    wire:model.debounce.500ms="item_quantity.{{ $key }}"
                                                    placeholder="Quantity" style="width: 100px;"/>
                                                </center>
                                            </td>
                                            <td>
                                                {{ $item['unit']['name'] }}
                                            </td>
                                            <td>
                                                <center>
                                                <input type="text" class="form-control rounded" placeholder="Pur Rate"
                                                    wire:model.debounce.500ms="item_rate.{{ $key }}" style="width: 100px;"/>
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                <input type="text" class="form-control rounded" placeholder="Discount"
                                                    wire:model.debounce.500ms="item_discount.{{$key}}" style="width: 100px;"/>
                                                </center>
                                            </td>
                                            <td>
                                                @if (isset($item['vat']['rate_percent']))
                                                    {{ $item['vat']['rate_percent'] }}
                                                @endif
                                            </td>
                                            <td>
                                                {{ $item_subtotal[$key] }}
                                            </td>
                                            {{-- <td>
                                            <input type="text" class="form-control"
                                                wire:model.debounce.500ms="item_batch_no.{{$key}}"
                                                placeholder="Batch No." />
                                        </td>
                                        <td>
                                            <input type="date" wire:model.debounce.500ms="item_expired_date.{{$key}}"
                                                class="form-control" />
                                        </td> --}}
                                            <td>
                                                <button class="btn btn-danger btn-sm"
                                                    wire:click="removeItem({{ $key }})">
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
                <div class="col-md-4">
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
                            @error('contact_id') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-1 mt-4 ">
                    <button class="btn btn-outline-primary btn-round ml-2 CustomerAddButton" wire:click="CustomerModal"
                        type="button"><i class="fa fa-plus"></i></button>
                </div>
                <div class="col-md-4">
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
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div wire:ignore class="form-group">
                        <label for="basicpill-lastname-input">Footer Content</label>
                        <textarea class="form-control" id="footer_content" rows="3" wire:model.lazy="footer_content"
                            placeholder="Footer Content" rows="8"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary float-right" wire:click="QuotationSave">Submit</button>
                </div>
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

                            <div class="col-md-6 form-group mb-3">
                                <label>Customer Code</label>
                                <input class="form-control" type="text" wire:model.lazy="customer_code"
                                    placeholder="Contacts Code">
                                @error('customer_code') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label>Customer Name</label>
                                <input class="form-control" type="text" wire:model.lazy="name"
                                    placeholder="Enter Customer Name">
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
                                    <option value="">--Select--</option>
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
                                    <option value="">--Status--</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                @error('status') <span class="error text-danger">{{ $message }}</span> @enderror
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
        $(document).ready(function() {
            if ($("#footer_content").length > 0) {
                tinymce.init({
                    selector: "textarea#footer_content",
                    height: 200,
                    forced_root_block: false,
                    setup: function(editor) {
                        editor.on('init change', function() {
                            editor.save();
                        });
                        editor.on('change', function(e) {
                            @this.set('footer_content', editor.getContent());
                        });
                    },
                    plugins: [
                        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                        "save table contextmenu directionality emoticons template paste textcolor"
                    ],
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
                    style_formats: [{
                        title: 'Bold text',
                        inline: 'b'
                    }, {
                        title: 'Red text',
                        inline: 'span',
                        styles: {
                            color: '#ff0000'
                        }
                    }, {
                        title: 'Red header',
                        block: 'h1',
                        styles: {
                            color: '#ff0000'
                        }
                    }, {
                        title: 'Example 1',
                        inline: 'span',
                        classes: 'example1'
                    }, {
                        title: 'Example 2',
                        inline: 'span',
                        classes: 'example2'
                    }, {
                        title: 'Table styles'
                    }, {
                        title: 'Table row 1',
                        selector: 'tr',
                        classes: 'tablerow1'
                    }]
                });

            }
            if ($("#header_content").length > 0) {
                tinymce.init({
                    selector: "textarea#header_content",
                    height: 200,
                    forced_root_block: false,
                    setup: function(editor) {
                        editor.on('init change', function() {
                            editor.save();
                        });
                        editor.on('change', function(e) {
                            @this.set('header_content', editor.getContent());
                        });
                    },
                    plugins: [
                        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                        "save table contextmenu directionality emoticons template paste textcolor"
                    ],
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
                    style_formats: [{
                        title: 'Bold text',
                        inline: 'b'
                    }, {
                        title: 'Red text',
                        inline: 'span',
                        styles: {
                            color: '#ff0000'
                        }
                    }, {
                        title: 'Red header',
                        block: 'h1',
                        styles: {
                            color: '#ff0000'
                        }
                    }, {
                        title: 'Example 1',
                        inline: 'span',
                        classes: 'example1'
                    }, {
                        title: 'Example 2',
                        inline: 'span',
                        classes: 'example2'
                    }, {
                        title: 'Table styles'
                    }, {
                        title: 'Table row 1',
                        selector: 'tr',
                        classes: 'tablerow1'
                    }]
                });

            }

            $('.summernote').summernote({
                height: 300,
                // set editor height
                minHeight: null,
                // set minimum height of editor
                maxHeight: null,
                // set maximum height of editor
                focus: true // set focus to editable area after initializing summernote

            });
        });
    </script>
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
