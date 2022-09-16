@push('css')
@endpush

<div>
    <x-slot name="title">VAT SETUP</x-slot>
    <x-slot name="header">VAT SETUP</x-slot>
    <div class="row mb-4">
        <div class="col-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="search-box mr-2 mb-2 d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title mb-3 size">Vat Setup</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                            <div class="text-sm-right model">
                                <button type="button" style="float: right;"
                                    class="model btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2"
                                    wire:click="VatModal">
                                    <i class="mdi mdi-plus mr-1"></i>New Vat
                                </button>
                            </div>
                        </div>
                        <div wire:ignore class="table-responsive">
                            <table class="display table table-striped table-bordered" id="VatTable" style="width:100%">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="VatModal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Vat Setup</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="VatSave">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label>Vat Code</label>
                                <input class="form-control" wire:model.lazy='code' type="text" placeholder="Code" />
                                @error('code') <span class="error text-danger">{{ $message }}</span> @enderror

                            </div>

                            <div class="col-md-12 form-group mb-3">
                                <label> Name</label>
                                <input class="form-control" wire:model.lazy='name' type="text" placeholder="Name" />
                                @error('name') <span class="error text-danger">{{ $message }}</span> @enderror

                            </div>

                            <div class="col-md-12 form-group mb-3">
                                <label>Percentage Rate</label>
                                <input class="form-control" wire:model.lazy='rate_percent' type="number"
                                    placeholder="Percentage Rate"  @if($VatId) readonly @endif/>
                                @error('rate_percent') <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12 form-group mb-3">
                                <label>Fixed Rate</label>
                                <input class="form-control" wire:model.lazy='rate_fixed' type="number"
                                    placeholder="Fixed Rate" />
                            </div>


                            {{-- <div class="col-md-12 form-group mb-3">
                                <label>Branch</label>
                                <select style="min-width: 100%;" wire:model.lazy="branch_id" class="form-control">
                                    <option value="">Select Branch</option>
                                    @foreach ($branches as $branch)
                                    <option value="{{$branch->id}}">{{$branch->name}}</option>
                                    @endforeach
                                </select>
                                @error('status') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div> --}}

                            <div class="col-md-12 form-group mb-3">
                                <label>Status</label>
                                <select style="min-width: 100%;" wire:model.lazy="status" class="form-control">
                                    <option value="">--Status--</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                @error('status') <span class="error text-danger">{{ $message }}</span> @enderror
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
</div>
@push('scripts')
    <script>
        function callEdit(id) {
            @this.call('VatEdit', id);
        }

        function callDelete(id) {
            @this.call('VatDelete', id);
        }

        $(document).ready(function() {

            var datatable = $('#VatTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('data.vat-table') }}",
                columns: [{
                        title: 'SL',
                        data: 'id'
                    },
                    {
                        title: 'Code',
                        data: 'code',
                        name: 'code'
                    },
                    {
                        title: 'Name',
                        data: 'name',
                        name: 'name'
                    },
                    {
                        title: 'Percentage Rate',
                        data: 'rate_percent',
                        name: 'rate_percent'
                    },

                    {
                        title: 'Rate Fixed',
                        data: 'rate_fixed',
                        name: 'rate_fixed'
                    },
                    {
                        title: 'Branch',
                        data: 'branch_id',
                        name: 'branch_id'
                    },
                    {
                        title: 'Status',
                        data: 'status',
                        name: 'status'
                    },


                    {
                        title: 'Action',
                        data: 'action',
                        name: 'action'
                    },
                ]
            });

            window.livewire.on('success', message => {
                datatable.draw(true);
            });
        });
    </script>
@endpush
