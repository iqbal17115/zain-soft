@push('css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
@endpush

<div>
    <x-slot name="title">DAY BOOK REPORT</x-slot>
    <x-slot name="header">DAY BOOK REPORT</x-slot>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="search-box mr-2  d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title" id="header-text-design">Day Book</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        {{-- <div class="col-md-5">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">Select Date</label>
                                <input type="text" id="reportrange" name="reportrange" class="form-control"/>
                            </div>
                        </div> --}}

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">Start Date</label>
                                <input type="date" wire:model.lazy="from_date" class="form-control"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">End Date</label>
                                <input type="date" wire:model.lazy="to_date" class="form-control"/>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">Company</label>
                                <select class="form-control">
                                    <option>Select Company</option>
                                    @foreach ($CompanyInfo as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{-- Start Report --}}
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="datatable-buttons" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead style="background-color: #06A5AA;font-weight: bold;">
                <tr>
                    <th>SL</th>
                    <th>TXN</th>
                    <th>Date</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Total</th>
                    <th>Debit</th>
                    <th>Credit</th>
                    <th>Balance</th>
                </tr>
                </thead>
                <tbody>
                    @php $i=0; @endphp
                    <tr>
                        <td><a href="javascript: void(0);" class="text-body font-weight-bold">{{ ++$i }}</a></td>
                        <td>11223311</td>
                        <td>2021-10-30</td>
                        <td>C88776776</td>
                        <td>DBBL</td>
                        <td>3000</td>
                        <td>9000</td>
                        <td>1000</td>
                        <td>8000</td>
                    </tr>
                </tbody>
            </table>
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
@endpush
