<?php

namespace App\Http\Livewire\Inventory;
use App\Models\Billing\Invoice;
use App\Models\Setting\ProfileSetting;
use App\Traits\NumberToWord;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PurchaseInvoice extends Component
{
    use NumberToWord;
    public $InvoiceId;
    public function mount($id=NULL){
       $this->InvoiceId=$id;
    }
    public function render()
    {
        // dd(ProfileSetting::get());
        $invoice=Invoice::find($this->InvoiceId);
        $numberToWord=$this->numtowords($invoice->amount_to_pay, $invoice->Branch->Currency->in_word_prefix, $invoice->Branch->Currency->in_word_surfix, $invoice->Branch->Currency->in_word_prefix_position, $invoice->Branch->Currency->in_word_surfix_position);
        $numberToWordVat=$this->numtowords($invoice->total_vat, $invoice->Branch->Currency->in_word_prefix, $invoice->Branch->Currency->in_word_surfix, $invoice->Branch->Currency->in_word_prefix_position, $invoice->Branch->Currency->in_word_surfix_position);
        return view('livewire.inventory.purchase-invoice',[
            'invoice'=>Invoice::whereCompanyId(Auth::user()->company_id)->find($this->InvoiceId),
            'numberToWordTotal'=>$numberToWord,
            'numberToWordVat'=>$numberToWordVat,
            'profilesetting'=> ProfileSetting::whereCompanyId(Auth::user()->company_id)->first(),
        ])->layout('layouts.invoice-master');
    }
}
