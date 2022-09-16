<?php

namespace App\Http\Livewire\Inventory;

use App\Models\Stock\Unit as UnitInfo;
use Illuminate\Support\Facades\Auth;
use App\Models\AccountSettings\Branch;
use Livewire\Component;

class Unit extends Component
{
    public $code;
    public $name;
    public $rate;
    public $status=1;
    public $unit_id;
    public $branch_id;
    public $company_id;

    public function UnitSave()
    {
        // dd('oke');
        $this->validate([
            'code' => 'required',
            'name' => 'required',
            // 'rate' => 'required',
            'status' => 'required',
        ]);

        if($this->unit_id){
           $Query = UnitInfo::find($this->unit_id);
        }else{
            $Query  = new UnitInfo();
            $Query->user_id = Auth::id();
        }

        $Query->code = $this->code;
        $Query->name = $this->name;
        // $Query->rate = $this->rate;
        $Query->status = $this->status;
        $Query->branch_id  = Auth::user()->branch_id ;
        $Query->company_id = Auth::user()->company_id;
        $Query->save();
        $this->UnitModal();
        $this->emit('success', [
            'text' => 'Category C\U Successfully',
        ]);
    }


    public function UnitEdit($id)
    {
        $Query  = UnitInfo::find($id);
        $this->unit_id = $Query->id;
        $this->code    = $Query->code;
        $this->name    = $Query->name;
        $this->status    = $Query->status;
        // $this->rate    = $Query->rate;
        $this->emit('modal', 'UnitModal');
    }
    public function GenerateCode(){
        $check_row=UnitInfo::orderBy('id', 'desc')->first();
        if(!$check_row){
          $this->code="U001";
        }else{
          $this->code=++$check_row->id;
          if($this->code<=9){
            $this->code="U00".$this->code;
          }else if($this->code<=99){
            $this->code="U0".$this->code;
          }else{
            $this->code="U".$this->code;
          }
        }
        // dd($this->code);
    }
    public function UnitDelete($id)
    {
        UnitInfo::find($id)->delete();
        $this->emit('success', [
            'text' => 'Unit Deleted Successfully',
        ]);
    }

    public function UnitModal()
    {
        $this->reset();
        $this->GenerateCode();
        $this->emit('modal', 'UnitModal');
    }

    public function render()
    {
        return view('livewire.inventory.unit',[
            'branches' => Branch::whereCompanyId(Auth::user()->company_id)->get()
        ]);
    }
}
