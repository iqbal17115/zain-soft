<?php

namespace App\Http\Livewire\Inventory;

use App\Models\Stock\Category as CategoryInfo;
use Illuminate\Support\Facades\Auth;
use App\Models\AccountSettings\Branch;
use Livewire\Component;
use Livewire\WithFileUploads;

class Category extends Component
{
    use WithFileUploads;
    public $code;
    public $name;
    // public $image;
    public $status=1;
    public $CategoryId;
    public $branch_id;
    public $QueryUpdate;
    public $company_id;

    public function CategorySave()
    {
        $this->validate([
            'code' => 'required',
            'name' => 'required',
            'status' => 'required',
        ]);

        if ($this->CategoryId) {
            $Query = CategoryInfo::find($this->CategoryId);
        } else {
            $Query = new CategoryInfo();
            $Query->user_id = Auth::id();
            $Query->branch_id = Auth::user()->branch_id;
            $Query->company_id = Auth::user()->company_id;
        }

        $Query->code = $this->code;
        $Query->name = $this->name;
        // if($this->image){
        //     $path = $this->image->store('/public/photo');
        //     $Query->image = basename($path);
        // }
        $Query->status = $this->status;
        $Query->save();
        $this->CategoryModal();
        $this->emit('success', [
            'text' => 'Category C\U Successfully',
        ]);
    }

    public function CategoryEdit($id)
    {
        $this->QueryUpdate = CategoryInfo::find($id);
        $this->CategoryId = $this->QueryUpdate->id;
        $this->code = $this->QueryUpdate->code;
        $this->branch_id = $this->QueryUpdate->branch_id;
        $this->name = $this->QueryUpdate->name;
        $this->status = $this->QueryUpdate->status;
        $this->emit('modal', 'CategoryModal');
    }

    public function CategoryDelete($id)
    {
        CategoryInfo::find($id)->delete();
        $this->emit('success', [
            'text' => 'WareHouse Deleted Successfully',
        ]);
    }
    public function GenerateCode(){
        $check_row=CategoryInfo::orderBy('id', 'desc')->first();
        if(!$check_row){
          $this->code="C001";
        }else{
          $this->code=++$check_row->id;
          if($this->code<=9){
            $this->code="C00".$this->code;
          }else if($this->code<=99){
            $this->code="C0".$this->code;
          }else{
            $this->code="C".$this->code;
          }
        }
        // dd($this->code);
    }
    public function CategoryModal()
    {
        $this->reset();
        $this->GenerateCode();
        $this->emit('modal', 'CategoryModal');
    }

    public function render()
    {
        return view('livewire.inventory.category',[
            'branches' => Branch::whereCompanyId(Auth::user()->company_id)->get()
        ]);
    }
}
