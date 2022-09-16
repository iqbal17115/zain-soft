<?php

namespace App\Http\Livewire\AccountsModule;

use App\Models\Accounts\AccountManager;
use App\Models\Accounts\Transaction;
use App\Models\AccountSettings\ChartOfAccount;
use App\Models\Billing\Invoice;
use App\Models\Contact\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Traits\NumberToWord;
use Livewire\Component;

class CustomerPayment extends Component
{
    use NumberToWord;
    public $contact_id;
    public $date;
    public $code;
    public $type = 'Receive';
    public $amount = 0;
    public $chart_of_account_id;
    public $invoice_code;
    public $invoice_no = [];
    public $transaction_id;
    public $note;
    public $QueryUpdate;
    public $ifCheque;
    public $due_date;
    public $due_amount;
    public $invoice_due = 0;
    public $Invoice;
    public $invoice;
    public $transaction;
    public $selected_invoice_code;
    public $PaidAmount = 0;
    public $InvoiceCodes;
    public $company_id;
    public $selectedInvoiceCode = [];
    public $selectedInvoiceId = [];
    public $InvoiceCodesByTransaction;

    public function InvoiceModal($id)
    {
        $this->transaction = Transaction::find($id);
        $invoice_ids = explode(", ", $this->transaction->invoice_ids);
        $this->InvoiceCodesByTransaction = Invoice::whereIn('id', $invoice_ids)->select('code')->get();
        $this->emit('modal', 'InvoiceModal');
    }
    public function InvoicePrint($id)
    {
        $this->emit('redirect', [
            'url' => route('accounts-module.customer-payment-invoice', ['id' => $id]),
        ]);
    }
    public function CustomerPayementSave()
    {
        $this->validate([
            'code' => 'required',
            'contact_id' => 'required',
            'amount' => 'required',
            'date' => 'required',
            // 'invoice_code' => 'required',
            'chart_of_account_id' => 'required'
        ]);
        DB::transaction(function () {
            // $invoice_code=explode(", ", $this->selectedInvoiceId);


            $invoice = Invoice::whereIn('id', $this->selectedInvoiceId)->get();

            $TotalInvoicePaidAmount = 0;
            $TotalAmountToPay = 0;
            $TotalAmount = $this->amount;
            foreach ($invoice as $invoice_val) {
                if ($this->amount > 0) {
                    $invoiceUp = Invoice::find($invoice_val->id);
                    if ($invoiceUp->due_amount > 0) {
                        if ($invoiceUp->due_amount <= $this->amount) {
                            $this->amount -= $invoiceUp->due_amount;
                            $invoiceUp->paid_amount = $invoiceUp->paid_amount + $invoiceUp->due_amount;
                            $invoiceUp->due_amount = 0;
                            $invoiceUp->payment_status = 'Paid';
                            $invoiceUp->save();
                        } else {
                            // dd($this->amount);
                            $invoiceUp->due_amount = $invoiceUp->due_amount - $this->amount;
                            $invoiceUp->paid_amount = $invoiceUp->paid_amount + $this->amount;
                            $invoiceUp->payment_status = 'Due';
                            $this->amount = 0;
                            $invoiceUp->save();
                            break;
                        }
                    }

                    // $TotalInvoicePaidAmount += $invoiceUp->InvoicePaidAmount->sum('amount');
                    // $TotalAmountToPay += $invoiceUp->amount_to_pay;
                    // $invoiceUp->paid_amount=$invoiceUp->InvoicePaidAmount->sum('amount');
                    // $invoiceUp->due_amount=$invoiceUp->amount_to_pay-$invoiceUp->InvoicePaidAmount->sum('amount');

                    // $invoice->paid_amount=$invoice->InvoicePaidAmount->sum('amount');
                    // $invoice->due_amount=$invoice->amount_to_pay-$invoice->InvoicePaidAmount->sum('amount');
                    // $invoiceUp->save();
                }
            }
            // dd(implode(", ", $this->selectedInvoiceId));
            if ($invoice) {
                if ($this->transaction_id) {
                    $Query = $this->QueryUpdate;
                } else {
                    $Query = new Transaction();
                }
                $Query->code = $this->code;
                $Query->date = $this->date;
                $Query->due_date = $this->due_date;
                $Query->type = $this->type;
                $Query->contact_id = $this->contact_id;
                $Query->amount = $TotalAmount;
                $Query->chart_of_account_id = $this->chart_of_account_id;
                $Query->note = $this->note;
                $Query->invoice_ids = implode(", ", $this->selectedInvoiceId);
                $Query->user_id = Auth::id();
                $Query->company_id = Auth::user()->company_id;
                $Query->save();

                $receivableChartId = ChartOfAccount::whereDefaultModule(5)->first('id')->id;
                $accountManager = AccountManager::whereTransactionId($Query->id)->whereCrAccountId($receivableChartId)->whereDrAccountId($Query->chart_of_account_id)->firstOrNew();
                $accountManager->code = $this->code;
                $accountManager->date = $this->date;
                $accountManager->transaction_id = $this->transaction_id;
                $accountManager->type = 'Debit';
                $accountManager->dr_account_id = $Query->chart_of_account_id;
                $accountManager->cr_account_id = $receivableChartId;
                // $accountManager->invoice_id=$invoice->id;
                // dd($accountManager->count());
                $accountManager->transaction_id = $Query->id;
                $accountManager->contact_id = $Query->contact_id;
                $accountManager->amount = $Query->amount;
                $accountManager->note = $Query->note;
                $accountManager->user_id = Auth::id();
                $accountManager->branch_id = Auth::user()->branch_id;
                $accountManager->company_id = Auth::user()->company_id;
                $accountManager->status = 1;

                if ($this->due_date) {
                    $accountManager->due_date = $this->due_date;
                    $accountManager->payment_status = 'Hold';
                } else {
                    $accountManager->payment_status = 'Active';
                }

                $accountManager->save();
                // Start Pay Due Amount
                //  foreach($this->selectedInvoiceId as $InvoiceId){
                //     dd($InvoiceId);
                //  }
                //  End Pay Due Amount
                $this->reset();
                $this->code = 'CP' . floor(time() - 999999999);
                $this->emit('success', [
                    'text' => 'Transaction C\U Successfully',
                ]);
            } else {
                $this->emit('error', [
                    'text' => 'This is Not Correct Invoice No',
                ]);
            }
        });
    }


    public function CustomerPaymentEdit($id)
    {
        $this->QueryUpdate = Transaction::find($id);
        $this->transaction_id = $this->QueryUpdate->id;
        $this->code = $this->QueryUpdate->code;
        $this->date = $this->QueryUpdate->date;
        $this->type = $this->QueryUpdate->type;
        $this->contact_id = $this->QueryUpdate->contact_id;
        $this->amount = $this->QueryUpdate->amount;
        $this->chart_of_account_id = $this->QueryUpdate->chart_of_account_id;
        $this->note = $this->QueryUpdate->note;
        if ($this->QueryUpdate->Invoice) {
            $this->invoice_code = $this->QueryUpdate->Invoice->code;
        }
        // dd($this->selectedInvoiceCode);
        $transaction = Transaction::whereInvoiceIds($this->QueryUpdate->invoice_ids)->first();
        if ($transaction) {
            $this->amount = $transaction->amount;
        }
        // $this->amount=
        $InvoiceCodes = explode(", ", $this->QueryUpdate->invoice_ids);
        foreach ($InvoiceCodes as $key => $value) {
            $Invoice = Invoice::find($value);
            array_push($this->selectedInvoiceCode, $Invoice->code);
            $this->invoice_due += $Invoice->due_amount;
            $this->InvoiceCodes = implode(", ", $this->selectedInvoiceCode);
        }
    }

    public function CustomerPaymentDelete($id)
    {
        DB::transaction(function () use ($id) {
            $transaction = Transaction::find($id);
            AccountManager::whereTransactionId($id)->delete();
            $IDS = explode(", ", $transaction->invoice_ids);
            // $invoice = Invoice::where('id', $transaction->invoice_id);
            foreach ($IDS as $id) {
                $invoice = Invoice::find($id);
                if (isset($invoice->InvoicePaidAmount)) {
                    $invoice->paid_amount = $invoice->InvoicePaidAmount->sum('amount');
                    $invoice->due_amount = $invoice->amount_to_pay - $invoice->InvoicePaidAmount->sum('amount');
                    $invoice->save();
                }
            }

            $transaction->delete();
            $this->emit('success', [
                'text' => 'Transaction C\U Successfully',
            ]);
        });
    }
    public function mount()
    {
        if (request()->filled('invoice_code')) {
            $this->Invoice = Invoice::where('code', request()->invoice_code)->first();
        }

        $this->code = 'CP' . floor(time() - 999999999);
        $this->date = Carbon::now()->format('Y-m-d');

        if ($this->Invoice) {
            $this->contact_id = $this->Invoice->contact_id;
            $this->invoice_code = $this->Invoice->code;
            //    $this->amount=$this->Invoice->paid_amount;
        }
    }



    public function render()
    {
        $InvoiceDue = [];
        if ($this->invoice_code) {
            // dd($this->to_user_id);
            $invoice = Invoice::whereCode($this->invoice_code)->first();
            if ($invoice) {
                $this->invoice_due = $invoice->due_amount;
            } else {
                $this->invoice_due = NULL;
            }
            //    dd($User);
        }

        if ($this->transaction_id && $this->contact_id) {
            $this->invoice_no = Invoice::whereContactId($this->contact_id)->get('code');
        } elseif ($this->contact_id) {
            $this->invoice_no = Invoice::whereContactId($this->contact_id)->wherePaymentStatus('Due')->whereNotIn('code', $this->selectedInvoiceCode)->get('code');
        }



        $total = 0;
        if ($this->transaction) {
            $IDS = explode(", ", $this->transaction->invoice_ids);
            $invoice = Invoice::find(4);
            // dd($invoice);
            $invoice_amount_to_pay = Transaction::where('invoice_ids', $this->transaction->invoice_ids)->sum('amount');
            $total = $this->numtowords($invoice_amount_to_pay, $invoice->Branch->Currency->in_word_prefix, $invoice->Branch->Currency->in_word_surfix, $invoice->Branch->Currency->in_word_prefix_position, $invoice->Branch->Currency->in_word_surfix_position);
        }
        if (isset($this->selected_invoice_code[0]) && !in_array($this->selected_invoice_code[0], $this->selectedInvoiceCode)) {
            array_push($this->selectedInvoiceCode, $this->selected_invoice_code[0]);
            $InvoiceCal = Invoice::whereCode($this->selected_invoice_code[0])->first();
            array_push($this->selectedInvoiceId, $InvoiceCal->id);
            $this->invoice_due += $InvoiceCal->due_amount;
            $this->InvoiceCodes = implode(", ", $this->selectedInvoiceCode);
        }
        return view('livewire.accounts-module.customer-payment', [
            'contacts' => Contact::where('type', 'customer')->get(),
            'chartofaccounts' => ChartOfAccount::whereNotNull('is_cashbank')->get(),
            'total' => $total,
        ]);
    }
}
