<?php

namespace App\Models\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Stock\Item;

use Illuminate\Database\Eloquent\Model;

class ItemInvoice extends Model
{
    use HasFactory;
    public function Item(){
        return $this->belongsTo(Item::class);
    }
}

