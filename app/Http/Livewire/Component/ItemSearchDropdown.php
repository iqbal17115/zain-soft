<?php

namespace App\Http\Livewire\Component;

use App\Models\Stock\Item;
use Livewire\Component;

class ItemSearchDropdown extends Component
{
    public $search;
    public $type;

    protected $queryString = ['search'];

    public function searchSelect($selected)
    {
        $this->emit('item_search', $selected);
        $this->reset('search');
    }

    public function render()
    {
        $Item = Item::where('code', 'like', '%'.$this->search.'%')->with('Unit')->with('Vat');
        if ($this->type) {
            $Item->where('type', $this->type);
        }
        $Item = $Item->get();

        return view('livewire.component.item-search-dropdown',
        [
            'search_list' => $Item,
        ]
    );
    }
}
