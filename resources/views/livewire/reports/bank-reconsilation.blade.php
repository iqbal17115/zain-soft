@push('css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
@endpush
<div>
    <x-slot name="title">Bank Reconsilation</x-slot>
    <x-slot name="header">Bank Reconsilation</x-slot>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="search-box mr-2  d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title">Bank Reconsilation</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>
            {{-- Start Report --}}
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead style="background-color: #06A5AA;font-weight: bold;">
                                <tr>
                                    <th>SL</th>
                                    <th>Code</th>
                                    <th>Contact</th>
                                    <th>Bank</th>
                                    <th>Date</th>
                                    <th>Cheque Date</th>
                                    <th>Amount</th>
                                    <th>chq/Receipt No</th>
                                    <th>Add By</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
@php
   $i=0;
@endphp
                                @foreach($AccountManager as $bankReconcillation)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{$bankReconcillation->code}}</td>
                                    <td>
                                        @if($bankReconcillation->Contact)
                                           {{$bankReconcillation->Contact->name}}
                                        @endif
                                    </td>
                                    <td>
                                        @if($bankReconcillation->ChartOfAccountDr)
                                           {{$bankReconcillation->ChartOfAccountDr->name}}
                                        @elseif($bankReconcillation->ChartOfAccountCr)
                                           {{$bankReconcillation->ChartOfAccountCr->name}}
                                        @endif
                                    </td>
                                    <td>{{$bankReconcillation->due_date}}</td>
                                    <td>{{$bankReconcillation->due_date}}</td>
                                    <td>{{$bankReconcillation->amount}}</td>
                                    <td>
                                        @if($bankReconcillation->Receipt)
                                           {{$bankReconcillation->Receipt->code}}
                                        @endif
                                    </td>
                                    <td>
                                        @if($bankReconcillation->User)
                                           {{$bankReconcillation->User->name}}
                                        @endif
                                    </td>
                                    <td>
                                        @if($bankReconcillation->payment_status=="Active")
                                           <span class="text-info font-weight-bold">Honour</span>
                                           @elseif($bankReconcillation->payment_status=="Inactive")
                                            <span class="text-info font-weight-bold">DisHonour</span>
                                           @else
                                           <a class="btn btn-success" wire:click="HonourModal({{$bankReconcillation->id}})">Honour</a>
                                           {{-- <a class="btn btn-danger">Disonour</a> --}}
                                        @endif
                                    </td>
                                </tr>
                                @endforeach

                                {{-- <tr>
                                    <th colspan="3" style="text-align: center;">Total</th>
                                    <th>0.00</th>
                                    <th>0.00</th>
                                    <th>952.38</th>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- End Report --}}

            {{-- Start Modal --}}
            <div wire:ignore.self class="modal fade" id="HonourModel" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Status Update</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form wire:submit.prevent="StatusSave">
                        <div class="modal-body">
                           <div class="row">
                               <div class="col-md-12">
                                   <label>Status</label>
                                   <select class="form-control" wire:model.lazy="status">
                                      <option value="">Select</option>
                                      <option value="Active">Honour</option>
                                      <option value="Inactive">Dishonour</option>
                                   </select>
                                @error('status') <span class="error text-danger">{{ $message }}</span> @enderror
                               </div>
                               <div class="col-md-12">
                                <label>Date</label>
                                <input type="date" class="form-control" wire:model.lazy="date"/>
                                @error('date') <span class="error text-danger">{{ $message }}</span> @enderror
                               </div>
                           </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            {{-- End Modal --}}
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
