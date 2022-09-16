@push('css')
@endpush

<div>
    <x-slot name="title">STOCKADJUSTMENTLIST</x-slot>
    <x-slot name="header">STOCKADJUSTMENTLIST</x-slot>
    <div class="row mb-4">
        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="search-box mr-2 mb-2 d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title mb-3">StockAdjustment List</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                            <div class="text-sm-right">
                                <a href="{{ route('inventory.add-stock-adjustment') }}"> <button type="button"
                                        style="float: right;"
                                        class="btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2"
                                        data-toggle="modal" data-target=".bd-example-modal-lg"><i
                                            class="mdi mdi-plus mr-1"></i>New Stockadjustment</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore class="table-responsive">
        <table class="display table table-striped table-bordered" id="PurchaseListTable" style="width:100%"></table>
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

            var datatable = $('#PurchaseListTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('data.purchase-list-table') }}",
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
