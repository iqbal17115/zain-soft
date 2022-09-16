@push('css')
@endpush

<div>
    <x-slot name="title">SERVICE NAME</x-slot>
    <x-slot name="header">SERVICE NAME</x-slot>
    <div class="row mb-4">
        <div class="col-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="search-box mr-2 mb-2 d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title mb-3 size">Service Name</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-8" >
                            <div class="text-sm-right model">
                                <button type="button" style="float: right;" class="model btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2" wire:click="ServiceNameModal">
                                    <i class="mdi mdi-plus mr-1"></i> New Service
                                </button>
                            </div>
                        </div>
                        <div wire:ignore class="table-responsive">
                            <table class="display table table-striped table-bordered" id="ServieNameTable" style="width:100%"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="ServiceNameModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Service Name</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="ServiceSave">
                    <div class="modal-body">
                        <div class="row">
                            {{-- <div class="col-md-6 form-group">
                                <label for="example-search-input" class="col-16 col-form-label">Category</label>
                                <select name="" class="form-control">
                                    <option value="">Select One Option</option>
                                    <option value="1">Default Category</option>
                                </select>
                            </div> --}}

                            {{-- <div class="col-md-6 form-group">
                                <label for="example-search-input" class="col-16 col-form-label"></label> Brand</label>
                                <select name="" class="form-control">
                                    <option value="">Select One Option</option>
                                    <option value="1">Default brand</option>
                                </select>
                            </div> --}}


                            <div class="col-md-6 form-group mb-3">
                                <label>Service Code</label>
                                <input class="form-control" wire:model.lazy='code' type="text" placeholder="Enter Service Code" />
                                @error('code') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <label>Service Name</label>
                                <input class="form-control" wire:model.lazy='name' type="text" placeholder="Enter Service Name" />
                                @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>



                            {{-- <div class="col-md-6 form-group mb-3">
                                <label>Category</label>
                                <select style="min-width: 100%;" wire:model.lazy="category_id"  class="form-control">
                                    <option value="">--Select--</option>
                                    @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                                @error('category_id') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div> --}}

                            <div class="col-md-6 form-group mb-3">
                                <label>Unit</label>
                                <select style="min-width: 100%;" wire:model.lazy="unit_id"  class="form-control">
                                    <option value="">--Select--</option>
                                    @foreach ($units as $unit)
                                    <option value="{{$unit->id}}">{{$unit->name}}</option>
                                    @endforeach
                                </select>
                                @error('unit_id') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label>Vat</label>
                                <select style="min-width: 100%;" wire:model.lazy="vat_id"  class="form-control">
                                    <option value="">--Select--</option>
                                    @foreach ($vats as $vat)
                                    <option value="{{$vat->id}}">{{$vat->name}}</option>
                                    @endforeach
                                </select>
                                @error('vat_id') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <label>Sale price</label>
                                <input class="form-control" wire:model.lazy='sale_price' type="text" placeholder="Enter Sale price" />
                                @error('sale_price') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label>If Branch</label>
                                <select style="min-width: 100%;" wire:model.lazy="branch_id"  class="form-control">
                                    <option value="">--Select--</option>
                                    @foreach ($branches as $branch)
                                    <option value="{{$branch->id}}">{{$branch->name}}</option>
                                    @endforeach
                                </select>
                                @error('branch_id') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label>Status</label>
                                <select style="min-width: 100%;" wire:model.lazy="status" class="form-control">
                                    <option value="">--Status--</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                @error('status') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            {{-- <div class="col-md-6 form-group">
                                <label for="example-search-input" class="col-16 col-form-label"></label> Unit</label>
                                <select name="" class="form-control">
                                    <option value="">Select One Option</option>
                                    <option value="1">pcs</option>
                                    <option value="1">kg</option>
                                </select>
                            </div> --}}

                            {{-- <div class="col-md-6 form-group">
                                <label>Vat%</label>
                                <input class="form-control" type="text" placeholder="Vat"/>
                            </div> --}}

                            {{-- <div class="col-md-6 form-group">
                                <label>Sale Rate</label>
                                <input class="form-control" type="text" placeholder="Sale Rate"/>
                            </div> --}}

                            {{-- <div class="col-md-12 form-group">
                                <label>If Branch</label>
                                <select style="min-width: 100%;" class="form-control">
                                    <option value="">Select Branch</option>
                                    <option value="40">Default Branch</option>
                                </select>
                            </div> --}}
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
</div>
@push('scripts')
<script>
    function callEdit(id) {
        @this.call('ServiceEdit', id);
    }
    function callDelete(id) {
        @this.call('ServiceDelete', id);
    }

    $(document).ready(function () {

        var datatable = $('#ServieNameTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('data.service-name-table')}}",
            columns: [
                {
                    title: 'SL',
                    data:  'id'
                },
                {
                    title: 'Service Code',
                    data:  'code',
                    name:  'code'
                },
                {
                    title: 'Name',
                    data:  'name',
                    name:  'name'
                },

                {
                    title: 'Sale price',
                    data:  'sale_price',
                    name:  'sale_price'
                },

                {
                    title: 'Action',
                    data:  'action',
                    name:  'action'
                },
            ]
        });

        window.livewire.on('success', message => {
            datatable.draw(true);
        });
    });
</script>
@endpush



