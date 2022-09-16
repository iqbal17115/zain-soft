<?php

namespace App\Http\Livewire\AccountsSetting;

use App\Models\AccountSettings\PaymentMethod as PaymentMethodTable;
use App\Models\AccountSettings\Branch;
use App\Models\AccountSettings\CompanyInfo;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PaymentMethod extends Component
{

    public $code;
    public $name;
    public $type;
    public $is_active;
    public $user_id;
    public $branch_id;
    public $company_info_id;
    public $status=1;
    public $payment_method_id;

    public function PaymentMethodSave()
    {
        $this->validate([
            'code' => 'required',
            'name' => 'required',
            'type' => 'required',
            'is_active' => 'required',
            'branch_id' => 'required',
            'company_info_id' => 'required',
            'status'    => 'required',
        ]);

        if ($this->payment_method_id) {
            $Query = PaymentMethodTable::find($this->payment_method_id);
        } else {
            $Query  = new PaymentMethodTable();
            $Query->user_id = Auth::id();
        }
        $Query->code = $this->code;
        $Query->name = $this->name;
        $Query->type = $this->type;
        $Query->is_active = $this->is_active;
        $Query->branch_id = $this->branch_id;
        $Query->status = $this->status;
        $Query->company_info_id = $this->company_info_id;
        $Query->save();
        $this->emit('modal', 'PaymentMethodModal');
        $this->emit('success', [
            'text' => 'Payment Method C\U Successfully',
        ]);
    }


    public function PaymentMethodEdit($id)
    {
        $Query = PaymentMethodTable::find($id);
        $this->payment_method_id = $Query->id;
        $this->code  = $Query->code;
        $this->name  = $Query->name;
        $this->type  = $Query->type;
        $this->is_active = $Query->is_active;
        $this->branch_id = $Query->branch_id;
        $this->status = $Query->status;
        $this->company_info_id = $Query->company_info_id;
        $this->emit('modal', 'PaymentMethodModal');
    }

    public function PaymentMethodDelete($id)
    {
        PaymentMethodTable::find($id)->delete();
        $this->emit('success', [
            'text' => 'Head of Account deleted Successfully',
        ]);
    }

    public function PaymentMethodModal()
    {
        $this->reset();
        $this->code = 'PA' . floor(time() - 999999999);
        $this->emit('modal', 'PaymentMethodModal');
    }
    public function render()
    {
        return view('livewire.accounts-setting.payment-method', [
            'branches' => Branch::get(),
            'companies' => CompanyInfo::get(),
        ]);
    }
}
