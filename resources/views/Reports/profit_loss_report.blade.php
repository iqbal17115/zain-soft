@extends('layouts.backend_app')
@section('content')
<div>
    <x-slot name="title">
        Profit Loss Report
    </x-slot>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="search-box mr-2 mb-2 d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title design_title">Profit Loss Report</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">Start Date</label>
                                <input type="date" wire:model.lazy="from_date" class="form-control currentDate"/>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">End Date</label>
                                <input type="date" wire:model.lazy="to_date" class="form-control currentDate"/>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">Brand</label>
                                <select class="form-control form-select select2 updateTable"
                                placeholder="Brand" name="brand_id" id="brand_id">
                                    <option value="">Select Brand</option>
                                    @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">Branch</label>
                                <select class="form-control form-select select2 updateTable"
                                placeholder="Branch" name="branch_id" id="branch_id">
                                    <option value="">Select Branch</option>
                                    @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4">
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
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="profit_loss_report_table" class="table table-striped table-bordered nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <tfoot>
                                <th colspan="2"></th>
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
    $(document).ready(function(){
        $('.currentDate').val(getDateFormat());
		$('#profit_loss_report_table').DataTable({
			processing: true,
			responsive: true,
			serverSide: true,
			ajax: {
				url: "{{ route('reports.profit-loss-report-data') }}",
				type: 'GET',
				cache: false,
				data : function ( d ) {
					d.from_date = $('#from_date').val();
					d.to_date = $('#to_date').val();
                    d.brand_id = $('#brand_id').val();
					d.branch_id = $('#branch_id').val();
					d.company_id1 = $('#company_id1').val();
				}
			},
			columns: [
			{ title: 'SL', data: 'id', name: 'id' },
			{ title: 'Category', data: 'category_id', name: 'category_id' },
			{ title: 'Brand', data: 'brand_id', name: 'brand_id' },
			{ title: 'Code', data: 'code', name: 'code' },
			{ title: 'Item Name', data: 'name', name: 'name' },
			{ title: 'Sale Qty', data: 'qty', name: 'qty' },
			{ title: 'Profit/Loss', data: 'profit', class: "profit", name: 'profit' }
			],
			dom: '<"html5buttons"B>lTfgitp',
			buttons: [
			'copyHtml5',
			'csvHtml5',
            // 'excel',
			{extend: 'excelHtml5', title: '{{$profile_setting->business_name}} \n {{$profile_setting->address}} \n Profit Loss Report',  footer:true,
				exportOptions:{
					columns: ":not(.not-show)"
				},
			},
			{extend: 'pdfHtml5', title: '{{$profile_setting->business_name}} \n {{$profile_setting->address}} \n Profit Loss Report', orientation: 'landscape', pageSize: 'LEGAL', footer:true,
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
			$('#profit_loss_report_table').DataTable().draw(true);
		});
	});
</script>
@endsection
