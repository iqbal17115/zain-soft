<?php

namespace App\Http\Livewire\Inventory;

use App\Models\Stock\Brand as brandModal;
use Illuminate\Support\Facades\Auth;
use App\Models\AccountSettings\Branch;
use Livewire\Component;

class Brand extends Component
{
    public $code;
    public $name;
    public $status=1;
    public $brand_id;
    public $branch_id;
    public $company_id;

    public function BrandSave()
    {
        $this->validate([
            'code' => 'required',
            'name' => 'required',
            'status' => 'required',
        ]);

        if ($this->brand_id) {
            $Query = brandModal::find($this->brand_id);
        } else {
            $Query = new brandModal();
            $Query->user_id = Auth::id();
        }

        $Query->code = $this->code;
        $Query->name = $this->name;
        $Query->status = $this->status;
        $Query->branch_id = Auth::user()->branch_id;
        $Query->company_id = Auth::user()->company_id;
        $Query->save();
        $this->BrandModal();
        $this->emit('success', [
            'text' => 'Brand C\U Successfully',
        ]);
    }

    public function BrandEdit($id)
    {
        $Query = brandModal::find($id);
        $this->brand_id = $Query->id;
        $this->code = $Query->code;
        $this->name = $Query->name;
        $this->status = $Query->status;
        $this->emit('modal', 'BrandModal');
    }

    public function BrandDelete($id)
    {
        brandModal::find($id)->delete();
        $this->emit('success', [
            'text' => 'Brand Deleted Successfully',
        ]);
    }
    public function GenerateCode(){
        $check_row=brandModal::orderBy('id', 'desc')->first();
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
    public function BrandModal()
    {
        $this->reset();
        $this->GenerateCode();
        $this->emit('modal', 'BrandModal');
    }

    public function render()
    {
        return view('livewire.inventory.brand',[
            'branches' => branch::get()
        ]);
    }
}
