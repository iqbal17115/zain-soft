<?php

namespace App\Http\Livewire\Reports;

use App\Models\AccountSettings\ChartOfAccount;
use App\Models\Billing\Invoice;
use App\Models\Accounts\Transaction;
use App\Models\Setting\Company;
use App\Models\Accounts\Receipt;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Livewire\Component;

class GeneralLedger extends Component
{
    public $testData;
    public $start_date;
    public $company_id;
    public $end_date;
    public $chart_of_account_id;
    public $invoice;
    public $Receipt;
    public $PurchaseReturnInvoice;
    public $ReceiptInvoice;

    public function ReceiptInvoiceShow($id){
        $this->reset(['invoice']);
        $this->Receipt=Receipt::find($id);
        // dd($this->ReceiptInvoice);
        $this->emit('modal', 'InvoiceModal');
    }

    public function InvoicePrint($id){
        $this->reset(['ReceiptInvoice']);
        $this->invoice=Invoice::find($id);
        if($this->invoice->type=="Sales"){
       $this->emit('redirect', [
        'url' => route('inventory.sale-invoice', ['id' => $this->invoice->id]),
       ]);
      }else if($this->invoice->type=="Purchase"){
        $this->emit('redirect', [
            'url' => route('inventory.purchase-invoice', ['id' => $this->invoice->id]),
           ]);
      }else if($this->invoice->type=="Sales Return"){
        $this->emit('redirect', [
            'url' => route('inventory.sale-return-invoice', ['id' => $this->invoice->id]),
           ]);
      }else if($this->invoice->type=="Purchase Return"){
        $this->emit('redirect', [
            'url' => route('inventory.purchase-return-invoice', ['id' => $this->invoice->id]),
           ]);
      }

    }

    public function InvoiceModal($id=NULL){
        $this->invoice=Invoice::find($id);
        $this->emit('modal', 'InvoiceModal');
    }

    public function PrintReceipt($id=Null){
        $this->Receipt=Receipt::find($id);
        if($this->Receipt){
            $this->emit('redirect',[
          'url' => route('accounts-module.receipt-invoice', ['id' => $this->Receipt->id]),
            ]);
        }
    }

    public function mount(){
        $this->start_date=Carbon::now()->format('Y-m-d');
        $this->end_date=Carbon::now()->format('Y-m-d');
    }
    public function openingDateFilter($model)
    {
        return $model->where('date', '<', Carbon::parse($this->start_date)->format('Y-m-d'))->where('company_id',$this->company_id);
    }

    public function dateFilter($model)
    {
        if($this->start_date && $this->end_date){
            return $model->where('date', '>=', Carbon::parse($this->start_date)->format('Y-m-d'))->where('date', '<=', Carbon::parse($this->end_date)->format('Y-m-d'))->where('company_id',$this->company_id);
        }else{
            return $model;
        }
    }
    public function render()
    {
        $ChartOfAccount = ChartOfAccount::query();
        $ChartOfAccountList = ChartOfAccount::query();
        $transaction = Transaction::query();
        $company  = Company::query();

        if ($this->company_id) {
            $company->whereId($this->company_id);
        }

        if ($this->chart_of_account_id) {
            $ChartOfAccount->whereId($this->chart_of_account_id);
        }
        if (Auth::user()->hasAnyRole('user')) {
            $ChartOfAccount->whereCompanyId(Auth::user()->company_id);
        }
        if (Auth::user()->hasAnyRole('user')) {
            $ChartOfAccountList->whereCompanyId(Auth::user()->company_id);
        }
        if (Auth::user()->hasAnyRole('user')) {
            $transaction->whereCompanyId(Auth::user()->company_id);
        }
        return view('livewire.reports.general-ledger', [
            'ChartOfAccount' => $ChartOfAccount->first(),
            'ChartOfAccountList' => $ChartOfAccountList->get(),
            'transaction' => $transaction->get(),
            'CompanyInfo' => $company->get(),
        ]);
    }
}
