<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="search-box mr-2  d-inline-block">
                            <div class="position-relative">
                                <h4 class="card-title" id="header-text-design">Sales Report</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="basicpill-firstname-input">Start Date</label>
                            <input type="date" wire:model.lazy="from_date" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="basicpill-firstname-input">End Date</label>
                            <input type="date" wire:model.lazy="to_date" class="form-control" />
                        </div>
                    </div>

                    <div wire:ignore class="col-md-3">
                        <div class="form-group">
                            <label for="basicpill-firstname-input">Customer</label>
                            <select class="form-control form-select select2" wire:model.lazy="contact_id"
                                id="contact_id" name="contact_id">
                                <option value="">Select Customer</option>
                                @foreach ($Customers as $Customer)
                                    <option value="{{ $Customer->id }}">{{ $Customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="basicpill-firstname-input">Branch</label>
                            <select class="form-control" wire:model.lazy="branch_id">
                                <option value="">Select Branch</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
