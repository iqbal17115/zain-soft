<?php

namespace App\Http\Livewire\Inventory;

use App\Models\Accounts\AccountManager;
use App\Models\AccountSettings\Branch as BranchModal;
use App\Models\AccountSettings\ChartOfAccount;
use App\Models\AccountSettings\Vat;
use App\Models\Billing\Invoice;
use App\Models\Contact\Contact;
use App\Models\Inventory\Brand;
use App\Models\Inventory\Category;
use App\Models\Inventory\Unit;
use App\Models\Stock\Item;
use App\Models\Stock\ItemInvoice;
use App\Models\Stock\StockManager;
use App\Traits\Stock;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Sales extends Component
{
    use Stock;
    //for customer model popup variable declare
    // public $code;
    public $type;
    public $name;
    public $applicant_name;
    public $passport_no;
    public $nationality;
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
    public $supplier_id = 0;
    public $status = 1;
    public $due_date;
    public $customer_id;
    public $vat_reg_type;
    public $vat_reg_date;
    public $telephone;
    public $website;
    public $country;
    public $division;
    public $credit_period;
    public $bank_details;

    // Variable declare for item save
    // public $code;
    public $purchase_price;
    public $item_code;
    public $avg_pur_price;
    // public $name;
    public $opening_stock;
    // public $discount;
    public $sale_price;
    public $low_stock_alert;
    public $is_stock_check;
    public $is_stock_check_disable;
    public $whole_sale_price;
    public $category_id;
    public $brand_id;
    public $item_id;
    public $unit_id;
    public $vat_id;
    // public $branch_id;
    // public $company_id;
    // public $status = 1;

    //variable declare for  Sale save
    public $item_quantity;
    public $item_rate;
    public $serial_no;
    public $discount;
    public $due;
    public $discount_amount = 0;
    public $item_subtotal;
    public $item_discount;
    public $subtotal;
    public $vat_total = 0;
    public $item_vat;
    public $item_sale_price;
    public $item_batch_no;
    public $item_expired_date;
    public $Item;
    public $shipping_charge = 0;
    public $amt_to_pay;
    public $payment_method_id;
    public $payment_amount;
    public $receipt_code;
    public $paid_amount;
    public $sale_payment_date;
    public $transaction_id;
    public $contact_id;
    public $code;
    public $customer_code;
    public $stock_code;
    public $account_manager_code;
    public $date;
    public $chalan_no;
    public $memo_no;
    public $note;
    public $do_no;
    public $lpo_no;
    public $InvoiceId;
    public $quotaion_id;
    public $due_amount;
    public $amt_amount;
    public $grand_total;
    public $ifCheque;
    public $sale_due_date;
    public $cheque_payment_date;
    public $ItemKey = 0;
    public $stockId=[];
    public $paymentMethodList = [];
    public $orderItemList = [];
    protected $listeners = [
        'item_search' => 'AddSaleItem',
        'payment_method_search' => 'AddPaymentMethod',
    ];

    public function removePaymentList($itemId, $ChartId, $id = null)
    {
        // dd($ChartId);
        $cart = collect($this->paymentMethodList);
        $accountManager = AccountManager::whereId($id)->whereInvoiceId($this->InvoiceId)->whereDrAccountId($ChartId)->first();
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
            $this->sale_payment_date = Carbon::now()->format('Y-m-d');
            $this->updateItemCal();
        } else {
            $this->emit('error', [
               'text' => 'Over Payment Not Possible!',
            ]);
        }
    }

    public function ItemModal()
    {
        $this->reset(['item_code', 'type', 'category_id', 'brand_id', 'code', 'name', 'unit_id', 'purchase_price', 'avg_pur_price', 'opening_stock', 'vat_id', 'discount', 'sale_price', 'low_stock_alert', 'is_stock_check', 'whole_sale_price', 'status']);
        $this->GenerateCodeforItem();
        $this->GenerateCode();
        $this->emit('modal', 'ItemModal');
    }

    public function GenerateCodeforItem()
    {
        $check_row = Item::orderBy('id', 'desc')->first();
        if (!$check_row) {
            $this->item_code = 'I001';
        } else {
            $this->item_code = ++$check_row->id;
            if ($this->item_code <= 9) {
                $this->item_code = 'I00'.$this->item_code;
            } elseif ($this->item_code <= 99) {
                $this->item_code = 'I0'.$this->item_code;
            } else {
                $this->code = 'I'.$this->code;
            }
        }
        // dd($this->code);
    }

    public function ItemSave()
    {
        $this->validate([
            'code' => 'required',
            'purchase_price' => 'required',
            'name' => 'required',
            'category_id' => 'required',
            'vat_id' => 'required',
            'unit_id' => 'required',
            'status' => 'required',
        ]);

        if ($this->item_id) {
            $Query = Item::find($this->item_id);
        } else {
            $Query = new Item();
            $Query->user_id = Auth::id();
        }
        $Query->code = $this->item_code;
        $Query->category_id = $this->category_id;
        $Query->brand_id = $this->brand_id;
        $Query->unit_id = $this->unit_id;
        $Query->vat_id = $this->vat_id;
        $Query->name = $this->name;
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
        $this->ItemModal();
        $this->emit('success', [
            'text' => 'Item C\U Successfully',
        ]);
    }

    public function SaleSave()
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
            $Query->type = 'Sales';
            $Query->date = $this->date;
            $Query->contact_id = $this->contact_id;
            $Query->invoice_id = $this->quotaion_id;
            $Query->chalan_no = $this->chalan_no;
            $Query->memo_no = $this->memo_no;
            $Query->note = $this->note;
            $Query->do_no = $this->do_no;
            $Query->lpo_no = $this->lpo_no;
            $Query->subtotal = $this->subtotal;

            $lastChar = substr($this->discount_amount, -1);

            if ($lastChar == '%') {
                $total_discount = substr($this->discount_amount, 0, -1);
                $Query->discount = $total_discount;
                $subtotal_discount = ($this->subtotal * $total_discount) / 100;
                $Query->discount_value = $subtotal_discount;
            } else {
                $Query->discount_value = $this->discount_amount;
            }
            $Query->due_date = $this->sale_due_date;
            $Query->total_vat = $this->vat_total;
            $Query->shipping_charge = $this->shipping_charge;
            $Query->amount_to_pay = $this->grand_total;
            $Query->paid_amount = $this->paid_amount;
            $Query->due_amount = $this->due;
            if ($this->due > 0) {
                $Query->payment_status = 'Due';
            } else {
                $Query->payment_status = 'Paid';
            }

            $Query->user_id = Auth::user()->id;
            $Query->branch_id = Auth::user()->branch_id;
            $Query->company_id = Auth::user()->company_id;
            $Query->status = 1;
            $Query->save();
            foreach ($this->orderItemList as $key => $value) {
                $item = Item::find($value['id']);

                $avaragePurPrice = $item->avg_pur_price;
                if ($avaragePurPrice <= 0 || $avaragePurPrice == null) {
                    $avaragePurPrice = $item->purchase_price;
                }
                $this->GenerateCodeStock();

                $StockManager = StockManager::whereInvoiceId($this->InvoiceId)->whereItemId($value['id'])->first();
                if($this->InvoiceId){
                    StockManager::whereIn('id', $this->stockId)->delete();
                }
                if (!$StockManager) {
                    $StockManager = new StockManager();
                }
                $StockManager->code = $this->stock_code;
                $StockManager->date = $this->date;
                $StockManager->item_id = $value['id'];
                $StockManager->category_id = $item->category_id;
                $StockManager->invoice_id = $Query->id;
                $StockManager->unit_id = $item->unit_id;
                $StockManager->vat_id = $item->vat_id;
                $StockManager->applicant_name = $this->applicant_name[$key];
                $StockManager->passport_no = $this->passport_no[$key];
                $StockManager->nationality = $this->nationality[$key];
                $StockManager->serial_no = $this->serial_no[$key];
                $StockManager->vat_subtotal = (floatval($this->item_subtotal[$key]) * floatval($this->item_vat[$key])) / 100;
                $StockManager->contact_id = $this->contact_id;
                $StockManager->flow = 'Out';
                $StockManager->sale_price = $item->sale_price;
                $StockManager->purchase_price = $avaragePurPrice;
                $StockManager->purchase_subtotal = $avaragePurPrice * $this->item_quantity[$key];
                //   Start Discount Cal
                $lastChar = substr($this->item_discount[$key], -1);
                if ($lastChar == '%') {
                    $item_discount = substr($this->item_discount[$key], 0, -1);
                    $StockManager->discount_percent = $item_discount;
                } else {
                    $StockManager->discount_value = $this->item_discount[$key];
                }
                // End Discount Cal
                $StockManager->quantity = $this->item_quantity[$key];
                $StockManager->sale_subtotal = $this->item_rate[$key] * $this->item_quantity[$key];
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

            }

            // Start Paid
            foreach ($this->paymentMethodList as $key => $amount) {
                $AccountManager = AccountManager::whereInvoiceId($Query->id)
                                 ->whereId($amount['id'])->whereDrAccountId($amount['payment_method_id'])->firstorNew();
                $AccountManager->code = $amount['transaction_id'];
                $AccountManager->type = 'Credit';
                $AccountManager->dr_account_id = $amount['payment_method_id'];
                $AccountManager->invoice_id = $Query->id;
                $AccountManager->contact_id = $this->contact_id;
                $AccountManager->amount = $amount['payment_amount'];
                // $AccountManager->transaction_id = $amount['transaction_id'];
                $AccountManager->date = $amount['sale_payment_date'];
                if ($amount['due_date']) {
                    $AccountManager->due_date = $amount['due_date'];
                    $AccountManager->payment_status = 'Hold';
                } else {
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
            $saleChartId = ChartOfAccount::whereDefaultModule(1)->first('id')->id;
            $saleAccountManager = AccountManager::whereInvoiceId($Query->id)->whereCrAccountId($saleChartId)->firstOrNew();
            $saleAccountManager->code = $this->code;
            $saleAccountManager->type = 'Credit';
            $saleAccountManager->cr_account_id = $saleChartId;
            $saleAccountManager->invoice_id = $Query->id;
            $saleAccountManager->contact_id = $this->contact_id;
            $saleAccountManager->amount = $this->subtotal;
            $saleAccountManager->date = $this->date;
            $saleAccountManager->note = 'Sale';
            $saleAccountManager->user_id = Auth::user()->id;
            $saleAccountManager->branch_id = Auth::user()->branch_id;
            $saleAccountManager->company_id = Auth::user()->company_id;
            $saleAccountManager->save();
            // End Sale

            // Start Discount
            if ($this->discount_amount) {
                $saleDiscountChartId = ChartOfAccount::whereDefaultModule(11)->first('id')->id;
                $saleDiscountAccountManager = AccountManager::whereInvoiceId($Query->id)->whereDrAccountId($saleDiscountChartId)->firstOrNew();
                $saleDiscountAccountManager->code = $this->code;
                $saleDiscountAccountManager->type = 'Debit';
                $saleDiscountAccountManager->dr_account_id = $saleDiscountChartId;
                $saleDiscountAccountManager->invoice_id = $Query->id;
                $saleDiscountAccountManager->contact_id = $this->contact_id;
                //   Start Discount Cal
                $lastChar = substr($this->discount_amount, -1);

                if ($lastChar == '%') {
                    $total_discount = substr($this->discount_amount, 0, -1);
                    $discount_val = ($this->subtotal * $total_discount) / 100;
                    $saleDiscountAccountManager->amount = $discount_val;
                } else {
                    $saleDiscountAccountManager->amount = $this->discount_amount;
                }
                // End Discount Cal
                // $saleDiscountAccountManager->amount = $this->discount_amount;
                $saleDiscountAccountManager->date = $this->date;
                $saleDiscountAccountManager->note = 'Discount';
                $saleDiscountAccountManager->user_id = Auth::user()->id;
                $saleDiscountAccountManager->branch_id = Auth::user()->branch_id;
                $saleDiscountAccountManager->company_id = Auth::user()->company_id;
                $saleDiscountAccountManager->save();
            }
            // End Discount

            // Start Shipping Charge
            if ($this->shipping_charge) {
                $saleShippingChartId = ChartOfAccount::whereDefaultModule(13)->first('id')->id;
                $saleShippingAccountManager = AccountManager::whereInvoiceId($Query->id)->whereCrAccountId($saleShippingChartId)->firstOrNew();
                $saleShippingAccountManager->code = $this->code;
                $saleShippingAccountManager->type = 'Credit';
                $saleShippingAccountManager->cr_account_id = $saleShippingChartId;
                $saleShippingAccountManager->invoice_id = $Query->id;
                $saleShippingAccountManager->contact_id = $this->contact_id;
                $saleShippingAccountManager->amount = $this->shipping_charge;
                $saleShippingAccountManager->date = $this->date;
                $saleShippingAccountManager->note = 'Shipping Charge';
                $saleShippingAccountManager->user_id = Auth::user()->id;
                $saleShippingAccountManager->branch_id = Auth::user()->branch_id;
                $saleShippingAccountManager->company_id = Auth::user()->company_id;
                $saleShippingAccountManager->save();
            }
            // End Shipping Charge
            // Start Output VAT
            if ($this->vat_total) {
                $saleVATChartId = ChartOfAccount::whereDefaultModule(10)->first('id')->id;
                $PurchaseVATAccountManager = AccountManager::whereInvoiceId($Query->id)->whereCrAccountId($saleVATChartId)->firstOrNew();
                $PurchaseVATAccountManager->code = $this->code;
                $PurchaseVATAccountManager->type = 'Credit';
                $PurchaseVATAccountManager->cr_account_id = $saleVATChartId;
                $PurchaseVATAccountManager->invoice_id = $Query->id;
                $PurchaseVATAccountManager->contact_id = $this->contact_id;
                $PurchaseVATAccountManager->amount = $this->vat_total;
                $PurchaseVATAccountManager->date = $this->date;
                $PurchaseVATAccountManager->note = 'Output VAT';
                $PurchaseVATAccountManager->user_id = Auth::user()->id;
                $PurchaseVATAccountManager->branch_id = Auth::user()->branch_id;
                $PurchaseVATAccountManager->company_id = Auth::user()->company_id;
                $PurchaseVATAccountManager->save();
            }
            // End Vat

            // Start Receivable
            if ($this->due) {
                $receivableChartId = ChartOfAccount::whereDefaultModule(5)->first('id')->id;
                $saleDueAccountManager = AccountManager::whereInvoiceId($Query->id)->whereDrAccountId($receivableChartId)->firstOrNew();
                $saleDueAccountManager->code = $this->code;
                $saleDueAccountManager->type = 'Debit';
                $saleDueAccountManager->dr_account_id = $receivableChartId;
                $saleDueAccountManager->invoice_id = $Query->id;
                $saleDueAccountManager->contact_id = $this->contact_id;
                $saleDueAccountManager->amount = $this->due;
                $saleDueAccountManager->date = $this->date;
                $saleDueAccountManager->note = 'Payable';
                $saleDueAccountManager->user_id = Auth::user()->id;
                $saleDueAccountManager->branch_id = Auth::user()->branch_id;
                $saleDueAccountManager->company_id = Auth::user()->company_id;
                $saleDueAccountManager->save();
            }
            // End Payable
            if (!$this->InvoiceId) {
                $this->reset();
                $this->date = Carbon::now()->format('Y-m-d');
            }

            $this->GenerateCode();
            $this->transaction_id = 'TR'.floor(time() - 999999999);
            $this->receipt_code = 'R'.floor(time() - 999999999);
            $this->sale_payment_date = Carbon::now()->format('Y-m-d');

            $this->emit('success_redirect', [
                'text' => 'Sale C/U Successfully',
                'url' => route('inventory.sale-list'),
            ]);
        });
    }

    public function updated()
    {
        $this->updateItemCal();
    }

    public function GenerateCode()
    {
        $check_row = Invoice::orderBy('id', 'desc')->first();
        if (!$check_row) {
            $this->code = 'S001';
        } else {
            $this->code = ++$check_row->id;
            if ($this->code <= 9) {
                $this->code = 'S00'.$this->code;
            } elseif ($this->code <= 99) {
                $this->code = 'S0'.$this->code;
            } else {
                $this->code = 'S'.$this->code;
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
        if (request()->filled('quote_to_sale')) {
            $Quotation = Invoice::where('code', request()->quote_to_sale)->first();
            if ($Quotation) {
                $this->quotaion_id = $Quotation->id;
                $this->contact_id = $Quotation->contact_id;
                $this->date = $Quotation->date;
                $this->sale_due_date = $Quotation->due_date;
                $this->shipping_charge = $Quotation->shipping_charge;
                if ($Quotation->discount) {
                    $this->discount_amount = $Quotation->discount_value.'%';
                } else {
                    $this->discount_amount = $Quotation->discount_value;
                }
                // $this->discount_amount = $SaleInvoice->discount_value;
                $this->grand_total = $Quotation->grand_total;
                $this->subtotal = $Quotation->subtotal;
                $this->due_amount = $Quotation->due_amount;
                $InvoiceItem = ItemInvoice::whereInvoiceId($Quotation->id)->get();
                // dd($PurchaseInvoiceDetail);
                $cart = collect($this->orderItemList);

                foreach ($InvoiceItem as $stockProduct) {
                    $item = Item::find($stockProduct->item_id);
                    $this->item_quantity[$item->id] = $stockProduct->quantity;
                    // $this->product_discount[$product->id] = $product->discount;
                    $this->item_rate[$item->id] = $stockProduct->sale_price;
                    $this->item_quantity[$item->id] = $stockProduct->quantity;
                    $this->item_rate[$item->id] = $stockProduct->sale_price;
                    $this->item_subtotal[$item->id] = $stockProduct->subtotal;
                    $this->serial_no[$item->id] = $stockProduct->serial_no;
                    // dd($stockProduct->Item->Vat->rate_percent);
                    $this->item_vat[$item->id] = $stockProduct->Item->Vat->rate_percent;
                    $this->item_discount[$item->id] = 0;
                    if ($stockProduct->discount_percent) {
                        $this->item_discount[$item->id] = $stockProduct->discount_percent.'%';
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
        $this->transaction_id = 'TR'.floor(time() - 999999999);
        $this->receipt_code = 'R'.floor(time() - 999999999);
        $this->GenerateCode();
        // dd($this->code);
        $this->date = Carbon::now()->format('Y-m-d');
        $this->sale_payment_date = Carbon::now()->format('Y-m-d');
        // Start Edit Sale
        if ($id) {
            $SaleInvoice = Invoice::find($id);
            $this->InvoiceId = $SaleInvoice->id;
            $this->code = $SaleInvoice->code;
            $this->contact_id = $SaleInvoice->contact_id;
            $this->date = $SaleInvoice->date;
            $this->chalan_no = $SaleInvoice->chalan_no;
            $this->memo_no = $SaleInvoice->memo_no;
            $this->note = $SaleInvoice->note;
            $this->do_no = $SaleInvoice->do_no;
            $this->lpo_no = $SaleInvoice->lpo_no;
            $this->shipping_charge = $SaleInvoice->shipping_charge;
            if ($SaleInvoice->discount) {
                $this->discount_amount = $SaleInvoice->discount_value.'%';
            } else {
                $this->discount_amount = $SaleInvoice->discount_value;
            }
            // $this->discount_amount = $SaleInvoice->discount_value;
            $this->grand_total = $SaleInvoice->grand_total;
            $this->subtotal = $SaleInvoice->subtotal;
            $this->due_amount = $SaleInvoice->due_amount;
            $this->paid_amount = $SaleInvoice->paid_amount;

            $StockManager = StockManager::whereInvoiceId($SaleInvoice->id)->get();
            // dd($PurchaseInvoiceDetail);
            $cart = collect($this->orderItemList);

            foreach ($StockManager as $stockProduct) {
                $item = Item::find($stockProduct->item_id);
                $this->item_quantity[$stockProduct->id] = $stockProduct->quantity;
                // $this->product_discount[$product->id] = $product->discount;
                $this->item_rate[$stockProduct->id] = $stockProduct->sale_price;
                $this->item_quantity[$stockProduct->id] = $stockProduct->quantity;
                $this->item_rate[$stockProduct->id] = $stockProduct->sale_price;
                $this->item_subtotal[$stockProduct->id] = $stockProduct->subtotal;
                $this->serial_no[$stockProduct->id] = $stockProduct->serial_no;
                $this->applicant_name[$stockProduct->id] = $stockProduct->applicant_name;
                $this->passport_no[$stockProduct->id] = $stockProduct->passport_no;
                $this->nationality[$stockProduct->id] = $stockProduct->nationality;
                $this->item_vat[$stockProduct->id] = $stockProduct->Item->Vat->rate_percent;
                $this->item_discount[$stockProduct->id] = 0;
                if ($stockProduct->discount_percent) {
                    $this->item_discount[$stockProduct->id] = $stockProduct->discount_percent.'%';
                }
                if ($stockProduct->discount_value) {
                    $this->item_discount[$stockProduct->id] = $stockProduct->discount_value;
                }
                $cart[$stockProduct->id] = $item;
            }
            $this->orderItemList = $cart;

            // Start Account Manager Edit
            $PaymentList = AccountManager::whereInvoiceId($id)->whereNotNull('payment_status')->where('payment_status', '!=', 'Inactive')->get();
            $cartPayment = collect($this->paymentMethodList);
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
            // End Account Manager Edit

            $this->updateItemCal();
        }
        // End Edit Sale
    }

    public function updateItemCal()
    {
        $grandTotal = 0;
        $vatTotal = 0;

        foreach ($this->orderItemList as $key => $value) {
            // dd($this->getStock(['item_id'=>$key])->current_stock);
            // if ($this->getStock(['item_id' => $key])->current_stock < $this->item_quantity[$key]) {
            //     $this->emit('error', [
            //         'text' => 'It is Cross Our Limit Of Stock!',
            //      ]);
            //     $this->item_quantity[$key] = 1;
            // }
            if (is_numeric($this->item_rate[$key]) && is_numeric($this->item_quantity[$key])) {
                $lastChar = substr($this->item_discount[$key], -1);
                if ($lastChar == '%') {
                    $item_discount = substr($this->item_discount[$key], 0, -1);
                    $item_discount = (float) $item_discount;
                    $discount = (floatval($this->item_rate[$key]) * floatval($this->item_quantity[$key] * $item_discount) / 100);
                    $this->item_subtotal[$key] = floatval($this->item_rate[$key]) * floatval($this->item_quantity[$key]) - floatval($discount);
                } else {
                    $this->item_subtotal[$key] = floatval($this->item_rate[$key]) * floatval($this->item_quantity[$key]) - floatval($this->item_discount[$key]);
                }
                $vatTotal += (floatval($this->item_subtotal[$key]) * floatval($this->item_vat[$key])) / 100;
                $grandTotal += $this->item_subtotal[$key];
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
            // $this->grand_total = $this->grand_total + $this->vat_total - floatval($this->discount_amount) + floatval($this->shipping_charge);
            $this->due = $this->grand_total - floatval($this->paid_amount);
            // dd($this->due);
        }
    }

    public function removeItem($itemId)
    {
        $cart = collect($this->orderItemList);
        // $stockManager = StockManager::whereInvoiceId($this->InvoiceId)->whereItemId($itemId)->first();
        // dd($itemId);
        // if ($stockManager) {
        //     $stockManager->delete();
        // }
        array_push($this->stockId, $itemId);
        $cart->pull($itemId);
        $this->orderItemList = $cart->toArray();
        $this->updateItemCal();
    }

    public function AddSaleItem($item)
    {
        // if ($this->getStock(['item_id' => $item['id']])->current_stock > 0) {
            $cart = collect($this->orderItemList);
            // if (isset($cart[$item['id']])) {
            //     $cart[$item['id']] = $item;
            //     $this->item_quantity[$item['id']] = $this->item_quantity[$item['id']] + 1;
            // } else {
                $cart[$this->ItemKey] = $item;
                $this->Item = Item::find($item['id']);
                // if ($this->Item->StockManager) {
                //     $this->warehouse_id[$item['id']] = $this->Item->StockManager->warehouse_id;
                // }
                $this->item_quantity[$this->ItemKey] = 1;
                $this->item_vat[$this->ItemKey] = $this->Item->Vat->rate_percent;
                $this->item_rate[$this->ItemKey] = $item['sale_price'];
                $this->serial_no[$this->ItemKey] = null;
                $this->item_sale_price[$this->ItemKey] = $item['sale_price'];
                $this->item_discount[$this->ItemKey] = 0;
                $this->item_subtotal[$this->ItemKey] = 0;
                $this->applicant_name[$this->ItemKey] = null;
                $this->passport_no[$this->ItemKey] = null;
                $this->nationality[$this->ItemKey] = null;
                ++$this->ItemKey;
            // }
            $this->orderItemList = $cart->toArray();
            $this->updateItemCal();
        // } else {
        //     $this->emit('error', [
        //         'text' => 'Out Of Stock!',
        //      ]);
        // }
    }

    // model popup for sale of supplier
    public function GenerateCodeForCustomer()
    {
        $check_row = Contact::orderBy('id', 'desc')->first();

        if (!$check_row) {
            $this->customer_code = 'C001';
        } else {
            $this->customer_code = ++$check_row->id;
            if ($this->customer_code <= 9) {
                $this->customer_code = 'C00'.$this->customer_code;
            } elseif ($this->customer_code <= 99) {
                $this->customer_code = 'C0'.$this->customer_code;
            }
        }
        // dd($this->code);
    }

    public function CustomerModal()
    {
        $this->reset(['customer_code', 'name', 'business_name', 'email', 'mobile', 'trn_no', 'sale_commission', 'is_default', 'address', 'status', 'opening_balance', 'branch_id', 'credit_limit', 'due_date']);
        // $this->code = 'CU' . floor(time() - 999999999);
        $this->GenerateCodeForCustomer();
        $this->GenerateCode();
        $this->emit('modal', 'CustomerModalBox');
    }

    public function CustomerSave()
    {
        $this->validate([
            'name' => 'required',
        ]);

        if ($this->vat_reg_type == 'Registered') {
            $this->validate([
                'vat_reg_date' => 'required',
            ]);
        }
        if ($this->vat_reg_type == 'Registered') {
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
        $Query->code = $this->customer_code;
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

    // public function CustomerSave()
    // {
    //     $this->validate([
    //         'customer_code' => 'required',
    //         'name' => 'required',
    //     ]);
    //     if ($this->customer_id) {
    //         $Query = Contact::find($this->customer_id);
    //     } else {
    //         $Query = new Contact();
    //         $Query->user_id = Auth::id();
    //     }
    //     $Query->code = $this->customer_code;
    //     $Query->type = 'customer';
    //     $Query->name = $this->name;
    //     $Query->business_name = $this->business_name;
    //     $Query->email = $this->email;
    //     $Query->mobile = $this->mobile;
    //     $Query->opening_balance = $this->opening_balance;
    //     $Query->trn_no = $this->trn_no;
    //     $Query->sale_commission = $this->sale_commission;
    //     // $Query->is_due_sale = $this->is_due_sale;
    //     $Query->is_default = $this->is_default;
    //     $Query->company_id = Auth::user()->company_id;
    //     $Query->address = $this->address;
    //     $this->status = $Query->status;
    //     $Query->branch_id = $this->branch_id;
    //     $Query->credit_limit = $this->credit_limit;
    //     $Query->due_date = $this->due_date;
    //     $Query->save();
    //     $this->CustomerModal();
    //     $this->emit('success', [
    //         'text' => 'Customer Accounts C/U Successfully',
    //     ]);
    // }

    public function render()
    {
        return view('livewire.inventory.sales', [
            'contacts' => Contact::whereCompanyId(Auth::user()->company_id)->whereType('customer')->get(),
            'payments' => ChartOfAccount::whereIsCashbank(1)->get(),
            'branches' => BranchModal::whereCompanyId(Auth::user()->company_id)->get(),
            'categories' => Category::whereCompanyId(Auth::user()->company_id)->get(),
            'brands' => Brand::whereCompanyId(Auth::user()->company_id)->get(),
            'units' => Unit::whereCompanyId(Auth::user()->company_id)->get(),
            'vats' => Vat::whereCompanyId(Auth::user()->company_id)->get(),
        ]);
    }
}
