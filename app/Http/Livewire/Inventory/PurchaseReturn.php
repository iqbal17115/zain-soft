<?php

namespace App\Http\Livewire\Inventory;

use App\Models\Accounts\AccountManager;
use App\Models\AccountSettings\Branch;
use App\Models\AccountSettings\ChartOfAccount;
use App\Models\Billing\Invoice;
use App\Models\Contact\Contact;
use App\Models\Stock\Item;
use App\Models\Stock\StockManager;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PurchaseReturn extends Component
{
    public $item_return_amount;
    public $total_return_amount;
    public $return_due;
    public $subtotal;
    public $vat_total = 0;
    public $shipping_charge = 0;
    public $payment_method_id;
    public $payment_amount;
    public $receipt_code;
    public $paid_amount=0;
    public $purchase_payment_date;
    public $transaction_id;
    public $contact_id;
    public $code;
    public $stock_code;
    public $account_manager_code;
    public $date;
    public $return_date;
    public $return_quantity=[];
    public $InvoiceId;
    public $ifCheque;
    public $cheque_payment_date;
    public $return_vat_total;
    public $return_grand_total;
    public $return_subtotal;
    public $paymentMethodList = [];
    public $PurchaseInvoice;
    public  $PurchaseReturnInvoiceId;
    protected $listeners = [
        'payment_method_search' => 'AddPaymentMethod',
    ];

    public function GetData($code){
        $PurchaseInvoice = Invoice::whereCode($code)->first();
        if($PurchaseInvoice){
           $id=$PurchaseInvoice->id;
           $this->PurchaseInvoice=$PurchaseInvoice;
           $PurchaseReturnInvoice = Invoice::whereInvoiceId($id)->first();

         if($PurchaseReturnInvoice){
           $this->PurchaseReturnInvoiceId  = $PurchaseReturnInvoice->id;
           $this->return_date = $PurchaseReturnInvoice->date;
           $this->return_due = $PurchaseReturnInvoice->due_amount;

           // $this->paid_amount  = $PurchaseReturnInvoice->paid_amount;
         }
           $this->InvoiceId = $PurchaseInvoice->id;
           $this->contact_id = $PurchaseInvoice->contact_id;
           $this->date = $PurchaseInvoice->date;
           $this->grand_total = $PurchaseInvoice->grand_total;
           $this->subtotal = $PurchaseInvoice->subtotal;

           $StockManager = StockManager::whereInvoiceId($PurchaseInvoice->id)->get();

           foreach ($StockManager as $stockProduct) {
               if($PurchaseReturnInvoice){
                   $getStock=StockManager::whereInvoiceId($PurchaseReturnInvoice->id)->whereItemId($stockProduct->item_id)->first();
                   if( $getStock){
                       $this->return_quantity[$stockProduct->id]=$getStock->quantity;
                       $this->item_return_amount[$stockProduct->id] = $getStock->subtotal;
                   }
               }
           }
            // Start Account Manager Edit
            if($PurchaseReturnInvoice){
               $PaymentList = AccountManager::whereInvoiceId($PurchaseReturnInvoice->id)->whereNotNull('payment_status')->where('payment_status','!=','Inactive')->get();

            }else{
               $PaymentList =null;
            }
            $cartPayment = collect($this->paymentMethodList);
               if( $PaymentList ){
                   foreach ($PaymentList as $paymentList) {
                       if ($paymentList->ChartOfAccountDr) {
                           $payment_name = $paymentList->ChartOfAccountDr->name;

                           $account_id = $paymentList->dr_account_id;
                       } else {
                           $payment_name = $paymentList->ChartOfAccountCr->name;
                           $account_id = $paymentList->cr_account_id;
                       }

                       $cartItem = [
                           'id' => $paymentList->id,
                           'payment_method_id' => $account_id,
                           'payment_method_name' => $payment_name,
                           'purchase_payment_date' => $paymentList->date,
                           'due_date' => $paymentList->due_date,
                           'transaction_id' => $paymentList->code,
                           'payment_amount' => $paymentList->amount,
                           'payment_code' => $paymentList->code,
                           'receopt_code' => $paymentList->note,
                       ];

                       $this->paymentMethodList = $cartPayment->push($cartItem);
                   }
                   $this->paymentMethodList = $cartPayment;
               }

            // End Account Manager Edit

            $this->updateItemCal();
        }
    }
    public function removePaymentList($itemId,$ChartId,$id=null)
    {
        $cart = collect($this->paymentMethodList);
        $accountManager=AccountManager::whereId($id)->whereInvoiceId($this->PurchaseReturnInvoiceId)->whereDrAccountId($ChartId)->first();
        if($accountManager){
            $accountManager->delete();
        }
        $cart->pull($itemId);
        $this->paymentMethodList = $cart;
        $this->updateItemCal();
    }

    public function AddPaymentMethod()
    {
        $this->validate([
            'payment_method_id' => 'required',
            'payment_amount' => 'required',
        ]);
        $PaymentMethod = ChartOfAccount::find($this->payment_method_id);
        $paymentMethodList = collect($this->paymentMethodList);
        $cartItem = [
            'id' => null,
            'date' => $this->purchase_payment_date,
            'payment_method_id' => $PaymentMethod->id,
            'payment_method_name' => $PaymentMethod->name,
            'payment_amount' => $this->payment_amount,
            'receipt_code' => $this->receipt_code,
            'transaction_id' => $this->transaction_id,
            'due_date' => $this->cheque_payment_date,
            'purchase_payment_date' => $this->purchase_payment_date,
            'receipt_code' => $this->receipt_code,
        ];
        $this->paymentMethodList = $paymentMethodList->push($cartItem);
        $key = $paymentMethodList->keys()->last();
        $payment_amount_total = 0;
        foreach ($this->paymentMethodList as $key => $amount) {
            $payment_amount_total += $amount['payment_amount'];
        }
        $this->paid_amount = $payment_amount_total;
        $this->reset(['payment_method_id', 'payment_amount', 'cheque_payment_date', 'ifCheque', 'payment_method_id', 'purchase_payment_date']);
        $this->receipt_code = 'R'.floor(time() - 999999999);
        $this->transaction_id = 'TR'.floor(time() - 999999999);
        $this->updateItemCal();
    }

    public function PurchaseSave()
    {

        // dd($this->return_quantity);
        $this->validate([
            'code' => 'required',
            'contact_id' => 'required',
            'return_date' => 'required',
        ]);
        DB::transaction(function () {
            $PurchaseInvoice = Invoice::find($this->InvoiceId);
            $PurchaseReturnInvoice = Invoice::whereInvoiceId($this->InvoiceId)->first();

            if (!$PurchaseReturnInvoice) {
                $PurchaseReturnInvoice = new Invoice();
                $PurchaseReturnInvoice->code = $this->code;
            }
            // dd($this->return_grand_total);
            $PurchaseReturnInvoice->type = 'Purchase Return';
            $PurchaseReturnInvoice->date = $this->return_date;
            $PurchaseReturnInvoice->contact_id = $this->contact_id;
            $PurchaseReturnInvoice->invoice_id = $this->InvoiceId;
            $PurchaseReturnInvoice->subtotal = $this->return_subtotal;
            $PurchaseReturnInvoice->total_vat = $this->vat_total;
            $PurchaseReturnInvoice->amount_to_pay = $this->return_grand_total;
            $PurchaseReturnInvoice->paid_amount = $this->paid_amount;
            $PurchaseReturnInvoice->due_amount = $this->return_due;
            $PurchaseReturnInvoice->payment_status = 'Due';
            $PurchaseReturnInvoice->user_id = Auth::user()->id;
            $PurchaseReturnInvoice->branch_id = Auth::user()->branch_id;
            $PurchaseReturnInvoice->company_id = Auth::user()->company_id;
            $PurchaseReturnInvoice->status = 1;
            $PurchaseReturnInvoice->save();
            foreach ($this->return_quantity as $key => $value) {
                    $purchaseItem = StockManager::whereInvoiceId($PurchaseInvoice->id)
                     ->whereId($key)->first();
                    $this->GenerateCodeStock();
                    $item = Item::find( $purchaseItem->item_id);
                    $StockManager=StockManager::whereItemId( $purchaseItem->item_id)->where('invoice_id',$PurchaseReturnInvoice->id)->first();
                //    dd( $StockManager);
                    $checkUpdate = false;
                    if (!$StockManager && !empty($value)) {
                        $StockManager = new StockManager();
                        $StockManager->code = $this->stock_code;
                        $StockManager->item_id = $purchaseItem->item_id;
                        $StockManager->invoice_id = $PurchaseReturnInvoice->id;
                    }
                    if (!empty($value)) {
                    $StockManager->date = $this->return_date;
                    $StockManager->category_id = $purchaseItem->category_id;
                    $StockManager->unit_id = $purchaseItem->unit_id;
                    $StockManager->contact_id = $this->contact_id;
                    $StockManager->flow = 'Out';
                    $StockManager->purchase_price = $purchaseItem->purchase_price;
                    $StockManager->quantity = $value;
                    $StockManager->purchase_subtotal = $purchaseItem->purchase_price * $value;
                    $StockManager->subtotal = $purchaseItem->purchase_price * $value;
                    $StockManager->sale_price = $item->sale_price ;
                    $StockManager->sale_subtotal = $item->sale_price*$value;
                    $StockManager->vat_id = $purchaseItem->vat_id;
                    $StockManager->vat_subtotal = ($purchaseItem->vat_subtotal/$purchaseItem->quantity)* $value;
                    $StockManager->user_id = Auth::user()->id;
                    $StockManager->status = 1;
                    $StockManager->branch_id = Auth::user()->branch_id;
                    $StockManager->company_id =  Auth::user()->company_id;
                    $checkUpdate = true;
                }
                if ($checkUpdate) {
                    $StockManager->save();
                }
            }
// dd($this->paymentMethodList);
            // Start Paid
            foreach ($this->paymentMethodList as $key => $amount) {

                $AccountManager = AccountManager::whereInvoiceId($PurchaseReturnInvoice->id)
                ->whereId($amount['id'])->whereDrAccountId($amount['payment_method_id'])->firstorNew();
                $AccountManager->code = $amount['transaction_id'];
                $AccountManager->type = 'Debit';
                $AccountManager->dr_account_id = $amount['payment_method_id'];
                $AccountManager->invoice_id = $PurchaseReturnInvoice->id;
                $AccountManager->contact_id = $this->contact_id;
                $AccountManager->amount = $amount['payment_amount'];
                // $AccountManager->transaction_id = $amount['transaction_id'];
                $AccountManager->date = $amount['purchase_payment_date'];
                if ($amount['due_date']) {
                    $AccountManager->due_date = $amount['due_date'];
                    $AccountManager->payment_status = 'Hold';
                }else{
                    $AccountManager->payment_status = 'Active';
                }
                if (isset($amount['receipt_code'])) {
                    $AccountManager->note = $amount['receipt_code'];
                }
                $AccountManager->user_id = Auth::user()->id;
                $AccountManager->branch_id = Auth::user()->branch_id;
                $AccountManager->company_id = Auth::user()->company_id;
                $AccountManager->save();
            }
            // End Paid
            // Start Purchase
            $purchaseReturnChartId = ChartOfAccount::whereDefaultModule(3)->first('id')->id;
            $purchaseAccountManager = AccountManager::whereInvoiceId($PurchaseReturnInvoice->id)->whereCrAccountId($purchaseReturnChartId)->firstOrNew();
            $purchaseAccountManager->code = $this->code;
            $purchaseAccountManager->type = 'Credit';
            $purchaseAccountManager->cr_account_id = $purchaseReturnChartId;
            $purchaseAccountManager->invoice_id = $PurchaseReturnInvoice->id;
            $purchaseAccountManager->contact_id = $this->contact_id;
            $purchaseAccountManager->amount = $this->return_subtotal;
            $purchaseAccountManager->date = $this->return_date;
            $purchaseAccountManager->note = 'Purchase Return';
            $purchaseAccountManager->user_id = Auth::user()->id;
            $purchaseAccountManager->branch_id = Auth::user()->branch_id;
            $purchaseAccountManager->company_id = Auth::user()->company_id;
            $purchaseAccountManager->save();
            // End Purchase

            // Start Output VAT
            if ($this->return_vat_total) {
                $purchaseVATChartId = ChartOfAccount::whereDefaultModule(9)->first('id')->id;
                $PurchaseVATAccountManager = AccountManager::whereInvoiceId($PurchaseReturnInvoice->id)->whereCrAccountId($purchaseVATChartId)->firstOrNew();
                $PurchaseVATAccountManager->code = $this->code;
                $PurchaseVATAccountManager->type = 'Credit';
                $PurchaseVATAccountManager->cr_account_id = $purchaseVATChartId;
                $PurchaseVATAccountManager->invoice_id = $PurchaseReturnInvoice->id;
                $PurchaseVATAccountManager->contact_id = $this->contact_id;
                $PurchaseVATAccountManager->amount = $this->return_vat_total;
                $PurchaseVATAccountManager->date = $this->return_date;
                $PurchaseVATAccountManager->note = 'Output VAT Return';
                $PurchaseVATAccountManager->user_id = Auth::user()->id;
                $PurchaseVATAccountManager->branch_id = Auth::user()->branch_id;
                $PurchaseVATAccountManager->company_id = Auth::user()->company_id;
                $PurchaseVATAccountManager->save();
            }
            // End Vat

            // Start Receivable
            if ($this->return_due) {
                $receivableChartId = ChartOfAccount::whereDefaultModule(6)->first('id')->id;
                $purchaseDueAccountManager = AccountManager::whereInvoiceId($PurchaseReturnInvoice->id)->whereDrAccountId($receivableChartId)->firstOrNew();
                $purchaseDueAccountManager->code = $this->code;
                $purchaseDueAccountManager->type = 'Debit';
                $purchaseDueAccountManager->dr_account_id = $receivableChartId;
                $purchaseDueAccountManager->invoice_id = $PurchaseReturnInvoice->id;
                $purchaseDueAccountManager->contact_id = $this->contact_id;
                $purchaseDueAccountManager->amount = $this->return_due;
                $purchaseDueAccountManager->date = $this->return_date;
                $purchaseDueAccountManager->note = 'ReceivaleReturnDue';
                $purchaseDueAccountManager->user_id = Auth::user()->id;
                $purchaseDueAccountManager->branch_id = Auth::user()->branch_id;
                $purchaseDueAccountManager->company_id = Auth::user()->company_id;
                $purchaseDueAccountManager->save();
            }
            // End Payable

            // $this->reset();

            $this->code = 'S'.floor(time() - 999999999);
            $this->transaction_id = 'TR'.floor(time() - 999999999);
            $this->receipt_code = 'R'.floor(time() - 999999999);


            $this->emit('success_redirect', [
                'text' => 'Purchase Return C/U Successfully',
                'url' => route('inventory.purchase-return-list'),
            ]);
        });
    }



    public function GenerateCode()
    {
        $check_row = Invoice::orderBy('id', 'desc')->first();
        if (!$check_row) {
            $this->code = 'I001';
        } else {
            $this->code = ++$check_row->id;
            if ($this->code <= 9) {
                $this->code = 'I00'.$this->code;
            } elseif ($this->code <= 99) {
                $this->code = 'I0'.$this->code;
            } else {
                $this->code = 'I'.$this->code;
            }
        }
        // dd($this->code);
    }

    public function GenerateCodeStock()
    {
        $check_row = StockManager::orderBy('id', 'desc')->first();
        if (!$check_row) {
            $this->stock_code = 'SM001';
        } else {
            $this->stock_code = ++$check_row->id;
            if ($this->stock_code <= 9) {
                $this->stock_code = 'SM00'.$this->stock_code;
            } elseif ($this->stock_code <= 99) {
                $this->stock_code = 'SM0'.$this->stock_code;
            } else {
                $this->stock_code = 'SM'.$this->stock_code;
            }
        }
        // dd($this->code);
    }

    public function GenerateCodeAccountManager()
    {
        $check_row = StockManager::orderBy('id', 'desc')->first();
        if (!$check_row) {
            $this->account_manager_code = 'AM001';
        } else {
            $this->account_manager_code = ++$check_row->id;
            if ($this->account_manager_code <= 9) {
                $this->account_manager_code = 'AM00'.$this->account_manager_code;
            } elseif ($this->account_manager_code <= 99) {
                $this->account_manager_code = 'AM0'.$this->account_manager_code;
            } else {
                $this->account_manager_code = 'AM'.$this->account_manager_code;
            }
        }
        // dd($this->code);
    }

    public function mount($id = null)
    {
        $this->transaction_id = 'TR'.floor(time() - 999999999);
        $this->receipt_code = 'R'.floor(time() - 999999999);
        $this->GenerateCode();
        // Start Edit Purchase
        if ($id) {
            $PurchaseInvoice = Invoice::find($id);
            $this->PurchaseInvoice=$PurchaseInvoice;
            $PurchaseReturnInvoice = Invoice::whereInvoiceId($id)->first();

          if($PurchaseReturnInvoice){
            $this->PurchaseReturnInvoiceId  = $PurchaseReturnInvoice->id;
            $this->return_date = $PurchaseReturnInvoice->date;
            $this->return_due = $PurchaseReturnInvoice->due_amount;

            // $this->paid_amount  = $PurchaseReturnInvoice->paid_amount;
          }
            $this->InvoiceId = $PurchaseInvoice->id;
            $this->contact_id = $PurchaseInvoice->contact_id;
            $this->date = $PurchaseInvoice->date;
            $this->grand_total = $PurchaseInvoice->grand_total;
            $this->subtotal = $PurchaseInvoice->subtotal;

            $StockManager = StockManager::whereInvoiceId($PurchaseInvoice->id)->get();

            foreach ($StockManager as $stockProduct) {
                if($PurchaseReturnInvoice){
                    $getStock=StockManager::whereInvoiceId($PurchaseReturnInvoice->id)->whereItemId($stockProduct->item_id)->first();
                    if( $getStock){
                        $this->return_quantity[$stockProduct->id]=$getStock->quantity;
                        $this->item_return_amount[$stockProduct->id] = $getStock->subtotal;
                    }
                }
            }
             // Start Account Manager Edit
             if($PurchaseReturnInvoice){
                $PaymentList = AccountManager::whereInvoiceId($PurchaseReturnInvoice->id)->whereNotNull('payment_status')->where('payment_status','!=','Inactive')->get();

             }else{
                $PaymentList =null;
             }
             $cartPayment = collect($this->paymentMethodList);
                if( $PaymentList ){
                    foreach ($PaymentList as $paymentList) {
                        if ($paymentList->ChartOfAccountDr) {
                            $payment_name = $paymentList->ChartOfAccountDr->name;

                            $account_id = $paymentList->dr_account_id;
                        } else {
                            $payment_name = $paymentList->ChartOfAccountCr->name;
                            $account_id = $paymentList->cr_account_id;
                        }

                        $cartItem = [
                            'id' => $paymentList->id,
                            'payment_method_id' => $account_id,
                            'payment_method_name' => $payment_name,
                            'purchase_payment_date' => $paymentList->date,
                            'due_date' => $paymentList->due_date,
                            'transaction_id' => $paymentList->code,
                            'payment_amount' => $paymentList->amount,
                            'payment_code' => $paymentList->code,
                            'receopt_code' => $paymentList->note,
                        ];

                        $this->paymentMethodList = $cartPayment->push($cartItem);
                    }
                    $this->paymentMethodList = $cartPayment;
                }

             // End Account Manager Edit

             $this->updateItemCal();
        }
        // End Edit Purchase
    }
    public function updatedReturnQuantity($value, $key)
    {
        // dd( $key);
        // $this->updateItemCal();
        $purchaseStock=StockManager::find($key);
        if ($value && is_numeric($value)) {
            $this->item_return_amount[$key] = $value* $purchaseStock->purchase_price;
        } else {
            $this->item_return_amount[$key] = 0;
        }
        $this->updateItemCal();

    }

    public function updateItemCal()
    {

        $return_total_vat=0;
        $returnGrandTotal=0;
        foreach ($this->PurchaseInvoice->StockManager as $key => $value) {

            if (isset($this->return_quantity[$value->id]) && is_numeric($this->return_quantity[$value->id]) && !empty($this->return_quantity[$value->id])) {
                $return_total_vat += $this->item_return_amount[$value->id]* $value->Item->Vat->rate_percent  / 100;
                $returnGrandTotal += $this->item_return_amount[$value->id];


            }
        }

        $this->return_subtotal = $returnGrandTotal;

        $this->return_vat_total = $return_total_vat;
        $this->return_grand_total = $returnGrandTotal+$this->return_vat_total;
        $payment_amount_total=0;
        foreach ($this->paymentMethodList as $key => $amount) {
            $payment_amount_total += $amount['payment_amount'];
        }
        $this->paid_amount = $payment_amount_total;
        $this->return_due = $this->return_grand_total - $payment_amount_total;

        $this->due_amount =$payment_amount_total;
    }
    public function render()
    {
        return view('livewire.inventory.purchase-return', [
            'contacts' => Contact::whereCompanyId(Auth::user()->company_id)->whereType('supplier')->get(),
            'payments' => ChartOfAccount::whereIsCashbank(1)->get(),
            'branches' => Branch::whereCompanyId(Auth::user()->company_id)->get(),
        ]);
    }
}
