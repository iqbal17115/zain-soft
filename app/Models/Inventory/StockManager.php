<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Stock\Item;
use App\Models\Billing\Invoice;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockManager extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    public function Item(){
        return $this->belongsTo(Item::class);
    }

    public function Invoice(){
        return $this->belongsTo(Invoice::class);
    }

}
