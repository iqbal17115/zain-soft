@push('css')
@endpush

<div>
    <x-slot name="title">PAYMENT METHODS</x-slot>
    <x-slot name="header">PAYMENT METHODS</x-slot>
    <div class="row mb-4">
        <div class="col-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="search-box mr-2 mb-2 d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title mb-3 size">Payment Method</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                            <div class="text-sm-right model">
                                <button type="button" style="float: right;"
                                    class="model btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2"
                                    wire:click="PaymentMethodModal">
                                    <i class="mdi mdi-plus mr-1"></i>New payment method
                                </button>
                            </div>
                        </div>
                        <div wire:ignore class="table-responsive">
                            <table class="display table table-striped table-bordered" id="PaymentMethodTable"
                                style="width:100%"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="PaymentMethodModal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Payment Method</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="PaymentMethodSave">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label> Payment Method Code</label>
                                <input class="form-control" wire:model.lazy='code' type="text"
                                    placeholder="Enter Code" />
                                @error('code') <span class="error text-danger">{{ $message }}</span> @enderror

                            </div>

                            <div class="col-md-12 form-group mb-3">
                                <label> Payment Method Name</label>
                                <input class="form-control" wire:model.lazy='name' type="text"
                                    placeholder="Enter Payment Method Name" />
                                @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-12 form-group mb-3">
                                <label>Payment Method Type</label>
                                <input class="form-control" wire:model.lazy='type' type="text"
                                    placeholder="Payment Method Type" />
                                @error('type') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label>Branch</label>
                                <select style="min-width: 100%;" wire:model.lazy="branch_id" class="form-control">
                                    <option value="">--Select--</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                                @error('branch_id') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-12 form-group mb-3">
                                <label>Company</label>
                                <select style="min-width: 100%;" wire:model.lazy="company_info_id" class="form-control">
                                    <option value="">--Select--</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                                @error('company_info_id') <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12 form-group mb-3">
                                <label>Status</label>
                                <select style="min-width: 100%;" wire:model.lazy="status" class="form-control">
                                    <option value="">--Status--</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                @error('status') <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12 form-group mb-3">
                                <div class="form-check form-check-inline">
                                    <label class="checkbox checkbox-info">
                                        <input type="checkbox" wire:model.lazy='is_active' checked="checked"><span>Is
                                            active</span><span class="checkmark"></span>
                                    </label>
                                    @error('is_active') <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
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
            @this.call('PaymentMethodEdit', id);
        }

        function callDelete(id) {
            @this.call('PaymentMethodDelete', id);
        }

        $(document).ready(function() {

            var datatable = $('#PaymentMethodTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('data.payment-method-table') }}",
                columns: [{
                        title: 'SL',
                        data: 'id'
                    },
                    {
                        title: 'Payment Method Code',
                        data: 'code',
                        name: 'code'
                    },
                    {
                        title: 'Name',
                        data: 'name',
                        name: 'name'
                    },
                    {
                        title: 'Type',
                        data: 'type',
                        name: 'type'
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
