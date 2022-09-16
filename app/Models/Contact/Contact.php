<?php

namespace App\Models\Contact;

use App\Models\Accounts\AccountManager;
use App\Models\Stock\StockManager;
use App\Models\AccountSettings\Branch;
use App\Models\Billing\Invoice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function StockManager()
    {
        return $this->hasOne(StockManager::class);
    }

    public function ReceivablePayableCrBalance()
    {
        return $this->hasMany('App\Models\Accounts\AccountManager', 'contact_id', 'id')->whereNotNull('cr_account_id');
    }

    public function ReceivablePayableDrBalance()
    {
        return $this->hasMany('App\Models\Accounts\AccountManager', 'contact_id', 'id')->whereNotNull('dr_account_id');
    }

    public function CrBalance()
    {
        return $this->hasMany('App\Models\Accounts\AccountManager', 'cr_account_id', 'id');
    }

    public function SaleInvoice()
    {
        return $this->hasMany('App\Models\Billing\Invoice', 'contact_id', 'id')->whereType('Sales');
    }

    public function PurchaseInvoice()
    {
        return $this->hasMany('App\Models\Billing\Invoice', 'contact_id', 'id')->whereType('Purchase');
    }

    public function InvoicePaidAmount()
    {
        return $this->hasMany(AccountManager::class)->where('payment_status', '!=', 'Inactive');
    }

    public function CheckStockManager(){
        return $this->hasOne(StockManager::class);
    }

    public function CheeckInvoice(){
        return $this->hasOne(Invoice::class);
    }

}
