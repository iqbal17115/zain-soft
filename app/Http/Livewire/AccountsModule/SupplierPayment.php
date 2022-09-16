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

class SupplierPayment extends Component
{
    use NumberToWord;

    public $contact_id;
    public $date;
    public $code;
    public $type='Payment';
    public $amount;
    public $chart_of_account_id;
    public $invoice_code;
    public $InvoiceId;
    public $Invoice;
    public $transaction_id;
    public $note;
    public $QueryUpdate;
    public $company_id;
    public $ifCheque;
    public $due_date;
    public $invoice_due;
    public $transaction;

    public function InvoiceModal($id){
        $this->transaction=Transaction::find($id);
        $this->emit('modal', 'InvoiceModal');
    }
    public function InvoicePrint($id){
        $this->emit('redirect', [
            'url' => route('accounts-module.supplier-payment-invoice', ['id' => $id]),
        ]);
    }

    public function SupplierPayementSave()
    {
        $this->validate([
            'code' => 'required',
            'contact_id' => 'required',
            'amount' => 'required',
            'date' => 'required',
            'invoice_code' => 'required',
            'chart_of_account_id' => 'required'
        ]);
        DB::transaction(function () {
        $invoice =Invoice::whereCode($this->invoice_code)->first();
        if($invoice){
        if($this->transaction_id){
            $Query= $this->QueryUpdate;
        }else{
            $Query = new Transaction();
        }
        $Query->code = $this->invoice_code;
        $Query->date = $this->date;
        $Query->due_date = $this->due_date;
        $Query->type = $this->type;
        $Query->contact_id = $this->contact_id;
        $Query->amount = $this->amount;
        $Query->chart_of_account_id = $this->chart_of_account_id;
        $Query->note = $this->note;
        $Query->invoice_id = $invoice->id;
        $Query->user_id = Auth::id();
        $Query->company_id = Auth::user()->company_id;
        $Query->save();

        $payableChartId = ChartOfAccount::whereDefaultModule(6)->first('id')->id;

                $accountManager=AccountManager::whereTransactionId($Query->id)->whereCrAccountId( $Query->chart_of_account_id)->whereDrAccountId($payableChartId)->firstOrNew();
                $accountManager->code=$this->code;
                $accountManager->date=$this->date;
                $accountManager->transaction_id=$this->transaction_id;
                $accountManager->type='Credit';
                $accountManager->dr_account_id=$payableChartId;
                $accountManager->cr_account_id=$Query->chart_of_account_id;
                $accountManager->invoice_id=$invoice->id;
                $accountManager->transaction_id=$Query->id;
                $accountManager->contact_id= $Query->contact_id;
                $accountManager->amount= $Query->amount;
                $accountManager->note=$Query->note;
                $accountManager->user_id=Auth::id();
                $accountManager->branch_id=Auth::user()->branch_id;
                $accountManager->company_id=Auth::user()->company_id;
                $accountManager->status=1;
                if($this->due_date){
                    $accountManager->due_date=$this->due_date;
                    $accountManager->payment_status='Hold';
                }else{
                    $accountManager->payment_status='Active';
                }
                $accountManager->save();


                $invoice->paid_amount=$invoice->InvoicePaidAmount->sum('amount');
                $invoice->due_amount=$invoice->amount_to_pay-$invoice->InvoicePaidAmount->sum('amount');
                $invoice->save();

                $this->reset();

                $this->code = 'SP'.floor(time() - 999999999);
                $this->date=Carbon::now()->format('Y-m-d');
                $this->emit('success', [
                    'text' => 'Supplier Payment Successfully Successfully',
                ]);
            }else{
                $this->emit('error', [
                    'text' => 'This is Not Correct Invoice No',
                ]);
            }
        });

    }


    public function SupplierPaymentEdit($id)
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
        $this->invoice_code = $this->QueryUpdate->Invoice->code;
    }




    public function SupplierPaymentDelete($id)
    {
        $transaction=Transaction::find($id);
        AccountManager::whereTransactionId($id)->delete();
        $invoice=Invoice::find($transaction->invoice_id);
        $invoice->paid_amount=$invoice->InvoicePaidAmount->sum('amount');
        $invoice->due_amount=$invoice->amount_to_pay-$invoice->InvoicePaidAmount->sum('amount');
        $invoice->save();
        $transaction->delete();
        $this->emit('success', [
            'text' => 'Transaction C\U Successfully',
        ]);
    }
    public function mount($invoice_code=NULL){
        if (request()->filled('invoice_code')) {
            $this->Invoice=Invoice::where('code', request()->invoice_code)->first();
        }
        $this->code = 'SP'.floor(time() - 999999999);
        $this->date=Carbon::now()->format('Y-m-d');

        if($this->Invoice){
            $this->contact_id=$this->Invoice->contact_id;
            $this->invoice_code=$this->Invoice->code;
            // $this->amount=$this->Invoice->paid_amount;
         }
    }



    public function render()
    {
        $InvoiceDue=[];
        if($this->invoice_code){
            // dd($this->to_user_id);
            $invoice =Invoice::whereCode( $this->invoice_code)->first();
           if($invoice){
               $this->invoice_due= $invoice->due_amount;
           }else{
            $this->invoice_due=NULL;
           }
        //    dd($User);
        }

        $total=0;
        if($this->transaction){
        $invoice=Invoice::find($this->transaction->invoice_id);
        $total=$this->numtowords($this->transaction->amount, $invoice->Branch->Currency->in_word_prefix, $invoice->Branch->Currency->in_word_surfix, $invoice->Branch->Currency->in_word_prefix_position, $invoice->Branch->Currency->in_word_surfix_position);
        }
        return view('livewire.accounts-module.supplier-payment',[
            'contacts' => Contact::where('type', 'Supplier')->get(),
            'chartofaccounts' => ChartOfAccount::whereNotNull('is_cashbank')->get(),
            'total'=>$total,
        ]);
    }
}
