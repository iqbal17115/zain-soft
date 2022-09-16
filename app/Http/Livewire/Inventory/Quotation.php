<?php

namespace App\Http\Livewire\Inventory;

use App\Models\Accounts\AccountManager;
use App\Models\AccountSettings\ChartOfAccount;
use App\Models\Billing\Invoice;
use App\Models\Stock\ItemInvoice;
use App\Models\Contact\Contact;
use App\Models\AccountSettings\Branch;
use App\Models\AccountSettings\Vat;
use App\Models\Stock\Brand;
use App\Models\Stock\Category;
use App\Models\Stock\Item;
use App\Models\Stock\Unit;
use App\Models\Stock\StockManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Livewire\Component;

class Quotation extends Component
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
      public $category_id;
      public $brand_id;
      public $item_id;
      public $unit_id;
      public $vat_id;

    //for customer model popup variable declare
    public $customer_code;
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
    public $supplier_id = 0;
    public $status = 1;
    public $due_date;
    public $customer_id;


    // variable declare for Quotation page
    public $content_body;
    public $content_footer;
    public $item_quantity;
    public $item_rate;
    public $discount;
    public $discount_amount = 0;
    public $item_subtotal;
    public $item_discount;
    public $subtotal;
    public $vat_total = 0;
    public $item_vat;
    public $item_sale_price;
    // public $item_batch_no;
    // public $item_expired_date;
    public $header_content;
    public $footer_content;
    public $Item;
    public $shipping_charge = 0;
    public $amt_to_pay;
    public $payment_method_id;
    public $contact_id;
    public $code;
    public $item_invoice_code;
    public $date;
    public $expired_date;
    public $InvoiceId;
    public $amt_amount;
    public $grand_total;
    public $paymentMethodList = [];
    public $orderItemList = [];
    protected $listeners = [
        'item_search' => 'AddQuotationItem',
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

        $this->reset(['item_code', 'purchase_price', 'item_name', 'opening_stock', 'item_add_discount', 'sale_price', 'low_stock_alert','is_stock_check','is_stock_check','is_stock_check_disable','whole_sale_price', 'category_id','brand_id','item_id', 'unit_id', 'vat_id']);
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
                $this->item_code = 'I00'.$this->item_code;
            } elseif ($this->item_code <= 99) {
                $this->item_code = 'I0'.$this->item_code;
            } else {
                $this->item_code = 'I'.$this->item_code;
            }
        }
        // dd($this->item_code);
    }
    public function ItemModal(){
        $this->GenerateCodeForItem();
        $this->emit('modal', 'ItemModal');
    }
    public function QuotationSave()
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
                $Query->type = "Quotation";
                $Query->user_id = Auth::user()->id;
                $Query->branch_id = Auth::user()->branch_id;
                $Query->company_id = Auth::user()->company_id;
            }

            $Query->code = $this->code;
            // dd($this->header_content);
            $Query->header_content = $this->header_content;
            $Query->footer_content = $this->footer_content;
            $Query->date = $this->date;
            $Query->expired_date = $this->expired_date;
            $Query->contact_id = $this->contact_id;
            $Query->subtotal     = $this->subtotal;
            // $Query->discount_value = $this->discount_amount;
            $lastChar = substr($this->discount_amount, -1);

            if ($lastChar == '%') {
                $total_discount = substr($this->discount_amount, 0, -1);
                $Query->discount = $total_discount;
                $subtotal_discount=($this->subtotal * $total_discount)/100;
                $Query->discount_value = $subtotal_discount;
            } else {
                $Query->discount_value = $this->discount_amount;
            }
            $Query->total_vat = $this->vat_total;
            $Query->shipping_charge = $this->shipping_charge;
            $Query->amount_to_pay = $this->grand_total;
            $Query->status = 1;
            $Query->save();

            foreach ($this->orderItemList as $key => $value) {
                $item = Item::find($key);
                // dd($orderItem);

                $this->GenerateItemInvoiceCode();
                $ItemInvoice=ItemInvoice::whereItemId($key)->whereInvoiceId($Query->id)->first();
                if(!$ItemInvoice){
                    $ItemInvoice=new ItemInvoice();
                }
                $ItemInvoice->code = $this->item_invoice_code;
                $ItemInvoice->date = $this->date;
                $ItemInvoice->item_id = $key;
                $ItemInvoice->category_id = $item->category_id;
                $ItemInvoice->invoice_id = $Query->id;
                $ItemInvoice->unit_id = $item->unit_id;
                $ItemInvoice->contact_id = $this->contact_id;
                $ItemInvoice->sale_price = $item->sale_price;

                //   Start Discount Cal
                $lastChar = substr($this->item_discount[$key], -1);
                if ($lastChar == '%') {
                    // $item_discount = substr($this->item_discount[$key], 0, -1);
                    // $ItemInvoice->discount_percent = $item_discount;
                    $total_discount = substr($this->discount_amount, 0, -1);
                $ItemInvoice->discount_percent = $total_discount;
                $subtotal_discount=($this->subtotal * $total_discount)/100;
                $ItemInvoice->discount_value = $subtotal_discount;
                } else {
                    $ItemInvoice->discount_value = $this->item_discount[$key];
                }

                // End Discount Cal
                $ItemInvoice->quantity = $this->item_quantity[$key];
                $ItemInvoice->subtotal = $this->item_rate[$key] * $this->item_quantity[$key];
                // if (isset($this->item_batch_no[$key])) {
                //     $ItemInvoice->batch_no = $this->item_batch_no[$key];
                // }
                // if (isset($this->item_expired_date[$key])) {
                //     $ItemInvoice->expired_date = $this->item_expired_date[$key];
                // }
                $ItemInvoice->user_id = Auth::user()->id;
                $ItemInvoice->branch_id = $item->branch_id;
                $ItemInvoice->save();

            }
            if(!$this->InvoiceId){
                $this->reset();
                $this->date=Carbon::now()->format('Y-m-d');
            }
            $this->GenerateCode();
            $this->emit('success_redirect', [
                'text' => 'Quotation C/U Successfully',
                'url' => route('inventory.quotation-list'),
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
            $this->code = "Q001";
        } else {
            $this->code = ++$check_row->id;
            if ($this->code <= 9) {
                $this->code = "Q00" . $this->code;
            } else if ($this->code <= 99) {
                $this->code = "Q0" . $this->code;
            } else {
                $this->code = "Q" . $this->code;
            }
        }
    }
    public function GenerateItemInvoiceCode()
    {
        $check_row = ItemInvoice::orderBy('id', 'desc')->first();
        if (!$check_row) {
            $this->item_invoice_code = "II001";
        } else {
            $this->item_invoice_code = ++$check_row->id;
            if ($this->item_invoice_code <= 9) {
                $this->item_invoice_code = "II00" . $this->item_invoice_code;
            } else if ($this->item_invoice_code <= 99) {
                $this->item_invoice_code = "II0" . $this->item_invoice_code;
            } else {
                $this->item_invoice_code = "II" . $this->item_invoice_code;
            }
        }
    }
    public function mount($id=NULL)
    {
        $this->GenerateCode();
        $this->GenerateItemInvoiceCode();
        $this->date=Carbon::now()->format('Y-m-d');
        $this->expired_date = Carbon::now()->format('Y-m-d');

        if($id){
            $QueryUpdate=Invoice::find($id);
            $this->InvoiceId = $QueryUpdate->id;
            $this->code = $QueryUpdate->code;
            $this->header_content = $QueryUpdate->header_content;
            $this->footer_content = $QueryUpdate->footer_content;
            $this->date = $QueryUpdate->date;
            $this->contact_id = $QueryUpdate->contact_id;
            $this->subtotal     = $QueryUpdate->subtotal;
            if($QueryUpdate->discount){
                $this->discount_amount = $QueryUpdate->discount_value.'%';
            }else{
                $this->discount_amount = $QueryUpdate->discount_value;
            }
            $this->discount_value = $QueryUpdate->discount_amount;
            $this->total_vat = $QueryUpdate->vat_total;
            $this->shipping_charge = $QueryUpdate->shipping_charge;
            $this->grand_total = $QueryUpdate->amount_to_pay;

            // Start Item Invoice
             $Items=ItemInvoice::whereInvoiceId($id)->get();
            $cart = collect($this->orderItemList);
            foreach ($Items as $stockItem) {
                $item = Item::find($stockItem->item_id);
                $this->item_quantity[$item->id] = $stockItem->quantity;
                $this->item_rate[$item->id] = $stockItem->sale_price;
                $this->item_subtotal[$item->id] = $stockItem->subtotal;
                // dd($stockItem->Item->Vat->rate_percent);
                $this->item_vat[$item->id] = $stockItem->Item->Vat->rate_percent;
                $this->item_discount[$item->id]=0;
                // dd($stockItem->discount_percent);
                if($stockItem->discount_percent){
                    $this->item_discount[$item->id] = $stockItem->discount_percent.'%';
                }else{
                    $this->item_discount[$item->id] = $stockItem->discount_value;
                }

                $cart[$item->id] = $item;
            }
            $this->orderItemList = $cart;
            // End Item Invoice
            $this->updateItemCal();
        }
    }
    public function updateItemCal()
    {
        $grandTotal = 0;
        $vatTotal = 0;

        foreach ($this->orderItemList as $key => $value) {
            if (is_numeric($this->item_rate[$key]) && is_numeric($this->item_quantity[$key])) {
                $lastChar = substr($this->item_discount[$key], -1);
                if ($lastChar == '%') {
                    //    dd($this->item_discount[$key]);
                    $item_discount = substr($this->item_discount[$key], 0, -1);
                    $item_discount = (float)$item_discount;
                    $discount = (floatval($this->item_rate[$key]) * floatval($this->item_quantity[$key] * $item_discount) / 100);
                    $this->item_subtotal[$key] = floatval($this->item_rate[$key]) * floatval($this->item_quantity[$key]) - floatval($discount);
                } else {
                    $this->item_subtotal[$key] = floatval($this->item_rate[$key]) * floatval($this->item_quantity[$key]) - floatval($this->item_discount[$key]);
                }
                $vatTotal += (floatval($this->item_subtotal[$key]) * floatval($this->item_vat[$key])) / 100;
                $grandTotal += $this->item_subtotal[$key];
            }
        }
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
        }
    }
    public function removeItem($itemId)
    {
        // $cart = collect($this->orderItemList);
        // $cart->pull($itemId);
        // $this->orderItemList = $cart;
        // $this->updateItemCal();

        $cart = collect($this->orderItemList);
        $stockManager = ItemInvoice::whereInvoiceId($this->InvoiceId)->whereItemId($itemId)->first();
        if ($stockManager) {
            $stockManager->delete();
        }
        $cart->pull($itemId);
        $this->orderItemList = $cart;
        $this->updateItemCal();
    }
    public function AddQuotationItem($item)
    {
        $cart = collect($this->orderItemList);
        if (isset($cart[$item['id']])) {
            $cart[$item['id']] = $item;
            $this->item_quantity[$item['id']] = $this->item_quantity[$item['id']] + 1;
        } else {
            $cart[$item['id']] = $item;
            $this->Item = Item::find($item['id']);
            $this->item_quantity[$item['id']] = 1;
            $this->item_vat[$item['id']] = $this->Item->Vat->rate_percent;
            $this->item_rate[$item['id']] = $item['sale_price'];
            $this->item_sale_price[$item['id']] = $item['sale_price'];
            $this->item_discount[$item['id']] = 0;
            $this->item_subtotal[$item['id']] = 0;
        }
        $this->orderItemList = $cart->toArray();
        $this->updateItemCal();
    }

    public function CustomerModal()
    {
        $this->reset(['customer_code','name','business_name','email','mobile','trn_no','sale_commission','is_default','address','status','opening_balance','branch_id','credit_limit','due_date']);
        // $this->code = 'CU' . floor(time() - 999999999);
        $this->GenerateCodeForCustomer();
        $this->GenerateCode();
        $this->emit('modal', 'CustomerModalBox');
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

    public function CustomerSave()
    {
        $this->validate([
            'customer_code' => 'required',
            'name' => 'required',
        ]);
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
        $Query->save();
        $this->CustomerModal();
        $this->emit('success', [
            'text' => 'Customer Accounts C/U Successfully',
        ]);
    }


    public function render()
    {
        return view('livewire.inventory.quotation', [
            'contacts' => Contact::whereCompanyId(Auth::user()->company_id)->whereType('Customer')->get(),
            'branches' => Branch::whereCompanyId(Auth::user()->company_id)->get(),
            'categories' => Category::whereCompanyId(Auth::user()->company_id)->get(),
            'brands' => Brand::whereCompanyId(Auth::user()->company_id)->get(),
            'units' => Unit::whereCompanyId(Auth::user()->company_id)->get(),
            'vats' => Vat::whereCompanyId(Auth::user()->company_id)->get(),
        ]);
    }
}
