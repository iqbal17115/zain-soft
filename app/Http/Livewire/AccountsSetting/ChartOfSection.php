<?php

namespace App\Http\Livewire\AccountsSetting;
use App\Models\AccountSettings\ChartOfSection as ChartOfSectionTable;
use App\Models\AccountSettings\ChartOfGroup;
use App\Models\AccountSettings\Branch;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChartOfSection extends Component
{
    public $code;
    public $name;
    public $status=1;
    public $ChartOfSectionId;

    public function ChartOfSectionSave(){
        $this->validate([
           'code'=> 'required',
           'name' => 'required',
           'status' => 'required',
        ]);
        if($this->ChartOfSectionId){
           $Query = ChartOfSectionTable::find($this->ChartOfSectionId);
        }else{
            $Query = new ChartOfSectionTable();
            $Query->user_id = Auth::id();
            $Query->company_id = Auth::user()->company_id;
        }

        $Query->code = $this->code;
        $Query->name = $this->name;
        $Query->value = strtolower($this->name);
        $Query->status = $this->status;
        $Query->save();
        $this->ChartOfSectionModel();
        $this->emit('success',[
           'text' => 'Chart of Section C\U Successfully',
        ]);
    }

    public function ChartOfSectionEdit($id){
        $Query = ChartOfSectionTable::find($id);
        $this->ChartOfSectionId = $Query->id;
        $this->code = $Query->code;
        $this->name = $Query->name;
        $this->status = $Query->status;
        $this->emit('modal', 'ChartOfSectionModel');
    }

    public function ChartOfSectionDelete($id){
        ChartOfSectionTable::find($id)->delete();
         $this->emit('success',[
            'text' => 'Chart of Section deleted successfully',
          ]);
    }
    public function GenerateCode(){
        $check_row=ChartOfSectionTable::orderBy('id', 'desc')->first();
        if(!$check_row){
          $this->code="CS001";
        }else{
          $this->code=++$check_row->id;
          if($this->code<=9){
            $this->code="CS00".$this->code;
          }else if($this->code<=99){
            $this->code="CS0".$this->code;
          }else{
            $this->code="CS".$this->code;
          }
        }
        // dd($this->code);
    }
    public function ChartOfSectionModel(){
        $this->reset();
        $this->GenerateCode();
        $this->emit('modal', 'ChartOfSectionModel');
    }
    public function render()
    {
        return view('livewire.accounts-setting.chart-of-section',[
            'branches' => Branch::whereCompanyId(Auth::user()->company_id)->get(),
            'sections'=>ChartOfGroup::whereCompanyId(Auth::user()->company_id)->get(),
        ]);
    }
}
