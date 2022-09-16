@push('css')
@endpush
<div>
    <x-slot name="title">CUSTOMER ACCOUNTS</x-slot>
    <x-slot name="header">CUSTOMER ACCOUNTS</x-slot>
    <div class="row mb-4">
        <div class="col-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="search-box mr-2 mb-2 d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title mb-3 size">Customer Accounts</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                            <div class="text-sm-right model">
                                <button type="button" style="float: right;"
                                    class="model btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2"
                                    wire:click="CustomerModal">
                                    <i class="mdi mdi-plus mr-1"></i> New Customer
                                </button>
                            </div>
                        </div>
                        <div wire:ignore class="table-responsive">
                            <table class="display table table-striped table-bordered" id="CustomerTable"
                                style="width:100%"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  Modal content for the above example -->
    <div wire:ignore.self class="modal fade" id="CustomerModalBox" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Customer Accounts</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="CustomerSave">
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-4 form-group mb-3">
                                <label>Customer Code</label>
                                <input class="form-control" type="text" wire:model.lazy="code"
                                    placeholder="Contacts Code">
                                @error('code') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label>Customer Name</label>
                                <input class="form-control" type="text" wire:model.lazy="name"
                                    placeholder="Enter Customer Name">
                                @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>


                            <div class="col-md-4 form-group mb-3">
                                <label>Contact person</label>
                                <input class="form-control" wire:model.lazy="business_name" type="text"
                                    placeholder="Enter Contact Name" />
                            </div>


                            <div class="col-md-4 form-group mb-3">
                                <label>Mobile No</label>
                                <input class="form-control" wire:model.lazy="mobile" type="text"
                                    placeholder="Enter Mobile No" />
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label>Telephone</label>
                                <input class="form-control" wire:model.lazy="telephone" type="text"
                                    placeholder="Enter Telephone No" />
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label>Email</label>
                                <input class="form-control" wire:model.lazy="email" type="email"
                                    placeholder="Enter Email" />
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label>Website</label>
                                <input class="form-control" wire:model.lazy="website" type="text"
                                    placeholder="Website" />
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label>Address</label>
                                <input class="form-control" wire:model.lazy="address" type="text"
                                    placeholder="Enter Address" />
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label>Opening Balance</label>
                                <input class="form-control" wire:model.lazy="opening_balance" type="text"
                                    placeholder="Opening Balance" />
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label>Country</label>
                                <select style="min-width: 100%;" wire:model.lazy="country" class="form-control">
                                    <option value="">--Select--</option>
                                    <option value="UAE">UAE</option>
                                    <option value="BD">Bangladesh</option>
                                </select>
                                @error('country') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label>Division/Province/State</label>
                                <select style="min-width: 100%;" wire:model.lazy="division" class="form-control">
                                    <option value="">--Select--</option>
                                    <option value="Dhaka">Dhaka</option>
                                    <option value="Khulna">Khulna</option>
                                </select>
                                @error('division') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label>Credit Period(Days)</label>
                                <input class="form-control" wire:model.lazy="credit_period" type="number"
                                    placeholder="Credit Period(Days)" />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label>Credit Limit</label>
                                <input class="form-control" wire:model.lazy="credit_limit" type="text"
                                    placeholder="Enter Credit Limit" />
                            </div>


                            {{-- <div class="col-md-6 form-group mb-3">
                                <label>Due Date</label>
                                <input class="form-control" wire:model.lazy="due_date" type="date"
                                    placeholder="Enter Due Date" />
                            </div> --}}


                            {{-- <div class="col-md-4 form-group mb-3">
                                <label>Sale Commission</label>
                                <input class="form-control" wire:model.lazy="sale_commission" type="text"
                                    placeholder="Sale Comission" />
                            </div> --}}


                            <div class="@if ($vat_reg_type == 'Registered') col-md-6 @else col-md-6 @endif form-group mb-3">
                                <label>Vat Registration Type</label>
                                <select style="min-width: 100%;" wire:model.lazy="vat_reg_type" class="form-control">
                                    <option value="">--Select--</option>
                                    <option value="Registered">Registered</option>
                                    <option value="Unregistered">Unregistered</option>
                                </select>
                                @error('vat_reg_type') <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            @if ($vat_reg_type == 'Registered')
                                <div class="col-md-6 form-group mb-3">
                                    <label>Vat Registration Date</label>
                                    <input class="form-control" wire:model.lazy="vat_reg_date" type="date" />
                                    @error('vat_reg_date') <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif


                            {{-- <div class="@if ($vat_reg_type == 'Registered') col-md-4 @else col-md-6 @endif form-group mb-3">
                                <label>TIN/TRN No</label>
                                <input class="form-control" wire:model.lazy="trn_no" type="text"
                                    placeholder="Enter TIN/TRN" />
                                @error('trn_no') <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div> --}}


                            @if ($vat_reg_type == 'Registered')
                            <div class="col-md-6 form-group mb-3">
                                <label>TIN/TRN No</label>
                                <input class="form-control" wire:model.lazy="trn_no" type="text"
                                    placeholder="Enter TIN/TRN" />
                                @error('trn_no') <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            @endif

                            <div class="col-md-12 form-group mb-3">
                                <textarea class="form-control" wire:model.lazy="bank_details" type="text"
                                    placeholder="Bank Details"></textarea>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label>If Branch</label>
                                <select style="min-width: 100%;" wire:model.lazy="branch_id" class="form-control">
                                    <option value="">--Select--</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
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

                            {{-- <div class="col-md-3 form-group">
                                <label></label>
                                <div class="row  mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" wire:model.lazy='is_due_sale' type="checkbox"
                                            value="" id="PrevoiusDueHide">
                                        <label class="form-check-label mt-1" for="PrevoiusDueHide">
                                            Is Due Sale
                                        </label>
                                    </div>
                                    <div class="form-check ml-5">
                                        <input class="form-check-input" wire:model.lazy='is_default' type="checkbox"
                                            value="" id="DuePaidHide">
                                        <label class="form-check-label mt-1" for="DuePaidHide">
                                            Is Default
                                        </label>
                                    </div>
                                </div>
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
    <!-- /.modal -->
</div>
@push('scripts')
    <script>
        function callEdit(id) {
            @this.call('CustomerAccountsEdit', id);
        }

        function callDelete(id) {
            @this.call('CustomerAccountsDelete', id);
        }

        $(document).ready(function() {

            var datatable = $('#CustomerTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('data.customer-table') }}",
                columns: [{
                        title: 'SL',
                        data: 'id'
                    },
                    {
                        title: 'Customer Code',
                        data: 'code',
                        name: 'code'
                    },
                    {
                        title: 'Name',
                        data: 'name',
                        name: 'name'
                    },
                    {
                        title: 'Mobile',
                        data: 'mobile',
                        name: 'mobile'
                    },

                    {
                        title: 'Telephone',
                        data: 'telephone',
                        name: 'telephone'
                    },

                    // {
                    //     title: 'Credit Limit',
                    //     data: 'credit_limit',
                    //     name: 'credit_limit'
                    // },
                    // {
                    //     title: 'Due Date',
                    //     data: 'due_date',
                    //     name: 'due_date'
                    // },

                    {
                        title: 'Email',
                        data: 'email',
                        name: 'email'
                    },

                    {
                        title: 'TRN',
                        data: 'trn_no',
                        name: 'trn_no'
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
