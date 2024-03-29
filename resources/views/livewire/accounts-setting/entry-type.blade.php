@push('css')
@endpush
<div>
    <x-slot name="title">
        Entry Types
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <div class="search-box mr-2 mb-2 d-inline-block">
                                <div class="position-relative">
                                    <h4>Entry Types List</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-right">
                                <button type="button"
                                    class="btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2"
                                    wire:click="entryTypeModal"><i class="mdi mdi-plus mr-1"></i> New Entry
                                    Type</button>
                            </div>
                        </div><!-- end col-->
                    </div>
                    <div wire:ignore class="table-responsive">
                        <table class="table table-bordered dt-responsive nowrap" id="dataTable"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  Modal content for the above example -->
    <div wire:ignore.self class="modal fade " id="EntryTypeModel" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myLargeModalLabel">Entry Type Add</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="EntryTypeSave">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="basicpill-firstname-input">Name</label>
                                    <input class="form-control" type="text" wire:model.lazy="name" placeholder="Name">
                                    @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="basicpill-firstname-input">Prefix</label>
                                    <input class="form-control" type="text" wire:model.lazy="prefix"
                                        placeholder="Prefix">
                                    @error('prefix') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="basicpill-firstname-input">Suffix</label>
                                    <input class="form-control" type="text" wire:model.lazy="suffix"
                                        placeholder="Suffix">
                                    @error('suffix') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            </div>


                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="basicpill-firstname-input">Status</label>
                                    <select wire:model.lazy="status" class="form-control">
                                        <option value="">--Select--</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    @error('status') <span class="error">{{ $message }}</span> @enderror
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
            @this.call('entryTypeEdit', id);
        }

        function callDelete(id) {
            @this.call('entryTypeDelete', id);
        }

        $(document).ready(function() {

            var datatable = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('data.entry_type_table') }}",
                columns: [{
                        title: 'ID',
                        data: 'id'
                    },

                    {
                        title: ' Name',
                        data: 'name',
                        name: 'name'
                    },
                    {
                        title: 'Prefix',
                        data: 'prefix',
                        name: 'prefix'
                    },
                    {
                        title: 'Suffix',
                        data: 'suffix',
                        name: 'suffix'
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
