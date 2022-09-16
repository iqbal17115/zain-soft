@push('css')

<style>
    .textfont {
        font-size: 15px;
        font-weight: bold;
    }
</style>


<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
@endpush

<div>
    <x-slot name="title">BALANCE SHEET REPORT</x-slot>
    <x-slot name="header">BALANCE SHEET REPORT</x-slot>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    {{-- Start Header --}}
                    <div class="breadcrumb" style="border-bottom: 1px solid #06A5AA;">
                        <div class="p-1 rounded text-center"
                            style="width: 100%;background-color: #e1e1e1;font-size: 16px;">
                            <a class="pt-1 font-weight-bold">Balance Sheet</a>
                        </div>
                    </div>
                    {{-- End Header --}}
                </div>
            </div>
            <div class="table-responsive">
                <table id="" class="table table-striped table-bordered nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead style="background-color: #06A5AA;font-weight: bold;">
                        <tr class="text-center">
                            <th>Particulars</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center">
                            <td class="textfont">Assets</td>
                            <td></td>
                        </tr>
                        @php
                        $asset=0;
                        $liabilities=0;
                        @endphp
                        @foreach ($Assets as $ChartOfGroup)
                        <tr class="text-center">
                            <td class="font-weight-bold">{{$ChartOfGroup->name}}</td>
                            <td></td>
                        </tr>
                        @php
                        $grandTotal=0;
                        @endphp
                        @foreach ($ChartOfGroup->ChartOfAccount->whereNull('is_income_statement') as $ChartOfAccount)
                        <tr class="text-center">
                            <td>{{$ChartOfAccount->name}}</td>
                            <td>
                                {{ ($this->getChartBalance(['dr_account_id'=>
                                $ChartOfAccount->id])->current_dr_balance)-($this->getChartBalance(['cr_account_id'=>
                                $ChartOfAccount->id])->current_cr_balance)}}
                                @php
                                $asset += ($this->getChartBalance(['dr_account_id'=>
                                $ChartOfAccount->id])->current_dr_balance)-($this->getChartBalance(['cr_account_id'=>
                                $ChartOfAccount->id])->current_cr_balance);
                                $grandTotal += ($this->getChartBalance(['dr_account_id'=>
                                $ChartOfAccount->id])->current_dr_balance)-($this->getChartBalance(['cr_account_id'=>
                                $ChartOfAccount->id])->current_cr_balance);
                                @endphp
                            </td>
                        </tr>
                        @endforeach
                        <tr class="text-center">
                            <td class="text-info font-weight-bold">Grand Total</td>
                            <td>
                                {{$grandTotal}}
                            </td>
                        </tr>
                        @endforeach


                        <tr class="text-center">
                            <td class="font-weight-bold">Total Assets (+)</td>
                            <td>{{$asset}}</td>
                        </tr>

                        <tr class="text-center">
                            <td class="textfont">Liabilities & Owners Equity</td>
                            <td></td>
                        </tr>
                        @foreach ($Liabilities as $Liability)
                        <tr class="text-center">
                            <td class="textfont">{{$Liability->name}}</td>
                            <td></td>
                        </tr>
                        @php
                        $grandTotal=0;
                        @endphp
                        @foreach ($Liability->ChartOfAccount as $liability)
                        <tr class="text-center">
                            <td>{{$liability->name}}</td>
                            <td>
                                {{ ($this->getChartBalance(['cr_account_id'=>
                                $liability->id])->current_cr_balance)-($this->getChartBalance(['dr_account_id'=>
                                $liability->id])->current_dr_balance)}}
                                @php
                                $liabilities += ($this->getChartBalance(['cr_account_id'=>
                                $liability->id])->current_cr_balance)-($this->getChartBalance(['dr_account_id'=>
                                $liability->id])->current_dr_balance);
                                $grandTotal += ($this->getChartBalance(['cr_account_id'=>
                                $liability->id])->current_cr_balance)-($this->getChartBalance(['dr_account_id'=>
                                $liability->id])->current_dr_balance);
                                @endphp
                            </td>
                        </tr>
                        @endforeach
                        <tr class="text-center">
                            <td class="text-info font-weight-bold">Grand Total</td>
                            <td>
                                {{$grandTotal}}
                            </td>
                        </tr>
                        @endforeach

                        <tr class="text-center">
                            <td>=</td>
                            <td>{{$liabilities}}</td>
                        </tr>




                        <tr class="text-center">
                            <td class="textfont">Net Income (+/-)</td>
                            <td>
                                {{($saleTotal-$saleDiscount) - ($this->getStock()->cost_of_goods)+
                                ($totalIncome-$totalexpense)}}
                            </td>
                        </tr>

                        <tr class="text-center">
                            <td class="textfont">Total Liabilities & Owners Equity</td>
                            <td>{{$liabilities+($saleTotal-$saleDiscount) - ($this->getStock()->cost_of_goods)+
                                ($totalIncome-$totalexpense)}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
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
