<?php

namespace App\Http\Livewire\AccountsSetting;
use App\Models\AccountSettings\Branch as BranchInfo;
use App\Models\AccountSettings\Currency;
use App\Models\Setting\Company;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Livewire\Component;

class Branch extends Component
{
    use WithFileUploads;
    public $code;
    public $name;
    public $address;
    public $mobile;
    public $status=1;
    public $branch_id;
    public $company_id;
    public $telephone;
    public $web_address;
    public $trn_no;
    public $type;
    public $currency_id;
    public $email;
    public $logo;
    public $QueryUpdate;

    public function BranchSave(){
        // dd('oke');
        $this->validate([
          'code'   => 'required',
          'name'   => 'required',
          'address'=> 'required',
          'mobile' => 'required',
          'status' => 'required',
          'company_id' => 'required',
        //   'currency_id' => 'required',
        ]);
        if($this->branch_id){
          $Query = BranchInfo::find($this->branch_id);
        }else{
            $Query = new BranchInfo();
            $Query->user_id = Auth::id();
        }

        $Query->code = $this->code;
        $Query->name = $this->name;
        $Query->email = $this->email;
        $Query->address = $this->address;
        if($this->logo){
            $path = $this->logo->store('/public/photo');
            $Query->logo = basename($path);
        }
        $Query->mobile = $this->mobile;
        $Query->status = $this->status;
        $Query->telephone = $this->telephone;
        $Query->web_address = $this->web_address;
        $Query->trn_no = $this->trn_no;
        $Query->type = $this->type;
        $Query->currency_id = $this->currency_id;
        $Query->company_id = Auth::user()->company_id;
        $Query->save();
        $this->BranchModel();
        $this->emit('success',[
            'text' => 'Brand C\U Successfully',
        ]);
    }

    public function BranchEdit($id){
        $this->QueryUpdate = BranchInfo::find($id);
        $this->branch_id = $this->QueryUpdate->id;
        $this->code = $this->QueryUpdate->code;
        $this->name = $this->QueryUpdate->name;
        $this->email = $this->QueryUpdate->email;
        $this->address = $this->QueryUpdate->address;
        $this->mobile = $this->QueryUpdate->mobile;
        $this->status = $this->QueryUpdate->status;
        $this->telephone = $this->QueryUpdate->telephone;
        $this->web_address = $this->QueryUpdate->web_address;
        $this->trn_no = $this->QueryUpdate->trn_no;
        $this->type = $this->QueryUpdate->type;
        $this->company_id = $this->QueryUpdate->company_id;
        $this->currency_id = $this->QueryUpdate->currency_id;
        $this->emit('modal', 'BranchModel');
    }

    public function BranchDelete($id){
        BranchInfo::find($id)->delete();
        $this->emit('success',[
          'text' => 'Branch deleted successfully',
        ]);
    }
    public function GenerateCode(){
        $check_row=BranchInfo::orderBy('id', 'desc')->first();
        if(!$check_row){
          $this->code="B001";
        }else{
          $this->code=++$check_row->id;
          if($this->code<=9){
            $this->code="B00".$this->code;
          }else if($this->code<=99){
            $this->code="B0".$this->code;
          }else{
            $this->code="B".$this->code;
          }
        }
        // dd($this->code);
    }
    public function BranchModel(){
        $this->reset();
        $this->GenerateCode();
        $this->emit('modal', 'BranchModel');
    }

    public function render()
    {
        return view('livewire.accounts-setting.branch',[
            'Company'=>Company::all(),
            'Currency'=>Currency::whereCompanyId(Auth::user()->company_id)->get(),
        ]);
    }
}
