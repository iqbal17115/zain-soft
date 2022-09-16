@push('css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
@endpush

<div>
    <x-slot name="title">PURCHASE DETAILED REPORT</x-slot>
    <x-slot name="header">PURCHASE DETAILED REPORT</x-slot>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="search-box mr-2  d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title" id="header-text-design">Purchase Detailed Report</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        {{-- <div class="col-md-4">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">Select Date</label>
                                <input type="text" id="reportrange" name="reportrange" class="form-control" />
                            </div>
                        </div> --}}

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">Start Date</label>
                                <input type="date" wire:model.lazy="from_date" class="form-control" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">End Date</label>
                                <input type="date" wire:model.lazy="to_date" class="form-control" />
                            </div>
                        </div>



                        <div wire:ignore class="col-md-3">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">Supplier</label>
                                <select class="form-control form-select select2" wire:model.lazy="conatct_id" id="contact_id" name="contact_id">
                                    <option value="">Select Supplier</option>
                                    @foreach ($Suppliers as $Supplier)
                                    <option value="{{$Supplier->id}}">{{$Supplier->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Start Report  --}}
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable-buttons" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead style="background-color: #06A5AA;font-weight: bold;">
                        <tr>
                            <th>SL</th>
                            <th>Date</th>
                            {{-- <th>Purchase Invoice</th> --}}
                            <th>Supplier Name</th>
                            <th>Item Name</th>
                            <th>Qty</th>
                            <th>Purchase Price(AED)</th>
                            <th>Sub Total(AED)</th>
                            <th>Branch</th>
                        </tr>
                        </thead>
                        <tbody>
                            @php $i=0; $purchase_price=0; $purchase_subtotal=0; @endphp
                            @foreach ($this->dateFilter($purchaseDetails) as $purchaseDetail)
                            <tr>
                                <td><a href="javascript: void(0);" class="text-body font-weight-bold">{{ ++$i }}</a></td>
                                <td>{{ $purchaseDetail->date }}</td>
                                {{-- <td>{{ $purchaseDetail->Contact->name }}</td> --}}
                                <td>
                                    @if($purchaseDetail->Contact) {{ $purchaseDetail->Contact->name }} @endif
                                </td>
                                <td>
                                    {{ $purchaseDetail->Item->name }}

                                </td>
                                <td>
                                    {{ $purchaseDetail->quantity }} {{$purchaseDetail->Item->Unit->name}}
                                </td>
                                <td>
                                    {{ $purchaseDetail->purchase_price }}
                                     @php $purchase_price += $purchaseDetail->purchase_price @endphp
                                </td>
                                <td>
                                    {{ $purchaseDetail->subtotal }}
                                    @php $purchase_subtotal += $purchaseDetail->subtotal @endphp
                                </td>
                                <td>
                                    @if($purchaseDetail->Branch)
                                    {{ $purchaseDetail->Branch->name }}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <thead>
                            <tr>
                                <th colspan="5" class="text-right">Total</th>
                                <th>
                                    {{ $purchase_price }}
                                </th>
                                <th>
                                    {{ $purchase_subtotal }}
                                </th>
                                <th></th>
                            </tr>
                            </thead>
                    </table>
                    {{ $purchaseDetails->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
    {{-- End Report --}}
</div>
@push('scripts')
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
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>
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

    <script>
        // Start Select2
        $(document).ready(function() {
         $('.select2').select2({
                 placeholder: '{{__('Select Supplier')}}',
                 allowClear: true
             });
             $('.select2').on('change', function (e) {
                 let elementName = $(this).attr('id');
                 var data = $(this).select2("val");
                 @this.set(elementName, data);
             });
     });
    //    End Select2
    </script>
@endpush
