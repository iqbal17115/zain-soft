<?php

namespace App\Http\Livewire\AccountsModule;
use App\Models\Accounts\Transaction;
use App\Traits\NumberToWord;
use App\Models\Billing\Invoice;
use Livewire\Component;

class SupplierPaymentInvoice extends Component
{
    use NumberToWord;
    public $TransactionId;
    public function mount($id=NULL){
       $this->TransactionId=$id;
    }
    public function render()
    {
        $transaction=Transaction::find($this->TransactionId);
        $invoice=Invoice::find($transaction->invoice_id);
        $total=$this->numtowords($transaction->Invoice->amount_to_pay, $invoice->Branch->Currency->in_word_prefix, $invoice->Branch->Currency->in_word_surfix, $invoice->Branch->Currency->in_word_prefix_position, $invoice->Branch->Currency->in_word_surfix_position);
        $amount = $this->numtowords($transaction->amount, $invoice->Branch->Currency->in_word_prefix, $invoice->Branch->Currency->in_word_surfix, $invoice->Branch->Currency->in_word_prefix_position, $invoice->Branch->Currency->in_word_surfix_position);
        return view('livewire.accounts-module.supplier-payment-invoice',[
            'transaction'=>$transaction,
             'total'=>$total,
             'amount'=>$amount,
        ])->layout('layouts.invoice-master');
    }
}
