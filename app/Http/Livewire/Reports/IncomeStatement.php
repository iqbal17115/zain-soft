<?php

namespace App\Http\Livewire\Reports;

use App\Models\AccountSettings\Branch;
use App\Models\AccountSettings\ChartOfAccount;
use App\Traits\ChartBalance;
use App\Models\Setting\Company;
use App\Traits\Stock;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Livewire\Component;

class IncomeStatement extends Component
{
    use ChartBalance;
    use Stock;
    public $start_date;
    public $end_date;

    public function mount(){
        $this->start_date=Carbon::now()->format('Y-m-d');
        $this->end_date=Carbon::now()->format('Y-m-d');
    }
    public function openingDateFilter($model)
    {
        return $model->where('date', '<', $this->start_date);
    }

    public function dateFilter($model)
    {
        return $model->where('date', '>=', Carbon::parse($this->start_date)->format('Y-m-d'))->where('date', '<=', Carbon::parse($this->end_date)->format('Y-m-d'));
    }
    public function render()
    {
        // $company  = Company::get();
        // if ($this->company_id) {
        //     $company->whereId($this->company_id);
        // }

        $ExpenseChart = ChartOfAccount::where('status', 1)
        ->whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('chart_of_groups')
                ->whereRaw('chart_of_groups.id = chart_of_accounts.chart_of_group_id')
                ->whereRaw('chart_of_groups.chart_of_section_id =  4');
        })
        ->get();
        $IncomeChart = ChartOfAccount::where('status', 1)
        ->whereExists(function ($query) {
            $query->select(DB::raw(1))
            ->from('chart_of_groups')
            ->whereRaw('chart_of_groups.id = chart_of_accounts.chart_of_group_id')
            ->whereRaw('chart_of_groups.chart_of_section_id =  3');
        })->get();

        $saleDiscountChart=ChartOfAccount::whereDefaultModule(11)->first();
        $saleDiscount=($this->getChartBalance(['dr_account_id'=> $saleDiscountChart->id,'start_date'=>$this->start_date,'end_date'=>$this->end_date])->current_dr_balance)-($this->getChartBalance(['cr_account_id'=> $saleDiscountChart->id,'start_date'=>$this->start_date,'end_date'=>$this->end_date])->current_cr_balance);
        $saleShippingChart=ChartOfAccount::whereDefaultModule(13)->first();
        $shippingCharge=($this->getChartBalance(['cr_account_id'=> $saleShippingChart->id,'start_date'=>$this->start_date,'end_date'=>$this->end_date])->current_cr_balance)-($this->getChartBalance(['dr_account_id'=> $saleShippingChart->id,'start_date'=>$this->start_date,'end_date'=>$this->end_date])->current_dr_balance);
        $saleChart=ChartOfAccount::whereDefaultModule(1)->first();
        $saleTotal=($this->getChartBalance(['cr_account_id'=> $saleChart->id,'start_date'=>$this->start_date,'end_date'=>$this->end_date])->current_cr_balance)-($this->getChartBalance(['dr_account_id'=> $saleChart->id,'start_date'=>$this->start_date,'end_date'=>$this->end_date])->current_dr_balance);
        $purchaseChart=ChartOfAccount::whereDefaultModule(2)->first();
        $purchaseTotal=($this->getChartBalance(['dr_account_id'=> $purchaseChart->id,'start_date'=>$this->start_date,'end_date'=>$this->end_date])->current_dr_balance)-($this->getChartBalance(['cr_account_id'=> $purchaseChart->id,'start_date'=>$this->start_date,'end_date'=>$this->end_date])->current_cr_balance);



        return view('livewire.reports.income-statement', [
            'branches' => Branch::get(),
            'Company'  => Company::get(),
            'ExpenseChart'=>$ExpenseChart,
            'IncomeChart'=>$IncomeChart,
            'saleDiscount'=>$saleDiscount,
            'shippingCharge'=>$shippingCharge,
            'purchaseTotal'=>$purchaseTotal,
            'saleTotal'=>$saleTotal,
            // 'CompanyInfo' => $company->get(),
        ]);
    }
}
