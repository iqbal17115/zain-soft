<?php

namespace App\Http\Livewire\Inventory;

use App\Models\Accounts\AccountManager;
use App\Models\AccountSettings\Branch as BranchModal;
use App\Models\AccountSettings\ChartOfAccount;
use App\Models\Billing\Invoice;
use App\Models\Contact\Contact;
use App\Models\Stock\Item;
use App\Models\Stock\StockManager;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SaleReturn extends Component
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
    public $sale_payment_date;
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
    public $SaleInvoice;
    public  $SaleReturnInvoiceId;
    protected $listeners = [
        'payment_method_search' => 'AddPaymentMethod',
    ];

    public function GetData($code){
        $SaleInvoice = Invoice::whereCode($code)->first();
        if($SaleInvoice){
           $id=$SaleInvoice->id;
           $this->SaleInvoice=$SaleInvoice;
           $SaleReturnInvoice = Invoice::whereInvoiceId($id)->first();

         if($SaleReturnInvoice){
           $this->SaleReturnInvoiceId  = $SaleReturnInvoice->id;
           $this->return_date = $SaleReturnInvoice->date;
           $this->return_due = $SaleReturnInvoice->due_amount;

           // $this->paid_amount  = $PurchaseReturnInvoice->paid_amount;
         }
           $this->InvoiceId = $SaleInvoice->id;
           $this->contact_id = $SaleInvoice->contact_id;
           $this->date = $SaleInvoice->date;
           $this->grand_total = $SaleInvoice->grand_total;
           $this->subtotal = $SaleInvoice->subtotal;

           $StockManager = StockManager::whereInvoiceId($SaleInvoice->id)->get();

           foreach ($StockManager as $stockProduct) {
               if($SaleReturnInvoice){
                   $getStock=StockManager::whereInvoiceId($SaleReturnInvoice->id)->whereItemId($stockProduct->item_id)->first();
                   if( $getStock){
                       $this->return_quantity[$stockProduct->id]=$getStock->quantity;
                       $this->item_return_amount[$stockProduct->id] = $getStock->subtotal;
                   }
               }
           }
            // Start Account Manager Edit
            if($SaleReturnInvoice){
               $PaymentList = AccountManager::whereInvoiceId($SaleReturnInvoice->id)->whereNotNull('payment_status')->where('payment_status','!=','Inactive')->get();

            }else{
               $PaymentList =null;
            }
            $cartPayment = collect($this->paymentMethodList);
               if( $PaymentList ){
                   foreach ($PaymentList as $paymentList) {
                       if ($paymentList->ChartOfAccountCr) {
                           $payment_name = $paymentList->ChartOfAccountCr->name;

                           $account_id = $paymentList->cr_account_id;
                       } else {
                           $payment_name = $paymentList->ChartOfAccountDr->name;
                           $account_id = $paymentList->dr_account_id;
                       }

                       $cartItem = [
                           'id' => $paymentList->id,
                           'payment_method_id' => $account_id,
                           'payment_method_name' => $payment_name,
                           'sale_payment_date' => $paymentList->date,
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
        $accountManager=AccountManager::whereId($id)->whereInvoiceId($this->SaleReturnInvoiceId)->whereCrAccountId($ChartId)->first();
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
            'date' => $this->sale_payment_date,
            'payment_method_id' => $PaymentMethod->id,
            'payment_method_name' => $PaymentMethod->name,
            'payment_amount' => $this->payment_amount,
            'receipt_code' => $this->receipt_code,
            'transaction_id' => $this->transaction_id,
            'due_date' => $this->cheque_payment_date,
            'sale_payment_date' => $this->sale_payment_date,
            'receipt_code' => $this->receipt_code,
        ];
        $this->paymentMethodList = $paymentMethodList->push($cartItem);
        $key = $paymentMethodList->keys()->last();
        $payment_amount_total = 0;
        foreach ($this->paymentMethodList as $key => $amount) {
            $payment_amount_total += $amount['payment_amount'];
        }
        $this->paid_amount = $payment_amount_total;
        $this->reset(['payment_method_id', 'payment_amount', 'cheque_payment_date', 'ifCheque', 'payment_method_id', 'sale_payment_date']);
        $this->receipt_code = 'R'.floor(time() - 999999999);
        $this->transaction_id = 'TR'.floor(time() - 999999999);
        $this->updateItemCal();
    }

    public function SaleSave()
    {
        // dd($this->return_quantity);
        $this->validate([
            'code' => 'required',
            'contact_id' => 'required',
            'return_date' => 'required',
        ]);
        DB::transaction(function () {
            $SaleInvoice = Invoice::find($this->InvoiceId);
            $SaleReturnInvoice = Invoice::whereInvoiceId($this->InvoiceId)->first();

            if (!$SaleReturnInvoice) {
                $SaleReturnInvoice = new Invoice();
                $SaleReturnInvoice->code = $this->code;
            }
            // dd($this->return_grand_total);
            $SaleReturnInvoice->type = 'Sales Return';
            $SaleReturnInvoice->date = $this->return_date;
            $SaleReturnInvoice->contact_id = $this->contact_id;
            $SaleReturnInvoice->invoice_id = $this->InvoiceId;
            $SaleReturnInvoice->subtotal = $this->return_subtotal;
            $SaleReturnInvoice->total_vat = $this->vat_total;
            $SaleReturnInvoice->amount_to_pay = $this->return_grand_total;
            $SaleReturnInvoice->paid_amount = $this->paid_amount;
            $SaleReturnInvoice->due_amount = $this->return_due;
            $SaleReturnInvoice->payment_status = 'Due';
            $SaleReturnInvoice->user_id = Auth::user()->id;
            $SaleReturnInvoice->branch_id = Auth::user()->branch_id;
            $SaleReturnInvoice->company_id = Auth::user()->company_id;
            $SaleReturnInvoice->status = 1;
            $SaleReturnInvoice->save();

            foreach ($this->return_quantity as $key => $value) {
                    $saleItem = StockManager::whereInvoiceId($SaleInvoice->id)
                     ->whereId($key)->first();
                    $this->GenerateCodeStock();
                    // dd($SaleReturnInvoice->id);
                    $item = Item::find( $saleItem->item_id);
                    $avaragePurPrice = $item->avg_pur_price;
                    if ($avaragePurPrice <= 0 || $avaragePurPrice == null) {
                        $avaragePurPrice = $item->purchase_price;
                    }
                    $StockManager=StockManager::whereItemId( $saleItem->item_id)->where('invoice_id',$SaleReturnInvoice->id)->first();
                //    dd( $StockManager);
                    $checkUpdate = false;
                    if (!$StockManager && !empty($value)) {
                        $StockManager = new StockManager();
                        $StockManager->code = $this->stock_code;
                        $StockManager->item_id = $saleItem->item_id;
                        $StockManager->invoice_id = $SaleReturnInvoice->id;
                    }
                    if (!empty($value)) {
                    $StockManager->date = $this->return_date;
                    $StockManager->category_id = $saleItem->category_id;
                    $StockManager->unit_id = $saleItem->unit_id;
                    $StockManager->contact_id = $this->contact_id;
                    $StockManager->flow = 'In';
                    $StockManager->purchase_price =  $avaragePurPrice;
                    $StockManager->purchase_subtotal =  $avaragePurPrice * $value;
                    $StockManager->sale_price = $saleItem->sale_price;
                    $StockManager->sale_subtotal = $saleItem->sale_price* $value;
                    $StockManager->quantity = $value;
                    $StockManager->subtotal = $saleItem->sale_price * $value;
                    $StockManager->vat_id = $saleItem->vat_id;
                    $StockManager->vat_subtotal = ($saleItem->vat_subtotal/$saleItem->quantity)* $value;
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

                $AccountManager = AccountManager::whereInvoiceId($SaleReturnInvoice->id)
                ->whereId($amount['id'])->whereCrAccountId($amount['payment_method_id'])->firstorNew();
                $AccountManager->code = $amount['transaction_id'];
                $AccountManager->type = 'Credit';
                $AccountManager->cr_account_id = $amount['payment_method_id'];
                $AccountManager->invoice_id = $SaleReturnInvoice->id;
                $AccountManager->contact_id = $this->contact_id;
                $AccountManager->amount = $amount['payment_amount'];
                // $AccountManager->transaction_id = $amount['transaction_id'];
                $AccountManager->date = $amount['sale_payment_date'];
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
            // Start Sale
            $salesReturnChartId = ChartOfAccount::whereDefaultModule(4)->first('id')->id;
            $saleAccountManager = AccountManager::whereInvoiceId($SaleReturnInvoice->id)->whereDrAccountId($salesReturnChartId)->firstOrNew();
            $saleAccountManager->code = $this->code;
            $saleAccountManager->type = 'Debit';
            $saleAccountManager->dr_account_id = $salesReturnChartId;
            $saleAccountManager->invoice_id = $SaleReturnInvoice->id;
            $saleAccountManager->contact_id = $this->contact_id;
            $saleAccountManager->amount = $this->return_subtotal;
            $saleAccountManager->date = $this->return_date;
            $saleAccountManager->note = 'Sale Return';
            $saleAccountManager->user_id = Auth::user()->id;
            $saleAccountManager->branch_id = Auth::user()->branch_id;
            $saleAccountManager->company_id = Auth::user()->company_id;
            $saleAccountManager->save();
            // End Sale

            // Start Output VAT
            if ($this->return_vat_total) {
                $saleVATChartId = ChartOfAccount::whereDefaultModule(10)->first('id')->id;
                $PurchaseVATAccountManager = AccountManager::whereInvoiceId($SaleReturnInvoice->id)->whereDrAccountId($saleVATChartId)->firstOrNew();
                $PurchaseVATAccountManager->code = $this->code;
                $PurchaseVATAccountManager->type = 'Debit';
                $PurchaseVATAccountManager->dr_account_id = $saleVATChartId;
                $PurchaseVATAccountManager->invoice_id = $SaleReturnInvoice->id;
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
                $receivableChartId = ChartOfAccount::whereDefaultModule(5)->first('id')->id;
                $saleDueAccountManager = AccountManager::whereInvoiceId($SaleReturnInvoice->id)->whereCrAccountId($receivableChartId)->firstOrNew();
                $saleDueAccountManager->code = $this->code;
                $saleDueAccountManager->type = 'Credit';
                $saleDueAccountManager->cr_account_id = $receivableChartId;
                $saleDueAccountManager->invoice_id = $SaleReturnInvoice->id;
                $saleDueAccountManager->contact_id = $this->contact_id;
                $saleDueAccountManager->amount = $this->return_due;
                $saleDueAccountManager->date = $this->return_date;
                $saleDueAccountManager->note = 'ReceivaleReturnDue';
                $saleDueAccountManager->user_id = Auth::user()->id;
                $saleDueAccountManager->branch_id = Auth::user()->branch_id;
                $saleDueAccountManager->company_id = Auth::user()->company_id;
                $saleDueAccountManager->save();
            }
            // End Payable

            // $this->reset();

            $this->code = 'S'.floor(time() - 999999999);
            $this->transaction_id = 'TR'.floor(time() - 999999999);
            $this->receipt_code = 'R'.floor(time() - 999999999);

            $this->emit('success_redirect', [
                'text' => 'Sale Return C/U Successfully',
                'url' => route('inventory.sale-return-list'),
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
        $this->date = Carbon::now()->format('Y-m-d');
        $this->return_date = Carbon::now()->format('Y-m-d');

        $this->GenerateCode();
        // Start Edit Sale
        if ($id) {
            $SaleInvoice = Invoice::find($id);
            $this->SaleInvoice=$SaleInvoice;
            $SaleReturnInvoice = Invoice::whereInvoiceId($id)->first();
          if( $SaleReturnInvoice){
            $this->SaleReturnInvoiceId  = $SaleReturnInvoice->id;
            $this->return_date = $SaleReturnInvoice->date;
            $this->return_due = $SaleReturnInvoice->due_amount;

            // $this->paid_amount  = $SaleReturnInvoice->paid_amount;
          }
            $this->InvoiceId = $SaleInvoice->id;
            $this->contact_id = $SaleInvoice->contact_id;
            $this->date = $SaleInvoice->date;
            $this->grand_total = $SaleInvoice->grand_total;
            $this->subtotal = $SaleInvoice->subtotal;

            $StockManager = StockManager::whereInvoiceId($SaleInvoice->id)->get();


            foreach ($StockManager as $stockProduct) {
                if($SaleReturnInvoice){
                    $getStock=StockManager::whereInvoiceId( $SaleReturnInvoice ->id)->whereItemId($stockProduct->item_id)->first();
                    if( $getStock){
                        $this->return_quantity[$stockProduct->id]=$getStock->quantity;
                        $this->item_return_amount[$stockProduct->id] = $getStock->subtotal;

                    }
                }

            }
             // Start Account Manager Edit
             if($SaleReturnInvoice){
                $PaymentList = AccountManager::whereInvoiceId($SaleReturnInvoice->id)->whereNotNull('payment_status')->where('payment_status','!=','Inactive')->get();

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
                            'sale_payment_date' => $paymentList->date,
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
        // End Edit Sale
    }
    public function updatedReturnQuantity($value, $key)
    {
        // dd( $key);
        // $this->updateItemCal();
        $saleStock=StockManager::find($key);
        if ($value && is_numeric($value)) {
            $this->item_return_amount[$key] = $value* $saleStock->sale_price;
        } else {
            $this->item_return_amount[$key] = 0;
        }
        $this->updateItemCal();

    }

    public function updateItemCal()
    {

        $return_total_vat=0;
        $returnGrandTotal=0;
        foreach ($this->SaleInvoice->StockManager as $key => $value) {

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
        // dd($this->SaleInvoice);
        return view('livewire.inventory.sale-return', [
            'contacts' => Contact::whereCompanyId(Auth::user()->company_id)->whereType('customer')->get(),
            'payments' => ChartOfAccount::whereIsCashbank(1)->get(),
            'branches' => BranchModal::whereCompanyId(Auth::user()->company_id)->get(),
        ]);
    }
}
