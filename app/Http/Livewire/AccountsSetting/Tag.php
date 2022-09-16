<?php

namespace App\Http\Livewire\AccountsSetting;
use App\Models\AccountSettings\Tag as TagModal;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Tag extends Component
{

    public $code;
    public $name;
    public $user_id;
    public $branch_id;
    public $company_id;
    public $status = 1;
    public $tag_id;




    public function TagSave(){
        $this->validate([
            'code' => 'required',
            'name' => 'required',
            'status' => 'required',
        ]);

        if ($this->tag_id) {
            $Query = TagModal::find($this->tag_id);
        } else {
            $Query = new TagModal();
            $Query->user_id = Auth::id();
        }

        $Query->code = $this->code;
        $Query->name = $this->name;
        $Query->status = $this->status;
        $Query->branch_id = Auth::user()->branch_id;
        $Query->company_id = Auth::user()->company_id;
        $Query->save();
        $this->TagModal();
        $this->emit('success', [
            'text' => 'Tag C\U Successfully',
        ]);

    }

    public function TagEdit($id)
    {

        $Query = TagModal::find($id);
        $this->tag_id = $Query->id;
        $this->code = $Query->code;
        $this->name = $Query->name;
        $this->status = $Query->status;
        $this->emit('modal', 'TagModal');
    }

    public function TagDelete($id)
    {
        TagModal::find($id)->delete();
        $this->emit('success', [
            'text' => 'Tag Deleted Successfully',
        ]);
    }


    public function GenerateCode(){
        $check_row=TagModal::orderBy('id', 'desc')->first();
        if(!$check_row){
          $this->code="T001";
        }else{
          $this->code=++$check_row->id;
          if($this->code<=9){
            $this->code="T00".$this->code;
          }else if($this->code<=99){
            $this->code="T0".$this->code;
          }else{
            $this->code="T".$this->code;
          }
        }
        // dd($this->code);
    }

    public function TagModal(){
        $this->reset();
        $this->GenerateCode();
        $this->emit('modal', 'TagModal');
    }


    public function render()
    {
        return view('livewire.accounts-setting.tag');
    }
}
