<?php

namespace App\Http\Livewire\Inventory;
use App\Models\Setting\ProfileSetting;
use Livewire\Component;

class DelieveryNote extends Component
{
    public function render()
    {
        return view('livewire.inventory.delievery-note',[
         'profilesetting' => ProfileSetting::first(),
        ]);
    }
}
