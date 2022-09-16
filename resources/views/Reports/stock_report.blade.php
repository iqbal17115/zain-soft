@extends('layouts.backend_app')
@section('content')
<div>
    <x-slot name="title">
        Stock Report
    </x-slot>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="search-box mr-2 mb-2 d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title design_title">Stock Report</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-2">
                            <div wire:ignore class="form-group">
                                <label for="basicpill-firstname-input">Stock Type</label>
                                <select class="form-control form-select select2 updateTable"
                                    placeholder="Item Type" name="item_type" id="item_type">
                                    <option value="">Select Stock Type</option>
                                    <option value="Material">Material</option>
                                    <option value="Product">Product</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <div wire:ignore class="form-group">
                                <label for="basicpill-firstname-input">Select Category</label>
                                <select class="form-control form-select select2 updateTable"
                                    placeholder="Category" name="category_id" id="category_id">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div wire:ignore class="form-group">
                                <label for="basicpill-firstname-input">Select Brand</label>
                                <select class="form-control form-select select2 updateTable"
                                    placeholder="Brand" name="brand_id" id="brand_id">
                                    <option value="">Select Brand</option>
                                    @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div wire:ignore class="form-group">
                                <label for="basicpill-firstname-input">Select Branch</label>
                                <select class="form-control form-select select2 updateTable"
                                    placeholder="Brand" name="branch_id" id="branch_id">
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
                        {{-- <div class="col-lg-2">
                            <div wire:ignore class="form-group">
                                <label for="basicpill-firstname-input">Warehouse</label>
                                <select class="form-control form-select select2 updateTable"
                                    placeholder="Warehouse" name="warehouse_id" id="warehouse_id">
                                    <option value="">Select Warehouse</option>
                                    @foreach ($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="stock_report_table" class="table table-striped table-bordered nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <tfoot>
                                <th colspan="2"></th>
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
		$('#stock_report_table').DataTable({
			processing: true,
			responsive: true,
			serverSide: true,
			ajax: {
				url: "{{ route('reports.stock-report-data') }}",
				type: 'GET',
				cache: false,
				data : function ( d ) {
					d.item_type = $('#item_type').val();
					d.category_id = $('#category_id').val();
					d.brand_id = $('#brand_id').val();
					d.branch_id = $('#branch_id').val();
					d.company_id1 = $('#company_id1').val();
					// d.warehouse_id = $('#warehouse_id').val();
				}
			},
			columns: [
			{ title: 'SL', data: 'id', name: 'id' },
			{ title: 'Category', data: 'category_id', name: 'category_id' },
			{ title: 'Brand', data: 'brand_id', name: 'brand_id' },
			{ title: 'Code', data: 'code', name: 'code' },
			{ title: 'Item Name', data: 'name', name: 'name' },
			{ title: 'Stock', data: 'stock', class: "stock", name: 'stock' }
			],
			dom: '<"html5buttons"B>lTfgitp',
			buttons: [
			'copyHtml5',
			'csvHtml5',
            // 'excel',
			{extend: 'excelHtml5', title: '{{$profile_setting->business_name}} \n {{$profile_setting->address}} \n Stock Report',  footer:true,
				exportOptions:{
					columns: ":not(.not-show)"
				},
			},
			{extend: 'pdfHtml5', title: '{{$profile_setting->business_name}} \n {{$profile_setting->address}} \n Stock Report', orientation: 'landscape', pageSize: 'LEGAL', footer:true,
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
				$.each(['stock'], function( index, value ) {
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
			$('#stock_report_table').DataTable().draw(true);
		});
	});
</script>
@endsection
