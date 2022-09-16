<?php

namespace App\Http\Livewire\Inventory;
use App\Models\Billing\Invoice;
use App\Models\Accounts\AccountManager;
use App\Models\Stock\StockManager;
use App\Traits\NumberToWord;
use Livewire\Component;

class PurchaseList extends Component
{
    use NumberToWord;
    public $numberToWordTotal;
    public $numberToWordVat;
    public $invoice;

    // public function InvoiceModalPrint($id){
    //     $this->invoice=Invoice::find($id);
    //     $this->numberToWordTotal=$this->numtowords($this->invoice->amount_to_pay, $this->invoice->Branch->Currency->in_word_prefix, $this->invoice->Branch->Currency->in_word_surfix, $this->invoice->Branch->Currency->in_word_prefix_position, $this->invoice->Branch->Currency->in_word_surfix_position);
    //     $this->numberToWordVat=$this->numtowords($this->invoice->total_vat, $this->invoice->Branch->Currency->in_word_prefix, $this->invoice->Branch->Currency->in_word_surfix, $this->invoice->Branch->Currency->in_word_prefix_position, $this->invoice->Branch->Currency->in_word_surfix_position);
    // }
    public function InvoiceModal($id){
        $this->invoice=Invoice::find($id);
        $this->numberToWordTotal=$this->numtowords($this->invoice->amount_to_pay, $this->invoice->Branch->Currency->in_word_prefix, $this->invoice->Branch->Currency->in_word_surfix, $this->invoice->Branch->Currency->in_word_prefix_position, $this->invoice->Branch->Currency->in_word_surfix_position);
        $this->numberToWordVat=$this->numtowords($this->invoice->total_vat, $this->invoice->Branch->Currency->in_word_prefix, $this->invoice->Branch->Currency->in_word_surfix, $this->invoice->Branch->Currency->in_word_prefix_position, $this->invoice->Branch->Currency->in_word_surfix_position);
        $this->emit('modal', 'InvoiceModal');
    }
    public function InvoicePrint($id){
        $this->emit('redirect', [
            'url' => route('inventory.purchase-invoice', ['id' => $id]),
        ]);
    }
    public function PurchaseListDelete($id){
        Invoice::find($id)->delete();
        StockManager::whereInvoiceId($id)->delete();
        AccountManager::whereInvoiceId($id)->delete();
        $this->emit('success', [
            'text' => 'Purchase Deleted Successfully',
         ]);
    }
    public function render()
    {
        return view('livewire.inventory.purchase-list');
    }
}
