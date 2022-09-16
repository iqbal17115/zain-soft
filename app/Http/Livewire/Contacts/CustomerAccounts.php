<?php

namespace App\Http\Livewire\Contacts;

use App\Models\Accounts\AccountManager;
use App\Models\AccountSettings\Branch;
use App\Models\AccountSettings\ChartOfAccount;
use App\Models\Contact\Contact;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CustomerAccounts extends Component
{
    public $code;
    public $type;
    public $name;
    public $sale_commission;
    public $is_due_sale;
    public $is_default;
    public $business_name;
    public $email;
    public $mobile;
    public $trn_no;
    public $address;
    public $company_id;
    public $branch_id;
    public $opening_balance;
    public $credit_limit;
    public $status = 1;
    public $due_date;
    public $telephone;
    public $country;
    public $division;
    public $credit_period;
    public $vat_reg_type;
    public $vat_reg_date;
    public $bank_details;
    public $website;
    public $customer_id = null;

    public function CustomerSave()
    {
        $this->validate([
            'name' => 'required',
        ]);

        if($this->vat_reg_type=="Registered"){
            $this->validate([
                'vat_reg_date' => 'required',
            ]);
        }
        if($this->vat_reg_type=="Registered"){
            $this->validate([
                'trn_no' => 'required',
            ]);
        }
        if ($this->customer_id) {
            $Query = Contact::find($this->customer_id);
        } else {
            $Query = new Contact();
            $Query->user_id = Auth::id();
        }
        $Query->code = $this->code;
        $Query->type = 'customer';
        $Query->name = $this->name;
        $Query->business_name = $this->business_name;
        $Query->email = $this->email;
        $Query->mobile = $this->mobile;
        $Query->opening_balance = $this->opening_balance;
        $Query->trn_no = $this->trn_no;
        $Query->sale_commission = $this->sale_commission;
        // $Query->is_due_sale = $this->is_due_sale;
        $Query->is_default = $this->is_default;
        $Query->company_id = Auth::user()->company_id;
        $Query->address = $this->address;
        $this->status = $Query->status;
        $Query->branch_id = $this->branch_id;
        $Query->credit_limit = $this->credit_limit;
        $Query->due_date = $this->due_date;
        $Query->telephone = $this->telephone;
        $Query->country = $this->country;
        $Query->division = $this->division;
        $Query->credit_period = $this->credit_period;
        $Query->vat_reg_type = $this->vat_reg_type;
        $Query->vat_reg_date = $this->vat_reg_date;
        $Query->bank_details = $this->bank_details;
        $Query->website = $this->website;
        $Query->save();

        if ($this->opening_balance) {
            $openBalanceChartId = ChartOfAccount::whereDefaultModule(7)->first('id')->id;
            $receivableChartId = ChartOfAccount::whereDefaultModule(5)->first('id')->id;
            $payableChartId = ChartOfAccount::whereDefaultModule(6)->first('id')->id;

            if ($openBalanceChartId) {
                $LedgerEntry = AccountManager::whereContactId($Query->id);
                $LedgerEntry->where('dr_account_id', $receivableChartId);
                $LedgerEntry->where('cr_account_id', $openBalanceChartId);
                $LedgerEntry = $LedgerEntry->firstOrNew();

                $LedgerEntry->amount = $this->opening_balance;
                $LedgerEntry->contact_id = $Query->id;
                $LedgerEntry->date = Carbon::now();
                $LedgerEntry->user_id = Auth::id();
                $LedgerEntry->type = 'Debit';
                $LedgerEntry->dr_account_id = $receivableChartId;
                $LedgerEntry->cr_account_id = $openBalanceChartId;

                $LedgerEntry->save();
            }
        }
        $this->CustomerModal();
        $this->emit('success', [
            'text' => 'Customer Accounts C/U Successfully',
        ]);
    }

    public function CustomerAccountsEdit($id)
    {
        $Query = Contact::find($id);
        $this->customer_id = $Query->id;
        $this->code = $Query->code;
        $this->name = $Query->name;
        $this->business_name = $Query->business_name;
        $this->email = $Query->email;
        $this->mobile = $Query->mobile;
        $this->opening_balance = $Query->opening_balance;
        $this->trn_no = $Query->trn_no;
        $this->sale_commission = $Query->sale_commission;
        // $this->is_due_sale = $Query->is_due_sale;
        $this->is_default = $Query->is_default;
        $this->company_id = $Query->company_id;
        $this->address = $Query->address;
        $this->status = $Query->status;
        $this->branch_id = $Query->branch_id;
        $this->credit_limit = $Query->credit_limit;
        $this->due_date = $Query->due_date;
        $this->telephone = $Query->telephone;
        $this->country = $Query->country;
        $this->division = $Query->division;
        $this->credit_period = $Query->credit_period;
        $this->vat_reg_type = $Query->vat_reg_type;
        $this->vat_reg_date = $Query->vat_reg_date;
        $this->bank_details = $Query->bank_details;
        $this->website = $Query->website;
        $this->emit('modal', 'CustomerModalBox');
    }

    public function CustomerAccountsDelete($id)
    {
        Contact::find($id)->delete();

        $this->emit('success', [
            'text' => 'Coustomer Accounts Delete Successfully',
        ]);
    }

    public function GenerateCode()
    {
        $check_row = Contact::orderBy('id', 'desc')->first();
        if (!$check_row) {
            $this->code = 'C001';
        } else {
            $this->code = ++$check_row->id;
            if ($this->code <= 9) {
                $this->code = 'C00'.$this->code;
            } elseif ($this->code <= 99) {
                $this->code = 'C0'.$this->code;
            }
        }
        // dd($this->code);
    }

    public function CustomerModal()
    {
        $this->reset();
        // $this->code = 'CU' . floor(time() - 999999999);
        $this->GenerateCode();
        $this->emit('modal', 'CustomerModalBox');
    }

    public function render()
    {
        return view('livewire.contacts.customer-accounts', [
            'branches' => Branch::whereCompanyId(Auth::user()->company_id)->get(),
        ]);
    }
}
