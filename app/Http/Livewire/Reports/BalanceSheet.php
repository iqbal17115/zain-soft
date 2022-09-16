<?php

namespace App\Http\Livewire\Reports;

use App\Models\Accounts\AccountManager;
use App\Models\AccountSettings\ChartOfAccount;
use App\Models\AccountSettings\ChartOfGroup;
use App\Traits\ChartBalance;
use App\Traits\Stock;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BalanceSheet extends Component
{
    use ChartBalance;
    use Stock;
    public function render()
    {
        $IncomeCrBalance = DB::table('account_managers')
            ->join('chart_of_accounts', 'account_managers.cr_account_id', '=', 'chart_of_accounts.id')
            ->join('chart_of_groups', 'chart_of_accounts.chart_of_group_id', '=', 'chart_of_groups.id')
            ->where('chart_of_groups.chart_of_section_id','=',3)
          ->sum('amount');
          $IncomedrBalance = DB::table('account_managers')
          ->join('chart_of_accounts', 'account_managers.dr_account_id', '=', 'chart_of_accounts.id')
          ->join('chart_of_groups', 'chart_of_accounts.chart_of_group_id', '=', 'chart_of_groups.id')
          ->where('chart_of_groups.chart_of_section_id','=',3)
        ->sum('amount');

          $ExpenseDrBalance = DB::table('account_managers')
          ->join('chart_of_accounts', 'account_managers.dr_account_id', '=', 'chart_of_accounts.id')
          ->join('chart_of_groups', 'chart_of_accounts.chart_of_group_id', '=', 'chart_of_groups.id')
          ->where('chart_of_groups.chart_of_section_id','=',4)
        ->sum('amount');
        $ExpenseCrBalance = DB::table('account_managers')
          ->join('chart_of_accounts', 'account_managers.cr_account_id', '=', 'chart_of_accounts.id')
          ->join('chart_of_groups', 'chart_of_accounts.chart_of_group_id', '=', 'chart_of_groups.id')
          ->where('chart_of_groups.chart_of_section_id','=',4)
        ->sum('amount');
        $totalIncome=$IncomeCrBalance -$IncomedrBalance;
        $totalexpense=$ExpenseDrBalance -$ExpenseCrBalance;

        $saleDiscountChart=ChartOfAccount::whereDefaultModule(11)->first();
        $saleDiscount=($this->getChartBalance(['dr_account_id'=> $saleDiscountChart->id])->current_dr_balance)-($this->getChartBalance(['cr_account_id'=> $saleDiscountChart->id])->current_cr_balance);
        $saleChart=ChartOfAccount::whereDefaultModule(1)->first();
        $saleTotal=($this->getChartBalance(['cr_account_id'=> $saleChart->id])->current_cr_balance)-($this->getChartBalance(['dr_account_id'=> $saleChart->id])->current_dr_balance);
        return view('livewire.reports.balance-sheet', [
            'Assets'=>ChartOfGroup::whereChartOfSectionId(1)->get(),
            'Liabilities'=>ChartOfGroup::whereChartOfSectionId(2)->get(),
            'saleDiscount'=>$saleDiscount,
            'saleTotal'=>$saleTotal,
            'totalIncome'=>$totalIncome,
            'totalexpense'=>$totalexpense,
        ]);
    }
}
