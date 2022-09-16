<?php

namespace App\Models\AccountSettings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChartOfAccount extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function EntryTypeAccountList($entryTypeid=null)
    {
        // dd($entryTypeid);
        return $this->hasOne(EntryTypeAccountList::class,'chart_of_account_id','id')->where('entry_type_id',1);
    }

    public function ChartOfGroup()
    {
        return $this->belongsTo(ChartOfGroup::class);
    }

    public function CrBalanceCheck()
    {
        return $this->hasOne('App\Models\Accounts\AccountManager', 'cr_account_id');
    }

    public function DrBalanceCheck()
    {
        return $this->hasOne('App\Models\Accounts\AccountManager', 'dr_account_id');
    }

    public function CrBalance()
    {
        return $this->hasMany('App\Models\Accounts\AccountManager', 'cr_account_id', 'id');
    }

    public function DrBalance()
    {
        return $this->hasMany('App\Models\Accounts\AccountManager', 'dr_account_id', 'id');
    }

    public function InputVatTotal($start = null, $end = null)
    {
        if ($start && $end) {
            return $this->hasMany('App\Models\Accounts\AccountManager', 'dr_account_id', 'id')->whereBetween('date', [$start, $end])->sum('amount');
        } else {
            return $this->hasMany('App\Models\Accounts\AccountManager', 'dr_account_id', 'id')->sum('amount');
        }
    }

    public function OutputVatTotal($start = null, $end = null)
    {
        if ($start && $end) {
            return $this->hasMany('App\Models\Accounts\AccountManager', 'cr_account_id', 'id')->whereBetween('date', [$start, $end])->sum('amount');
        } else {
            return $this->hasMany('App\Models\Accounts\AccountManager', 'cr_account_id', 'id')->sum('amount');
        }
    }
}
