<?php

namespace App\Http\Livewire\Reports;
use App\Models\Billing\Invoice;
use App\Models\Contact\Contact;
use App\Models\AccountSettings\Branch;
use Carbon\Carbon;
use Livewire\Component;

class PurchaseReport extends Component
{
    public $from_date;
    public $to_date;
    public $contact_id;
    public $branch_id;

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
        $purchaseInvoice=Invoice::whereType("Purchase")->orderBy('id', 'desc');
        if($this->branch_id){
            $purchaseInvoice->whereBranchId($this->branch_id);
        }
        if($this->contact_id){
            $purchaseInvoice->whereContactId($this->contact_id);
        }
        return view('livewire.reports.purchase-report', [
            'purchases' => $purchaseInvoice->paginate(20),
            'Suppliers' => Contact::whereType('Supplier')->get(),
            'branches' => Branch::get(),
        ]);
    }
}
