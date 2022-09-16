@push('css')
@endpush
<div>
    <x-slot name="title">CHANGE PASSWORD</x-slot>
    <x-slot name="header">CHANGE PASSWORD</x-slot>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Change Password</div>
                    <form wire:submit.prevent="PasswordChange">
                        <div class="row">
                            <div class="col-md-3 hidden-sm hidden-xs"></div>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="state.current_password">Current Password</label>
                                        <input class="form-control" wire:model.lazy="oldpassword" type="password" placeholder="Enter your current password" />
                                         @error('oldpassword') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="state.password">New Password</label>
                                        <input class="form-control" wire:model.lazy="newpassword" type="password" placeholder="Enter your new password" />
                                        @error('newpassword') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="state.password_confirmation">Confirm Password</label>
                                        <input class="form-control" wire:model.lazy="password_confirmation" type="password" placeholder="Confirm Password"/>
                                        @error('password_confirmation') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">Change Password</button>
                                    </div>
                                </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- end of main-content -->
</div>
@push('scripts')

@endpush
