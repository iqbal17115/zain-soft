<?php

namespace App\Models\Stock;

use App\Models\AccountSettings\Branch;
use App\Models\Billing\Invoice;
use App\Models\Contact\Contact;
use App\Models\Stock\Item;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockManager extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    public function Branch(){
        return $this->belongsTo(Branch::class);
    }
    public function Item(){
        return $this->belongsTo(Item::class);
    }

    public function Invoice(){
        return $this->belongsTo(Invoice::class);
    }

    public function Contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
