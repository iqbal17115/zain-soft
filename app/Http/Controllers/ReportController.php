<?php

namespace App\Http\Controllers;

use App\Models\Accounts\AccountManager;
use App\Models\AccountSettings\Branch;
use App\Models\AccountSettings\CompanyInfo;
use App\Models\Setting\Company;
use App\Models\Billing\Invoice;
use App\Models\Contact\Contact;
use App\Models\Inventory\Brand;
use App\Models\Inventory\Category;
use App\Models\Stock\Item;
use App\Models\Stock\StockManager;
use App\Traits\ProfitLoss;
use App\Traits\Receivable;
use App\Traits\Stock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    use Stock;
    use Receivable;
    use ProfitLoss;

    public function CustomerLedgerReportData(Request $request)
    {
        $GetFilterData = [];
        if ($request->contact_id) {
            $account_managers = Contact::find($request->contact_id);
            if (Auth::user()->hasAnyRole('user')) {
                $account_managers->whereCompanyId(Auth::user()->company_id);
            }
            if ($request->company_id1) {
                $account_managers->whereCompanyId($request->company_id1);
                $account_managers = AccountManager::whereCompanyId($request->company_id1)->where('contact_id', $request->contact_id)
                ->whereDate('date', '>=', Carbon::parse($request->from_date)->format('y-m-d'))
                ->whereDate('date', '<=', Carbon::parse($request->to_date)->format('y-m-d'))
                ->get();
            }else{
                $account_managers = AccountManager::where('contact_id', $request->contact_id)
                ->whereDate('date', '>=', Carbon::parse($request->from_date)->format('y-m-d'))
                ->whereDate('date', '<=', Carbon::parse($request->to_date)->format('y-m-d'))
                ->get();
            }

            $openingBalance = $this->getReceivable(['contact_id' => $request->contact_id, 'start_date' => Carbon::parse($request->from_date)->format('Y-m-d'), 'end_date' => Carbon::parse($request->to_date)->format('Y-m-d')])->opening_balance;
            $GetFilterData[1]['id'] = 1;
            $GetFilterData[1]['code'] = '';
            $GetFilterData[1]['date'] = '';
            $GetFilterData[1]['particulars'] = 'Previous Opening Balance';
            $GetFilterData[1]['debit'] = '';
            $GetFilterData[1]['credit'] = '';
            $GetFilterData[1]['balance'] = $openingBalance;
            $x = 2;
            $CreditBalance = $this->getReceivable(['contact_id' => $request->contact_id, 'start_date' => Carbon::parse($request->from_date)->format('Y-m-d'), 'end_date' => Carbon::parse($request->to_date)->format('Y-m-d')])->current_balance;
        } else {

            $account_managers = [];
            $CreditBalance = false;
        }
        foreach ($account_managers as $getTransaction) {
            $GetFilterData[$x]['id'] = $x;
            $GetFilterData[$x]['date'] = Carbon::parse($getTransaction->date)->format('d-M-Y');
            $GetFilterData[$x]['code'] = $getTransaction->code;
            $ParticularDetails = $getTransaction->type;
            $GetFilterData[$x]['particulars'] = $ParticularDetails;
            if ($getTransaction->type == 'Credit') {
                $GetFilterData[$x]['credit'] = $getTransaction->amount;
                $openingBalance = $openingBalance + $getTransaction->amount;
            } else {
                $GetFilterData[$x]['credit'] = '';
            }

            if ($getTransaction->type == 'Debit') {
                $GetFilterData[$x]['debit'] = $getTransaction->amount;
                $openingBalance = $openingBalance - $getTransaction->amount;
            } else {
                $GetFilterData[$x]['debit'] = '';
            }

            $GetFilterData[$x]['balance'] = $openingBalance;
            ++$x;
        }
        if ($CreditBalance) {
            $GetFilterData[$x]['id'] = $x;
            $GetFilterData[$x]['code'] = '';
            $GetFilterData[$x]['date'] = '';
            $GetFilterData[$x]['particulars'] = 'Closing Balance';
            $GetFilterData[$x]['debit'] = '';
            $GetFilterData[$x]['credit'] = '';
            $GetFilterData[$x]['balance'] = $CreditBalance;
        }

        return DataTables::of($GetFilterData)->toJson();
    }

    public function CustomerLedgerReport()
    {
        $CompanyInfo =  Company::query();
        $CompanyInfo = $CompanyInfo->get();

        // $Contacts = Contact::whereType('Customer')->get();
        $Contacts = Contact::query()->whereType('Customer');
        if (Auth::user()->hasAnyRole('user')) {
            $Contacts->whereCompanyId(Auth::user()->company_id);
        }
        $Contacts = $Contacts->get();
        return view('Reports.customer_ledger_report', compact('Contacts','CompanyInfo'));
    }

    public function ProfitLossReportData(Request $request)
    {
        $items = Item::query();
        if (Auth::user()->hasAnyRole('user')) {
            $items->whereCompanyId(Auth::user()->company_id);
        }


        if ($request->company_id1) {
            $items->whereCompanyId($request->company_id1);
        }

        // if($request->from_date && $request->to_date){
        //     $items->whereDate('date', '>=', Carbon::parse($request->from_date)->format('Y-m-d'))->whereDate('date', '<=', Carbon::parse($request->to_date)->format('Y-m-d'));
        // }
        if ($request->brand_id) {
            $items->where('brand_id', $request->brand_id);
        }
        if ($request->branch_id) {
            $items->where('branch_id', $request->branch_id);
        }
        $items->get();
        $this->i = 1;

        return DataTables::of($items)
            ->addColumn('id', function ($data) {
                return $this->i++;
            })
            ->addColumn('profit', function ($data) {
                return $this->getProfitLoss(['item_id' => $data->id])->avg_profit;
            })
            ->addColumn('qty', function ($data) {
                return $this->getProfitLoss(['item_id' => $data->id])->total_out;
            })
            ->addColumn('category_id', function ($data) {
                return $data->Category->name;
            })
            ->addColumn('brand_id', function ($data) {
                if ($data->Brand) {
                    return $data->Brand->name;
                } else {
                    return null;
                }
            })
            ->toJson();
    }

    public function ProfitLossReport()
    {
        $CompanyInfo =  Company::query();
        $CompanyInfo = $CompanyInfo->get();

        $brands = Brand::query();
        if (Auth::user()->hasAnyRole('user')) {
            $brands->whereCompanyId(Auth::user()->company_id);
        }
        $brands = $brands->get();

        $branches = Branch::query();
        if (Auth::user()->hasAnyRole('user')) {
            $branches->whereCompanyId(Auth::user()->company_id);
        }
        $branches = $branches->get();
        $categories = Category::query();
        if (Auth::user()->hasAnyRole('user')) {
            $categories->whereCompanyId(Auth::user()->company_id);
        }
        $categories = $categories->get();
        return view('Reports.profit_loss_report', compact('brands', 'branches', 'categories', 'CompanyInfo'));
    }

    public function SupplierLedgerReportData(Request $request)
    {
        $Contact = Contact::query();
        if (Auth::user()->hasAnyRole('user')) {
            $Contact->whereCompanyId(Auth::user()->company_id);
        }
        $Contact->get();
        $this->i = 1;

        return DataTables::of($Contact)
            ->addColumn('id', function ($data) {
                return $this->i++;
            })
            // ->addColumn('contact_id', function ($data) {
            //     return $data->Contact->name;
            // })
            // ->addColumn('branch_id', function ($data) {
            //     return $data->Branch->name;
            // })
            ->toJson();
    }

    public function SupplierLedgerReport()
    {
        $CompanyInfo =  Company::query();
        $CompanyInfo = $CompanyInfo->get();
        return view('Reports.supplier_ledger_report', compact('CompanyInfo'));
    }

    public function SaleReturnReportData(Request $request)
    {
        $saleReturnReport = Invoice::query()->whereType('Sales Return')->orderBy('id', 'desc');
        if (Auth::user()->hasAnyRole('user')) {

            $saleReturnReport->whereCompanyId(Auth::user()->company_id);
        }

        if ($request->company_id1) {
            $saleReturnReport->whereCompanyId($request->company_id1);
        }

        if ($request->from_date && $request->to_date) {
            $saleReturnReport->whereDate('date', '>=', Carbon::parse($request->from_date)->format('Y-m-d'))->whereDate('date', '<=', Carbon::parse($request->to_date)->format('Y-m-d'));
        }
        if ($request->contact_id) {
            $saleReturnReport->where('contact_id', $request->contact_id);
        }

        $saleReturnReport->get();
        $this->i = 1;

        return DataTables::of($saleReturnReport)
            ->addColumn('id', function ($data) {
                return $this->i++;
            })
            ->addColumn('contact_id', function ($data) {
                return $data->Contact->name;
            })
            ->addColumn('branch_id', function ($data) {
                return $data->Branch->name;
            })
            ->toJson();
    }

    public function SaleReturnReport(Request $request)
    {
        $CompanyInfo =  Company::query();
        $CompanyInfo = $CompanyInfo->get();

        $Customers = Contact::query()->whereType('Customer');
        if (Auth::user()->hasAnyRole('user')) {

            $Customers->whereCompanyId(Auth::user()->company_id);
        }
        $Customers = $Customers->get();

        return view('Reports.sale_return_report', compact('Customers','CompanyInfo'));
    }

    public function PurchaseReturnReportData(Request $request)
    {
        $purchaseReturnReport = Invoice::query()->whereType('Purchase Return')->orderBy('id', 'desc');
        if (Auth::user()->hasAnyRole('user')) {

            $purchaseReturnReport->whereCompanyId(Auth::user()->company_id);
        }

        if ($request->from_date && $request->to_date) {
            $purchaseReturnReport->whereDate('date', '>=', Carbon::parse($request->from_date)->format('Y-m-d'))->whereDate('date', '<=', Carbon::parse($request->to_date)->format('Y-m-d'));
        }
        if ($request->contact_id) {
            $purchaseReturnReport->where('contact_id', $request->contact_id);
        }

        if ($request->company_id1) {
            $purchaseReturnReport->whereCompanyId($request->company_id1);
        }

        $purchaseReturnReport->get();
        $this->i = 1;

        return DataTables::of($purchaseReturnReport)
            ->addColumn('id', function ($data) {
                return $this->i++;
            })
            ->addColumn('contact_id', function ($data) {
                return $data->Contact->name;
            })
            ->addColumn('branch_id', function ($data) {
                return $data->Branch->name;
            })
            ->toJson();
    }

    public function PurchaseReturnReport()
    {
        $CompanyInfo =  Company::query();
        $CompanyInfo = $CompanyInfo->get();

        $Suppliers = Contact::query()->whereType('Supplier');
        if (Auth::user()->hasAnyRole('user')) {

            $Suppliers->whereCompanyId(Auth::user()->company_id);
        }
        $Suppliers = $Suppliers->get();
        return view('Reports.purchase_return_report', compact('Suppliers','CompanyInfo'));
    }

    public function SaleDetailReportData(Request $request)
    {
        $purchase = StockManager::orderBy('id', 'desc')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('invoices')
                    ->whereType('Sales')
                    ->whereColumn('invoices.id', 'stock_managers.invoice_id');
            });
        if (Auth::user()->hasAnyRole('user')) {

            $purchase->whereCompanyId(Auth::user()->company_id);
        }

        if ($request->company_id1) {
            $purchase->whereCompanyId($request->company_id1);
        }

        $purchase->get();
        $this->i = 1;

        return DataTables::of($purchase)
            ->addColumn('id', function ($data) {
                return $this->i++;
            })

            ->addColumn('invoice_code', function ($data) {
                return $data->Invoice? $data->Invoice->code:'';
            })
            ->addColumn('contact_id', function ($data) {
                return $data->Contact->name;
            })
            ->addColumn('item_id', function ($data) {
                return $data->Item->name;
            })
            ->addColumn('branch_id', function ($data) {
                return $data->Branch->name;
            })
            ->toJson();
    }

    public function SaleDetailReport()
    {
        $CompanyInfo =  Company::query();
        $CompanyInfo = $CompanyInfo->get();

        return view('Reports.sale_detail_report', compact('CompanyInfo'));
    }

    public function PurchaseDetailReportData(Request $request)
    {
        $purchase = StockManager::orderBy('id', 'desc')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('invoices')
                    ->whereType('Purchase')
                    ->whereColumn('invoices.id', 'stock_managers.invoice_id');
            });

        if (Auth::user()->hasAnyRole('user')) {

            $purchase->whereCompanyId(Auth::user()->company_id);
        }

        if ($request->company_id1) {
            $purchase->whereCompanyId($request->company_id1);
        }

        if ($request->branch_id) {
            $purchase->where('branch_id', $request->branch_id);
        }

        if ($request->contact_id) {
            $purchase->where('contact_id', $request->contact_id);
        }

        if ($request->from_date && $request->to_date) {
            $purchase->whereDate('date', '>=', Carbon::parse($request->from_date)->format('Y-m-d'))->whereDate('date', '<=', Carbon::parse($request->to_date)->format('Y-m-d'));
        }

        $purchase->get();
        $this->i = 1;

        return DataTables::of($purchase)
            ->addColumn('id', function ($data) {
                return $this->i++;
            })
            ->addColumn('contact_id', function ($data) {
                return $data->Contact->name;
            })
            ->addColumn('item_id', function ($data) {
                return $data->Item->name;
            })
            ->addColumn('branch_id', function ($data) {
                return $data->Branch->name;
            })
            ->toJson();
    }

    public function PurchaseDetailReport()
    {

        $CompanyInfo =  Company::query();
        $CompanyInfo = $CompanyInfo->get();

        $Suppliers = Contact::query()->whereType('Supplier');
        if (Auth::user()->hasAnyRole('user')) {

            $Suppliers->whereCompanyId(Auth::user()->company_id);
        }
        $Suppliers = $Suppliers->get();
        $branches = Branch::query();
        if (Auth::user()->hasAnyRole('user')) {
            $branches->whereCompanyId(Auth::user()->company_id);
        }
        $branches = $branches->get();

        return view('Reports.purchase_detail_report', compact('Suppliers', 'branches', 'CompanyInfo'));
    }

    public function SaleReport()
    {

        $CompanyInfo =  Company::query();
        $CompanyInfo = $CompanyInfo->get();

        $Customers = Contact::query()->whereType('Customer');
        if (Auth::user()->hasAnyRole('user')) {

            $Customers->whereCompanyId(Auth::user()->company_id);
        }
        $Customers = $Customers->get();

        $branches = Branch::query();
        if (Auth::user()->hasAnyRole('user')) {

            $branches->whereCompanyId(Auth::user()->company_id);
        }
        $branches = $branches->get();
        return view('Reports.sale_report', compact('Customers', 'branches', 'CompanyInfo'));
    }

    public function SaleReportData(Request $request)
    {
        $saleInvoice = Invoice::query()->whereType('Sales')->orderBy('id', 'desc');
        if (Auth::user()->hasAnyRole('user')) {

            $saleInvoice->whereCompanyId(Auth::user()->company_id);
        }
        if ($request->company_id1) {
            $saleInvoice->whereCompanyId($request->company_id1);
        }

        if ($request->branch_id) {
            $saleInvoice->where('branch_id', $request->branch_id);
        }

        if ($request->contact_id) {
            $saleInvoice->where('contact_id', $request->contact_id);
        }

        if ($request->payment_status) {
            $saleInvoice->where('payment_status', $request->payment_status);
        }


        if ($request->from_date && $request->to_date) {
            $saleInvoice->whereDate('date', '>=', Carbon::parse($request->from_date)->format('Y-m-d'))->whereDate('date', '<=', Carbon::parse($request->to_date)->format('Y-m-d'));
        }

        $saleInvoice->get();
        $this->i = 1;

        return DataTables::of($saleInvoice)
            ->addColumn('id', function ($data) {
                return $this->i++;
            })
            ->addColumn('contact_id', function ($data) {
                if ($data->Contact) {
                    return $data->Contact->name;
                } else {
                    return null;
                }
            })
            ->addColumn('branch_id', function ($data) {
                return $data->Branch->name;
            })

            ->addColumn('payment_status', function ($data) {
                return $data->payment_status;
            })


            ->toJson();
    }

    public function PurchaseReport()
    {
        $CompanyInfo =  Company::query();
        $Suppliers = Contact::query()->whereType('Supplier');
        if (Auth::user()->hasAnyRole('user')) {

            $Suppliers->whereCompanyId(Auth::user()->company_id);
        }
        $Suppliers = $Suppliers->get();
        $branches = Branch::query();
        if (Auth::user()->hasAnyRole('user')) {

            $branches->whereCompanyId(Auth::user()->company_id);
        }
        $branches = $branches->get();
        $CompanyInfo = $CompanyInfo->get();


        return view('Reports.purchase_report', compact('Suppliers', 'branches', 'CompanyInfo'));
    }

    public function PurchaseReportData(Request $request)
    {
        $purchaseInvoice = Invoice::query()->whereType('Purchase')->orderBy('id', 'desc');
        if (Auth::user()->hasAnyRole('user')) {
            $purchaseInvoice->whereCompanyId(Auth::user()->company_id);
        }
        if ($request->company_id1) {
            $purchaseInvoice->whereCompanyId($request->company_id1);
        }
        if ($request->branch_id) {
            $purchaseInvoice->where('branch_id', $request->branch_id);
        }

        if ($request->contact_id) {
            $purchaseInvoice->where('contact_id', $request->contact_id);
        }

        if ($request->from_date && $request->to_date) {
            $purchaseInvoice->whereDate('date', '>=', Carbon::parse($request->from_date)->format('Y-m-d'))->whereDate('date', '<=', Carbon::parse($request->to_date)->format('Y-m-d'));
        }

        $purchaseInvoice->get();
        $this->i = 1;

        return DataTables::of($purchaseInvoice)
            ->addColumn('id', function ($data) {
                return $this->i++;
            })
            ->addColumn('contact_id', function ($data) {
                if ($data->Contact) {
                    return $data->Contact->name;
                } else {
                    return null;
                }
            })
            ->addColumn('branch_id', function ($data) {
                return $data->Branch->name;
            })
            ->toJson();
    }

    public function LowStockReportData(Request $request)
    {
        $items = Item::query()->where('low_stock_alert', '!=', null);
        if (Auth::user()->hasAnyRole('user')) {

            $items->whereCompanyId(Auth::user()->company_id);
        }

        if ($request->company_id1) {
            $items->whereCompanyId($request->company_id1);
        }

        if ($request->category_id) {
            $items->where('category_id', $request->category_id);
        }
        if ($request->branch_id) {
            $items->where('branch_id', $request->branch_id);
        }
        if ($request->branch_id) {
            $items->where('brand_id', $request->brand_id);
        }
        if ($request->item_type) {
            $items->where('type', $request->item_type);
        }

        $items->get();
        $this->i = 1;

        return DataTables::of($items)
            ->addColumn('id', function ($data) {
                return $this->i++;
            })
            ->addColumn('category_id', function ($data) {
                return $data->Category->name;
            })
            ->addColumn('brand_id', function ($data) {
                if ($data->Brand) {
                    return $data->Brand->name;
                } else {
                    return null;
                }
            })
            ->addColumn('stock', function ($data) {
                return $this->getStock(['item_id' => $data->id])->current_stock;
            })
            ->toJson();
    }

    public function LowStockReport()
    {
        $CompanyInfo =  Company::query();
        $brands = Brand::query();
        if (Auth::user()->hasAnyRole('user')) {

            $brands->whereCompanyId(Auth::user()->company_id);
        }
        $brands = $brands->get();
        $branches = Branch::query();
        if (Auth::user()->hasAnyRole('user')) {

            $branches->whereCompanyId(Auth::user()->company_id);
        }
        $branches = $branches->get();
        $categories = Category::query();
        if (Auth::user()->hasAnyRole('user')) {

            $categories->whereCompanyId(Auth::user()->company_id);
        }
        $categories = $categories->get();
        $items = Item::query();
        if (Auth::user()->hasAnyRole('user')) {

            $items->whereCompanyId(Auth::user()->company_id);
        }
        $items = $items->get();
        $CompanyInfo = $CompanyInfo->get();

        return view('Reports.low_stock_report', compact('brands', 'branches', 'categories', 'items', 'CompanyInfo'));
    }

    public function StockReportData(Request $request)
    {
        $items = Item::query()->orderBy('id', 'desc');
        if (Auth::user()->hasAnyRole('user')) {

            $items->whereCompanyId(Auth::user()->company_id);
        }
        if ($request->category_id) {
            $items->where('category_id', $request->category_id);
        }

        if ($request->company_id1) {
            $items->whereCompanyId($request->company_id1);
        }
        if ($request->branch_id) {
            $items->where('branch_id', $request->branch_id);
        }
        if ($request->branch_id) {
            $items->where('brand_id', $request->brand_id);
        }
        if ($request->item_type) {
            $items->where('type', $request->item_type);
        }
        // if ($request->warehouse_id) {
        //     $items->where('warehouse_id', $request->warehouse_id);
        // }
        $items->get();
        $this->i = 1;

        return DataTables::of($items)
            ->addColumn('id', function ($data) {
                return $this->i++;
            })
            ->addColumn('category_id', function ($data) {
                return $data->Category->name;
            })
            ->addColumn('brand_id', function ($data) {
                if ($data->Brand) {
                    return $data->Brand->name;
                } else {
                    return null;
                }
            })
            ->addColumn('stock', function ($data) {
                return $this->getStock(['item_id' => $data->id])->current_stock;
            })
            ->toJson();
    }

    public function StockReport()
    {
        $CompanyInfo =  Company::query();
        $brands = Brand::query();
        if (Auth::user()->hasAnyRole('user')) {

            $brands->whereCompanyId(Auth::user()->company_id);
        }
        $brands = $brands->get();

        $branches = Branch::query();
        if (Auth::user()->hasAnyRole('user')) {

            $branches->whereCompanyId(Auth::user()->company_id);
        }
        $branches = $branches->get();

        $categories = Category::query();
        if (Auth::user()->hasAnyRole('user')) {

            $categories->whereCompanyId(Auth::user()->company_id);
        }
        $categories = $categories->get();
        $CompanyInfo = $CompanyInfo->get();
        $items = Item::query();
        if (Auth::user()->hasAnyRole('user')) {
            $items->whereCompanyId(Auth::user()->company_id);
        }
        $items = $items->get();


        return view('Reports.stock_report', compact('brands', 'branches', 'categories', 'items', 'CompanyInfo'));
    }

    public function PayableReportData(Request $request)
    {
        $Contact = Contact::whereType('Supplier');

        if (Auth::user()->hasAnyRole('user')) {
            $Contact->whereCompanyId(Auth::user()->company_id);
        }

        if ($request->company_id1) {
            $Contact->whereCompanyId($request->company_id1);
        }
        $Contact->get();

        if ($request->contact_id) {
            $Contact->where('id', $request->contact_id);
        }

        $Contact->get();
        $this->i = 1;

        return DataTables::of($Contact)
            ->addColumn('id', function ($data) {
                return $this->i++;
            })
            ->addColumn('opening_balance', function ($data) {
                return $this->getReceivable(['contact_id' => $data->id])->opening_balance;
            })
            ->addColumn('credit', function ($data) {
                return $this->getReceivable(['contact_id' => $data->id])->total_credit;
            })
            ->addColumn('debit', function ($data) {
                return $this->getReceivable(['contact_id' => $data->id])->total_debit;
            })
            ->addColumn('closing_balance', function ($data) {
                return $this->getReceivable(['contact_id' => $data->id])->current_balance;
            })
            ->toJson();
    }

    public function PayableReport()
    {
        $ContactLists = Contact::whereType('Supplier');
        $CompanyInfo =  Company::query();

        if (Auth::user()->hasAnyRole('user')) {

            $ContactLists->whereCompanyId(Auth::user()->company_id);
        }
        $ContactLists = $ContactLists->get();
        $CompanyInfo = $CompanyInfo->get();

        return view('Reports.payable_report', compact('ContactLists','CompanyInfo'));
    }

    public function ReceivableReportData(Request $request)
    {
        $Contact = Contact::whereType('Customer');
        if (Auth::user()->hasAnyRole('user')) {
            $Contact->whereCompanyId(Auth::user()->company_id);
        }

        if ($request->contact_id) {
            $Contact->where('id', $request->contact_id);
        }

        if ($request->company_id1) {
            $Contact->whereCompanyId($request->company_id1);
        }
        $Contact->get();
        $this->i = 1;

        return DataTables::of($Contact)
            ->addColumn('id', function ($data) {
                return $this->i++;
            })
            ->addColumn('opening_balance', function ($data) {
                return $this->getReceivable(['contact_id' => $data->id])->opening_balance;
            })
            ->addColumn('credit', function ($data) {
                return $this->getReceivable(['contact_id' => $data->id])->total_credit;
            })
            ->addColumn('debit', function ($data) {
                return $this->getReceivable(['contact_id' => $data->id])->total_debit;
            })
            ->addColumn('closing_balance', function ($data) {
                return $this->getReceivable(['contact_id' => $data->id])->current_balance;
            })
            ->toJson();
    }

    public function ReceivableReport()
    {
        $ContactLists = Contact::query()->whereType('Customer');
        $CompanyInfo =  Company::query();

        if (Auth::user()->hasAnyRole('user')) {
            $ContactLists->whereCompanyId(Auth::user()->company_id);
        }
        $CompanyInfo = $CompanyInfo->get();
        $ContactLists = $ContactLists->get();
        // dd($ContactLists);
        return view('Reports.receivable_report', compact('ContactLists','CompanyInfo'));
    }
}
