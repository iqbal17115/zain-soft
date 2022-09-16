<?php

namespace App\Http\Livewire\Reports;
use App\Models\Accounts\AccountManager;
use Livewire\Component;

class BankReconsilation extends Component
{
    public $AccountManagerId;
    public $date;
    public $status;

    public function StatusSave(){
        $this->validate([
            'date'   => 'required',
            'status'   => 'required',
          ]);
          $UpdateStatus=AccountManager::find($this->AccountManagerId);
          $UpdateStatus->payment_status=$this->status;
          $UpdateStatus->date=$this->date;
          $UpdateStatus->save();
          $this->reset();

          $this->emit('modal', 'HonourModel');
          $this->emit('success',[
              'text' => 'Status Change Successfully',
          ]);
    }
    public function HonourModal($id){
        $this->AccountManagerId=$id;
        $this->emit('modal', 'HonourModel');
    }
    public function render()
    {
        $AccountManager = AccountManager::where('due_date', '!=', NULL)
        // ->whereStatus(0)
        ->whereNotNull('payment_status')
        // ->where('payment_status','!=','Paid')
        ->get();
        return view('livewire.reports.bank-reconsilation',[
            'AccountManager' => $AccountManager,
        ]);
    }
}
