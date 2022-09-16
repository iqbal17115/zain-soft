@push('css')
@endpush

<div>
    <x-slot name="title">New COMPANY</x-slot>
    <x-slot name="header">New COMPANY</x-slot>
    <div class="row mb-4">
        <div class="col-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="search-box mr-2 mb-2 d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title mb-3 size">Company List</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                            <div class="text-sm-right model">
                                <button type="button" style="float: right;"
                                    class="model btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2"
                                    wire:click="CompanyInfoModel">
                                    <i class="mdi mdi-plus mr-1"></i>New company
                                </button>
                            </div>
                        </div>
                        <div wire:ignore class="table-responsive">
                            <table class="display table table-striped table-bordered" id="CompanyInfoTable"
                                style="width:100%"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="CompanyInfoModel" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New company Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="CompanyInfoSave">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label>Code</label>
                                <input class="form-control" wire:model.lazy='code' type="text" placeholder="Enter Code" />
                                @error('code') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label>Name</label>
                                <input class="form-control" wire:model.lazy='name' type="text" placeholder="Enter Name" />
                                @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
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
                                <label>Address</label>
                                <input class="form-control" wire:model.lazy='address' type="text"
                                    placeholder="Enter Address" />
                                @error('address') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            {{-- <div class="col-md-12 form-group mb-3">
                                <label>Branch</label>
                                <select style="min-width: 100%;" wire:model.lazy='branch_id' class="form-control">
                                    <option value="">Select One Branch</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div> --}}

                            <div class="col-md-6 form-group mb-3">
                                <label>Postal Code</label>
                                <input class="form-control" wire:model.lazy='postal_code' type="text"
                                    placeholder="Enter Postal Code" />
                                @error('postal_code') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label>Mobile</label>
                                <input class="form-control" wire:model.lazy='mobile' type="text"
                                    placeholder="Enter Mobile" />
                                @error('mobile') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label>Telephone</label>
                                <input class="form-control" wire:model.lazy='telephone' type="text"
                                    placeholder="Enter Telephone" />
                                @error('telephone') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label>Country</label>
                                <input class="form-control" wire:model.lazy='country' type="text"
                                    placeholder="Enter Country" />
                                @error('country') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>


                            <div class="col-md-6 form-group mb-3">
                                <label>Email</label>
                                <input class="form-control" wire:model.lazy='email' type="text"
                                    placeholder="Enter Telephone" />
                                @error('email') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label>TRN/TIN</label>
                                <input class="form-control" wire:model.lazy='trn' type="text"
                                    placeholder="Enter Telephone" />
                                @error('trn') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label>Web address</label>
                                <input class="form-control" wire:model.lazy='web_address' type="text"
                                    placeholder="Enter Web Address" />
                                @error('web_address') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label>Status</label>
                                <select style="min-width: 100%;" wire:model.lazy="status" class="form-control">
                                    <option value="">--Status--</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
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
            @this.call('CompanyInfoEdit', id);
        }

        function callDelete(id) {
            @this.call('CompanyInfoDelete', id);
        }

        $(document).ready(function() {

            var datatable = $('#CompanyInfoTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('data.company-table') }}",
                columns: [{
                        title: 'SL',
                        data: 'id'
                    },
                    {
                        title: 'Company Code',
                        data: 'code',
                        name: 'code'
                    },
                    {
                        title: 'Name',
                        data: 'name',
                        name: 'name'
                    },
                    {
                        title: 'Address',
                        data: 'address',
                        name: 'address'
                    },

                    {
                        title: 'Email',
                        data: 'email',
                        name: 'email'
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
