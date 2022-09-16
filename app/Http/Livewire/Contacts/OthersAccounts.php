<?php

namespace App\Http\Livewire\Contacts;

use App\Models\AccountSettings\Branch;
use App\Models\Contact\Contact;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;


class OthersAccounts extends Component
{

    public $code;
    public $name;
    public $type;
    public $email;
    public $mobile;
    public $business_name;
    public $trn_no;
    public $sale_commission;
    public $is_due_sale;
    public $is_default;
    public $company_id;
    public $address;
    public $opening_balance;
    public $branch_id;
    public $status=1;
    public $credit_limit;
    public $due_date;
    public $other_account_id;



    public function OthersAccountSave()
    {

        $this->validate([
            'name' => 'required',
        ]);
        if ($this->other_account_id) {
            $Query  = Contact::find($this->other_account_id);
        } else {

            $Query = new Contact();
            $Query->user_id = Auth::id();
        }
        $Query->code = $this->code;
        $Query->name = $this->name;
        $Query->type = 'others';
        $Query->email = $this->email;
        $Query->mobile = $this->mobile;
        $Query->business_name = $this->business_name;
        $Query->trn_no = $this->trn_no;
        $Query->sale_commission = $this->sale_commission;
        $Query->is_due_sale = $this->is_due_sale;
        $Query->is_default = $this->is_default;
        $Query->company_id = Auth::user()->company_id;
        $Query->opening_balance = $this->opening_balance;
        $Query->branch_id = $this->branch_id;
        $Query->address = $this->address;
        $Query->status = $this->status;
        $Query->credit_limit = $this->credit_limit;
        $Query->due_date = $this->due_date;
        $Query->save();
        $this->OtherAccountModal();
        $this->emit('success', [
            'text' => 'Others Accounts C/U Successfully',
        ]);
    }

    public function OthersAccountsEdit($id)
    {
        $Query = Contact::find($id);
        $this->other_account_id = $Query->id;
        $this->code = $Query->code;
        $this->name = $Query->name;
        $this->email = $Query->email;
        $this->address = $Query->address;
        $this->mobile = $Query->mobile;
        $this->status = $Query->status;
        $this->sale_commission = $Query->sale_commission;
        $this->is_due_sale = $Query->is_due_sale;
        $this->is_default = $Query->is_default;
        $this->company_id = $Query->company_id;
        $this->opening_balance = $Query->opening_balance;
        $this->branch_id = $Query->branch_id;
        $this->business_name = $Query->business_name;
        $this->trn_no = $Query->trn_no;
        $this->credit_limit = $Query->credit_limit;
        $this->due_date = $Query->due_date;
        $this->emit('modal', 'OtherAccountModal');
    }

    public function OthersAccountsDelete($id)
    {
        Contact::find($id)->delete();
        $this->emit('success', [
            'text' => 'Others Accounts deleted Successfully',
        ]);
    }
    public function GenerateCode(){
        $check_row=Contact::orderBy('id', 'desc')->first();
        if(!$check_row){
          $this->code="O001";
        }else{
          $this->code=++$check_row->id;
          if($this->code<=9){
            $this->code="O00".$this->code;
          }else if($this->code<=99){
            $this->code="O0".$this->code;
          }
        }
        // dd($this->code);
    }
    public function OtherAccountModal()
    {
        $this->reset();
        $this->GenerateCode();
        $this->emit('modal', 'OtherAccountModal');
    }

    public function render()
    {
        return view('livewire.contacts.others-accounts', [
            'branches' => Branch::whereCompanyId(Auth::user()->company_id)->get()
        ]);
    }
}
