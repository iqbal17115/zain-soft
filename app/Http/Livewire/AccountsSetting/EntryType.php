<?php

namespace App\Http\Livewire\AccountsSetting;
use App\Models\AccountSettings\EntryType as EntryTypeInfo;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EntryType extends Component
{
    public $suffix;
    public $prefix;
    public $name;
    public $status=1;
    public $company_id;
    public $branch_id;
    public $entry_type_id = null;

    public function EntryTypeSave()
    {
        $this->validate([
            'status' => 'required',
            'name' => 'required',
        ]);

        if ($this->entry_type_id) {
            $Query = EntryTypeInfo::find($this->entry_type_id);
        } else {
            $Query = new EntryTypeInfo();
            $Query->user_id = Auth::id();
        }
        $Query->prefix = $this->prefix;
        $Query->suffix = $this->suffix;
        $Query->name = $this->name;
        $Query->status = $this->status;
        $Query->company_id = Auth::user()->company_id;
        $Query->branch_id = Auth::user()->branch_id;
        $Query->save();
        $this->entryTypeModal();
        // $this->reset();
        $this->emit('success', [
            'text' => 'Entry Type Created Successfully!',
        ]);
    }

    public function entryTypeEdit($id)
    {
        $Query = EntryTypeInfo::find($id);
        $this->entry_type_id = $Query->id;
        $this->prefix = $Query->prefix;
        $this->suffix = $Query->suffix;
        $this->status = $Query->status;
        $this->name = $Query->name;
        $this->emit('modal', 'EntryTypeModel');
    }

    public function entryTypeDelete($id)
    {
        EntryTypeInfo::find($id)->delete();

        $this->emit('success', [
            'text' => 'Entry Type Deleted Successfully',
        ]);
    }

    public function entryTypeModal()
    {
        $this->reset();
        $this->emit('modal', 'EntryTypeModel');
    }
    public function render()
    {
        return view('livewire.accounts-setting.entry-type');
    }
}
