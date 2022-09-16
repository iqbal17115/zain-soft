<?php

namespace App\Http\Livewire\AccountsSetting;

use App\Models\AccountSettings\ChartOfGroup as ChartOfGroupTable;
use App\Models\AccountSettings\ChartOfSection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;


class ChartOfGroup extends Component
{

    public $code;
    public $name;
    public $flow;
    public $user_id;
    public $status=1;
    public $chart_of_section_id;
    public $ChartOfSectionId;


    public function ChartOfGroupSave()
    {
        $this->validate([
            'code' => 'required',
            'name' => 'required',
            'chart_of_section_id' => 'required',
            'status'   => 'required',
        ]);

        if ($this->ChartOfSectionId) {
            $Query = ChartOfGroupTable::find($this->ChartOfSectionId);
        } else {
            $Query = new ChartOfGroupTable();
            $Query->user_id = Auth::id();
            $Query->company_id = Auth::user()->company_id;
        }

        $Query->chart_of_section_id = $this->chart_of_section_id;
        $Query->code = $this->code;
        $Query->name = $this->name;
        $Query->status = $this->status;
        $Query->save();
        $this->ChartOfGroupModel();
        $this->emit('success', [
            'text' => 'Chart of Group C\U Successfully',
        ]);
    }

    public function ChartOfGroupEdit($id)
    {
        $Query = ChartOfGroupTable::find($id);
        $this->ChartOfSectionId = $Query->id;
        $this->chart_of_section_id = $Query->chart_of_section_id;
        $this->code = $Query->code;
        $this->name = $Query->name;
        $this->status = $Query->status;
        $this->flow = $Query->flow;
        $this->emit('modal', 'ChartOfGroupModel');
    }

    public function ChartOfGroupDelete($id)
    {
        ChartOfGroupTable::find($id)->delete();
        $this->emit('success', [
            'text' => 'Chart of Group Deleted Successfully',
        ]);
    }
    public function GenerateCode(){
        $check_row=ChartOfGroupTable::orderBy('id', 'desc')->first();
        if(!$check_row){
          $this->code="CG001";
        }else{
          $this->code=++$check_row->id;
          if($this->code<=9){
            $this->code="CG00".$this->code;
          }else if($this->code<=99){
            $this->code="CG0".$this->code;
          }else{
            $this->code="CG".$this->code;
          }
        }
        // dd($this->code);
    }
    public function ChartOfGroupModel()
    {
        $this->reset();
        $this->GenerateCode();
        $this->emit('modal', 'ChartOfGroupModel');
    }
    public function render()
    {
        return view('livewire.accounts-setting.chart-of-group', [
            'sections'=>ChartOfSection::get(),
        ]);
    }
}
