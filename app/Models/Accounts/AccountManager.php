<?php

namespace App\Models\Accounts;

use App\Models\AccountSettings\ChartOfAccount;
use App\Models\Billing\Invoice;
use App\Models\Accounts\Receipt;
use App\Models\Contact\Contact;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountManager extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    public function User(){
        return $this->belongsTo(User::class);
    }
    public function Contact(){
        return $this->belongsTo(Contact::class);
    }
    public function ChartOfAccountDr()
    {
        return $this->belongsTo(ChartOfAccount::class, 'dr_account_id');
    }

    public function ChartOfAccountCr()
    {
        return $this->belongsTo(ChartOfAccount::class, 'cr_account_id');
    }

    public function Invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
    public function Transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function Receipt()
    {
        return $this->belongsTo(Receipt::class);
    }
}
