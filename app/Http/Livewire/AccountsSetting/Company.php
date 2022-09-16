<?php

namespace App\Http\Livewire\AccountsSetting;

use App\Models\Setting\Company as CompanyData;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Company extends Component
{
    use WithFileUploads;
    public $code;
    public $name;
    public $address;
    public $telephone;
    public $postal_code;
    public $mobile;
    public $email;
    public $trn;
    public $country;
    public $web_address;
    public $logo;
    public $user_id;
    public $status ="Active";
    public $CompanyId;
    public $QueryUpdate;

    public function CompanyInfoSave()
    {
        $this->validate([
            'code' => 'required',
            'name' => 'required',
            'address' => 'required',
            'status' => 'required',
        ]);

        if ($this->CompanyId) {
            $Query = CompanyData::find($this->CompanyId);
        } else {

            $Query = new CompanyData();
            $Query->user_id = Auth::user()->id;
        }

        $Query->code = $this->code;
        $Query->name = $this->name;
        $Query->address = $this->address;
        $Query->status = $this->status;
        $Query->telephone = $this->telephone;
        $Query->mobile = $this->mobile;
        $Query->postal_code = $this->postal_code;
        $Query->country = $this->country;
        $Query->email = $this->email;
        $Query->trn = $this->trn;
        $Query->web_address = $this->web_address;
        if ($this->logo) {
            $path = $this->logo->store('/public/photo');
            $Query->logo = basename($path);
        }
        $Query->save();
        $this->CompanyInfoModel();
        $this->emit('success', [
            'text' => 'Company C/U Successfully',
        ]);
    }

    public function CompanyInfoEdit($id)
    {
        $this->QueryUpdate = CompanyData::find($id);
        $this->CompanyId = $this->QueryUpdate->id;
        $this->code = $this->QueryUpdate->code;
        $this->name = $this->QueryUpdate->name;
        $this->address = $this->QueryUpdate->address;
        $this->telephone = $this->QueryUpdate->telephone;
        $this->mobile = $this->QueryUpdate->mobile;
        $this->postal_code = $this->QueryUpdate->postal_code;
        $this->email = $this->QueryUpdate->email;
        $this->country = $this->QueryUpdate->country;
        $this->trn = $this->QueryUpdate->trn;
        $this->web_address = $this->QueryUpdate->web_address;
        $this->status = $this->QueryUpdate->status;
        $this->emit('modal', 'CompanyInfoModel');
    }

    public function CompanyInfoDelete($id)
    {
        CompanyData::find($id)->delete();
        $this->emit('success', [
            'text' => 'company Info deleted successfully',
        ]);
    }
    public function GenerateCode()
    {
        $check_row = CompanyData::orderBy('id', 'desc')->first();
        if (!$check_row) {
            $this->code = "C001";
        } else {
            $this->code = ++$check_row->id;
            if ($this->code <= 9) {
                $this->code = "C00" . $this->code;
            } else if ($this->code <= 99) {
                $this->code = "C0" . $this->code;
            } else {
                $this->code = "C" . $this->code;
            }
        }
        // dd($this->code);
    }
    public function CompanyInfoModel()
    {
        $this->reset();
        $this->GenerateCode();
        $this->emit('modal', 'CompanyInfoModel');
    }
    public function render()
    {
        return view('livewire.accounts-setting.company');
    }
}
