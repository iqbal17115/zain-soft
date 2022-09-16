@push('css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
@endpush

<div>
    <x-slot name="title">TRAILL BALANCE REPORT</x-slot>
    <x-slot name="header">TRAILL BALANCE REPORT</x-slot>
    {{-- Start Report --}}
    <div class="card">
        <div class="card-body">
            {{-- Start Header --}}
            <div class="breadcrumb" style="border-bottom: 1px solid #06A5AA;">
                <div class="p-1 rounded text-center" style="width: 100%;background-color: #e1e1e1;font-size: 16px;">
                    <a class="pt-1 font-weight-bold">Trial Balance</a>
                </div>
            </div>
            {{-- End Header --}}
            <div class="table-responsive">
                <table id="datatable-buttons" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead style="background-color: #06A5AA;font-weight: bold;">
                    <tr>
                        <th>SL</th>
                        <th>Account Name</th>
                        <th>Opening</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Closing</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php
                         $i=0;
                         $sectionDrTotalAmount = 0;
                         $sectionCrTotalAmount = 0;
                        @endphp
                        @foreach ($ChartOfSectiion as $chartOfSectiion)
                            @php
                            $drTotalAmount = 0;
                            $crTotalAmount = 0;
                            @endphp
                        <tr>
                            <td colspan="6">
                            <button class="btn btn-outline-success">
                                {{$chartOfSectiion->name}}
                            </button>
                            </td>


                        </tr>
                            @foreach($chartOfSectiion->ChartOfGroup as $chartOfGroup)
                            @php
                            $drSubAmount = 0;
                            $crSubAmount = 0;
                            @endphp
                            <tr>
                                <td></td>
                                <td style="background-color: #1da4cd;font-size: 16px;" class="font-weight-bold text-white">{{$chartOfGroup->name}}</td>
                                <td>0</td>
                                <td>{{$drSubAmount}}</td>
                                <td>{{$crSubAmount}}</td>
                                <td>0</td>

                            </tr>
                                @foreach($chartOfGroup->ChartOfAccount as $COAValue)
                                @php
                                    $drAmount = $this->totalDrLedger($COAValue->id);
                                    $crAmount = $this->totalCrLedger($COAValue->id);
                                    $drSubAmount += $drAmount;
                                    $crSubAmount += $crAmount;
                                @endphp
                                <tr>
                                    <td><a href="javascript: void(0);" class="text-body font-weight-bold">{{ ++$i }}</a></td>
                                    <td>----{{$COAValue->name}}</td>
                                    <td>
                                        DR : {{$this->totalDrLedger($COAValue->id,true)}}
                                        CR : {{$this->totalCrLedger($COAValue->id,true)}}
                                    </td>
                                    <td>{{$drAmount}}</td>
                                    <td> {{$crAmount}}</td>
                                    <td>
                                        DR : {{$this->totalDrLedger($COAValue->id,false,true)}}
                                        CR : {{$this->totalCrLedger($COAValue->id,false,true)}}
                                    </td>

                                </tr>
                                @endforeach
                                @php
                                $drTotalAmount += $drSubAmount;
                                $crTotalAmount += $crSubAmount;
                                @endphp
                            @endforeach
                            <tr>
                                <td colspan="2" class="text-primary font-weight-bold">{{$chartOfSectiion->name}} Total</td>
                                <td>0</td>
                                <td>{{$drTotalAmount}}</td>
                                <td>{{$crTotalAmount}}</td>
                                <td>0</td>

                            </tr>
                               @php
                               $sectionDrTotalAmount+=$drTotalAmount;
                               $sectionCrTotalAmount+= $crTotalAmount;
                               @endphp
                        @endforeach
                        <tr>
                            <td colspan="2"><button><i class="fas fa-calculator"></i> <span class="text-info font-weight-bold">Grand Total</span></button></td>
                            <td>0</td>
                            <td>{{$sectionDrTotalAmount}}</td>
                            <td>{{$sectionCrTotalAmount}}</td>
                            <td>0</td>

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
