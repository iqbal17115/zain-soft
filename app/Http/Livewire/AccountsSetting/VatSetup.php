<?php

namespace App\Http\Livewire\AccountsSetting;

use App\Models\AccountSettings\Vat;
use App\Models\AccountSettings\Branch;
use App\Models\AccountSettings\CompanyInfo;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class VatSetup extends Component
{

    public $code;
    public $name;
    public $rate_percent;
    public $rate_fixed;
    public $status=1;
    public $VatId;

    public function VatSave()
    {
        $this->validate([
          'code' => 'required',
          'name' => 'required',
          'rate_percent' => 'required',
        ]);

        if ($this->VatId) {
            $Query = Vat::find($this->VatId);
        } else {
            $Query = new Vat();
            $Query->user_id = Auth::id();
            $Query->company_id = Auth::user()->company_id;
            $Query->branch_id = Auth::user()->branch_id;
        }
        $Query->code = $this->code;
        $Query->name = $this->name;
        $Query->rate_percent = $this->rate_percent;
        $Query->rate_fixed   = $this->rate_fixed;
        $Query->status = $this->status;
        $Query->save();
        $this->VatModal();
        $this->emit('success', [
            'text' => 'Vat C\U Successfully',
        ]);
    }

    public function VatEdit($id)
    {
        $Query = Vat::find($id);
        $this->VatId = $Query->id;
        $this->code   = $Query->code;
        $this->name   = $Query->name;
        $this->rate_percent = $Query->rate_percent;
        $this->rate_fixed   = $Query->rate_fixed;
        $this->emit('modal', 'VatModal');
    }

    public function VatDelete($id)
    {
        Vat::find($id)->delete();
        $this->emit('success', [
            'text' => 'Currency Deleted Successfully',
        ]);
    }
    public function GenerateCode(){
        $check_row=Vat::orderBy('id', 'desc')->first();
        if(!$check_row){
          $this->code="V001";
        }else{
          $this->code=++$check_row->id;
          if($this->code<=9){
            $this->code="V00".$this->code;
          }else if($this->code<=99){
            $this->code="V0".$this->code;
          }else{
            $this->code="V".$this->code;
          }
        }
        // dd($this->code);
    }
    public function VatModal()
    {
        $this->reset();
        $this->GenerateCode();
        $this->emit('modal', 'VatModal');
    }



    public function render()
    {
        return view('livewire.accounts-setting.vat-setup', [
            'branches' => Branch::whereCompanyId(Auth::user()->company_id)->get(),
            'companies' => CompanyInfo::get()
        ]);
    }
}
