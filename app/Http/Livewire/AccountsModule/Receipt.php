<?php

namespace App\Http\Livewire\AccountsModule;

use App\Models\Accounts\AccountManager;
use App\Models\Accounts\Receipt as AccountsReceipt;
use App\Models\AccountSettings\ChartOfAccount;
use App\Models\AccountSettings\EntryType;
use App\Models\AccountSettings\EntryTypeAccountList;
use App\Models\AccountSettings\Tag;
use App\Models\Contact\Contact;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Receipt extends Component
{
    public $date;
    public $code;
    public $contact_id;
    public $note;
    public $type = [];
    public $tag_id;
    public $chart_of_account_id;
    public $payment_method_id;
    public $amount = [];
    public $dr_amount = [];
    public $cr_amount = [];
    public $dr_amount_total;
    public $cr_amount_total;
    public $cartList = [];
    public $cheque_payment_date = [];
    public $item_chart_of_account_id;
    public $item_contact_id;
    public $item_amount;
    public $item_type;
    public $EntryType;
    public $ifCheque;
    public $cheque_date;
    public $ChartOfAccountCheque;
    public $Receipt;

    public function mount($id = null)
    {
        $this->date = Carbon::now()->format('Y-m-d');
        // dd($this->date);
        if ($_GET) {
            $this->EntryType = EntryType::find($_GET['entry_type']);
        }
        $this->Receipt = AccountsReceipt::find($id);

        $this->GenerateCode();
        if ($id) {
            $Receipt = $this->Receipt;
            $this->code = $Receipt->code;
            $this->EntryType = EntryType::find($Receipt->entry_type_id);
            $this->date = Carbon::parse($Receipt->date);
            $this->note = $Receipt->note;

            $LedgerEntry = AccountManager::whereReceiptId($Receipt->id)->get();
            $cartList = collect($this->cartList);
            foreach ($LedgerEntry as $LedgerEntry) {
                if ($LedgerEntry->dr_account_id == null) {
                    $ChartOfAccount = ChartOfAccount::find($LedgerEntry->cr_account_id);
                } else {
                    $ChartOfAccount = ChartOfAccount::find($LedgerEntry->dr_account_id);
                }
                $Contact = Contact::find($LedgerEntry->contact_id);
                $cartList = collect($this->cartList);

                $cartItem = [
                    'id' => $LedgerEntry->id,
                    'chart_of_account_id' => $ChartOfAccount->id,
                    'chart_of_account_name' => $ChartOfAccount->name,
                    'contact_id' => $Contact->id,
                    'contact_name' => $Contact->name
                ];

                $this->cartList = $cartList->push($cartItem);

                $key = $cartList->keys()->last();

                $this->amount[$key] = $LedgerEntry->amount;
                $this->type[$key] = $LedgerEntry->type;

                if ($LedgerEntry->type == 'Debit') {
                    $this->dr_amount[$key] = $LedgerEntry->amount;
                } else {
                    $this->dr_amount[$key] = 0;
                }

                if ($LedgerEntry->type == 'Credit') {
                    $this->cr_amount[$key] = $LedgerEntry->amount;
                } else {
                    $this->cr_amount[$key] = 0;
                }

                $this->dr_amount_total = 0;
                $this->cr_amount_total = 0;
                foreach ($this->cartList as $key => $amount) {
                    $this->dr_amount_total += $this->dr_amount[$key];
                    $this->cr_amount_total += $this->cr_amount[$key];
                }
            }
            $this->cartList = $cartList;
            // $this->updateItemCal();
        }
    }

    public function add()
    {
        $this->validate([
            'item_contact_id' => 'required',
            'item_chart_of_account_id' => 'required',
            'item_type' => 'required',
            'item_amount' => 'required',
           ]);
        $ChartOfAccount = ChartOfAccount::find($this->item_chart_of_account_id);
        $Contact = Contact::find($this->item_contact_id);

        $cartList = collect($this->cartList);

        $cartItem = [
            'id' => null,
            'chart_of_account_id' => $ChartOfAccount->id,
            'chart_of_account_name' => $ChartOfAccount->name,
            'contact_id' => $Contact->id,
            'contact_name' => $Contact->name,
        ];

        $this->cartList = $cartList->push($cartItem);

        $key = $cartList->keys()->last();

        $this->amount[$key] = $this->item_amount;
        $this->type[$key] = $this->item_type;
        $this->cheque_payment_date[$key] = $this->cheque_date;

        if ($this->item_type == 'Debit') {
            $this->dr_amount[$key] = $this->item_amount;
        } else {
            $this->dr_amount[$key] = 0;
        }

        if ($this->item_type == 'Credit') {
            $this->cr_amount[$key] = $this->item_amount;
        } else {
            $this->cr_amount[$key] = 0;
        }

        $this->dr_amount_total = 0;
        $this->cr_amount_total = 0;
        foreach ($this->cartList as $key => $amount) {
            $this->dr_amount_total += $this->dr_amount[$key];
            $this->cr_amount_total += $this->cr_amount[$key];
        }

        $this->reset(['item_chart_of_account_id', 'item_contact_id', 'item_type', 'item_amount']);
    }

    public function GenerateCode()
    {
        $check_row = AccountsReceipt::orderBy('id', 'desc')->first();
        if (!$check_row) {
            $this->code = 'R001';
        } else {
            $this->code = ++$check_row->id;
            if ($this->code <= 9) {
                $this->code = 'R00'.$this->code;
            } elseif ($this->code <= 99) {
                $this->code = 'R0'.$this->code;
            } else {
                $this->code = 'R'.$this->code;
            }
        }
        // dd($this->code);
    }

    public function Submit()
    {
        $this->validate([
         'date' => 'required',
         'code' => 'required',
         'contact_id' => 'required',
        ]);
        if ($this->dr_amount_total == $this->cr_amount_total) {
            if ($this->Receipt) {
                $Query = $this->Receipt;
                $message = $this->EntryType->name.' Updated Successfully';
            } else {
                $Query = new AccountsReceipt();
                $Query->user_id = Auth::id();
                $Query->entry_type_id = $this->EntryType->id;
                $message = $this->EntryType->name.' Submitted Successfully';
            }

            // dd($this->dr_amount_total);
            // $Query->date = Carbon::parse($this->date);
            $Query->date = $this->date;
            $Query->code = $this->code;
            if ($this->tag_id != null) {
                $Query->tag_id = $this->tag_id;
            }
            $Query->note = $this->note;
            $Query->amount = $this->dr_amount_total;
            $Query->branch_id = Auth::user()->branch_id;
            $Query->company_id = Auth::user()->company_id;
            $Query->save();
            // dd($this->type);
            foreach ($this->cartList as $key => $value) {
                $chartOfAccountid = ChartOfAccount::find($value['chart_of_account_id']);
                if (isset($value['id']) && $value['id']) {
                    $LedgerEntry = AccountManager::find($value['id']);
                } else {
                    $LedgerEntry = new AccountManager();
                }
                $LedgerEntry->code = 'Txn125';

                $LedgerEntry->type = $this->type[$key];
                $LedgerEntry->contact_id = $value['contact_id'];
                $LedgerEntry->receipt_id = $Query->id;
                $LedgerEntry->due_date = $this->cheque_payment_date[$key];
                if ($this->cr_amount[$key]) {
                    if (isset($value['chart_of_account_id']) && !empty($value['chart_of_account_id'])) {
                        $LedgerEntry->cr_account_id = $value['chart_of_account_id'];
                    }
                    $LedgerEntry->amount = $this->cr_amount[$key];
                } else {
                    if (isset($value['chart_of_account_id']) && !empty($value['chart_of_account_id'])) {
                        $LedgerEntry->dr_account_id = $value['chart_of_account_id'];
                    }
                    $LedgerEntry->amount = $this->dr_amount[$key];
                }
                if ($chartOfAccountid->is_cashbank != null) {
                    if ($this->cheque_payment_date[$key]) {
                        $LedgerEntry->payment_status = 'Hold';
                    } else {
                        $LedgerEntry->payment_status = 'Active';
                    }
                }

                $LedgerEntry->date = $this->date;
                $LedgerEntry->user_id = Auth::id();
                $LedgerEntry->branch_id = Auth::user()->branch_id;
                $LedgerEntry->company_id = Auth::user()->company_id;
                $LedgerEntry->save();
            }
            if (!$this->Receipt) {
                $this->reset(['cartList', 'code', 'date', 'tag_id', 'note', 'dr_amount_total', 'cr_amount_total']);
            }
            $this->GenerateCode();

            $this->emit('success_redirect', [
                'text' => $message,
                'url' => route('accounts-module.receipt-invoice', ['id' => $Query->id]),
            ]);
        } else {
            $this->emit('error', [
                'text' => 'Dr & Cr Balance not matchss',
            ]);
        }
    }

    public function removeItem($itemId)
    {
        $cart = collect($this->cartList);
        $cart->pull($itemId);
        $this->cartList = $cart;
        $this->dr_amount_total = 0;
        $this->cr_amount_total = 0;
        foreach ($this->cartList as $key => $amount) {
            $this->dr_amount_total += $this->dr_amount[$key];
            $this->cr_amount_total += $this->cr_amount[$key];
        }
        // $this->reset(['cheque_date']);
    }

    public function render()
    {
        if ($this->item_chart_of_account_id) {
            $this->ChartOfAccountCheque = ChartOfAccount::whereId($this->item_chart_of_account_id)->where('is_cashbank', '!=', null)->first();
        } else {
            $this->ChartOfAccountCheque = null;
        }

        return view('livewire.accounts-module.receipt', [
            'Contact' => Contact::whereType('Staff')->get(),
            'Tag' => Tag::all(),
            'ChartOfAccount' => EntryTypeAccountList::whereEntryTypeId($this->EntryType->id)->get(),
        ]);
    }
}
