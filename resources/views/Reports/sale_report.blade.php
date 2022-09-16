@extends('layouts.backend_app')
@section('content')
    <div>
        <x-slot name="title">
            Sale Report
        </x-slot>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="search-box mr-2 mb-2 d-inline-block">
                                    <div class="position-relative">
                                        <h4 class="card-title design_title">Sale Report</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="basicpill-firstname-input">From Date</label>
                                            <input type="date" class="form-control updateTable currentDate" id="from_date"
                                                name="from_date" />
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="basicpill-firstname-input">To Date</label>
                                            <input type="date" class="form-control updateTable currentDate" id="to_date"
                                                name="to_date" />
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div wire:ignore class="form-group">
                                            <label for="basicpill-firstname-input">Select Customer</label>
                                            <select class="form-control form-select select2 updateTable"
                                                placeholder="Customer" name="contact_id" id="contact_id">
                                                <option value="">Select Customer</option>
                                                @foreach ($Customers as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div wire:ignore class="form-group">
                                            <label for="basicpill-firstname-input">Select Branch</label>
                                            <select class="form-control form-select select2 updateTable"
                                                placeholder="Branch" name="branch_id" id="branch_id">
                                                <option value="">Select Branch</option>
                                                @foreach ($branches as $branch)
                                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label for="basicpill-firstname-input">Status</label>
                                            <select class="form-control form-select select2 updateTable"
                                                placeholder="Branch" name="payment_status" id="payment_status">
                                                <option value="">Select</option>
                                                <option value="Due">Due</option>
                                                <option value="Paid">Paid</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div wire:ignore class="form-group">
                                            <label for="basicpill-firstname-input">Select Company</label>
                                            <select class="form-control form-select select2 updateTable"
                                                placeholder="Customer" name="company_id1" id="company_id1">
                                                <option value="">Select Company</option>
                                                @foreach ($CompanyInfo as $CompanyInfo)
                                                <option value="{{ $CompanyInfo->id }}">{{ $CompanyInfo->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="sale_report_table" class="table table-striped table-bordered nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <tfoot>
                                    <th colspan="1"></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.currentDate').val(getDateFormat());
            $('#sale_report_table').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('reports.sale-report-data') }}",
                    type: 'GET',
                    cache: false,
                    data: function(d) {
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                        d.contact_id = $('#contact_id').val();
                        d.branch_id = $('#branch_id').val();
                        d.payment_status = $('#payment_status').val();
                        d.company_id1 = $('#company_id1').val();
                    }
                },
                columns: [{
                        title: 'SL',
                        data: 'id',
                        name: 'id'
                    },
                    {
                        title: 'Date',
                        data: 'date',
                        name: 'date'
                    },
                    {
                        title: 'Customer Name',
                        data: 'contact_id',
                        name: 'contact_id'
                    },
                    {
                        title: 'Sale Code',
                        data: 'code',
                        name: 'code'
                    },
                    // {
                    //     title: 'Sub Total(AED)',
                    //     data: 'subtotal',
                    //     name: 'subtotal'
                    // },
                    // {
                    //     title: 'Discount(AED)',
                    //     data: 'discount',
                    //     name: 'discount'
                    // },
                    // {
                    //     title: 'Shipping Charge(AED)',
                    //     data: 'shipping_charge',
                    //     class: "shipping_charge",
                    //     name: 'shipping_charge'
                    // },
                    // {
                    //     title: 'Vat Total(AED)',
                    //     data: 'total_vat',
                    //     class: "total_vat",
                    //     name: 'total_vat'
                    // },
                    {
                        title: 'Total(AED)',
                        data: 'amount_to_pay',
                        class: "amount_to_pay",
                        name: 'amount_to_pay'
                    },
                    {
                        title: 'Paid(AED)',
                        data: 'paid_amount',
                        class: "paid_amount",
                        name: 'paid_amount'
                    },
                    {
                        title: 'Due(AED)',
                        data: 'due_amount',
                        class: "due_amount",
                        name: 'due_amount'
                    },

                    {
                        title: 'Due Date',
                        data: 'due_date',
                        class: "due_date",
                        name: 'due_date'
                    },

                    {
                        title: 'Branch',
                        data: 'branch_id',
                        class: "branch_id",
                        name: 'branch_id'
                    }
                ],
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    'copyHtml5',
                    'csvHtml5',
                    // 'excel',
                    {
                        extend: 'excelHtml5',
                        title: '{{ $profile_setting->business_name }} \n {{ $profile_setting->address }} \n Sale Report',
                        footer: true,
                        exportOptions: {
                            columns: ":not(.not-show)"
                        },
                    },
                    {
                        extend: 'pdfHtml5',
                        title: '{{ $profile_setting->business_name }} \n {{ $profile_setting->address }} \n Sale Report',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        footer: true,
                        exportOptions: {
                            charset: "utf-8",
                            columns: ":not(.not-show)"
                        },
                        customize: function(doc) {
                            doc.content[1].table.widths =
                                Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                            doc.styles.tableFooter.alignment = 'center';
                            doc.styles.tableBodyEven.alignment = 'center';
                            doc.styles.tableBodyOdd.alignment = 'center';
                        }
                    }
                ],
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();
                    $.each(['amount_to_pay','paid_amount','due_amount'],function(index, value) {
                        api.columns('.' + value, {
                            page: 'all'
                        }).every(function() {
                            var sum = this
                                .data()
                                .reduce(function(a, b) {
                                    if (!Number(a) && a != 0) {
                                        a = a.replace(/\,/g, '');
                                    }

                                    if (!Number(b) && b != 0) {
                                        b = b.replace(/\,/g, '');
                                    }
                                    var x = parseFloat(a) || 0;
                                    var y = parseFloat(b) || 0;
                                    return x + y;
                                }, 0);
                            $(this.footer()).html(parseFloat(sum).toFixed(2));
                        });
                    });

                },
                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ]
            });

            $(document).on('change', '.updateTable', function() {
                $('#sale_report_table').DataTable().draw(true);
            });
        });
    </script>
@endsection
