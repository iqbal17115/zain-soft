@push('css')
@endpush

<div>
    <x-slot name="title">ADD STOCKADJUSTMENT</x-slot>
    <x-slot name="header">ADD STOCKADJUSTMENT</x-slot>
    <div class="row mb-4">
        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <div class="search-box mr-2 mb-2 d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title mb-3"> New stock adjustment</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row mt-3">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="example-search-input" class="col-16 col-form-label">
                                            code</label>
                                        <div class="col-16">
                                            <input type="text" name="" class="form-control" placeholder="Enter  code">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="example-search-input" class="col-16 col-form-label">
                                            Date</label>
                                        <div class="col-16">
                                            <input type="date" name="" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="example-search-input" class="col-16 col-form-label">Product
                                            Name/Code</label>
                                        <div class="col-16">
                                            <input type="text" name="" class="form-control"
                                                placeholder="Enter product/Material">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="example-search-input" class="col-16 col-form-label">Search</label>
                                        <div class="col-16">
                                            <button type="button"
                                                class="btn btn-primary add_product_row_button">Add</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-search-input" class="col-16 col-form-label">Barcode Scan</label>
                                        <div class="col-16">
                                            <input type="text" name="product_barcode" autocomplete="off" autofocus="on"
                                                data-type="Product" class="form-control"
                                                placeholder="Enter Barcode Scan/Product Code">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore class="table-responsive">
        <table class="display table table-striped table-bordered" id="AddStockAdjustmentTable" style="width:100%"></table>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="example-search-input" class="col-16 col-form-label">Search Stuff</label>
                            <div class="col-16">
                                <input type="text" name="" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="example-search-input" class="col-16 col-form-label">Type</label>
                            <div class="col-16">
                                <select class="form-control">
                                    <option>Transfer</option>
                                    <option>Damage</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="example-search-input" class="col-16 col-form-label">From Branch</label>
                            <div class="col-16">
                                <select class="form-control">
                                    <option>Default Branch</option>
                                    <option>Default Branch</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="example-search-input" class="col-16 col-form-label">To Branch</label>
                            <div class="col-16">
                                <select class="form-control">
                                    <option>Default Branch</option>
                                    <option>Default Branch</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="example-search-input" class="col-16 col-form-label">From WareHouse</label>
                            <div class="col-16">
                                <select class="form-control">
                                    <option>Default WareHouse</option>
                                    <option>Uttora WareHouse</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="example-search-input" class="col-16 col-form-label">To Ware House</label>
                            <div class="col-16">
                                <select class="form-control">
                                    <option>Default WareHouse</option>
                                    <option>Uttara WareHouse</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="example-search-input" class="col-16 col-form-label">Comments/Narration</label>
                            <div class="col-16">
                                <textarea style="height: 40px;" cols="0" name="note" rows="1"
                                    class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <center class="mb-5">
            <button type="submit" class="btn btn-primary" wire:click="Submit">Submit</button>
        </center>
    </div>
</div>
@push('scripts')
    <script>
        function callEdit(id) {
            @this.call('PurchaseListEdit', id);
        }

        function callDelete(id) {
            @this.call('PurchaseListDelete', id);
        }

        $(document).ready(function() {

            var datatable = $('#AddStockAdjustmentTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('data.add-stock-adjustment-table') }}",
                columns: [{
                        title: 'SL',
                        data: 'id'
                    },
                    {
                        title: 'Service Code',
                        data: 'code',
                        name: 'code'
                    },
                    {
                        title: 'Name',
                        data: 'name',
                        name: 'name'
                    },

                    {
                        title: 'Sale_price',
                        data: 'sale_price',
                        name: 'sale_price'
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

