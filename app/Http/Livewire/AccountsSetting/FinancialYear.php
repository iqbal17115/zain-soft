<?php

namespace App\Http\Livewire\AccountsSetting;

use App\Models\AccountSettings\FinancialYear as FinancialYearTable;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FinancialYear extends Component
{
    public $name;
    public $start_datetime;
    public $end_datetime;
    public $status=1;
    public $company_id;
    public $branch_id;
    public $financialYearId;

    public function FinancialYearSave()
    {
        $this->validate([
            'name' => 'required',
        ]);
        if ($this->financialYearId) {
            $Query = FinancialYearTable::find($this->financialYearId);
        } else {
            $Query = new FinancialYearTable();
            $Query->user_id = Auth::id();
        }

        $Query->name = $this->name;
        $Query->start_datetime = $this->start_datetime;
        $Query->end_datetime = $this->end_datetime;
        $Query->status = $this->status;
        $Query->branch_id = Auth::user()->branch_id;
        $Query->company_id = Auth::user()->company_id;
        $Query->save();
        if ($this->status == 1) {
            FinancialYearTable::where('id', '!=', $Query->id)->update(['status' => 0]);
        } elseif ($this->financialYearId && $this->status == 0) {
            FinancialYearTable::where('id', '=', $Query->id)->update(['status' => 1]);
        }
        $this->FinancialYearModal();
        $this->emit('success', [
        'text' => 'Financial Year C\U Successfully',
        ]);
    }

    public function FinancialYearEdit($id)
    {
        $Query = FinancialYearTable::find($id);
        $this->financialYearId = $Query->id;
        $this->name = $Query->name;
        $this->start_datetime = $Query->start_datetime;
        $this->end_datetime = $Query->end_datetime;
        $this->status = $Query->status;
        $this->emit('modal', 'FinancialYearModal');
    }

    public function FinancialYearDelete($id)
    {
        FinancialYearTable::find($id)->delete();
        $this->emit('success', [
              'text' => 'Financial Year Deleted Successfully',
           ]);
    }

    public function FinancialYearModal()
    {
        $this->reset();
        $this->emit('modal', 'FinancialYearModal');
    }

    public function render()
    {
        return view('livewire.accounts-setting.financial-year');
    }
}
