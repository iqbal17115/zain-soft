@push('css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
@endpush
<div>
    <x-slot name="title">VAT RETURN REPORT</x-slot>
    <x-slot name="header">VAT RETURN REPORT</x-slot>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="search-box mr-2  d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title" id="header-text-design">VAT RETURN REPORT</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">Start Date</label>
                                <input type="date" wire:model.lazy="start_date" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">End Date</label>
                                <input type="date" wire:model.lazy="end_date" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">Report Type</label>
                                <select class="form-control" wire:model.lazy="type">
                                    <option value="Vat Return Details">Vat Return Details</option>
                                    <option value="Vat Return Sammary">Vat Return Sammary</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
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
            </div><br>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead style="background-color: #06A5AA;font-weight: bold;">
                                <tr>
                                    <th scope="col">Particulars</th>
                                    <th scope="col">Accesible Value</th>
                                    <th scope="col">Vat Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th colspan="3">Sales</th>
                                </tr>
                                {{-- <tr>
                                    <th scope="row">A. Output Vat</th>
                                    <td>{{$chartOfAccountOutputVat}}</td>
                                    <td></td>
                                </tr> --}}
                                <tr>
                                    <th scope="row">Output VAT (5%)</th>
                                    <td></td>
                                    <td>{{$chartOfAccountOutputVat}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Total Output Vat</th>
                                    <td>0.00</td>
                                    <td>{{$chartOfAccountOutputVat}}</td>
                                </tr>
                                <tr>
                                    <th colspan="3">Purchase</th>
                                </tr>
                                {{-- <tr>
                                    <th scope="row">B. Input Vat</th>
                                    <td>0.00</td>
                                    <td></td>
                                </tr> --}}
                                <tr>
                                    <th scope="row">Input VAT (5%)</th>
                                    <td></td>
                                    <td>{{$chartOfAccountInputVat}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Total Input Vat</th>
                                    <td>0.00</td>
                                    <td>{{$chartOfAccountInputVat}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">VAT Refunable / Carried Forward</th>
                                    <th scope="col">{{$chartOfAccountOutputVat-$chartOfAccountInputVat}}</th>
                                </tr>
                            </thead>
                        </table>
                        @if($type=="Vat Return Details")
                        <h1>Transaction Details :</h1><br>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">TransactionDate</th>
                                    <th scope="col">Receipt No</th>
                                    <th scope="col">Received Amount</th>
                                    <th scope="col">Total Tax</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th colspan="4">Sales</th>
                                </tr>
                                @php
                                   $invoice_amount=0;
                                   $amount=0;
                                @endphp
                                @foreach ($VatCollection as $vatCollection)

                                <tr>
                                    <th scope="row">{{$vatCollection->date}}</th>
                                    <td>@if($vatCollection->invoice_id)
                                          {{$vatCollection->Invoice->code}}
                                        @else
                                          {{$vatCollection->Receipt->code}}
                                        @endif</td>
                                    <td>
                                        @if($vatCollection->invoice_id)
                                        {{$vatCollection->Invoice->paid_amount}}
                                         @php
                                           $invoice_amount += $vatCollection->Invoice->paid_amount;
                                         @endphp
                                        @else
                                        {{$vatCollection->Receipt->amount}}
                                         @php
                                           $invoice_amount += $vatCollection->Receipt->amount;
                                         @endphp
                                        @endif
                                    </td>
                                    <td>
                                        {{$vatCollection->amount}}
                                        @php
                                           $amount += $vatCollection->amount;
                                        @endphp
                                    </td>
                                </tr>

                                @endforeach

                                <tr>
                                    <th colspan="2">Total </th>
                                    <td>@if ($currencySymbol) {{ $currencySymbol->symbol }} @endif{{$invoice_amount}}</td>
                                    <td>@if ($currencySymbol) {{ $currencySymbol->symbol }} @endif{{$amount}}</td>
                                </tr>
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div><br><br><br>
            {{-- End Report --}}
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
