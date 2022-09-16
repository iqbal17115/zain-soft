<?php

namespace App\Http\Livewire\Reports;
use App\Models\Billing\Invoice;
use App\Models\Contact\Contact;
use App\Models\Inventory\Category;
use App\Models\Inventory\Brand;
use App\Models\AccountSettings\Warehouse;
use App\Models\AccountSettings\Branch;
use App\Models\Stock\Item;
use App\Traits\ProfitLoss as TraitsProfitLoss;
use Carbon\Carbon;
use Livewire\Component;

class ProfitLoss extends Component
{
    use TraitsProfitLoss;
    public $type;
    public $category_id;
    public $brand_id;
    public $from_date;
    public $to_date;
    public $contact_id;
    public $branch_id;

    public function mount(){
        $this->from_date=Carbon::now()->format('Y-m-d');
        $this->to_date=Carbon::now()->format('Y-m-d');
    }
    // public function dateFilter($model){
    //     if($this->from_date && $this->to_date){
    //        return $model->where('date', '>=', Carbon::parse($this->from_date)->format('Y-m-d'))->where('date', '<=', Carbon::parse($this->to_date)->format('Y-m-d'));
    //     }else{
    //        return $model;
    //     }
    // }
    public function render()
    {
        $items=Item::orderBy('id', 'desc');
        if($this->type){
            $items=Item::whereType($this->type);
        }
        if($this->category_id){
            $items=Item::whereCategoryId($this->category_id);
        }
        if($this->brand_id){
            $items=Item::whereBrandId($this->brand_id);
        }

        return view('livewire.reports.profit-loss',[
            'items'=>$items->paginate(20),
            'Customers' => Contact::whereType('Customer')->get(),
            'branches' => Branch::get(),
            'warehouses' => Warehouse::get(),
            'categories' => Category::get(),
            'brands'     => Brand::get(),
        ]);
    }
}
