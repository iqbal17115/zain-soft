<?php

namespace App\Http\Livewire\Reports;

use App\Models\Accounts\AccountManager;
use App\Models\Setting\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class VatCollectionReport extends Component
{
    public $start_date;
    public $end_date;

    public function mount(){
        $this->start_date=Carbon::now()->format('Y-m-d');
        $this->end_date=Carbon::now()->format('Y-m-d');
    }
    public function render()
    {
        // $AccountManager=AccountManager::where()
        if($this->start_date && $this->end_date){
        $AccountManager = AccountManager::where('status', 1)
        ->whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('chart_of_accounts')
                ->whereRaw('chart_of_accounts.id = account_managers.cr_account_id')
                ->whereRaw('chart_of_accounts.default_module =  10');
        })
        ->whereBetween('account_managers.date',[$this->start_date, $this->end_date])
        ->get();
       }else{
        $AccountManager = AccountManager::where('status', 1)
        ->whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('chart_of_accounts')
                ->whereRaw('chart_of_accounts.id = account_managers.cr_account_id')
                ->whereRaw('chart_of_accounts.default_module =  10');
        })
        ->get();
       }
        return view('livewire.reports.vat-collection-report', [
             'CompanyInfo'  => Company::get(),
            'AccountManager' => $AccountManager,
    ]);
    }
}
