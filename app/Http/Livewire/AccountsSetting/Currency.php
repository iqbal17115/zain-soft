<?php

namespace App\Http\Livewire\AccountsSetting;

use App\Models\AccountSettings\Currency as CurrencyTable;
use App\Models\AccountSettings\Branch;
use App\Models\Setting\Company;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Currency extends Component
{

    public $code;
    public $title;
    public $symbol;
    public $symbol_position;
    public $in_word_prefix;
    public $in_word_surfix;
    public $in_word_prefix_position;
    public $in_word_surfix_position;
    public $status=1;
    public $currency_id;
    public $company_id;
    public $branch_id;


    public function CurrencySave()
    {

        $this->validate([
            'code'  => 'required',
            'title' => 'required',
            'symbol' => 'required',
            'symbol_position' => 'required',
            'status' => 'required',
            'branch_id' => 'required',
            'company_id' => 'required',
        ]);

        if ($this->currency_id) {
            $Query = CurrencyTable::find($this->currency_id);
        } else {
            $Query = new CurrencyTable();
            $Query->user_id = Auth::id();


        }
        $Query->code    = $this->code;
        $Query->title   = $this->title;
        $Query->symbol  = $this->symbol;
        $Query->symbol_position = $this->symbol_position;
        $Query->in_word_prefix = $this->in_word_prefix;
        $Query->in_word_surfix = $this->in_word_surfix;
        $Query->in_word_prefix_position = $this->in_word_prefix_position;
        $Query->in_word_surfix_position = $this->in_word_surfix_position;
        $Query->status = $this->status;
        $Query->company_id = Auth::user()->company_id;
        $Query->branch_id = $this->branch_id;
        $Query->save();
        $this->emit('modal', 'CurrencyModal');
        $this->emit('success', [
            'text' => 'Currency C\U Successfully',
        ]);
    }

    public function CurrencyEdit($id)
    {
        $Query = CurrencyTable::find($id);
        $this->currency_id = $Query->id;
        $this->code  = $Query->code;
        $this->title = $Query->title;
        $this->symbol = $Query->symbol;
        $this->symbol_position = $Query->symbol_position;
        $this->in_word_prefix = $Query->in_word_prefix;
        $this->in_word_surfix = $Query->in_word_surfix;
        $this->in_word_prefix_position = $Query->in_word_prefix_position;
        $this->in_word_surfix_position = $Query->in_word_surfix_position;
        $this->company_id = $Query->company_id;
        $this->branch_id = $Query->branch_id;
        $this->status = $Query->status;
        $this->emit('modal', 'CurrencyModal');
    }

    public function CurrencyDelete($id)
    {
        CurrencyTable::find($id)->delete();
        $this->emit('success', [
            'text' => 'Currency Deleted Successfully',
        ]);
    }
    public function GenerateCode(){
        $check_row=CurrencyTable::orderBy('id', 'desc')->first();
        if(!$check_row){
          $this->code="CU001";
        }else{
          $this->code=++$check_row->id;
          if($this->code<=9){
            $this->code="CU00".$this->code;
          }else if($this->code<=99){
            $this->code="CU0".$this->code;
          }else{
            $this->code="CU".$this->code;
          }
        }
        // dd($this->code);
    }
    public function CurrencyModal()
    {
        $this->reset();
        $this->GenerateCode();
        $this->emit('modal', 'CurrencyModal');
    }
    public function render()
    {
        return view('livewire.accounts-setting.currency', [
            'branches' => Branch::whereCompanyId($this->company_id)->get(),
            // 'branches' => Branch::get(),
            'companies' => Company::get(),
        ]);
    }
}
