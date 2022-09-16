@push('css')
@endpush

<div>
    <x-slot name="title">TAG</x-slot>
    <x-slot name="header">TAG</x-slot>
    <div class="row mb-4">
        <div class="col-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="search-box mr-2 mb-2 d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title mb-3 size">Tag</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                            <div class="text-sm-right model">
                                <button type="button" style="float: right;"
                                    class="model btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2"
                                    wire:click="TagModal">
                                    <i class="mdi mdi-plus mr-1"></i>New Tag
                                </button>
                            </div>
                        </div>
                        <div wire:ignore class="table-responsive">
                            <table class="display table table-striped table-bordered" id="TagTable" style="width:100%">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="TagModal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tag</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="TagSave">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label>Tag Code</label>
                                <input class="form-control" wire:model.lazy='code' type="text"
                                    placeholder="Enter code" />
                                @error('code') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-12 form-group mb-3">
                                <label>Tag Name</label>
                                <input class="form-control" wire:model.lazy='name' type="text"
                                    placeholder="Enter unit Name" />
                                @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
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
            @this.call('TagEdit', id);
        }

        function callDelete(id) {
            @this.call('TagDelete', id);
        }

        $(document).ready(function() {

            var datatable = $('#TagTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('data.tag-table') }}",
                columns: [{
                        title: 'SL',
                        data: 'id'
                    },
                    {
                        title: 'Tag Code',
                        data: 'code',
                        name: 'code'
                    },
                    {
                        title: 'Name',
                        data: 'name',
                        name: 'name'
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
