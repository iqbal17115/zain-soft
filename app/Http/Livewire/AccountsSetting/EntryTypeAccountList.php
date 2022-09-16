<?php

namespace App\Http\Livewire\AccountsSetting;

use App\Models\AccountSettings\ChartOfAccount;
use App\Models\AccountSettings\EntryTypeAccountList as EntryTypeAccountListInfo;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EntryTypeAccountList extends Component
{
    public $EntryTypeId;
    public $TypeAccountList;
    public $status;
    public $entrytypecheck;

    public function EntryTypeAccountList($chart_of_account_id)
    {
        // dd($id);
        // dd(true);
        $EntryType = EntryTypeAccountListInfo::whereEntryTypeId($this->EntryTypeId)->whereChartOfAccountId($chart_of_account_id)->first();
        if (!$EntryType) {
            $TypeOfAccountList = new EntryTypeAccountListInfo();
            $TypeOfAccountList->entry_type_id = $this->EntryTypeId;
            $TypeOfAccountList->chart_of_account_id = $chart_of_account_id;
            $TypeOfAccountList->status = 1;
            $TypeOfAccountList->user_id = Auth::user()->id;
            $TypeOfAccountList->company_id = Auth::user()->company_id;
            $TypeOfAccountList->save();
        } else {
            EntryTypeAccountListInfo::whereEntryTypeId($this->EntryTypeId)->whereChartOfAccountId($chart_of_account_id)->delete();
        }


    }
    public function submit(){
        // dd($this->entrytypecheck);
        foreach ($this->entrytypecheck as $key => $value) {
            if ($value) {
                 $EntryType = EntryTypeAccountListInfo::whereChartOfAccountId($key)->whereEntryTypeId($this->EntryTypeId)->first();
                 if(!$EntryType ){
                    $TypeOfAccountList = new EntryTypeAccountListInfo();
                    $TypeOfAccountList->entry_type_id = $this->EntryTypeId;
                    $TypeOfAccountList->chart_of_account_id = $key;
                    $TypeOfAccountList->status = 1;
                    $TypeOfAccountList->user_id = Auth::user()->id;
                    $TypeOfAccountList->company_id = Auth::user()->company_id;
                   $TypeOfAccountList->save();
                 }

            }
            else{
                EntryTypeAccountListInfo::whereEntryTypeId($this->EntryTypeId)->delete();
            }
        }
        $this->emit('success', [
            'text' => 'Entry Type Created Successfully!',
        ]);
    }

    public function mount($id)
    {
        $this->EntryTypeId = $id;
        $EntryTypeList=EntryTypeAccountListInfo::whereEntryTypeId($id)->get();
        foreach( $EntryTypeList as $entrytypelist){
            $chartOfAccount=ChartOfAccount::find($entrytypelist->chart_of_account_id);
            $this->entrytypecheck[$chartOfAccount->id]=$entrytypelist->chart_of_account_id;
        }
    }

    public function render()
    {
        return view('livewire.accounts-setting.entry-type-account-list', [
          'ChartOfAccounts' => ChartOfAccount::get(),
        ]);
    }
}
