@extends('layouts.backend_app')
@section('content')
<div>
    <x-slot name="title">
        Purchase Return Report
    </x-slot>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="search-box mr-2 mb-2 d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title design_title">Purchase Return Report</h4>
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
                                    <div wire:ignore class="form-group">
                                        <label for="basicpill-firstname-input">Select Supplier</label>
                                        <select class="form-control form-select select2 updateTable"
                                            placeholder="Supplier" name="contact_id" id="contact_id">
                                            <option value="">Select Supplier</option>
                                            @foreach ($Suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
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
                        <table id="purchase_return_report_table" class="table table-striped table-bordered nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            {{-- <tfoot>
                                <th colspan="8"></th>
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
		$('#purchase_return_report_table').DataTable({
			processing: true,
			responsive: true,
			serverSide: true,
			ajax: {
				url: "{{ route('reports.purchase-return-report-data') }}",
				type: 'GET',
				cache: false,
				data : function ( d ) {
					d.from_date = $('#from_date').val();
					d.to_date = $('#to_date').val();
					d.contact_id = $('#contact_id').val();
					d.branch_id = $('#branch_id').val();
					d.company_id1 = $('#company_id1').val();
				}
			},
			columns: [
			{ title: 'SL', data: 'id', name: 'id' },
			{ title: 'Date', data: 'date', name: 'date' },
			{ title: 'Supplier Name', data: 'contact_id', name: 'contact_id' },
			{ title: 'Purchase Code', data: 'code', name: 'code' },
			{ title: 'Sub Total', data: 'subtotal', name: 'subtotal' },
			{ title: 'Discount', data: 'discount_value', name: 'discount_value' },
			{ title: 'Shipping Charge', data: 'shipping_charge', class: "shipping_charge", name: 'shipping_charge' },
			{ title: 'Vat Total', data: 'total_vat', class: "total_vat", name: 'total_vat' },
			{ title: 'Total', data: 'amount_to_pay', class: "amount_to_pay", name: 'amount_to_pay' },
			{ title: 'Paid', data: 'paid_amount', class: "paid_amount", name: 'paid_amount' },
			{ title: 'Due', data: 'due_amount', class: "due_amount", name: 'due_amount' },
			{ title: 'Branch', data: 'branch_id', class: "branch_id", name: 'branch_id' }
			],
			dom: '<"html5buttons"B>lTfgitp',
			buttons: [
			'copyHtml5',
			'csvHtml5',
            // 'excel',
			{extend: 'excelHtml5', title: '{{$profile_setting->business_name}} \n {{$profile_setting->address}} \n Purchase Return Report',  footer:true,
				exportOptions:{
					columns: ":not(.not-show)"
				},
			},
			{extend: 'pdfHtml5', title: '{{$profile_setting->business_name}} \n {{$profile_setting->address}} \n Purchase Return Report', orientation: 'landscape', pageSize: 'LEGAL', footer:true,
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
				$.each(function( index, value ) {
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
			$('#purchase_return_report_table').DataTable().draw(true);
		});
	});
</script>
@endsection
