<?php

namespace App\Models\Billing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contact\Contact;
use App\Models\Stock\StockManager;
use App\Models\Stock\ItemInvoice;
use App\Models\Accounts\AccountManager;
use App\Models\AccountSettings\Branch;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function InvoicePaidAmount(){
        return $this->hasMany(AccountManager::class)->where('payment_status','!=','Inactive');
    }
    public function AccountManager(){
        return $this->hasMany(AccountManager::class);
    }
    public function Branch(){
        return $this->belongsTo(Branch::class);
    }
    public function StockItemInvoice(){
        return $this->hasMany(ItemInvoice::class);
    }
    public function ItemInvoice(){
        return $this->hasOne(ItemInvoice::class);
    }
    public function StockManager1(){
        return $this->hasOne(StockManager::class);
    }
    public function StockManager(){
        return $this->hasMany(StockManager::class);
    }
    public function Contact()
    {
        return $this->belongsTo(Contact::class);
    }
    public function Invoice()
    {
        return $this->belongsTo(Invoice::class,'invoice_id');
    }

}
