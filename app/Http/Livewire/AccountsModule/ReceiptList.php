<?php

namespace App\Http\Livewire\AccountsModule;
use App\Models\AccountSettings\EntryType;
use App\Models\Accounts\AccountManager;
use App\Models\Accounts\Receipt;
use App\Traits\NumberToWord;
use Livewire\Component;

class ReceiptList extends Component
{
    use NumberToWord;

    public $Receipt;
    public $numberToWord;
    public function InvoiceModal($id){
        $this->Receipt = Receipt::find($id);
        $this->numberToWord = $this->numtowords($this->Receipt->amount, $this->Receipt->Branch->Currency->in_word_prefix, $this->Receipt->Branch->Currency->in_word_surfix, $this->Receipt->Branch->Currency->in_word_prefix_position, $this->Receipt->Branch->Currency->in_word_surfix_position);
        $this->emit('modal', 'InvoiceModal');
    }
    public function InvoicePrint($id){
        $this->emit('redirect', [
            'url' => route('accounts-module.receipt-invoice', ['id' => $id]),
        ]);
    }
    public function receiptDelete($id)
    {
        AccountManager::where('receipt_id', $id)->Delete();
        Receipt::find($id)->Delete();

        $this->emit('success', [
            'text' => 'Delete Successfully',
        ]);
    }
    public function render()
    {
        return view('livewire.accounts-module.receipt-list',[
            'EntryType' => EntryType::all(),
        ]);
    }
}
