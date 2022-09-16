<?php

namespace App\Http\Livewire\Reports;

use App\Models\Contact\Contact;
use App\Models\Billing\Invoice;
use Carbon\Carbon;
use App\Models\Setting\Company;
use Livewire\Component;

class SupplierLedgerReport extends Component
{
    public $testData;
    public $start_date;
    public $end_date;
    public $contact_id;
    public $invoice;
    public $CompanyInfo;
    public $company_id;
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
    public function openingDateFilter($model)
    {
        return $model->where('date', '<', Carbon::parse($this->start_date)->format('Y-m-d'));
    }

    public function dateFilter($model)
    {
        if ($this->start_date && $this->end_date) {
            return $model->where('date', '>=', Carbon::parse($this->start_date)->format('Y-m-d'))->where('date', '<=', Carbon::parse($this->end_date)->format('Y-m-d'));
        } else {
            return $model;
        }
    }

    public function mount()
    {
        $this->start_date = Carbon::now()->format('Y-m-d');
        $this->end_date = Carbon::now()->format('Y-m-d');
    }

    public function render()
    {
        $Contact = Contact::query();

        $CompanyInfo  =  Company::query();
        if ($this->contact_id) {
            $Contact->whereId($this->contact_id);
        }

        if ($this->company_id) {
            $CompanyInfo->companyId($this->company_id);
        }

        return view('livewire.reports.supplier-ledger-report', [
            'Contact' => $Contact->first(),
            'ContactList' => Contact::whereType('Supplier')->get(),
            'CompanyInfo' => $CompanyInfo->get(),
        ]);
    }
}
