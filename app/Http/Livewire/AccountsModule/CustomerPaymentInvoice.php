<?php

namespace App\Http\Livewire\AccountsModule;
use App\Models\Accounts\Transaction;
use App\Traits\NumberToWord;
use App\Models\Billing\Invoice;
use Livewire\Component;

class CustomerPaymentInvoice extends Component
{
    use NumberToWord;
    public $TransactionId;
    public $invoice;
    public function mount($id=NULL){
       $this->TransactionId=$id;
    }
    public function render()
    {
        $transaction=Transaction::find($this->TransactionId);
        $IDS=explode(", ",$transaction->invoice_ids);
        $invoice=Invoice::find($IDS[0]);
        $invoice_amount_to_pay=Transaction::where('invoice_ids', $transaction->invoice_ids)->sum('amount');
        // dd($invoice_amount_to_pay);
        $total=$this->numtowords($invoice_amount_to_pay, $invoice->Branch->Currency->in_word_prefix, $invoice->Branch->Currency->in_word_surfix, $invoice->Branch->Currency->in_word_prefix_position, $invoice->Branch->Currency->in_word_surfix_position);
        return view('livewire.accounts-module.customer-payment-invoice',[
            'transaction'=>$transaction,
             'total'=>$total,
             'amount_to_pay'=>$invoice_amount_to_pay
        ])->layout('layouts.invoice-master');
    }
}
