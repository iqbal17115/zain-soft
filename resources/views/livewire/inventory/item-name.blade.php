@push('css')
@endpush

<div>
    <x-slot name="title">ITEM NAME</x-slot>
    <x-slot name="header">ITEM NAME</x-slot>
    <div class="row mb-4">
        <div class="col-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="search-box mr-2 mb-2 d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title mb-3 size">Item Name</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-8" >
                            <div class="text-sm-right model">
                                <button type="button" style="float: right;" class="model btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2" wire:click="ItemModal">
                                    <i class="mdi mdi-plus mr-1"></i>New item
                                </button>
                            </div>
                        </div>
                        <div wire:ignore class="table-responsive">
                            <table class="display table table-striped table-bordered" id="ItemTable" style="width:100%"></table>
                        </div>
                    </div>
                </div>
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
                                <input class="form-control"  wire:model.lazy='code' type="text" placeholder="Enter code" />
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
    function callEdit(id) {
        @this.call('ItemEdit', id);
    }
    function callDelete(id) {
        @this.call('ItemDelete', id);
    }

    $(document).ready(function () {

        var datatable = $('#ItemTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('data.item-table')}}",
            columns: [
                {
                    title: 'SL',
                    data:  'id'
                },
                {
                    title: 'Item Code',
                    data:  'code',
                    name:  'code'
                },

                {
                    title: 'Name',
                    data:  'name',
                    name:  'name'
                },

                {
                    title: 'Category Name',
                    data:  'category_id',
                    name:  'category_id'
                },

                {
                    title: 'Brand Name',
                    data:  'brand_id',
                    name:  'brand_id'
                },

                {
                    title: 'Purchase Price',
                    data:  'purchase_price',
                    name:  'purchase_price'
                },


                {
                    title: 'Opening Stock',
                    data:  'opening_stock',
                    name:  'opening_stock'
                },
                // {
                //     title: 'Discount',
                //     data:  'discount',
                //     name:  'discount'
                // },
                {
                    title: 'Sale Price',
                    data:  'sale_price',
                    name:  'sale_price'
                },
                {
                    title: 'Whole Sale Price',
                    data:  'whole_sale_price',
                    name:  'whole_sale_price'
                },
                {
                    title: 'Low Stock Alert',
                    data:  'low_stock_alert',
                    name:  'low_stock_alert'
                },
                {
                    title: 'Action',
                    data:  'action',
                    name:  'action'
                },
            ]
        });

        window.livewire.on('success', message => {
            datatable.draw(true);
        });
    });
</script>
@endpush


