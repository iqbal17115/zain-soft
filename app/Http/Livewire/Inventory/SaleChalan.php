<?php

namespace App\Http\Livewire\Inventory;
use Livewire\Component;

class SaleChalan extends Component
{
    public function render()
    {
        return view('livewire.inventory.sale-chalan')->layout('layouts.invoice-master');
    }
}
