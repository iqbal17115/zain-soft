@push('css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
@endpush

<div>
    <x-slot name="title">STOCK REPORT</x-slot>
    <x-slot name="header">STOCK REPORT</x-slot>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="search-box mr-2  d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title" id="header-text-design">Stock Report</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">Stock Type</label>
                                <select class="form-control" wire:model.lazy="type">
                                   <option value="">Select Stock Type</option>
                                   <option value="Product">Product</option>
                                   <option value="Material">Material</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">Category</label>
                                <select class="form-control" wire:model.lazy="category_id">
                                    <option value="">Select Branch</option>
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">Brand</label>
                                <select class="form-control" wire:model.lazy="brand_id">
                                    <option value="">Select Branch</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{$brand->id}}">{{$brand->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">Branch</label>
                                <select class="form-control" wire:model.lazy="branch_id">
                                    <option value="">Select Branch</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{$branch->id}}">{{$branch->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">Ware House</label>
                                <select class="form-control">
                                    @foreach ($warehouses as $warehouse)
                                    <option>Select Ware House</option>
                                    <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="datatable-buttons" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead style="background-color: #06A5AA;font-weight: bold;">
                <tr>
                    <th>SL</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Code</th>
                    <th>Item Name</th>
                    <th>Stock</th>
                </tr>
                </thead>
                <tbody>
                    @php
                        $i=0;
                    @endphp
                    @foreach ($items as $item)
                    @php
                    //  $stockIn = $this->openingDateFilter($item->StockManagerIn())->sum('quantity');
                    //  $stockOut = $this->openingDateFilter($item->StockManagerOut())->sum('quantity');
                    //  $sIn = $this->dateFilter($item->StockManagerIn())->sum('quantity');
                    //  $sOut = $this->dateFilter($item->StockManagerOut())->sum('quantity');
                    @endphp

                    <tr>
                        <td><a href="javascript: void(0);" class="text-body font-weight-bold">{{ ++$i }}</a> </td>
                        <td>
                            @if($item->Category)
                              {{ $item->Category->name }}
                            @endif
                        </td>
                        <td>@if($item->Brand)
                            {{ $item->Brand->name }}
                            @endif
                        </td>

                        <td>
                            {{ $item->code }}
                        </td>
                        <td>
                            {{ $item->name }}
                       </td>
                        <td>
                            @if ($item->low_stock_alert && $this->getStock(['item_id'=> $item->id])->current_stock<=$item->low_stock_alert)
                              <span class="text-danger font-weight-bold">
                                 {{ $this->getStock(['item_id'=> $item->id])->current_stock}}
                              </span>
                            @else
                            {{ $this->getStock(['item_id'=> $item->id])->current_stock}}
                            @endif
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
            {{-- {{ $items->links('pagination::bootstrap-4') }} --}}

        </div>
    </div>
</div>
@push('scripts')
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <!-- Sweet alert init js -->
    <script src="{{ URL::asset('assets/js/pages/sweet-alerts.init.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/tabletools/2.2.4/js/dataTables.tableTools.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/tabletools/2.2.2/swf/copy_csv_xls_pdf.swf"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.print.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#datatable-buttons').DataTable({
                "pageLength": 50,
                dom: 'Bfrtip',
                buttons: ['copy','csv','excel','pdf','print']
            });
        });
        $(document).ready(function() {
            $('#FlagsExport').DataTable({
                "pageLength": 50,
                dom: 'Bfrtip',
                buttons: ['copy','csv','excel','pdf','print']
            });
        });
    </script>
    <script type="text/javascript">
        $(function() {
            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                }
            }, cb);

            cb(start, end);
        });
    </script>
@endpush
