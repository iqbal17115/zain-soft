<?php

namespace App\Http\Livewire\Reports;

use App\Models\Accounts\AccountManager;
use App\Models\AccountSettings\ChartOfAccount;
use App\Models\Setting\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class VatReturnReport extends Component
{
    public $type="Vat Return Details";
    public $start_date;
    public $end_date;

    public function mount(){
        $this->start_date=Carbon::now()->format('Y-m-d');
        $this->end_date=Carbon::now()->format('Y-m-d');
    }
    public function render()
    {
        if($this->start_date && $this->end_date){
        $vatCollection = AccountManager::where('status', 1)
        ->whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('chart_of_accounts')
                ->whereRaw('chart_of_accounts.id = account_managers.cr_account_id')
                ->whereRaw('chart_of_accounts.default_module =  10');
        })
        ->whereBetween('account_managers.date',[$this->start_date, $this->end_date])
        ->get();

        $chartOfAccountInputVat = ChartOfAccount::whereDefaultModule(9)->first()->InputVatTotal($this->start_date, $this->end_date);
        $chartOfAccountOutputVat = ChartOfAccount::whereDefaultModule(10)->first()->OutputVatTotal($this->start_date, $this->end_date);

        }else{
        $vatCollection = AccountManager::where('status', 1)
        ->whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('chart_of_accounts')
                ->whereRaw('chart_of_accounts.id = account_managers.cr_account_id')
                ->whereRaw('chart_of_accounts.default_module =  10');
        })
        ->get();
        $chartOfAccountInputVat = ChartOfAccount::whereDefaultModule(9)->first()->InputVatTotal();
        $chartOfAccountOutputVat = ChartOfAccount::whereDefaultModule(10)->first()->OutputVatTotal();
        }

        return view('livewire.reports.vat-return-report', [
            'CompanyInfo' => company::get(),
            'chartOfAccountInputVat' => $chartOfAccountInputVat,
            'chartOfAccountOutputVat' => $chartOfAccountOutputVat,
            'VatCollection' => $vatCollection,
        ]);
    }
}
