@push('css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
@endpush

<div>
    <x-slot name="title">SALES RETURN REPORT</x-slot>
    <x-slot name="header">SALES RETURN REPORT</x-slot>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="search-box mr-2  d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title" id="header-text-design">Sales Return Report</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">Select Date</label>
                                <input type="text" id="reportrange" name="reportrange" class="form-control"/>
                            </div>
                        </div> --}}


                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">Start Date</label>
                                <input type="date" wire:model.lazy="from_date" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">End Date</label>
                                <input type="date" wire:model.lazy="to_date" class="form-control" />
                            </div>
                        </div>



                        <div wire:ignore class="col-md-4">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">Customer</label>
                                <select class="form-control form-select select2" wire:model.lazy="contact_id"
                                    id="contact_id" name="contact_id">
                                    @foreach ($customers as $customer)
                                        <option>Select Customer</option>
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable-buttons" class="table table-striped table-bordered nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead style="background-color: #06A5AA;font-weight: bold;">
                        <tr>
                            <th>SL</th>
                            <th>Date</th>
                            <th>Customer Name</th>
                            <th>Sales Code</th>
                            <th>Sub Total(AED)</th>
                            <th>Discount(AED)</th>
                            <th>Shipping Charge(AED)</th>
                            <th>Vat Total(AED)</th>
                            <th>Total(AED)</th>
                            <th>Paid(AED)</th>
                            <th>Due(AED)</th>
                            <th>Branch</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 0;
                            $subtotal = 0;
                            $discount = 0;
                            $shipping_charge = 0;
                            $grand_total = 0;
                            $paid_amount = 0;
                            $due_amount = 0;
                            $service_charge = 0;
                            $total_vat = 0;
                            $amount_to_pay =0;
                            $saleReturnsReport=0;
                        @endphp
                        @foreach ($this->dateFilter($saleReturnsReports) as $saleReturnsReport)
                            <tr>
                                <td><a href="javascript: void(0);" class="text-body font-weight-bold">{{ ++$i }}</a></td>
                                <td>{{$saleReturnsReport->date}}</td>
                                <td>@if($saleReturnsReport->Contact){{ $saleReturnsReport->Contact->name}}@endif</td>
                                <td>{{$saleReturnsReport->code}}</td>
                                <td>
                                    {{ $saleReturnsReport->subtotal }}
                                    @php
                                    $subtotal +=$saleReturnsReport->subtotal;
                                    @endphp
                                </td>
                                <td>{{$saleReturnsReport->discount}}
                                    @php
                                    $discount +=$saleReturnsReport->discount;
                                    @endphp
                                </td>
                                <td>{{$saleReturnsReport->shipping_charge}}
                                    @php
                                    $shipping_charge +=$saleReturnsReport->shipping_charge;
                                    @endphp
                                </td>
                                <td>{{$saleReturnsReport->total_vat}}
                                    @php
                                    $total_vat +=$saleReturnsReport->total_vat;
                                    @endphp
                                </td>
                                <td>{{$saleReturnsReport->amount_to_pay}}
                                    @php
                                    $amount_to_pay +=$saleReturnsReport->amount_to_pay;
                                    @endphp
                                </td>
                                <td>{{$saleReturnsReport->paid_amount}}
                                    @php
                                    $paid_amount +=$saleReturnsReport->paid_amount;
                                    @endphp
                                </td>
                                <td>{{$saleReturnsReport->due_amount}}
                                    @php
                                    $due_amount +=$saleReturnsReport->due_amount;
                                    @endphp
                                </td>
                                <td>{{$saleReturnsReport->Branch->name}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <thead>
                        <tr>
                            <th colspan="4" class="text-right">Total</th>
                            <th>
                               {{ $subtotal }}
                            </th>
                            <th>
                               {{ $discount }}
                            </th>
                            <th>
                                {{ $shipping_charge }}
                            </th>
                            <th>
                                {{ $total_vat }}
                            </th>
                            <th>
                                {{ $amount_to_pay }}
                            </th>

                            <th>
                                {{ $paid_amount }}
                            </th>
                            <th>
                                {{ $due_amount }}
                            </th>
                            <th>

                            </th>
                        </tr>
                    </thead>
                </table>
                {{ $saleReturnsReports->links('pagination::bootstrap-4') }}
            </div>
        </div>
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
    <!-- Sweet Alerts js -->
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <!-- Sweet alert init js -->
    <script src="{{ URL::asset('assets/js/pages/sweet-alerts.init.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
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
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/tabletools/2.2.4/js/dataTables.tableTools.min.js">
    </script>
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
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            });
        });
        $(document).ready(function() {
            $('#FlagsExport').DataTable({
                "pageLength": 50,
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            });
        });
    </script>

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
@endpush
