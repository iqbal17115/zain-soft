<?php

namespace App\Http\Livewire\Reports;
use App\Models\Stock\Item;
use App\Models\Inventory\Category;
use App\Models\Inventory\Brand;
use App\Models\AccountSettings\Branch;
use App\Models\AccountSettings\Warehouse;
use App\Traits\ProfitLoss;
use App\Traits\Stock;
use Carbon\Carbon;
use Livewire\Component;

class LowStockAlert extends Component
{
    use ProfitLoss;
    use Stock;
    public $type;
    public $branch_id;
    public $category_id;
    public $brand_id;

    public function render()
    {
        $items=Item::orderBy('id', 'desc');
        if($this->type){
            $items=Item::whereType($this->type);
        }
        if($this->branch_id){
            $items=Item::whereType($this->branch_id);
        }
        return view('livewire.reports.low-stock-alert',[
            'items'=>$items->paginate(20),
            'branches' => Branch::get(),
            'warehouses' => Warehouse::get(),
            'categories' => Category::get(),
            'brands'     => Brand::get(),
        ]);
    }
}
