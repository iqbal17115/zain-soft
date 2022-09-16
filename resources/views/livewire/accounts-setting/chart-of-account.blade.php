@push('css')
@endpush
<div>
    <x-slot name="title">
        Chart of Accounts
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <div class="search-box mr-2 mb-2 d-inline-block">
                                <div class="position-relative">
                                    <h4>Chart of Account List</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-right">
                                <button type="button"
                                    class="btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2"
                                    wire:click="chartOfAccountsModal"><i class="mdi mdi-plus mr-1"></i> New Chart of
                                    Accounts</button>
                            </div>
                        </div><!-- end col-->
                    </div>
                    <div wire:ignore class="table-responsive">
                        <table class="table table-centered table-nowrap" id="chartOfAccountsTable"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  Modal content for the above example -->
    <div wire:ignore.self class="modal fade" id="ChartOfAccounts" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myLargeModalLabel">Chart of Accounts Add</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="ChartOfGroupSave">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="basicpill-firstname-input">Chart of Group</label>
                                    <select wire:model.lazy="chart_of_group_id" class="form-control">
                                        <option value="">Select Type</option>
                                        @foreach ($ChartOfGroup as $ChartOfGroup)
                                            <option value="{{ $ChartOfGroup->id }}">{{ $ChartOfGroup->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('chart_of_group_id') <span
                                        class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="basicpill-firstname-input">Chart of Accounts Code</label>
                                    <input class="form-control" type="text" wire:model.lazy="code"
                                        placeholder="Chart of Accounts Code">
                                    @error('code') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="basicpill-lastname-input">Chart of Accounts Name</label>
                                    <input class="form-control" type="text" wire:model.lazy="name"
                                        placeholder="Enter Chart of Accounts Name">
                                    @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="basicpill-lastname-input">Opening Balance</label>
                                    <input class="form-control" type="text" wire:model.lazy="opening_balance"
                                        placeholder="Enter Opening Balance">
                                    @error('opening_balance') <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="basicpill-firstname-input">Opening Balance Type</label>
                                    <select wire:model.lazy="type" class="form-control">
                                        <option value="">--Select Type--</option>
                                        <option value="Debit">Debit</option>
                                        <option value="Credit">Credit</option>
                                    </select>
                                    @error('type') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="basicpill-firstname-input">Set Accounts Default Module</label>
                                    <select class="form-control" wire:model.defer="default_module"
                                        @if ($default_module) disabled @endif>
                                        <option value="">Select Status</option>
                                        @foreach (config('status.head_of_account_type') as $key => $value)
                                            <option value="{{ $key }}">
                                                {{ Str::of($value)->replace('_', ' ')->title() }}</option>
                                        @endforeach
                                    </select>
                                    @error('default_module') <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" id="is_income_statement" type="checkbox"
                                            wire:model.lazy="is_income_statement">
                                        <label class="form-check-label" for="is_income_statement">Is Income
                                            Statement</label><br>
                                        <input class="form-check-input" id="is_balance_sheet" type="checkbox"
                                            wire:model.lazy="is_balance_sheet">
                                        <label class="form-check-label" for="is_balance_sheet">Is Balance
                                            Sheet</label><br>
                                        <input class="form-check-input" id="is_cashbank" type="checkbox"
                                            wire:model.lazy="is_cashbank">
                                        <label class="form-check-label" for="is_cashbank">Is Cash or Bank</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label for="basicpill-lastname-input">Note</label>
                                    <textarea cols="2" wire:model.lazy="note" rows="1"
                                        class="form-control"></textarea>
                                    @error('note') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
@push('scripts')

    <script>
        function callEdit(id) {
            @this.call('chartOfAccountsEdit', id);
        }

        function callDelete(id) {
            @this.call('chartOfAccountsDelete', id);
        }

        $(document).ready(function() {

            var datatable = $('#chartOfAccountsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('data.chart_of_accounts_table') }}",
                columns: [{
                        title: 'ID',
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
                        title: 'ChartOfGroup',
                        data: 'chart_of_group_id',
                        name: 'chart_of_group_id'
                    },

                    {
                        title: 'Opening Balance',
                        data: 'opening_balance',
                        name: 'opening_balance'
                    },
                    {
                        title: 'Is Cash Bank',
                        data: 'is_cashbank',
                        name: 'is_cashbank'
                    },
                    {
                        title: 'Is Balance Sheet',
                        data: 'is_balance_sheet',
                        name: 'is_balance_sheet'
                    },
                    // {
                    //     title: 'Status',
                    //     data: 'status',
                    //     name: 'status'
                    // },
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
    <script>
        window.livewire.on('success', message => {
        datatable.draw(true);
        });
        });
    </script>
@endpush
