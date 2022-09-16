<?php

namespace App\Http\Livewire\Reports;
use App\Models\Stock\StockManager;
use App\Models\Contact\Contact;
use App\Models\AccountSettings\Branch;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PurchaseDetailReport extends Component
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
        $purchase=StockManager::orderBy('id', 'desc')
        ->whereExists(function ($query) {
            $query->select(DB::raw(1))
                  ->from('invoices')
                  ->whereType('Purchase')
                  ->whereColumn('invoices.id', 'stock_managers.invoice_id');
        });
        if($this->branch_id){
            $purchase->whereBranchId($this->branch_id);
        }
        if($this->contact_id){
            $purchase->whereContactId($this->contact_id);
        }
        return view('livewire.reports.purchase-detail-report',[
            'purchaseDetails'=>$purchase->paginate(20),
            'Suppliers' => Contact::whereType('Supplier')->get(),
            'branches' => Branch::get(),
        ]);
    }
}
