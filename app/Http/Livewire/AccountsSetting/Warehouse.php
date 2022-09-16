<?php

namespace App\Http\Livewire\AccountsSetting;
use App\Models\AccountSettings\Warehouse as WarehouseInfo;
use App\Models\AccountSettings\Branch;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Warehouse extends Component
{
    public $code;
    public $name;
    public $address;
    public $WarehouseId;
    public $branch_id;
    public $status=1;

    public function WareHouseSave(){
        $this->validate([
           'code' => 'required',
           'name' => 'required',
           'address' => 'required',
           'status' => 'required',
        ]);

        if($this->WarehouseId){
            $Query = WarehouseInfo::find($this->WarehouseId);
        }else{
            $Query   = new WarehouseInfo();
            $Query->user_id = Auth::id();
            $Query->company_id = Auth::user()->company_id;
        }

        $Query->code = $this->code;
        $Query->name = $this->name;
        $Query->address = $this->address;
        $Query->branch_id = $this->branch_id;
        $Query->status = $this->status;
        $Query->save();

        $this->WareHouseModal();
        $this->emit('success',[
            'text' => 'WareHouse C\U Successfully',
      ]);
    }

    public function WareHouseEdit($id){
        $Query = WarehouseInfo::find($id);
        $this->WarehouseId = $Query->id;
        $this->code = $Query->code;
        $this->name = $Query->name;
        $this->address = $Query->address;
        $this->branch_id = $Query->branch_id;
        $this->status = $Query->status;
        $this->emit('modal', 'WareHouseModal');
    }

    public function WareHouseDelete($id){
        WarehouseInfo::find($id)->delete();
          $this->emit('success',[
            'text' => 'WareHouse Deleted Successfully',
      ]);
    }
    public function GenerateCode(){
        $check_row=WarehouseInfo::orderBy('id', 'desc')->first();
        if(!$check_row){
          $this->code="W001";
        }else{
          $this->code=++$check_row->id;
          if($this->code<=9){
            $this->code="W00".$this->code;
          }else if($this->code<=99){
            $this->code="W0".$this->code;
          }else{
            $this->code="W".$this->code;
          }
        }
        // dd($this->code);
    }
    public function WareHouseModal(){
        $this->reset();
        $this->GenerateCode();
        $this->emit('modal', 'WareHouseModal');
    }

    public function render()
    {
        return view('livewire.accounts-setting.warehouse',[
            'branches'=>Branch::get(),
        ]);
    }
}
