<?php

namespace App\Models\AccountSettings;
use App\Models\AccountSettings\ChartOfGroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChartOfSection extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function ChartOfGroup()
    {
        return $this->hasMany(ChartOfGroup::class);
    }
}
