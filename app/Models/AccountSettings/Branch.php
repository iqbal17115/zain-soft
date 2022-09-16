<?php

namespace App\Models\AccountSettings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Setting\Company;

class Branch extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    public function Currency(){
        return $this->belongsTo(Currency::class);
    }
    public function Company(){
        return $this->belongsTo(Company::class);
    }
}
