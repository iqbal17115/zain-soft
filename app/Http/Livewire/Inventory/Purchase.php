<?php

namespace App\Http\Livewire\Inventory;

use App\Models\Accounts\AccountManager;
use App\Models\AccountSettings\Branch;
use App\Models\AccountSettings\ChartOfAccount;
use App\Models\Billing\Invoice;
use App\Models\Contact\Contact;
use App\Models\AccountSettings\Vat;
use App\Models\Stock\Brand;
use App\Models\Stock\Category;
use App\Models\Stock\Item;
use App\Models\Stock\Unit;
use App\Models\Stock\StockManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Stock\ItemInvoice;
use Carbon\Carbon;
use Livewire\Component;

class Purchase extends Component
{
    // Item Variable
    public $item_code;
    public $purchase_price;
    public $item_name;
    public $opening_stock;
    public $item_add_discount;
    public $sale_price;
    public $low_stock_alert;
    public $is_stock_check;
    public $is_stock_check_disable;
    public $whole_sale_price;
    public $serial_no;
    public $category_id;
    public $brand_id;
    public $item_id;
    public $unit_id;
    public $vat_id;

    // variable declare for supplier add in purchase
    // public $code;
    public $type;
    public $name;
    public $business_name;
    public $email;
    public $mobile;
    public $sale_commission;
    public $is_due_sale;
    public $is_default;
    public $trn_no;
    public $address;
    public $status = 1;
    public $company_id;
    public $opening_balance;
    public $branch_id;
    public $credit_limit;
    public $due_date;
    public $requisition_id;
    public $supplier_id = null;

    // Variable declare for purchase page functionality
    public $item_quantity;
    public $item_rate;
    public $discount;
    public $discount_amount = 0;
    public $item_subtotal;
    public $item_purchase_price;
    public $item_batch_no;
    public $item_expired_date;
    public $item_discount;
    public $subtotal;
    public $item_vat;
    public $vat_total = 0;
    public $Item;
    public $due;
    public $grand_total;
    public $shipping_charge = 0;
    public $amt_to_pay;
    public $payment_method_id;
    public $payment_amount;
    public $receipt_code;
    public $paid_amount;
    public $purchase_payment_date;
    public $transaction_id;
    public $contact_id;
    public $code;
    public $supplier_code;
    public $date;
    public $chalan_no;
    public $memo_no;
    public $InvoiceId;
    public $due_amount;
    public $ifCheque;
    public $cheque_payment_date;
    public $paymentMethodList = [];
    public $orderItemList = [];
    protected $listeners = [
        'item_search' => 'AddPurchaseItem',
        'payment_method_search' => 'AddPaymentMethod',
    ];

    public function ItemSave()
    {
        // dd($this->item_name);
        $this->validate([
            'item_code' => 'required',
            'purchase_price' => 'required',
            'item_name' => 'required',
            'category_id' => 'required',
            'vat_id' => 'required',
            'unit_id' => 'required',
            'status' => 'required',
        ]);

        $Query = new Item();
        $Query->user_id = Auth::id();
        $Query->code = $this->item_code;
        $Query->category_id = $this->category_id;
        $Query->brand_id = $this->brand_id;
        $Query->unit_id = $this->unit_id;
        $Query->vat_id = $this->vat_id;
        $Query->name = $this->item_name;
        $Query->purchase_price = $this->purchase_price;
        $Query->type = 'Product';
        $Query->opening_stock = $this->opening_stock;
        $Query->discount = $this->discount;
        $Query->branch_id = Auth::user()->branch_id;
        $Query->company_id = Auth::user()->company_id;
        $Query->sale_price = $this->sale_price;
        $Query->low_stock_alert = $this->low_stock_alert;
        $Query->is_stock_check = $this->is_stock_check;
        $Query->status = $this->status;
        $Query->whole_sale_price = $this->whole_sale_price;
        $Query->save();

        if ($this->opening_stock) {
            $openBalanceChartId = ChartOfAccount::whereDefaultModule(7)->first('id')->id;
            $purchaseChartId = ChartOfAccount::whereDefaultModule(2)->first('id')->id;

            if ($openBalanceChartId) {
                $LedgerEntry = AccountManager::whereItemId($Query->id);
                $LedgerEntry->where('dr_account_id', $purchaseChartId);
                $LedgerEntry->where('cr_account_id', $openBalanceChartId);
                $LedgerEntry = $LedgerEntry->firstOrNew();

                $LedgerEntry->amount = $this->opening_stock * $this->purchase_price;
                $LedgerEntry->user_id = Auth::id();
                $LedgerEntry->date = Carbon::now();
                $LedgerEntry->code = $this->code;
                $LedgerEntry->item_id = $Query->id;
                $LedgerEntry->type = 'Debit';
                $LedgerEntry->dr_account_id = $purchaseChartId;
                $LedgerEntry->cr_account_id = $openBalanceChartId;
                $LedgerEntry->branch_id = Auth::user()->branch_id;
                $LedgerEntry->company_id = Auth::user()->company_id;
                $LedgerEntry->save();
            }

            $stockManager = StockManager::whereItemId($Query->id)->whereIsOpeningStock(1)->firstOrnew();
            $stockManager->code = 123;
            $stockManager->date = Carbon::now();
            $stockManager->item_id = $Query->id;
            $stockManager->category_id = $this->category_id;
            $stockManager->unit_id = $this->unit_id;
            $stockManager->is_opening_stock = 1;
            $stockManager->flow = 'In';
            $stockManager->quantity = $this->opening_stock;
            $stockManager->purchase_price = $this->purchase_price;
            $stockManager->sale_price = $this->sale_price;
            $stockManager->subtotal = $this->opening_stock * $this->purchase_price;
            $stockManager->status = 1;
            $stockManager->user_id = Auth::id();
            $stockManager->branch_id = Auth::user()->branch_id;
            $stockManager->company_id = Auth::user()->company_id;
            $stockManager->save();
        }

        $this->reset(['item_code', 'purchase_price', 'item_name', 'opening_stock', 'item_add_discount', 'sale_price', 'low_stock_alert', 'is_stock_check', 'is_stock_check', 'is_stock_check_disable', 'whole_sale_price', 'category_id', 'brand_id', 'item_id', 'unit_id', 'vat_id']);
        $this->ItemModal();
        $this->emit('success', [
            'text' => 'Item C\U Successfully',
        ]);
    }
    public function GenerateCodeForItem()
    {
        $check_row = Item::orderBy('id', 'desc')->first();
        if (!$check_row) {
            $this->item_code = 'I001';
        } else {
            $this->item_code = ++$check_row->id;
            if ($this->item_code <= 9) {
                $this->item_code = 'I00' . $this->item_code;
            } elseif ($this->item_code <= 99) {
                $this->item_code = 'I0' . $this->item_code;
            } else {
                $this->item_code = 'I' . $this->item_code;
            }
        }
        // dd($this->item_code);
    }
    public function ItemModal()
    {
        $this->GenerateCodeForItem();
        $this->emit('modal', 'ItemModal');
    }
    public function removePaymentList($itemId, $ChartId, $id = null)
    {
        // dd(true);
        $cart = collect($this->paymentMethodList);
        $accountManager = AccountManager::whereId($id)->whereInvoiceId($this->InvoiceId)->whereCrAccountId($ChartId)->first();
        if ($accountManager) {
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

        if (($this->payment_amount + $this->paid_amount) <= $this->grand_total) {
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
            ];
            $this->paymentMethodList = $paymentMethodList->push($cartItem);
            $key = $paymentMethodList->keys()->last();
            $payment_amount_total = 0;
            foreach ($this->paymentMethodList as $key => $amount) {
                $payment_amount_total += $amount['payment_amount'];
            }
            $this->paid_amount = $payment_amount_total;
            $this->reset(['payment_method_id', 'payment_amount', 'cheque_payment_date', 'ifCheque', 'payment_method_id', 'purchase_payment_date']);
            $this->transaction_id = 'TR' . floor(time() - 999999999);
            $this->purchase_payment_date = Carbon::now()->format('Y-m-d');
            $this->updateItemCal();
        } else {
            $this->emit('error', [
                'text' => 'Over Payment Not Possible!',
            ]);
        }
    }

    public function mount($id = null)
    {
        // Start Requision To Purchase
        if (request()->filled('requisition_to_purchase')) {
            $Requisition = Invoice::where('code', request()->requisition_to_purchase)->first();
            if ($Requisition) {
                $this->requisition_id = $Requisition->id;
                $this->contact_id = $Requisition->contact_id;
                $this->date = $Requisition->date;
                $this->shipping_charge = $Requisition->shipping_charge;
                if ($Requisition->discount) {
                    $this->discount_amount = $Requisition->discount_value . '%';
                } else {
                    $this->discount_amount = $Requisition->discount_value;
                }
                // $this->discount_amount = $SaleInvoice->discount_value;
                $this->grand_total = $Requisition->grand_total;
                $this->subtotal = $Requisition->subtotal;
                $this->due_amount = $Requisition->due_amount;
                $InvoiceItem = ItemInvoice::whereInvoiceId($Requisition->id)->get();
                // dd($PurchaseInvoiceDetail);
                $cart = collect($this->orderItemList);

                foreach ($InvoiceItem as $stockProduct) {
                    $item = Item::find($stockProduct->item_id);
                    $this->item_quantity[$item->id] = $stockProduct->quantity;
                    // $this->product_discount[$product->id] = $product->discount;
                    $this->item_rate[$item->id] = $stockProduct->purchase_price;
                    $this->item_quantity[$item->id] = $stockProduct->quantity;
                    $this->item_rate[$item->id] = $stockProduct->purchase_price;
                    $this->item_subtotal[$item->id] = $stockProduct->subtotal;
                    // dd($stockProduct->Item->Vat->rate_percent);
                    $this->item_vat[$item->id] = $stockProduct->Item->Vat->rate_percent;
                    $this->item_discount[$item->id] = 0;
                    if ($stockProduct->discount_percent) {
                        $this->item_discount[$item->id] = $stockProduct->discount_percent . '%';
                    }
                    if ($stockProduct->discount_value) {
                        $this->item_discount[$item->id] = $stockProduct->discount_value;
                    }
                    $cart[$item->id] = $item;
                }
                $this->orderItemList = $cart;

                $this->updateItemCal();
            }
        }
        // End Requision To Purchase

        $this->transaction_id = 'TR' . floor(time() - 999999999);
        $this->receipt_code = 'R' . floor(time() - 999999999);
        // dd(Carbon::now()->format('Y-m-d'));
        $this->date = Carbon::now()->format('Y-m-d');
        $this->purchase_payment_date = Carbon::now()->format('Y-m-d');
        $this->GenerateCode();
        // Start Edit Purchase
        if ($id) {
            $PurchaseInvoice = Invoice::find($id);
            $this->InvoiceId = $PurchaseInvoice->id;
            $this->code = $PurchaseInvoice->code;
            $this->contact_id = $PurchaseInvoice->contact_id;
            $this->date = $PurchaseInvoice->date;
            $this->chalan_no = $PurchaseInvoice->chalan_no;
            $this->memo_no = $PurchaseInvoice->memo_no;
            $this->shipping_charge = $PurchaseInvoice->shipping_charge;
            if ($PurchaseInvoice->discount) {
                $this->discount_amount = $PurchaseInvoice->discount_value . '%';
            } else {
                $this->discount_amount = $PurchaseInvoice->discount_value;
            }
            // $this->discount_amount = $PurchaseInvoice->discount_value;
            $this->grand_total = $PurchaseInvoice->grand_total;
            $this->subtotal = $PurchaseInvoice->subtotal;
            $this->due_amount = $PurchaseInvoice->due_amount;
            $this->paid_amount = $PurchaseInvoice->paid_amount;

            $StockManager = StockManager::whereInvoiceId($PurchaseInvoice->id)->get();
            // dd($PurchaseInvoiceDetail);
            $cart = collect($this->orderItemList);

            foreach ($StockManager as $stockProduct) {
                $item = Item::find($stockProduct->item_id);
                $this->item_quantity[$item->id] = $stockProduct->quantity;
                $this->serial_no[$item->id] = $stockProduct->serial_no;
                // $this->product_discount[$product->id] = $product->discount;
                $this->item_rate[$item->id] = $stockProduct->purchase_price;
                $this->item_quantity[$item->id] = $stockProduct->quantity;
                $this->item_rate[$item->id] = $stockProduct->purchase_price;
                $this->item_subtotal[$item->id] = $stockProduct->subtotal;
                // dd($stockProduct->Item->Vat->rate_percent);
                $this->item_vat[$item->id] = $stockProduct->Item->Vat->rate_percent;
                $this->item_discount[$item->id] = 0;
                if ($stockProduct->discount_percent) {
                    $this->item_discount[$item->id] = $stockProduct->discount_percent . '%';
                }
                if ($stockProduct->discount_value) {
                    $this->item_discount[$item->id] = $stockProduct->discount_value;
                }
                $cart[$item->id] = $item;
            }
            $this->orderItemList = $cart;

            // Start Account Manager Edit
            $PaymentList = AccountManager::whereInvoiceId($id)->whereNotNull('payment_status')->where('payment_status', '!=', 'Inactive')->get();
            $cartPayment = collect($this->paymentMethodList);
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
                    'purchase_payment_date' => $paymentList->date,
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
            // End Account Manager Edit
            $this->updateItemCal();
        }
        // End Edit Purchase
    }

    public function updated()
    {
        $this->updateItemCal();
    }

    public function PurchaseSave()
    {

        $this->validate([
            'code' => 'required',
            'contact_id' => 'required',
            'date' => 'required',
        ]);
        DB::transaction(function () {
            if ($this->InvoiceId) {
                $Query = Invoice::find($this->InvoiceId);
            } else {
                $Query = new Invoice();
            }

            $Query->code = $this->code;
            $Query->type = 'Purchase';
            $Query->date = $this->date;
            $Query->contact_id = $this->contact_id;
            $Query->chalan_no = $this->chalan_no;
            $Query->memo_no = $this->memo_no;
            $Query->subtotal = $this->subtotal;
            // $Query->discount_value = $this->discount_amount;
            $lastChar = substr($this->discount_amount, -1);

            if ($lastChar == '%') {
                $total_discount = substr($this->discount_amount, 0, -1);
                $Query->discount = $total_discount;
                $subtotal_discount = ($this->subtotal * $total_discount) / 100;
                $Query->discount_value = $subtotal_discount;
            } else {
                $Query->discount_value = $this->discount_amount;
            }
            $Query->total_vat = $this->vat_total;
            $Query->shipping_charge = $this->shipping_charge;
            $Query->amount_to_pay = $this->grand_total;
            $Query->paid_amount = $this->paid_amount;
            $Query->due_amount = $this->due;
            $Query->payment_status = 'Due';
            $Query->user_id = Auth::user()->id;
            $Query->branch_id = 1;
            $Query->company_id = 1;
            $Query->status = 1;
            $Query->save();

            foreach ($this->orderItemList as $key => $value) {
                $item = Item::find($key);
                //    dd($orderItem);
                $StockManager = StockManager::whereInvoiceId($Query->id)->whereItemId($item->id)->first();
                if (!$StockManager) {
                    $StockManager = new StockManager();
                }
                $StockManager->code = $this->code;
                $StockManager->date = $this->date;
                $StockManager->item_id = $key;
                $StockManager->category_id = $item->category_id;
                $StockManager->invoice_id = $Query->id;
                $StockManager->unit_id = $item->unit_id;
                $StockManager->vat_id = $item->vat_id;
                $StockManager->vat_subtotal = ($this->item_rate[$key] * $this->item_quantity[$key] * $item->Vat->rate_percent / 100);
                $StockManager->contact_id = $this->contact_id;
                $StockManager->flow = 'In';
                $StockManager->sale_price = $item->sale_price;
                $StockManager->sale_subtotal = $item->sale_price * $this->item_quantity[$key];
                $StockManager->purchase_price = $this->item_rate[$key];
                //   Start Discount Cal
                $lastChar = substr($this->item_discount[$key], -1);

                if ($lastChar == '%') {
                    $item_discount = substr($this->item_discount[$key], 0, -1);
                    $StockManager->discount_percent = $item_discount;
                } else {
                    $StockManager->discount_value = $this->item_discount[$key];
                }
                // End Discount Cal
                $StockManager->discount_value = $item->discount;
                $StockManager->quantity = $this->item_quantity[$key];
                $StockManager->serial_no = $this->serial_no[$key];
                $StockManager->purchase_subtotal = $this->item_rate[$key] * $this->item_quantity[$key];
                $StockManager->subtotal = $this->item_rate[$key] * $this->item_quantity[$key];
                if (isset($this->item_batch_no[$key])) {
                    $StockManager->batch_no = $this->item_batch_no[$key];
                }
                if (isset($this->item_expired_date[$key])) {
                    $StockManager->expired_date = $this->item_expired_date[$key];
                }
                $StockManager->user_id = Auth::user()->id;
                $StockManager->branch_id = $item->branch_id;
                $StockManager->company_id = Auth::user()->company_id;
                $StockManager->save();

                $avarage = StockManager::whereStatus(1)
                    ->whereExists(function ($query) {
                        $query->select(DB::raw(1))
                            ->from('invoices')
                            ->whereRaw('invoices.id = stock_managers.invoice_id')
                            ->whereRaw('invoices.type !=  "Sales Return"');
                    })->get();
                $avaragePurPrice = $avarage->sum('purchase_subtotal') / $avarage->sum('quantity');

                $itemUpdate = Item::find($key);
                $itemUpdate->avg_pur_price = $avaragePurPrice;
                $itemUpdate->updated_at = Carbon::now();
                $itemUpdate->save();
            }

            // Start Paid
            foreach ($this->paymentMethodList as $key => $amount) {
                //   dd ( $amount['purchase_payment_date']);
                $AccountManager = AccountManager::whereInvoiceId($Query->id)
                    ->whereId($amount['id'])->whereCrAccountId($amount['payment_method_id'])->firstOrNew();
                $AccountManager->code = $amount['transaction_id'];
                $AccountManager->type = 'Credit';
                $AccountManager->cr_account_id = $amount['payment_method_id'];
                $AccountManager->invoice_id = $Query->id;
                $AccountManager->contact_id = $this->contact_id;
                $AccountManager->date = $amount['purchase_payment_date'];
                // $AccountManager->transaction_id = $amount['transaction_id'];
                if ($amount['due_date']) {
                    $AccountManager->due_date = $amount['due_date'];
                    $AccountManager->payment_status = "Hold";
                } else {
                    $AccountManager->payment_status = "Active";
                }
                $AccountManager->amount = $amount['payment_amount'];
                // $AccountManager->date = $this->cheque_payment_date;
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
            $purchaseChartId = ChartOfAccount::whereDefaultModule(2)->first('id')->id;
            $PurchaseAccountManager = AccountManager::whereInvoiceId($Query->id)->whereDrAccountId($purchaseChartId)->firstOrNew();
            $PurchaseAccountManager->code = $this->code;
            $PurchaseAccountManager->type = 'Debit';
            $PurchaseAccountManager->dr_account_id = $purchaseChartId;
            $PurchaseAccountManager->invoice_id = $Query->id;
            $PurchaseAccountManager->contact_id = $this->contact_id;
            $PurchaseAccountManager->amount = $this->subtotal;
            $PurchaseAccountManager->date = $this->date;
            $PurchaseAccountManager->note = 'Purchase';
            $PurchaseAccountManager->user_id = Auth::user()->id;
            $PurchaseAccountManager->branch_id = Auth::user()->branch_id;
            $PurchaseAccountManager->company_id = Auth::user()->company_id;
            $PurchaseAccountManager->save();
            // End Purchase

            // Start Discount
            if ($this->discount_amount) {
                $purchaseDiscountChartId = ChartOfAccount::whereDefaultModule(12)->first('id')->id;
                $PurchaseDiscountAccountManager = AccountManager::whereInvoiceId($Query->id)->whereCrAccountId($purchaseDiscountChartId)->firstOrNew();
                $PurchaseDiscountAccountManager->code = $this->code;
                $PurchaseDiscountAccountManager->type = 'Credit';
                $PurchaseDiscountAccountManager->cr_account_id = $purchaseDiscountChartId;
                $PurchaseDiscountAccountManager->invoice_id = $Query->id;
                $PurchaseDiscountAccountManager->contact_id = $this->contact_id;
                //   Start Discount Cal
                $lastChar = substr($this->discount_amount, -1);

                if ($lastChar == '%') {
                    $total_discount = substr($this->discount_amount, 0, -1);
                    $discount_val = ($this->subtotal * $total_discount) / 100;
                    $PurchaseDiscountAccountManager->amount = $discount_val;
                } else {
                    $PurchaseDiscountAccountManager->amount = $this->discount_amount;
                }
                // End Discount Cal
                $PurchaseDiscountAccountManager->date = $this->date;
                $PurchaseDiscountAccountManager->note = 'Discount';
                $PurchaseDiscountAccountManager->user_id = Auth::user()->id;
                $PurchaseDiscountAccountManager->branch_id = Auth::user()->branch_id;
                $PurchaseDiscountAccountManager->company_id = Auth::user()->company_id;
                $PurchaseDiscountAccountManager->save();
            }
            // End Discount

            // Start Shipping Charge
            if ($this->shipping_charge) {
                $purchaseShippingChartId = ChartOfAccount::whereDefaultModule(14)->first('id')->id;
                $PurchaseShippingAccountManager = AccountManager::whereInvoiceId($Query->id)->whereDrAccountId($purchaseShippingChartId)->firstOrNew();
                $PurchaseShippingAccountManager->code = $this->code;
                $PurchaseShippingAccountManager->type = 'Debit';
                $PurchaseShippingAccountManager->dr_account_id = $purchaseShippingChartId;
                $PurchaseShippingAccountManager->invoice_id = $Query->id;
                $PurchaseShippingAccountManager->contact_id = $this->contact_id;
                $PurchaseShippingAccountManager->amount = $this->shipping_charge;
                $PurchaseShippingAccountManager->date = $this->date;
                $PurchaseShippingAccountManager->note = 'Shipping Charge';
                $PurchaseShippingAccountManager->user_id = Auth::user()->id;
                $PurchaseShippingAccountManager->branch_id = Auth::user()->branch_id;
                $PurchaseShippingAccountManager->company_id = Auth::user()->company_id;
                $PurchaseShippingAccountManager->save();
            }
            // End Shipping Charge
            // Start Input VAT
            if ($this->vat_total) {
                $purchaseVATChartId = ChartOfAccount::whereDefaultModule(9)->first('id')->id;
                $PurchaseVATAccountManager = AccountManager::whereInvoiceId($Query->id)->whereDrAccountId($purchaseVATChartId)->firstOrNew();
                $PurchaseVATAccountManager->code = $this->code;
                $PurchaseVATAccountManager->type = 'Debit';
                $PurchaseVATAccountManager->dr_account_id = $purchaseVATChartId;
                $PurchaseVATAccountManager->invoice_id = $Query->id;
                $PurchaseVATAccountManager->contact_id = $this->contact_id;
                $PurchaseVATAccountManager->amount = $this->vat_total;
                $PurchaseVATAccountManager->date = $this->date;
                $PurchaseVATAccountManager->note = 'INPUT VAT';
                $PurchaseVATAccountManager->user_id = Auth::user()->id;
                $PurchaseVATAccountManager->branch_id = Auth::user()->branch_id;
                $PurchaseVATAccountManager->company_id = Auth::user()->company_id;
                $PurchaseVATAccountManager->save();
            }
            // End Vat

            // Start Payable
            if ($this->due) {
                $purchasePayableChartId = ChartOfAccount::whereDefaultModule(6)->first('id')->id;
                $PurchaseDueAccountManager = AccountManager::whereInvoiceId($Query->id)->whereCrAccountId($purchasePayableChartId)->firstOrNew();
                $PurchaseDueAccountManager->code = $this->code;
                $PurchaseDueAccountManager->type = 'Credit';
                $PurchaseDueAccountManager->cr_account_id = $purchasePayableChartId;
                $PurchaseDueAccountManager->invoice_id = $Query->id;
                $PurchaseDueAccountManager->contact_id = $this->contact_id;
                $PurchaseDueAccountManager->amount = $this->due;
                $PurchaseDueAccountManager->date = $this->date;
                $PurchaseDueAccountManager->note = 'Payable';
                $PurchaseDueAccountManager->user_id = Auth::user()->id;
                $PurchaseDueAccountManager->branch_id = Auth::user()->branch_id;
                $PurchaseDueAccountManager->company_id = Auth::user()->company_id;
                $PurchaseDueAccountManager->save();
            }
            // End Payable

            if (!$this->InvoiceId) {
                $this->reset();
                $this->purchase_payment_date = Carbon::now()->format('Y-m-d');
            }

            $this->GenerateCode();
            $this->transaction_id = 'TR' . floor(time() - 999999999);
            $this->receipt_code = 'R' . floor(time() - 999999999);
            $this->date = Carbon::now()->format('Y-m-d');
            $this->emit('success_redirect', [
                'text' => 'Purchase C/U Successfully',
                'url' => route('inventory.purchase-list'),
            ]);
        });
    }

    public function updateItemCal()
    {
        $grandTotal = 0;
        $vatTotal = 0;
        // dd($this->orderItemList);
        // sort($this->orderItemList);
        foreach ($this->orderItemList as $key => $value) {
            if (is_numeric($this->item_rate[$key]) && is_numeric($this->item_quantity[$key])) {

                $lastChar = substr($this->item_discount[$key], -1);
                if ($lastChar == '%') {
                    //    dd($this->item_discount[$key]);
                    $item_discount = substr($this->item_discount[$key], 0, -1);
                    $item_discount = (float) $item_discount;
                    $discount = (floatval($this->item_rate[$key]) * floatval($this->item_quantity[$key] * $item_discount) / 100);
                    $this->item_subtotal[$key] = floatval($this->item_rate[$key]) * floatval($this->item_quantity[$key]) - floatval($discount);
                } else {
                    $this->item_subtotal[$key] = floatval($this->item_rate[$key]) * floatval($this->item_quantity[$key]) - floatval($this->item_discount[$key]);
                }
                $vatTotal += (floatval($this->item_subtotal[$key]) * floatval($this->item_vat[$key])) / 100;
                $grandTotal += floatval($this->item_subtotal[$key]);
            }
        }
        $payment_amount_total = 0;
        foreach ($this->paymentMethodList as $key => $amount) {
            $payment_amount_total += $amount['payment_amount'];
        }
        $this->paid_amount = $payment_amount_total;
        $this->vat_total = $vatTotal;
        $this->grand_total = $grandTotal;
        $this->subtotal = $grandTotal;
        if ((is_numeric($this->shipping_charge)) || is_numeric($this->discount_amount)) {
            $lastCharDis = substr($this->discount_amount, -1);
            if ($lastCharDis == '%') {
                $discount_amount = substr($this->discount_amount, 0, -1);
                $discount_amount = (float) $discount_amount;
                $total_discount = ($this->grand_total * $discount_amount) / 100;
                $this->grand_total = $this->grand_total + $this->vat_total - floatval($total_discount) + floatval($this->shipping_charge);
            } else {
                $this->grand_total = $this->grand_total + $this->vat_total - floatval($this->discount_amount) + floatval($this->shipping_charge);
            }
            $this->due = $this->grand_total - floatval($this->paid_amount);
        }
    }

    public function removeItem($itemId)
    {
        $cart = collect($this->orderItemList);
        $stockManager = StockManager::whereInvoiceId($this->InvoiceId)->whereItemId($itemId)->first();
        if ($stockManager) {
            $stockManager->delete();
        }
        $cart->pull($itemId);
        $this->orderItemList = $cart;
        $this->updateItemCal();
    }

    public function AddPurchaseItem($item)
    {
        $cart = collect($this->orderItemList);
        // dd($this->orderItemList);
        if (isset($cart[$item['id']])) {
            $cart[$item['id']] = $item;
            $this->item_quantity[$item['id']] = $this->item_quantity[$item['id']] + 1;
        } else {
            $cart[$item['id']] = $item;
            $this->Item = Item::find($item['id']);
            // if($this->Item->StockManager){
            //     $this->warehouse_id[$item['id']] = $this->Item->StockManager->warehouse_id;
            // }
            $this->item_quantity[$item['id']] = 1;
            $this->item_vat[$item['id']] = $this->Item->Vat->rate_percent;
            $this->item_rate[$item['id']] = $item['purchase_price'];
            $this->item_purchase_price[$item['id']] = $item['purchase_price'];
            $this->item_discount[$item['id']] = 0;
            $this->item_subtotal[$item['id']] = 0;
            $this->serial_no[$item['id']] = null;
        }
        $this->orderItemList = $cart->toArray();
        $this->updateItemCal();
    }

    //for customer popup model in purchase
    public function SupplierSave()
    {
        $this->validate([
            'supplier_code' => 'required',
            'name' => 'required',
        ]);
        if ($this->supplier_id) {
            $Query = Contact::find($this->supplier_id);
        } else {
            $Query = new Contact();
            $Query->user_id = Auth::id();
        }
        $Query->code = $this->supplier_code;
        $Query->type = 'supplier';
        $Query->name = $this->name;
        $Query->business_name = $this->business_name;
        $Query->email = $this->email;
        $Query->mobile = $this->mobile;
        $Query->trn_no = $this->trn_no;
        $Query->sale_commission = $this->sale_commission;
        // $Query->is_due_sale = $this->is_due_sale;
        $Query->is_default = $this->is_default;
        $Query->company_id = Auth::user()->company_id;
        $Query->address = $this->address;
        $Query->status = $this->status;
        $Query->opening_balance = $this->opening_balance;
        $Query->branch_id = $this->branch_id;
        $Query->credit_limit = $this->credit_limit;
        $Query->due_date = $this->due_date;
        $Query->status = '1';
        $Query->branch_id = $this->branch_id;
        $Query->save();
        $this->SupplierModal();
        $this->emit('success', [
            'text' => 'Supplier Accounts C/U Successfully',
        ]);
    }

    public function GenerateCode()
    {
        $check_row = Invoice::orderBy('id', 'desc')->first();
        if (!$check_row) {
            $this->code = 'P001';
        } else {
            $this->code = ++$check_row->id;
            if ($this->code <= 9) {
                $this->code = 'P00' . $this->code;
            } elseif ($this->code <= 99) {
                $this->code = 'P0' . $this->code;
            } else {
                $this->code = 'P' . $this->code;
            }
        }
        // dd($this->code);
    }

    public function GenerateCodeForSupplier()
    {
        $check_row = Contact::orderBy('id', 'desc')->first();
        if (!$check_row) {
            $this->supplier_code = "S001";
        } else {
            $this->supplier_code = ++$check_row->id;
            if ($this->supplier_code <= 9) {
                $this->supplier_code = "S00" . $this->supplier_code;
            } else if ($this->supplier_code <= 99) {
                $this->supplier_code = "S0" . $this->supplier_code;
            }
        }
        // dd($this->code);
    }

    public function SupplierModal()
    {
        $this->reset(['supplier_code', 'name', 'business_name', 'email', 'mobile', 'trn_no', 'sale_commission', 'is_default', 'address', 'status', 'opening_balance', 'branch_id', 'credit_limit', 'due_date']);
        $this->GenerateCodeForSupplier();
        $this->GenerateCode();
        $this->emit('modal', 'SupplierModalBox');
    }

    public function render()
    {
        // dd($this->paymentMethodList);
        return view('livewire.inventory.purchase', [
            'contacts' => Contact::whereCompanyId(Auth::user()->company_id)->whereType('supplier')->get(),
            'payments' => ChartOfAccount::whereIsCashbank(1)->get(),
            'branches' => Branch::whereCompanyId(Auth::user()->company_id)->get(),
            'categories' => Category::whereCompanyId(Auth::user()->company_id)->get(),
            'brands' => Brand::whereCompanyId(Auth::user()->company_id)->get(),
            'units' => Unit::whereCompanyId(Auth::user()->company_id)->get(),
            'vats' => Vat::whereCompanyId(Auth::user()->company_id)->get(),
        ]);
    }
}
