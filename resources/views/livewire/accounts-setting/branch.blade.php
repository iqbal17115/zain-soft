@push('css')
@endpush

<div>
    <x-slot name="title">BRANCH</x-slot>
    <x-slot name="header">BRANCH</x-slot>
    <div class="row mb-4">
        <div class="col-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="search-box mr-2 mb-2 d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title mb-3 size">Branch</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                            <div class="text-sm-right model">
                                <button type="button" style="float: right;"
                                    class="model btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2"
                                    wire:click="BranchModel">
                                    <i class="mdi mdi-plus mr-1"></i> New Branch
                                </button>
                            </div>
                        </div>
                        <div wire:ignore class="table-responsive">
                            <table class="display table table-striped table-bordered" id="BranchTable"
                                style="width:100%"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="BranchModel" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Branch Add</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="BranchSave">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label>Branch Code</label>
                                <input class="form-control" wire:model.lazy="code" type="text"
                                    placeholder="Enter  Branch Code" />
                                @error('code') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label>Branch Name</label>
                                <input class="form-control" wire:model.lazy="name" type="text"
                                    placeholder="Enter Branch Name" />
                                @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label>Branch Address</label>
                                <textarea class="form-control" wire:model.lazy="address" rows="1"
                                    placeholder="Enter Branch Address"></textarea>
                                @error('address') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label>Email</label>
                                <input class="form-control" wire:model.lazy="email" type="email"
                                    placeholder="Email" />
                            </div>

                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <label class="control-label">Logo (517.38*492 jpg)</label>
                                    <div class="custom-file">
                                        <input type="file" wire:model.lazy="logo" x-ref="image">
                                        @if (!$logo)
                                            @if ($QueryUpdate)
                                                <img src="{{ asset('storage/photo/' . $QueryUpdate->logo) }}"
                                                    style="height:30px; weight:30px;" alt="Image"
                                                    class="img-circle img-fluid">
                                            @endif
                                        @endif
                                        @if ($logo)
                                            <img src="{{ $logo->temporaryUrl() }}" style="height:30px; weight:30px;"
                                                alt="Image" class="img-circle img-fluid">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label>Mobile</label>
                                <input class="form-control" wire:model.lazy="mobile" type="text"
                                    placeholder="Enter Phone" />
                                @error('mobile') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label>Telephone</label>
                                <input class="form-control" wire:model.lazy="telephone" type="text"
                                    placeholder="Enter Phone" />
                                @error('telephone') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label>Company</label>
                                <select style="min-width: 100%;" wire:model.lazy="company_id" class="form-control">
                                    <option value="">--Select Company--</option>
                                    @foreach ($Company as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                                @error('company_id') <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label>Web Address</label>
                                <input class="form-control" wire:model.lazy="web_address" type="text"
                                    placeholder="Enter Web Address" />
                                @error('web_address') <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label>TRN</label>
                                <input class="form-control" wire:model.lazy="trn_no" type="text"
                                    placeholder="Enter TRN" />
                                @error('trn_no') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label>Header</label>
                                <select style="min-width: 100%;" wire:model.lazy="type" class="form-control">
                                    <option value="">--Select Header--</option>
                                    <option value="1">With Header</option>
                                    <option value="2">Without Header</option>
                                </select>
                                @error('type') <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label>Currency</label>
                                <select style="min-width: 100%;" wire:model.lazy="currency_id" class="form-control">
                                    <option value="">--Select Currency--</option>
                                    @foreach ($Currency as $currency)
                                        <option value="{{ $currency->id }}">{{ $currency->title }}</option>
                                    @endforeach
                                </select>
                                @error('currency_id') <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

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
            @this.call('BranchEdit', id);
        }

        function callDelete(id) {
            @this.call('BranchDelete', id);
        }

        $(document).ready(function() {

            var datatable = $('#BranchTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('data.branch-table') }}",
                columns: [{
                        title: 'SL',
                        data: 'id'
                    },
                    {
                        title: 'Branch Code',
                        data: 'code',
                        name: 'code'
                    },
                    {
                        title: 'Branch Name',
                        data: 'name',
                        name: 'name'
                    },
                    {
                        title: 'Email',
                        data: 'email',
                        name: 'email'
                    },
                    {
                        title: 'Branch Address',
                        data: 'address',
                        name: 'address'
                    },
                    {
                        title: 'Mobile',
                        data: 'mobile',
                        name: 'mobile'
                    },
                    {
                        title: 'Currency',
                        data: 'currency_id',
                        name: 'currency_id'
                    },
                    {
                        title: 'Company',
                        data: 'company_id',
                        name: 'company_id'
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
