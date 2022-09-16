<?php

namespace App\Http\Livewire\Inventory;
use App\Models\Billing\Invoice;
use App\Traits\NumberToWord;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RequisitionInvoice extends Component
{
    use NumberToWord;
    public $InvoiceId;
    public function mount($id=NULL){
       $this->InvoiceId=$id;
    }

    public function render()
    {
        $invoice=Invoice::find($this->InvoiceId);
        // dd( $invoice);
        $numberToWordVat=$this->numtowords($invoice->total_vat, $invoice->Branch->Currency->in_word_prefix, $invoice->Branch->Currency->in_word_surfix, $invoice->Branch->Currency->in_word_prefix_position, $invoice->Branch->Currency->in_word_surfix_position);

        $numberToWord=$this->numtowords($invoice->amount_to_pay, $invoice->Branch->Currency->in_word_prefix, $invoice->Branch->Currency->in_word_surfix, $invoice->Branch->Currency->in_word_prefix_position, $invoice->Branch->Currency->in_word_surfix_position);
        return view('livewire.inventory.requisition-invoice',[
            'invoice'=>Invoice::whereCompanyId(Auth::user()->company_id)->find($this->InvoiceId),
            'numberToWordTotal'=>$numberToWord,
            'numberToWordVat'=>$numberToWordVat,
        ])->layout('layouts.invoice-master');
    }
}
