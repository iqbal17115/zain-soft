@push('css')
@endpush
<div>
    <x-slot name="title">PROFILE SETUP</x-slot>
    <x-slot name="header">PROFILE SETUP</x-slot>
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="ProfileSave">
                <div class="row">
                    {{-- <div class="col-md-6 form-group mb-3">
                        <label>Profile Photo</label>
                        <input class="form-control" type="file" wire:model.lazy="profile_photo" placeholder="Profile Photo">
                        @error('profile_photo') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div> --}}
                    <div class="col-md-6 form-group mb-3">
                        <label>Business Name</label>
                        <input class="form-control" type="text" wire:model.debounce.250ms="business_name" placeholder="Business Name:">
                        @error('business_name') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6 form-group mb-3">
                        <label>Your Name</label>
                        <input class="form-control" type="text" wire:model.debounce.250ms="name" placeholder="Your Name">
                        @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="form-group">
                            <label class="control-label">Profile Photo (517.38*492 jpg)</label>
                            <div class="custom-file">
                                <input type="file" wire:model.lazy="profile_photo" x-ref="image">
                                @if (!$profile_photo)
                                    @if($ProfileSetting)
                                        <img src="{{ asset('storage/photo/'.$ProfileSetting->profile_photo)}}"  style="height:30px; weight:30px;" alt="Image" class="img-circle img-fluid">
                                    @endif
                                @endif
                                @if ($profile_photo)
                                    <img src="{{ $profile_photo->temporaryUrl() }}" style="height:30px; weight:30px;" alt="Image" class="img-circle img-fluid">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="form-group">
                            <label class="control-label">Logo (517.38*492 jpg)</label>
                            <div class="custom-file">
                                <input type="file" wire:model.lazy="logo" x-ref="image">
                                @if (!$logo)
                                    @if($ProfileSetting)
                                      <img src="{{ asset('storage/photo/'.$ProfileSetting->logo)}}"  style="height:30px; weight:30px;" alt="Image" class="img-circle img-fluid">
                                    @endif
                                @endif
                                @if ($logo)
                                    <img src="{{ $logo->temporaryUrl() }}" style="height:30px; weight:30px;" alt="Image" class="img-circle img-fluid">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 form-group mb-3">
                        <label>Email</label>
                        <input class="form-control" type="text" wire:model.debounce.250ms="email" placeholder="Enter Your Email">
                        @error('email') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6 form-group mb-3">
                        <label>Mobile No</label>
                        <input class="form-control" type="text" wire:model.debounce.250ms="mobile" placeholder="Enter Mobile No">
                        @error('mobile') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6 form-group mb-3">
                        <label>Telephone</label>
                        <input class="form-control" type="text" wire:model.debounce.250ms="telephone" placeholder="Enter Telephone No">
                        @error('mobile') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6 form-group mb-3">
                        <label>TRN No</label>
                        <input class="form-control" type="text" wire:model.debounce.250ms="trn_no" placeholder="Enter TRN No">
                        @error('trn_no') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6 form-group mb-3">
                        <label>Address</label>
                        <input class="form-control" type="text" wire:model.debounce.250ms="address" placeholder="Enter Address">
                        @error('address') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <label>Country</label>
                        <select style="min-width: 100%;" wire:change="GetCurrentCountry($event.target.value)" class="form-control">
                            <option value="">Select Country</option>
                            @foreach ($all_countries as $key=>$country_name)
                            <option value="{{$key}}" @if($key==$country) selected @endif>{{$country_name}}</option>
                            @endforeach
                        </select>
                        {{-- @error('country') <span class="error text-danger">{{ $message }}</span> @enderror --}}
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <label>City</label>

                        <input class="form-control" type="text" wire:model.lazy="city" placeholder="City">
                        @error('city') <span class="error text-danger">{{ $message }}</span> @enderror
                        {{-- <select style="min-width: 100%;" wire:change="GetCurrentCity($event.target.value)" class="form-control">
                            @foreach ($states as $country_state)
                                <option value="{{$country_state}}" @if($country_state==$city) selected @endif>{{$country_state}}</option>
                            @endforeach
                        </select> --}}
                        {{-- @error('city') <span class="error text-danger">{{ $message }}</span> @enderror --}}
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <label>Postal Code</label>
                        <input class="form-control" type="text" wire:model.debounce.250ms="postal_code" placeholder="Enter Postal Code">
                        @error('postal_code') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-12 form-group mb-3">
                        <label>Website</label>
                        <input class="form-control" type="text" wire:model.debounce.250ms="website" placeholder="Enter Website">
                        @error('website') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-12 form-group mb-3">
                    <center><button type="submit" class="btn btn-primary">Save Profile</button></center>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {

                $('#country').change(function() {
                    loadState($(this).find(':selected').val())
                })
                $('#state').change(function() {
                    loadCity($(this).find(':selected').val())
                })
            });
            function loadCountry() {
                $.ajax({
                    type: "POST",
                    url: "ajax.php",
                    data: "get=country"
                }).done(function(result) {

                    $(result).each(function() {
                        $("#country").append($(result));
                    })
                });
            }
            function loadState(countryId) {
                $("#state").children().remove()
                $.ajax({
                    type: "POST",
                    url: "ajax.php",
                    data: "get=state&countryId=" + countryId
                }).done(function(result) {

                    $("#state").append($(result));

                });
            }
            function loadCity(stateId) {
                $("#city").children().remove()
                $.ajax({
                    type: "POST",
                    url: "ajax.php",
                    data: "get=city&stateId=" + stateId
                }).done(function(result) {

                    $("#city").append($(result));

                });
            }

            // init the countries
            loadCountry();
        </script>
@endpush
