<?php

namespace App\Http\Livewire\Inventory;
use App\Models\Stock\Item;
use Livewire\Component;

class GenerateBarcode extends Component
{
    public $Item;
    public $warehouse_id;
    public $item_rate;
    public $orderItemList=[];
    protected $listeners = [
        'item_search' => 'AddPurchaseItem',
    ];
    public function removeItem($itemId)
    {
        $cart = collect($this->orderItemList);
        $cart->pull($itemId);
        $this->orderItemList = $cart;
    }
    public function AddPurchaseItem($item)
    {
        $cart = collect($this->orderItemList);
        if (isset($cart[$item['id']])) {
            $cart[$item['id']] = $item;
        } else {
            $cart[$item['id']] = $item;
            $this->Item=Item::find($item['id']);
        }
        $this->orderItemList = $cart->toArray();
    }
    public function render()
    {
        return view('livewire.inventory.generate-barcode');
    }
}
