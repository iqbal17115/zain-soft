<?php

namespace App\Http\Livewire\AccountsSetting;

use App\Models\Accounts\AccountManager;
use App\Models\AccountSettings\ChartOfAccount as ChartofAccountTable;
use App\Models\AccountSettings\ChartOfGroup;
use App\Models\AccountSettings\CompanyInfo;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChartOfAccount extends Component
{
    public $code;
    public $name;
    public $type;
    public $note;
    public $default_module;
    public $chart_of_group_id;
    public $opening_balance;
    public $is_cashbank;
    public $is_income_statement;
    public $is_balance_sheet;
    public $chart_of_accounts_id = null;
    public $company_id;

    public function ChartOfGroupSave()
    {
        $this->validate([
            'code' => 'required',
            'name' => 'required',
            'chart_of_group_id' => 'required',
            'default_module' => ['nullable', 'unique:chart_of_accounts,default_module,'.$this->chart_of_accounts_id],
        ]);

        if ($this->chart_of_accounts_id) {
            $Query = ChartofAccountTable::find($this->chart_of_accounts_id);
        } else {
            $Query = new ChartofAccountTable();
            $Query->user_id = Auth::id();
        }
        $Query->code = $this->code;
        $Query->name = $this->name;
        if ($this->type != null) {
            $Query->type = $this->type;
        }
        $Query->note = $this->note;
        $Query->opening_balance = $this->opening_balance;
        $Query->chart_of_group_id = $this->chart_of_group_id;
        $Query->is_income_statement = $this->is_income_statement;
        $Query->is_balance_sheet = $this->is_balance_sheet;
        $Query->company_id = Auth::user()->company_id;
        $Query->is_cashbank = $this->is_cashbank;
        if (!$Query->default_module) {
            $Query->default_module = $this->default_module;
        }
        $Query->save();

        if ($this->opening_balance) {
            $openBalanceChartId = ChartofAccountTable::whereDefaultModule(7)->first('id')->id;

            if ($openBalanceChartId) {
                $AccountManager = AccountManager::whereType($this->type);

                if ($this->type == 'Debit') {
                    $AccountManager->where('dr_account_id', $Query->id);
                    $AccountManager->where('cr_account_id', $openBalanceChartId);
                } else {
                    $AccountManager->where('cr_account_id', $Query->id);
                    $AccountManager->where('dr_account_id', $openBalanceChartId);
                }

                $AccountManager = $AccountManager->firstOrNew();

                $AccountManager->amount = $this->opening_balance;
                $AccountManager->user_id = Auth::id();
                if ($this->type == 'Credit') {
                    $AccountManager->type = 'Credit';
                    $AccountManager->dr_account_id = $openBalanceChartId;
                    $AccountManager->cr_account_id = $Query->id;
                } else {
                    $AccountManager->type = 'Debit';
                    $AccountManager->dr_account_id = $Query->id;
                    $AccountManager->cr_account_id = $openBalanceChartId;
                }
                $AccountManager->save();
            }
        }

        $this->chartOfAccountsModal();

        $this->emit('success', [
            'text' => 'Chart Account Create Successfully',
        ]);
    }

    public function chartOfAccountsEdit($id)
    {
        $Query = ChartofAccountTable::find($id);
        $this->chart_of_accounts_id = $Query->id;
        $this->code = $Query->code;
        $this->type = $Query->type;
        $this->note = $Query->note;
        $this->name = $Query->name;
        $this->default_module = $Query->default_module;
        $this->chart_of_group_id = $Query->chart_of_group_id;
        $this->opening_balance = $Query->opening_balance;
        $this->is_cashbank = $Query->is_cashbank;
        $this->is_income_statement = $Query->is_income_statement;
        $this->is_balance_sheet = $Query->is_balance_sheet;
        $this->company_id = $Query->company_id;

        $this->emit('modal', 'ChartOfAccounts');
    }

    public function chartOfAccountsDelete($id)
    {
        ChartofAccountTable::find($id)->delete();

        $this->emit('success', [
            'text' => 'Chart Accounts Delete Successfully',
        ]);
    }

    public function GenerateCode()
    {
        $check_row = ChartofAccountTable::orderBy('id', 'desc')->first();
        if (!$check_row) {
            $this->code = 'CA001';
        } else {
            $this->code = ++$check_row->id;
            if ($this->code <= 9) {
                $this->code = 'CA00'.$this->code;
            } elseif ($this->code <= 99) {
                $this->code = 'CA0'.$this->code;
            }
        }
        // dd($this->code);
    }

    public function chartOfAccountsModal()
    {
        $this->reset();
        $this->GenerateCode();
        $this->emit('modal', 'ChartOfAccounts');
    }

    public function render()
    {
        return view('livewire.accounts-setting.chart-of-account', [
            'ChartOfGroup' => ChartOfGroup::get(),
            'companies' => CompanyInfo::get(),
        ]);
    }
}
