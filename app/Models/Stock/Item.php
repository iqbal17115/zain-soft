<?php

namespace App\Models\Stock;
use App\Models\Stock\StockManager;
use App\Models\Inventory\Unit;
use App\Models\Inventory\Category;
use App\Models\Inventory\Brand;
use App\Models\AccountSettings\Vat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    public function StockManager1(){
        return $this->hasOne(StockManager::class);
    }
    public function StockManager(){
        return $this->hasMany(StockManager::class);
    }
    public function Unit(){
        return $this->belongsTo(Unit::class);
    }
    public function Vat(){
        return $this->belongsTo(Vat::class);
    }
    public function Category(){
        return $this->belongsTo(Category::class);
    }

    public function Brand(){
        return $this->belongsTo(Brand::class);
    }

    public function StockManagerIn()
    {
        return $this->hasMany(StockManager::class)->whereFlow('In');
    }

    public function StockManagerOut()
    {
        return $this->hasMany(StockManager::class)->whereFlow('Out');
    }

}
