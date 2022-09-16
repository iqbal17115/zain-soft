<?php

namespace App\Http\Livewire\Inventory;

use App\Models\AccountSettings\Branch;
use App\Models\AccountSettings\Vat;
use App\Models\Stock\Category;
use App\Models\Stock\Item;
use App\Models\Stock\Unit;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ServiceName extends Component
{
    public $code;
    public $name;
    public $type;
    public $sale_price;
    public $service_id;
    public $branch_id;
    public $category_id;
    public $brand_id = 0;
    public $vat_id;
    public $unit_id;
    public $status = 1;

    public function ServiceSave()
    {
        $this->validate([
           'code' => 'required',
           'name' => 'required',
           'sale_price' => 'required',
        //    'category_id' => 'required',
           'branch_id' => 'required',
           'unit_id' => 'required',
           'vat_id' => 'required',
           'status' => 'required',
        ]);

        if ($this->service_id) {
            $Query = Item::find($this->service_id);
        } else {
            $Query = new Item();
            $Query->user_id = Auth::id();
        }
        $Query->code = $this->code;
        $Query->type = 'Service';
        $Query->name = $this->name;
        $Query->branch_id = $this->branch_id;
        $Query->unit_id = $this->unit_id;
        $Query->vat_id = $this->vat_id;
        $Query->sale_price = $this->sale_price;
        $Query->branch_id = Auth::user()->branch_id;
        $Query->company_id = Auth::user()->company_id;
        $Query->status = $this->status;
        // if($Query->type='Sevice'){
        //     $Query->brand_id = null;
        // }
        $Query->save();
        $this->ServiceNameModal();
        $this->emit('success', [
           'text' => 'Service C\U Successfully',
        ]);
    }

    public function ServiceEdit($id)
    {
        $Query = Item::find($id);
        $this->service_id = $Query->id;
        $this->code = $Query->code;
        $this->name = $Query->name;
        $this->branch_id = $Query->branch_id;
        $this->vat_id = $Query->vat_id;
        $this->unit_id = $Query->unit_id;
        $this->sale_price = $Query->sale_price;
        $this->status = $Query->status;
        $this->emit('modal', 'ServiceNameModal');
    }

    public function ServiceDelete($id)
    {
        Item::find($id)->delete();
        $this->emit('success', [
              'text' => 'Service Deleted Successfully',
            ]);
    }

    public function GenerateCode()
    {
        $check_row = Item::orderBy('id', 'desc')->first();
        if (!$check_row) {
            $this->code = 'S001';
        } else {
            $this->code = ++$check_row->id;
            if ($this->code <= 9) {
                $this->code = 'S00'.$this->code;
            } elseif ($this->code <= 99) {
                $this->code = 'S0'.$this->code;
            } else {
                $this->code = 'S'.$this->code;
            }
        }
        // dd($this->code);
    }

    public function ServiceNameModal()
    {
        $this->reset();
        $this->GenerateCode();
        $this->emit('modal', 'ServiceNameModal');
    }

    public function render()
    {
        return view('livewire.inventory.service-name', [
            'branches' => Branch::whereCompanyId(Auth::user()->company_id)->get(),
            'vats' => Vat::whereCompanyId(Auth::user()->company_id)->get(),
            'categories' => Category::whereCompanyId(Auth::user()->company_id)->get(),
            'units' => Unit::whereCompanyId(Auth::user()->company_id)->get(),
        ]);
    }
}
