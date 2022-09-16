@push('css')
@endpush

<div>
    <x-slot name="title">CHART OF GROUP</x-slot>
    <x-slot name="header">CHART OF GROUP</x-slot>
    <div class="row mb-4">
        <div class="col-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="search-box mr-2 mb-2 d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title mb-3 size">Chart of Group</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                            <div class="text-sm-right model">
                                <button type="button" style="float: right;"
                                    class="model btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2"
                                    wire:click="ChartOfGroupModel">
                                    <i class="mdi mdi-plus mr-1"></i>New Chart Of Group
                                </button>
                            </div>
                        </div>
                        <div wire:ignore class="table-responsive">
                            <table class="display table table-striped table-bordered" id="ChartOfGroupTable"
                                style="width:100%"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="ChartOfGroupModel" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Chart Of Group</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="ChartOfGroupSave">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label>Chart of Section</label>
                                <select style="min-width: 100%;" wire:model.lazy='chart_of_section_id' class="form-control">
                                    <option value="">--Select Section--</option>
                                    @foreach ($sections as $section)
                                    <option value="{{$section->id}}">{{$section->name}}</option>
                                    @endforeach
                                </select>
                                @error('chart_of_section_id') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label>Code</label>
                                <input class="form-control" wire:model.lazy='code' type="text"
                                    placeholder="Enter Chart of Group Code" />
                                @error('code') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label>Name</label>
                                <input class="form-control" wire:model.lazy='name' type="text"
                                    placeholder="Name" />
                                @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            {{-- <div class="col-md-12 form-group mb-3">
                                <label>Branch</label>
                                <select style="min-width: 100%;" wire:model.lazy='branch_id' class="form-control">
                                    <option value="">Select One Branch</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                                @error('branch_id') <span class="error text-danger">{{ $message }}</span> @enderror
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
            @this.call('ChartOfGroupEdit', id);
        }

        function callDelete(id) {
            @this.call('ChartOfGroupDelete', id);
        }

        $(document).ready(function() {

            var datatable = $('#ChartOfGroupTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('data.chart-of-group-table') }}",
                columns: [{
                        title: 'SL',
                        data: 'id'
                    },
                    {
                        title: 'Section',
                        data: 'chart_of_section_id',
                        name: 'chart_of_section_id'
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
