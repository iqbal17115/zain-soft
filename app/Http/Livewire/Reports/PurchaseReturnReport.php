<?php

namespace App\Http\Livewire\Reports;
use App\Models\Contact\Contact;
use App\Models\Billing\Invoice;
use Carbon\Carbon;
use Livewire\Component;

class PurchaseReturnReport extends Component
{
    public $contact_id;
    public $from_date;
    public $to_date;

    public function mount(){
        $this->from_date=Carbon::now()->format('Y-m-d');
        $this->to_date=Carbon::now()->format('Y-m-d');
    }
    public function dateFilter($model){
        if($this->from_date && $this->to_date){
           return $model->where('date', '>=', Carbon::parse($this->from_date)->format('Y-m-d'))->where('date', '<=', Carbon::parse($this->to_date)->format('Y-m-d'));
        }else{
           return $model;
        }
    }
    public function render()
    {
        $purchaseReturnReport=Invoice::whereType("Purchase Return")->orderBy('id', 'desc');

        if($this->contact_id){
            $purchaseReturnReport->whereContactId($this->contact_id);
        }

        return view('livewire.reports.purchase-return-report',[
            'purchaseReturnReports' => $purchaseReturnReport->paginate(20),
             'suppliers' => Contact::whereType('Supplier')->get(),
        ]);
    }
}
