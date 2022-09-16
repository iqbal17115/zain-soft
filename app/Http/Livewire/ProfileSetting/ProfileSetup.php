<?php

namespace App\Http\Livewire\ProfileSetting;

use App\Models\AccountSettings\ProfileSetting;
use Illuminate\Support\Facades\Auth;
use CountryState;
use Livewire\WithFileUploads;
use Livewire\Component;

class ProfileSetup extends Component
{
    use WithFileUploads;
    public $business_name;
    public $name;
    public $profile_photo;
    public $logo;
    public $email;
    public $mobile;
    public $telephone;
    public $trn_no;
    public $address;
    public $postal_code;
    public $country;
    public $website;
    public $city;
    public $all_countries;
    public $states;
    public $ProfileSetting = null;

    public function GetCurrentCountry($country)
    {
        // $this->states = CountryState::getStates($country);
        $this->country = $country;
    }
    // public function GetCurrentCity($city)
    // {
    //     $this->city = $city;
    // }
    public function mount()
    {

        $this->all_countries = CountryState::getCountries();
        $this->ProfileSetting = ProfileSetting::first();
        // if ($this->ProfileSetting) {
        //     $this->states = CountryState::getStates($this->ProfileSetting->country);
        // } else {
        //     $this->states = CountryState::getStates("AD");
        // }
        // dd($this->ProfileSetting);
        if ($this->ProfileSetting) {
            $this->business_name = $this->ProfileSetting->business_name;
            $this->name = $this->ProfileSetting->name;
            $this->email = $this->ProfileSetting->email;
            $this->mobile = $this->ProfileSetting->mobile;
            $this->telephone = $this->ProfileSetting->telephone;
            $this->trn_no = $this->ProfileSetting->trn_no;
            $this->address = $this->ProfileSetting->address;
            $this->postal_code = $this->ProfileSetting->postal_code;
            $this->city = $this->ProfileSetting->city;
            // dd($this->city);
            $this->country = $this->ProfileSetting->country;
            // if($this->ProfileSetting->country){
            //    $this->country = $this->ProfileSetting->country;
            // }
            $this->website = $this->ProfileSetting->website;
        }
    }

    public function ProfileSave()
    {
        // dd(true);
        $this->validate([
            'business_name' => 'required',
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            // 'txn_no' => 'required',
            // 'address' => 'required',
            // 'postal_code' => 'required',
            // 'city' => 'required',
            // 'country' => 'required',
            // 'website' => 'required',
        ]);
        if ($this->ProfileSetting) {
            $Query = $this->ProfileSetting;
        } else {
            $Query = new ProfileSetting();
            $Query->user_id = Auth::id();
        }
        $Query->business_name = $this->business_name;
        $Query->name = $this->name;
        if ($this->profile_photo) {
            $path = $this->profile_photo->store('/public/photo');
            $Query->profile_photo = basename($path);
        }
        if ($this->logo) {
            $path = $this->logo->store('/public/photo');
            $Query->logo = basename($path);
        }
        $Query->email = $this->email;
        $Query->mobile = $this->mobile;
        $Query->telephone = $this->telephone;
        $Query->trn_no = $this->trn_no;
        $Query->address = $this->address;
        $Query->postal_code = $this->postal_code;
        $Query->city = $this->city;
        $Query->country = $this->country;
        $Query->website = $this->website;
        $Query->save();
        $this->emit('success', ['text' => 'Profile Settings C/U Successfully']);
    }
    public function render()
    {
        // if($this->country){
        //    $this->states=CountryState::getStates($this->country);
        // }
        // dd($this->country);
        //     if(!$this->ProfileSetting){
        //         $states=CountryState::getStates("AD");
        //    }else{
        //         $states=CountryState::getStates($this->country);
        //    }
        return view('livewire.profile-setting.profile-setup');
    }
}
