<?php

namespace App\Http\Livewire\Contacts;

use App\Models\AccountSettings\Branch;
use App\Models\Contact\Contact;
use App\Models\Setting\Company;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class StaffAccounts extends Component
{

    public $code;
    public $type;
    public $name;
    public $email;
    public $mobile;
    public $business_name;
    public $address;
    public $opening_balance;
    public $branch_id;
    public $trn_no;
    public $sale_commission;
    public $is_due_sale;
    public $is_default;
    public $user_id;
    public $company_id;
    public $credit_limit;
    public $due_date;
    public $staff_id;
    public $status=1;


    public function StaffSave()
    {

        $this->validate([
            'name' => 'required',
        ]);
        if ($this->staff_id) {
            $Query = Contact::find($this->staff_id);
        } else {
            $Query = new Contact();
            $Query->user_id = Auth::id();
        }
        $Query->code = $this->code;
        $Query->type = 'staff';
        $Query->name = $this->name;
        $Query->business_name = $this->business_name;
        $Query->email = $this->email;
        $Query->mobile = $this->mobile;
        $Query->trn_no = $this->trn_no;
        $Query->sale_commission = $this->sale_commission;
        $Query->is_due_sale = $this->is_due_sale;
        $Query->is_default = $this->is_default;
        $Query->opening_balance = $this->opening_balance;
        // $Query->company_id = Auth::user()->company_id;
        $Query->company_id = $this->company_id;
        $Query->branch_id = $this->branch_id;
        $Query->address = $this->address;
        $Query->status = $this->status;
        $Query->credit_limit = $this->credit_limit;
        $Query->due_date = $this->due_date;
        $Query->save();
        $this->StaffModal();
        $this->emit('success', [
            'text' => 'Customer Accounts C/U Successfully',
        ]);
    }


    public function StaffAccountsEdit($id)
    {
        $Query = Contact::find($id);
        $this->staff_id  = $Query->id;
        $this->code = $Query->code;
        $this->name = $Query->name;
        $this->business_name = $Query->business_name;
        $this->email  = $Query->email;
        $this->mobile = $Query->mobile;
        $this->opening_balance = $Query->opening_balance;
        $this->branch_id = $Query->branch_id;
        $this->trn_no = $Query->trn_no;
        $this->sale_commission = $Query->sale_commission;
        $this->is_due_sale = $Query->is_due_sale;
        $this->is_default = $Query->is_default;
        $this->company_id = $Query->company_id;
        $this->address = $Query->address;
        $this->status  = $Query->status;
        $this->credit_limit = $Query->credit_limit;
        $this->due_date = $Query->due_date;
        $this->emit('modal', 'StaffModal');
    }

    public function StaffAccountsDelete($id)
    {
        Contact::find($id)->delete();

        $this->emit('success', [
            'text' => 'Staff Accounts has been deleted successfully',
        ]);
    }
    public function GenerateCode(){
        $check_row=Contact::orderBy('id', 'desc')->first();
        if(!$check_row){
          $this->code="ST001";
        }else{
          $this->code=++$check_row->id;
          if($this->code<=9){
            $this->code="ST00".$this->code;
          }else if($this->code<=99){
            $this->code="ST0".$this->code;
          }
        }
        // dd($this->code);
    }
    public function StaffModal()
    {
        $this->reset();
        $this->GenerateCode();
        $this->emit('modal', 'StaffModal');
    }

    public function render()
    {
        return view('livewire.contacts.staff-accounts', [
            'branches' => Branch::whereCompanyId(Auth::user()->company_id)->get(),
            'companies' => Company::get()
        ]);
    }
}
