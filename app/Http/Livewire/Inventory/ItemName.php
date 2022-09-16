<?php

namespace App\Http\Livewire\Inventory;

use App\Models\Accounts\AccountManager;
use App\Models\AccountSettings\ChartOfAccount;
use App\Models\AccountSettings\Vat;
use App\Models\Inventory\StockManager;
use App\Models\Stock\Brand;
use App\Models\Stock\Category;
use App\Models\Stock\Item;
use App\Models\Stock\Unit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ItemName extends Component
{
    public $code;
    public $purchase_price;
    public $name;
    public $opening_stock;
    public $discount;
    public $sale_price;
    public $low_stock_alert;
    public $is_stock_check;
    public $is_stock_check_disable;
    public $whole_sale_price;
    public $category_id;
    public $brand_id;
    public $item_id;
    public $unit_id;
    public $vat_id;
    public $branch_id;
    public $company_id;
    public $status = 1;

    public function ItemSave()
    {
        $this->validate([
            'code' => 'required',
            'purchase_price' => 'required',
            'name' => 'required',
            'category_id' => 'required',
            'vat_id' => 'required',
            'unit_id' => 'required',
            'status' => 'required',
        ]);

        if ($this->item_id) {
            $Query = Item::find($this->item_id);
        } else {
            $Query = new Item();
            $Query->user_id = Auth::id();
        }
        $Query->code = $this->code;
        $Query->category_id = $this->category_id;
        $Query->brand_id = $this->brand_id;
        $Query->unit_id = $this->unit_id;
        $Query->vat_id = $this->vat_id;
        $Query->name = $this->name;
        $Query->purchase_price = $this->purchase_price;
        $Query->type = 'Product';
        $Query->opening_stock = $this->opening_stock;
        $Query->discount = $this->discount;
        $Query->branch_id = Auth::user()->branch_id;
        $Query->company_id = Auth::user()->company_id;
        $Query->sale_price = $this->sale_price;
        $Query->low_stock_alert = $this->low_stock_alert;
        $Query->is_stock_check = $this->is_stock_check;
        $Query->status = $this->status;
        $Query->whole_sale_price = $this->whole_sale_price;
        $Query->save();

        if ($this->opening_stock) {
            $openBalanceChartId = ChartOfAccount::whereDefaultModule(7)->first('id')->id;
            $purchaseChartId = ChartOfAccount::whereDefaultModule(2)->first('id')->id;

            if ($openBalanceChartId) {
                $LedgerEntry = AccountManager::whereItemId($Query->id);
                $LedgerEntry->where('dr_account_id', $purchaseChartId);
                $LedgerEntry->where('cr_account_id', $openBalanceChartId);
                $LedgerEntry = $LedgerEntry->firstOrNew();

                $LedgerEntry->amount = $this->opening_stock * $this->purchase_price;
                $LedgerEntry->user_id = Auth::id();
                $LedgerEntry->date = Carbon::now();
                $LedgerEntry->code = $this->code;
                $LedgerEntry->item_id = $Query->id;
                $LedgerEntry->type = 'Debit';
                $LedgerEntry->dr_account_id = $purchaseChartId;
                $LedgerEntry->cr_account_id = $openBalanceChartId;
                $LedgerEntry->branch_id = Auth::user()->branch_id;
                $LedgerEntry->company_id = Auth::user()->company_id;
                $LedgerEntry->save();
            }

            $stockManager = StockManager::whereItemId($Query->id)->whereIsOpeningStock(1)->firstOrnew();
            $stockManager->code = 123;
            $stockManager->date = Carbon::now();
            $stockManager->item_id = $Query->id;
            $stockManager->category_id = $this->category_id;
            $stockManager->unit_id = $this->unit_id;
            $stockManager->is_opening_stock = 1;
            $stockManager->flow = 'In';
            $stockManager->quantity = $this->opening_stock;
            $stockManager->purchase_price = $this->purchase_price;
            $stockManager->sale_price = $this->sale_price;
            $stockManager->subtotal = $this->opening_stock * $this->purchase_price;
            $stockManager->status = 1;
            $stockManager->user_id = Auth::id();
            $stockManager->branch_id = Auth::user()->branch_id;
            $stockManager->company_id = Auth::user()->company_id;
            $stockManager->save();
        }
        $this->ItemModal();
        $this->emit('success', [
            'text' => 'Item C\U Successfully',
        ]);
    }

    public function ItemEdit($id)
    {
        $Query = item::find($id);
        $this->item_id = $Query->id;
        $this->code = $Query->code;
        $this->category_id = $Query->category_id;
        $this->brand_id = $Query->brand_id;
        $this->unit_id = $Query->unit_id;
        $this->vat_id = $Query->vat_id;
        $this->name = $Query->name;
        $this->purchase_price = $Query->purchase_price;
        $this->opening_stock = $Query->opening_stock;
        $this->discount = $Query->discount;
        $this->sale_price = $Query->sale_price;
        $this->low_stock_alert = $Query->low_stock_alert;
        $this->is_stock_check = $Query->is_stock_check;
        $this->status = $Query->status;
        $this->whole_sale_price = $Query->whole_sale_price;
        $this->emit('modal', 'ItemModal');
    }

    public function ItemDelete($id)
    {
        Item::find($id)->delete();
        $this->emit('success', [
           'text' => 'Item Deleted Successfully',
        ]);
    }

    public function GenerateCode()
    {
        $check_row = Item::orderBy('id', 'desc')->first();
        if (!$check_row) {
            $this->code = 'I001';
        } else {
            $this->code = ++$check_row->id;
            if ($this->code <= 9) {
                $this->code = 'I00'.$this->code;
            } elseif ($this->code <= 99) {
                $this->code = 'I0'.$this->code;
            } else {
                $this->code = 'I'.$this->code;
            }
        }
        // dd($this->code);
    }

    public function ItemModal()
    {
        $this->reset();
        $this->GenerateCode();
        $this->emit('modal', 'ItemModal');
    }

    public function render()
    {
        return view('livewire.inventory.item-name', [
            'categories' => Category::whereCompanyId(Auth::user()->company_id)->get(),
            'brands' => Brand::whereCompanyId(Auth::user()->company_id)->get(),
            'units' => Unit::whereCompanyId(Auth::user()->company_id)->get(),
            'vats' => Vat::whereCompanyId(Auth::user()->company_id)->get(),
        ]);
    }
}
