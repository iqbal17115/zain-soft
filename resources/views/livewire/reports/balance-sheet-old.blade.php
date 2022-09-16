@push('css')

    <style>
        .textleft {
            margin-left: 40px;
        }

        .devider {
            border-top: 1px solid #bbb;
            border-length: -4px;
        }

        .deviders {
            border-top: 1px solid #bbb;
            border-length: -4px;
        }

    </style>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
@endpush

<div>
    <x-slot name="title">BALANCE SHEET OLD</x-slot>
    <x-slot name="header">BALANCE SHEET OLD</x-slot>
    <div class="card">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="invoice" role="tabpanel" aria-labelledby="invoice-tab">
                <div class="d-sm-flex mb-5" data-view="print"><span class="m-auto"></span>
                    <button class="btn btn-primary mb-sm-0 mb-3 print-invoice">Print</button>&nbsp;&nbsp;&nbsp;
                    <button class="btn btn-primary mb-sm-0 mb-3 print-invoice">Download</button>
                </div>
                <!-- -===== Print Area =======-->
                <div id="print-area">
                    <div class="col-md-12">
                        <h1 class="font-weight-bold text-center" style="font-size: 18px">@if($profile_setting){{$profile_setting->business_name}}@endif</h1>
                        <h3 class="font-weight-bold text-center" style="font-size: 16px;">Balance Sheet</h3>
                        <h3 class="font-weight-bold text-center" style="font-size: 16px;">November Month</h3>
                    </div>
                    <table class="table table-bordered mt-2">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <p>ASSETS</p>
                                    <p>Current Assets</p>
                                    <p class="ml-5">Cash & Cash equivalent</p>
                                    <p class="ml-5">Account Receivable</p>
                                    <p class="ml-5">Inventory</p>
                                    <p class="ml-5">Prepaid Expense</p>
                                    <p class="ml-5">Investments</p>
                                    <p class="ml-5">Total Current Asset</p>


                                    <p class="mt-2">Property and Equipment</p>
                                    <p class="ml-5">Lands</p>
                                    <p class="ml-5">Building and Improvements</p>
                                    <p class="ml-5">Equipment</p>
                                    <p class="ml-5">Less acumulated depriciation</p>


                                    <p class="mt-2">Other Asset</p>
                                    <p class="ml-5">Intengible Assets</p>
                                    <p class="ml-5">Intengible Assets</p>
                                    <p>Total Asset</p>
                                </td>

                                <td>
                                    <p>&nbsp;</p>
                                    <p>&nbsp</p>
                                    <p>12000</p>
                                    <p>18000</p>
                                    <p>18000</p>
                                    <p>18000</p>
                                    <p>18000</p>
                                    <p>18000</p>

                                    <p>&nbsp;</p>
                                    <p>18000</p>
                                    <p>18000</p>
                                    <p>18000</p>
                                    <p>18000</p>

                                    <p>&nbsp;</p>
                                    <p>18000</p>
                                    <p>18000</p>

                                </td>


                                <td>
                                    <p>LIABILITIES AND SHAREHOLDER'S EQITY</p>
                                    <p>Current Liabilities</p>
                                    <p class="ml-5">Accounts Payable</p>
                                    <p class="ml-5">Notes Payble</p>
                                    <p class="ml-5">Accured Expense</p>
                                    <p class="ml-5">Deffered Revenue</p>
                                    <p class="ml-5">Total Current liabilities</p>
                                    <p class="ml-5">Total Current Asset</p>
                                    <p>Total Liabilities</p>

                                    <p class="mt-2">SHAREHOLDER'S EUQUITY</p>
                                    <p class="ml-5">Common Stock</p>
                                    <p class="ml-5">Additional paid-in capital</p>
                                    <p class="ml-5">Retained Earnings</p>
                                    <p class="ml-5">Treasury Stock</p>
                                    <p>Total Liabilities and Shareholder's equity</p>
                                </td>

                                <td>
                                    <p>&nbsp;</p>
                                    <p>&nbsp</p>
                                    <p>12000</p>
                                    <p>18000</p>
                                    <p>18000</p>
                                    <p>18000</p>
                                    <p>18000</p>
                                    <p>18000</p>

                                    <p>&nbsp;</p>
                                    <p>&nbsp</p>
                                    <p>12000</p>
                                    <p>18000</p>
                                    <p>18000</p>
                                    <p>18000</p>
                                    <p>18000</p>

                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <!-- ==== / Print Area =====-->
            </div>
        </div>
    </div><br><br>

    {{-- <div class="row mt-4">
                            <table style="width:100% border: 1px solid black;">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p>ASSETS</p>
                                            <p>CURRENT ASSETS</p>
                                            <p class="textleft">Cash & Cash equivalents</p>
                                            <p class="textleft">Accounts Receivable</p>
                                            <p class="textleft">Inventory</p>
                                            <p class="textleft">Prepaid Expense</p>
                                            <p class="textleft">Investments</p>
                                            <p class="textleft devider">Total Current Asset</p>
                                            <p class="textleft devider"></p>
                                            <p class="mt-2">Property and Equipment</p>
                                            <p class="textleft">Lands</p>
                                            <p class="textleft">Building and Improvements</p>
                                            <p class="textleft">Equipment</p>
                                            <p class="textleft">Less accumulated depriciation</p>
                                            <p class="mt-3">Others Assets</p>
                                            <p class="textleft">Intengible Assets</p>
                                            <p class="textleft">Less accumulated amortization</p>
                                            <p>Totat Assets</p>

                                        </div>
                                        <div class="col-md-4">
                                            <p>&nbsp;</p>
                                            <p>&nbsp;</p>
                                            <p>20000</p>
                                            <p>15,000</p>
                                            <p>4,000</p>
                                            <p>10,000</p>
                                            <p>10,000</p>
                                            <p class="deviders">$100,000</p>
                                            <p class="deviders"></p>
                                            <p>&nbsp;</p>
                                            <p>&nbsp;24300</p>
                                            <p>&nbsp;24300</p>
                                            <p>&nbsp;24300</p>
                                            <p>&nbsp;24300</p>
                                            <p>&nbsp;</p>
                                            <p>&nbsp;</p>
                                            <p>&nbsp;24300</p>
                                            <p>&nbsp;2300</p>
                                            <p class="deviders">&nbsp;2300</p>
                                            <p class="deviders"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p>LIABILITIES AND SHARAEHOLDER'S EQUITY</p>
                                            <p>Current liabilities</p>
                                            <p class="textleft">Accounts Payable</p>
                                            <p class="textleft">Notes Payable</p>
                                            <p class="textleft">Accured Expenses</p>
                                            <p class="textleft">Deffered revenue</p>
                                            <p class="textleft devider">Total Current liabilities</p>
                                            <p class="textleft devider"></p>
                                            <p class="textleft mt-3">Long Term debt.</p>
                                            <p class="mt-2">Total liabilities</p>
                                            <p class="mt-4">Shareholder's Equity</p>
                                            <p class="textleft">Common Stock</p>
                                            <p class="textleft">Additional paid-in capital</p>
                                            <p class="textleft">Retained Earnings</p>
                                            <p class="textleft">Treasury Stock</p>
                                            <p class="mt-4">Total liabilities and shareholder's equity</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p>&nbsp;</p>
                                            <p>&nbsp;</p>
                                            <p>20000</p>
                                            <p>15,000</p>
                                            <p>4,000</p>
                                            <p>10,000</p>
                                            <p class="deviders">50,000</p>
                                            <p class="deviders"></p>
                                            <p class="deviders"></p>

                                            <p>&nbsp;</p>
                                            <p>20000</p>
                                            <p class="deviders">247000</p>
                                            <p class="deviders"></p>
                                            <p class="deviders"></p>

                                            <p>&nbsp;</p>
                                            <p>&nbsp;</p>
                                            <p>20000</p>
                                            <p>15,000</p>
                                            <p>4,000</p>
                                            <p>10,000</p>
                                            <p class="mt-4 deviders">10,000</p>
                                            <p class="deviders"></p>
                                            <p class="deviders"></p>
                                        </div>
                                    </div>
                                </div>
                            </table>
                        </div> --}}

    {{-- <div class="card">
        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-12">
                    <h1>Company Name Here</h1>
                    <p>Balance Sheet</p>
                    <p>November Month</p>
                </div>
            </div>
            <div class="table-responsive">
                <table id="" class="table table-striped table-bordered nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-8">
                                    <p>ASSETS</p>
                                    <p>CURRENT ASSETS</p>
                                    <p class="textleft">Cash & Cash equivalents</p>
                                    <p class="textleft">Accounts Receivable</p>
                                    <p class="textleft">Inventory</p>
                                    <p class="textleft">Prepaid Expense</p>
                                    <p class="textleft">Investments</p>
                                    <p class="textleft devider">Total Current Asset</p>
                                    <p class="textleft devider"></p>
                                    <p class="mt-2">Property and Equipment</p>
                                    <p class="textleft">Lands</p>
                                    <p class="textleft">Building and Improvements</p>
                                    <p class="textleft">Equipment</p>
                                    <p class="textleft">Less accumulated depriciation</p>
                                    <p class="mt-3">Others Assets</p>
                                    <p class="textleft">Intengible Assets</p>
                                    <p class="textleft">Less accumulated amortization</p>
                                    <p>Totat Assets</p>

                                </div>
                                <div class="col-md-4">
                                    <p>&nbsp;</p>
                                    <p>&nbsp;</p>
                                    <p>20000</p>
                                    <p>15,000</p>
                                    <p>4,000</p>
                                    <p>10,000</p>
                                    <p>10,000</p>
                                    <p class="deviders">$100,000</p>
                                    <p class="deviders"></p>
                                    <p>&nbsp;</p>
                                    <p>&nbsp;24300</p>
                                    <p>&nbsp;24300</p>
                                    <p>&nbsp;24300</p>
                                    <p>&nbsp;24300</p>


                                    <p>&nbsp;</p>
                                    <p>&nbsp;</p>
                                    <p>&nbsp;24300</p>
                                    <p>&nbsp;2300</p>
                                    <p class="deviders">&nbsp;2300</p>
                                    <p class="deviders"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-8">
                                    <p>LIABILITIES AND SHARAEHOLDER'S EQUITY</p>
                                    <p>Current liabilities</p>
                                    <p class="textleft">Accounts Payable</p>
                                    <p class="textleft">Notes Payable</p>
                                    <p class="textleft">Accured Expenses</p>
                                    <p class="textleft">Deffered revenue</p>
                                    <p class="textleft devider">Total Current liabilities</p>
                                    <p class="textleft devider"></p>
                                    <p class="textleft mt-3">Long Term debt.</p>
                                    <p class="mt-2">Total liabilities</p>
                                    <p class="mt-4">Shareholder's Equity</p>
                                    <p class="textleft">Common Stock</p>
                                    <p class="textleft">Additional paid-in capital</p>
                                    <p class="textleft">Retained Earnings</p>
                                    <p class="textleft">Treasury Stock</p>
                                    <p class="mt-4">Total liabilities and shareholder's equity</p>
                                </div>
                                <div class="col-md-4">
                                    <p>&nbsp;</p>
                                    <p>&nbsp;</p>
                                    <p>20000</p>
                                    <p>15,000</p>
                                    <p>4,000</p>
                                    <p>10,000</p>
                                    <p class="deviders">50,000</p>
                                    <p class="deviders"></p>
                                    <p class="deviders"></p>

                                    <p>&nbsp;</p>
                                    <p>20000</p>
                                    <p class="deviders">247000</p>
                                    <p class="deviders"></p>
                                    <p class="deviders"></p>

                                    <p>&nbsp;</p>
                                    <p>&nbsp;</p>
                                    <p>20000</p>
                                    <p>15,000</p>
                                    <p>4,000</p>
                                    <p>10,000</p>
                                    <p class="mt-4 deviders">10,000</p>
                                    <p class="deviders"></p>
                                    <p class="deviders"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </table>
            </div>
        </div>
    </div> --}}
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
@endpush
