@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
@endpush

<div>
    <x-slot name="title">RECEIABLE REPORT</x-slot>
    <x-slot name="header">RECEIABLE REPORT</x-slot>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="search-box mr-2  d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title" id="header-text-design">Receivable Report</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">Start Date</label>
                                <input type="date" wire:model.lazy="start_date" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">End Date</label>
                                <input type="date" wire:model.lazy="end_date" class="form-control" />
                            </div>
                        </div>
                        <div wire:ignore class="col-md-4">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">Search Customer</label>
                                <select class="form-control form-select select2" wire:model.lazy="contact_id" id="contact_id">
                                   <option>Select Customer</option>
                                    @foreach ($contacts as $contact)
                                    <option value="{{$contact->id}}">{{$contact->name}}</option>
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
                <table id="example" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead style="background-color: #06A5AA;font-weight: bold;">
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Opening Balance</th>
                        <th>Credit</th>
                        <th>Debit</th>
                        <th>Closing Balance</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php $i=0; $subTotal=0; $discount=0; $shipping_charge=0; $grand_total=0;$paid_amount=0;$due=0;$service_charge=0; $vat_total=0; $debit=0; $credit=0; $closing=0; @endphp
                        @foreach ($contacts as $contact)
                            @php
                            $drOpening = $this->openingDateFilter($contact->ReceivablePayableCrBalance())->sum('amount');
                            $crOpening = $this->openingDateFilter($contact->ReceivablePayableDrBalance())->sum('amount');
                            $dr = $this->dateFilter($contact->ReceivablePayableDrBalance())->sum('amount');
                            $cr = $this->dateFilter($contact->ReceivablePayableCrBalance())->sum('amount');
                           @endphp
                        <tr>
                            <td><a href="javascript: void(0);" class="text-body font-weight-bold">{{ ++$i }}</a></td>
                            <td>{{$contact->name}}</td>
                            <td>
                                {{$this->getReceivable(['contact_id'=>$contact->id,'start_date'=>$start_date,'end_date'=>$end_date])->opening_balance}}
                            </td>
                            <td>
                                {{$this->getReceivable(['contact_id'=>$contact->id,'start_date'=>$start_date,'end_date'=>$end_date])->total_credit}}
                                @php
                                  $credit += $this->getReceivable(['contact_id'=>$contact->id,'start_date'=>$start_date,'end_date'=>$end_date])->total_credit;
                                @endphp
                            </td>
                            <td>
                                {{$this->getReceivable(['contact_id'=>$contact->id,'start_date'=>$start_date,'end_date'=>$end_date])->total_debit}}
                                @php
                                  $debit += $this->getReceivable(['contact_id'=>$contact->id,'start_date'=>$start_date,'end_date'=>$end_date])->total_debit;
                                @endphp
                            </td>

                            <td>
                                {{$this->getReceivable(['contact_id'=>$contact->id])->current_balance}}
                                {{-- {{($crOpening-$drOpening )+($cr-$dr)}} --}}
                                @php
                                  $closing += $this->getReceivable(['contact_id'=>$contact->id])->current_balance;
                                @endphp
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3">Total</th>
                            <th>{{$credit}}</th>
                            <th>{{$debit}}</th>
                            <th>{{$closing}}</th>
                        </tr>
                    </tfoot>
                </table>
                {{-- {{ $sales->links('pagination::bootstrap-4') }} --}}
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

    <script type="text/javascript" class="init">
        $(document).ready(function() {
            $('#example').DataTable({
                "pageLength": 50,
                dom: 'Bfrtip',
                buttons:
                [
                    'copy','csv','excel','pdf'
                ],
                lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
            });
        });
    </script>
    <script>
        // Start Select2
        $(document).ready(function() {
         $('.select2').select2({
                 placeholder: '{{__('Select Customer')}}',
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
