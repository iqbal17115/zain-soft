@extends('layouts.backend_app')
@section('content')
<div>
    <x-slot name="title">
        Customer Ledger Report
    </x-slot>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="search-box mr-2 mb-2 d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title design_title">Customer Ledger Report New</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="basicpill-firstname-input">From Date</label>
                                        <input type="date" class="form-control updateTable currentDate" id="from_date"
                                            name="from_date" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="basicpill-firstname-input">To Date</label>
                                        <input type="date" class="form-control updateTable currentDate" id="to_date"
                                            name="to_date" />
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="basicpill-firstname-input">Select Customer</label>
                                        <select class="form-control form-select select2 updateTable"
                                            placeholder="Customer" name="contact_id" id="contact_id">
                                            <option value="">Select Customer</option>
                                            @foreach ($Contacts as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3">
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
                        <table id="customer_ledger_report_table" class="table table-striped table-bordered nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            {{-- <tfoot>
                                <th colspan="4"></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tfoot> --}}
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
    $(document).ready(function(){
        $('.currentDate').val(getDateFormat());
		$('#customer_ledger_report_table').DataTable({
			processing: true,
			responsive: true,
			serverSide: true,
			ajax: {
				url: "{{ route('reports.customer-ledger-report-data') }}",
				type: 'GET',
				cache: false,
				data : function ( d ) {
					d.from_date = $('#from_date').val();
					d.to_date = $('#to_date').val();
					d.contact_id = $('#contact_id').val();
					d.company_id1 = $('#company_id1').val();
					// d.branch_id = $('#branch_id').val();
				}
			},
			columns: [
			{ title: 'ID', targets: 1,  data: 'id', name: 'id' },
			{ title: 'Code',  data: 'code', name: 'code' },
			{ title: 'Date',  data: 'date', name: 'date' },
			{ title: 'Particulars',  data: 'particulars', name: 'particulars' },
			{ title: 'Credit',  data: 'credit', class: "credit", name: 'credit' },
			{ title: 'Debit',  data: 'debit', class: "debit", name: 'debit' },
			{ title: 'Balance',  data: 'balance', class: "balance", name: 'balance' },
			],
			dom: '<"html5buttons"B>lTfgitp',
			buttons: [
			'copyHtml5',
			'csvHtml5',
            // 'excel',
			{extend: 'excelHtml5', title: '{{$profile_setting->business_name}} \n {{$profile_setting->address}} \n Purchase Report',  footer:true,
				exportOptions:{
					columns: ":not(.not-show)"
				},
			},
			{extend: 'pdfHtml5', title: '{{$profile_setting->business_name}} \n {{$profile_setting->address}} \n Purchase Report',  orientation: 'landscape', pageSize: 'LEGAL', footer:true,
				exportOptions:{
					charset: "utf-8",
					columns: ":not(.not-show)"
				},
				customize: function (doc) {
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
				$.each(['subtotal','shipping_charge', 'total_vat', 'amount_to_pay','paid_amount', 'due_amount'], function( index, value ) {
					api.columns('.'+value, {
						page: 'all'
						}).every(function() {
						var sum = this
						.data()
						.reduce(function(a, b) {
							if(!Number(a) && a != 0){
								a = a.replace(/\,/g,'');
							}

							if(!Number(b) && b != 0){
								b = b.replace(/\,/g,'');
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

		$(document).on('change','.updateTable',function () {
			$('#customer_ledger_report_table').DataTable().draw(true);
		});
	});
</script>
@endsection
