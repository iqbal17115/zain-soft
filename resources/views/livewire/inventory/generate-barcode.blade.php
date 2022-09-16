@push('css')
@endpush

<div>
    <x-slot name="title">GENERATE BARCODE</x-slot>
    <x-slot name="header">GENERATE BARCODE</x-slot>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-sm-16 col-md-16">
                        <div class="align-items-right justify-content-between d-flex" style="background-color:none;">
                            <button class="btn btn-outline-success pull-right">Generate Barcode</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-5">
            <div class="form-group">
                <label for="example-search-input" class="col-16 col-form-label">Product/Material</label>
                <livewire:component.item-search-dropdown-name item_type="product" />
            </div>
        </div>
        <div class="col-md-3">

        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="example-search-input" class="col-16 col-form-label">Barcode Scan</label>
                <div class="col-16">
                    <input type="text" name="" autocomplete="off" autofocus="on" data-type="Product"
                        class="form-control" placeholder="Enter Barcode Scan/Product Code">
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-16 col-md-16">
        <button type="submit" class="btn btn-success " data-target="#sales_invoice" align="right">
            Generate Barcode
        </button>
    </div>

    {{-- Start Show Item --}}
    <div class="col-md-12 mt-4 mr-7">
        <div class="card text-left">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SL.</th>
                                    <th>Item Code</th>
                                    <th>Product name</th>
                                    <th>Unit</th>
                                    <th>Pur Rate</th>
                                    <th>Sale Rate</th>
                                    <th>Quantity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderItemList as $key => $item)
                                    <tr>
                                        <td>1</td>
                                        <td>{{ $item['code'] }}</td>
                                        <td>{{ $item['name'] }}</td>
                                        <td>
                                            {{ $item['unit']['name'] }}
                                        </td>
                                        <td>
                                            {{ $item['purchase_price'] }}
                                        </td>
                                        <td>
                                            {{ $item['sale_price'] }}
                                        </td>
                                        <td>
                                            <input name=""style="min-width:50px;" type="text" class="form-control" placeholder="Quantity">
                                        </td>
                                        <td>
                                            <button class="btn btn-danger btn-sm"
                                                wire:click="removeItem({{ $key }})"><i
                                                    class="i-Folder-Trash"></i>&nbsp
                                                Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End Show Item --}}
</div>
@push('scripts')

@endpush
