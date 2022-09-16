<?php

namespace App\Http\Livewire\AccountsModule;

use App\Models\Accounts\Receipt;
use App\Traits\NumberToWord;
use Livewire\Component;

class ReceiptInvoice extends Component
{
    public $Receipt;
    use NumberToWord;

    public function mount($id)
    {
        $this->Receipt = Receipt::find($id);
        // dd($this->Receipt->amount);

        // build a new number transformer using the RFC 3066 language identifier
    }

    public function render()
    {
        $numberToWord = $this->numtowords($this->Receipt->amount, $this->Receipt->Branch->Currency->in_word_prefix, $this->Receipt->Branch->Currency->in_word_surfix, $this->Receipt->Branch->Currency->in_word_prefix_position, $this->Receipt->Branch->Currency->in_word_surfix_position);

        return view('livewire.accounts-module.receipt-invoice', [
            'numberToWord' => $numberToWord,
        ])->layout('layouts.invoice-master');
    }
}
