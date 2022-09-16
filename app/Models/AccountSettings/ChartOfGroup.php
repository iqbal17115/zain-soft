<?php

namespace App\Models\AccountSettings;
use App\Models\AccountSettings\ChartOfSection;
use App\Models\AccountSettings\ChartOfAccount;
use App\Models\AccountSettings\EntryTypeAccountList;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChartOfGroup extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function ChartOfSection()
    {
        return $this->belongsTo(ChartOfSection::class);
    }

    public function EntryTypeAccountList()
    {
        return $this->hasOne(EntryTypeAccountList::class);
    }

    public function ChartOfAccount()
    {
        return $this->hasMany(ChartOfAccount::class);
    }

    public function CheckChartOfAccount(){
        return $this->hasOne(ChartOfAccount::class);
    }
}
