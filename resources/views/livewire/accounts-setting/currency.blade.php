@push('css')
@endpush

<div>
    <x-slot name="title">CURRENCY</x-slot>
    <x-slot name="header">CURRENCY</x-slot>
    <div class="row mb-4">
        <div class="col-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="search-box mr-2 mb-2 d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title mb-3 size">Currency</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                            <div class="text-sm-right model">
                                <button type="button" style="float: right;"
                                    class="model btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2"
                                    wire:click="CurrencyModal">
                                    <i class="mdi mdi-plus mr-1"></i> New Currency
                                </button>
                            </div>
                        </div>
                        <div wire:ignore class="table-responsive">
                            <table class="display table table-striped table-bordered" id="CurrencyTable"
                                style="width:100%"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="CurrencyModal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Currency</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="CurrencySave">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label> Currency Code</label>
                                <input class="form-control" wire:model.lazy='code' type="text"
                                    placeholder="Enter  Currency Code" />
                                @error('code') <span class="error text-danger">{{ $message }}</span> @enderror

                            </div>

                            <div class="col-md-6 form-group">
                                <label> Currency Title</label>
                                <input class="form-control" wire:model.lazy='title' type="text"
                                    placeholder="Enter Currency Title" />
                                @error('title') <span class="error text-danger">{{ $message }}</span> @enderror

                            </div>

                            <div class="col-md-6 form-group">
                                <label>Symbol</label>
                                <input class="form-control" wire:model.lazy='symbol' type="text"
                                    placeholder="Enter Symbol" />
                                @error('symbol') <span class="error text-danger">{{ $message }}</span> @enderror

                            </div>

                            <div class="col-md-6 form-group">
                                <label>Symbol Position</label>
                                <select class="form-control" wire:model.lazy='symbol_position'>
                                    <option>--Select--</option>
                                    <option value="Prefix">Prefix</option>
                                    <option value="Surfix">Surfix</option>
                                </select>
                                @error('symbol_position') <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <label>In Word Prefix</label>
                                <input class="form-control" wire:model.lazy='in_word_prefix' type="text"
                                    placeholder="Enter In Word Prefix" />
                                @error('in_word_prefix') <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <label>In Word Surfix</label>
                                <input class="form-control" wire:model.lazy='in_word_surfix' type="text"
                                    placeholder="Enter In Word Suffix" />
                                @error('in_word_surfix') <span class="error text-danger">{{ $message }}</span>
                                @enderror

                            </div>


                            <div class="col-md-6 form-group">
                                <label>In Word Surfix Position</label>
                                <select class="form-control" wire:model.lazy='in_word_surfix_position'>
                                    <option value="Prefix">Prefix</option>
                                    <option value="Surfix">Surfix</option>
                                </select>
                                @error('in_word_surfix_position') <span
                                    class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <label>In Word Prefix Position</label>
                                <select class="form-control" wire:model.lazy='in_word_prefix_position'>
                                    <option value="Prefix">Prefix</option>
                                    <option value="Surfix">Surfix</option>
                                </select>
                                @error('in_word_prefix_position') <span
                                    class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="basicpill-firstname-input">Company</label>
                                    <select class="form-control" wire:model.lazy="company_id">
                                        <option>Select Company</option>
                                         @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                         @endforeach
                                    </select>
                                    @error('company_id') <span
                                    class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="basicpill-firstname-input">Branch</label>
                                    <select class="form-control" wire:model.lazy="branch_id">
                                        <option>Select Branch</option>
                                         @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                         @endforeach
                                    </select>
                                    @error('branch_id') <span
                                    class="error text-danger">{{ $message }}</span> @enderror
                                </div>
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
            @this.call('CurrencyEdit', id);
        }

        function callDelete(id) {
            @this.call('CurrencyDelete', id);
        }

        $(document).ready(function() {

            var datatable = $('#CurrencyTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('data.currency-table') }}",
                columns: [{
                        title: 'SL',
                        data: 'id'
                    },
                    {
                        title: 'Currency Code',
                        data: 'code',
                        name: 'code'
                    },
                    {
                        title: 'Title',
                        data: 'title',
                        name: 'title'
                    },
                    {
                        title: 'Symbol',
                        data: 'symbol',
                        name: 'symbol'
                    },
                    {
                        title: 'In Word Prefix',
                        data: 'in_word_prefix',
                        name: 'in_word_prefix'
                    },
                    {
                        title: 'In Word Surfix',
                        data: 'in_word_surfix',
                        name: 'in_word_surfix'
                    },
                    {
                        title: 'Branch',
                        data: 'branch_id',
                        name: 'branch_id'
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
