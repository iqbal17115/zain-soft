<?php

namespace App\Models\AccountSettings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AccountSettings\Branch;
use App\Models\Stock\Item;
use Illuminate\Database\Eloquent\SoftDeletes;
use NumberToWords\Legacy\Numbers\Words\Locale\It;

class Vat extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    public function Branch(){
        return $this->belongsTo(Branch::class);
    }

    public function CheckVat(){
        return $this->hasOne(Item::class);
    }
}
