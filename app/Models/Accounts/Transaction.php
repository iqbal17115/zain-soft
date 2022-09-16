<?php

namespace App\Models\Accounts;

use App\Models\AccountSettings\ChartOfAccount;
use App\Models\Billing\Invoice;
use App\Models\Contact\Contact;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    public function Contact(){
        return $this->belongsTo(Contact::class);
    }
    public function ChartOfAccount(){
        return $this->belongsTo(ChartOfAccount::class);
    }
    public function Invoice(){
        return $this->belongsTo(Invoice::class);
    }

    public function InvoiceId()
    {
        return $this->belongsTo(Invoice::class,'invoice_ids');
    }
}
