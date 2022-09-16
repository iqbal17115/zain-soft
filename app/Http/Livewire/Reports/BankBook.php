<?php

namespace App\Http\Livewire\Reports;

use App\Models\AccountSettings\ChartOfAccount;
use App\Models\Billing\Invoice;
use App\Models\Setting\Company;
use Carbon\Carbon;
use Livewire\Component;

class BankBook extends Component
{
    public $testData;
    public $start_date;
    public $end_date;
    public $chart_of_account_id;
    public $invoice;
    public $ReceiptInvoice;

    public function InvoicePrint($id){
        $this->reset('invoice');
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
    public function mount(){
        $this->start_date=Carbon::now()->format('Y-m-d');
        $this->end_date=Carbon::now()->format('Y-m-d');
    }
    public function openingDateFilter($model)
    {
        return $model->where('date', '<', $this->start_date);
    }

    public function dateFilter($model)
    {
        if($this->start_date && $this->end_date){
           return $model->where('date', '>=', Carbon::parse($this->start_date)->format('Y-m-d'))->where('date', '<=', Carbon::parse($this->end_date)->format('Y-m-d'));
        }else{
            return $model;
        }

    }

    public function render()
    {
        $ChartOfAccount = ChartOfAccount::query();

        if ($this->chart_of_account_id) {
            $ChartOfAccount->whereId($this->chart_of_account_id);
        }

        return view('livewire.reports.bank-book', [
            'ChartOfAccount' => $ChartOfAccount->first(),
            'ChartOfAccountList' => ChartOfAccount::whereNotNull('is_cashbank')->get(),
            'CompanyInfo' => Company::get(),
        ]);
    }
}
