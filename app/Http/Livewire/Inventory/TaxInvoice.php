<?php

namespace App\Http\Livewire\Inventory;
use App\Models\Billing\Invoice;
use App\Models\AccountSettings\ProfileSetting;
use App\Models\Inventory\StockManager;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TaxInvoice extends Component
{
    public function render()
    {
        return view('livewire.inventory.tax-invoice',[
          'profilesettings' => ProfileSetting::whereCompanyId(Auth::user()->company_id)->get(),
          'invoices' => Invoice::whereCompanyId(Auth::user()->company_id)->latest()->get(),
          'stockmanagers' => StockManager::whereCompanyId(Auth::user()->company_id)->get(),
        ])->layout('layouts.invoice-master');
    }
}
