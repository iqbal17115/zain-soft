<?php

namespace App\Http\Livewire\Reports;

use App\Models\AccountSettings\ChartOfAccount;
use App\Models\Contact\Contact;
use App\Traits\Receivable;
use Carbon\Carbon;
use Livewire\Component;

class ReceivableReport extends Component
{
    use Receivable;
    public $contact_id;
    public $start_date;
    public $end_date;

    public function mount(){
        $this->start_date=Carbon::now()->format('Y-m-d');
        $this->end_date=Carbon::now()->format('Y-m-d');
    }
    public function openingDateFilter($model)
    {
        return $model->where('date', '<', Carbon::parse($this->start_date)->format('Y-m-d'));
    }
    public function dateFilter($model)
    {
        return $model->where('date', '>=', Carbon::parse($this->start_date)->format('Y-m-d'))->where('date', '<=', Carbon::parse($this->end_date)->format('Y-m-d'));
    }

    public function render()
    {
        if($this->contact_id){
           $contacts=Contact::whereType('customer')->whereId($this->contact_id)->get();
        }else{
           $contacts=Contact::whereType('customer')->get();
        }
        return view('livewire.reports.receivable-report', [
            'contacts' => $contacts,
            'Receivable' => ChartOfAccount::whereDefaultModule(5)->first(),
        ]);
    }
}
