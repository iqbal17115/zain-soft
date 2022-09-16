<?php

namespace App\Http\Controllers;

use App\Models\Accounts\Receipt;
use App\Models\Accounts\Transaction;
use App\Models\AccountSettings\Branch;
use App\Models\AccountSettings\ChartOfAccount;
use App\Models\AccountSettings\ChartOfGroup;
use App\Models\AccountSettings\ChartOfSection;
use App\Models\AccountSettings\Currency;
use App\Models\AccountSettings\EntryType;
use App\Models\AccountSettings\FinancialYear;
use App\Models\AccountSettings\PaymentMethod;
use App\Models\AccountSettings\Tag;
use App\Models\AccountSettings\Vat;
use App\Models\AccountSettings\Warehouse;
use App\Models\Billing\Invoice;
use App\Models\Contact\Contact as ContactData;
use App\Models\Setting\Company;
use App\Models\Stock\Brand;
use App\Models\Stock\Category;
use App\Models\Stock\Item;
use App\Models\Stock\StockManager;
use App\Models\Stock\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class DatatableController extends Controller
{
    public function index()
    {
        return Datatables::of([])->make(true);
    }

    public function CompanyUpdate(Request $request)
    {
        // dd($request->company_id);
        $User = User::find(Auth::user()->id);
        $User->company_id = $request->company_id;
        $User->save();
    }

    public function RequisitionListTable()
    {
        $Query = Invoice::whereType('Requisition')->orderBy('id', 'DESC');
        if (Auth::user()->hasAnyRole('user')) {
            $Query->whereCompanyId(Auth::user()->company_id);
        }
        $this->i = 1;

        return Datatables::of($Query)
            ->addColumn('id', function ($data) {
                return $this->i++;
            })
            ->addColumn('contact_id', function ($data) {
                return $data->Contact ? $data->Contact->name : '';
            })
            ->addColumn('action', function ($data) {
                // return '
                // <a title="Invoice" class="btn btn-primary btn-sm mb-1" onclick="callInvoice('.$data->id.')">
                //    <i class="fas fa-eye text-white"></i>
                // </a>
                // <a title="Edit" class="btn btn-dark btn-sm mb-1" href="'.route('inventory.make-requisition', ['id' => $data->id]).'" data-id="'.$data->id.'">
                //    <i class="fas fa-edit"></i>
                // </a>
                // <a title="Purchase" class="btn btn-info btn-sm mb-1" href="'.route('inventory.purchase', ['requisition_to_purchase' => $data->code]).'">
                //       <i class="fas fa-store"></i>
                // </a>
                // <button title="Delete" class="btn btn-danger btn-sm mb-1" type="button" onclick="callDelete('.$data->id.')">
                //    <i class="fas fa-trash"></i>
                // </button>
                // ';

                $html = '<div class="dropdown"><button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                $html .= 'Action';
                $html .= '</button>';

                $html .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                $html .= '<a title="Invoice" class="dropdown-item btn btn-warning btn-sm font-weight-bold  mb-1" onclick="callInvoice('.$data->id.')" target="_blank"> <i class="fas fa-eye"></i>&nbsp;View</a>';
                if (Auth::User()->can('edit requisition')) {
                    $html .= '<a title="Edit" class="dropdown-item btn btn-success btn-sm font-weight-bold  mb-1" href="'.route('inventory.make-requisition', ['id' => $data->id]).'" data-id="'.$data->id.'"><i class="fas fa-edit"></i>&nbsp;Edit</a>';
                }
                $html .= '<a title="Purchase" class="dropdown-item btn btn-warning btn-sm font-weight-bold  mb-1" href="'.route('inventory.purchase', ['requisition_to_purchase' => $data->code]).'"><i class="fas fa-undo-alt"></i>&nbsp;Convert To Purchase</a>';
                if (Auth::User()->can('delete requisition')) {
                    $html .= '<button title="Delete" class="dropdown-item btn btn-danger btn-sm font-weight-bold  mb-1" onclick="callDelete('.$data->id.')"><i class="fas fa-trash"></i>&nbsp;Delete</button>';
                }
                $html .= '</div></div>';

                return $html;
            })
            ->rawColumns(['action'])
            ->toJSON();
    }

    public function QuotationListTable()
    {
        $Query = Invoice::whereType('Quotation')->whereCompanyId(Auth::user()->company_id)->orderBy('id', 'DESC');
        $this->i = 1;

        return Datatables::of($Query)
            ->addColumn('id', function ($data) {
                return $this->i++;
            })
            ->addColumn('contact_id', function ($data) {
                return $data->Contact ? $data->Contact->name : '';
            })
            ->addColumn('action', function ($data) {
                // return '
                // <a title="Invoice" class="btn btn-primary btn-sm mb-1" onclick="callInvoice('.$data->id.')" target="_blank">
                //    <i class="fas fa-eye text-white"></i>
                // </a>
                // <a title="Edit" class="btn btn-dark btn-sm mb-1" href="'.route('inventory.quotation', ['id' => $data->id]).'" data-id="'.$data->id.'">
                //    <i class="fas fa-edit"></i>
                // </a>
                // <a title="Sale" class="btn btn-info btn-sm mb-1" href="'.route('inventory.sales', ['quote_to_sale' => $data->code]).'">
                //       <i class="fas fa-store"></i>
                // </a>
                // <button title="Delete" class="btn btn-danger btn-sm mb-1"  type="button" onclick="callDelete('.$data->id.')">
                //    <i class="fas fa-trash"></i>
                // </button>
                // ';

                $html = '<div class="dropdown"><button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                $html .= 'Action';
                $html .= '</button>';

                $html .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                $html .= '<a title="Invoice" class="dropdown-item btn btn-warning btn-sm font-weight-bold  mb-1" onclick="callInvoice('.$data->id.')" target="_blank"> <i class="fas fa-eye "></i>&nbsp;View</a>';
                if (Auth::User()->can('edit quotation')) {
                    $html .= '<a title="Edit" class="dropdown-item btn btn-success btn-sm font-weight-bold  mb-1" href="'.route('inventory.quotation', ['id' => $data->id]).'" data-id="'.$data->id.'"><i class="fas fa-edit"></i>&nbsp;Edit</a>';
                }
                $html .= '<a title="Sale" class="dropdown-item btn btn-warning btn-sm font-weight-bold  mb-1" href="'.route('inventory.sales', ['quote_to_sale' => $data->code]).'"><i class="fas fa-undo-alt"></i>&nbsp;Convert To Sale</a>';
                if (Auth::User()->can('delete quotation')) {
                    $html .= '<button title="Delete" class="dropdown-item btn btn-danger btn-sm font-weight-bold  mb-1" onclick="callDelete('.$data->id.')"><i class="fas fa-trash"></i>&nbsp;Delete</button>';
                }
                $html .= '</div></div>';

                return $html;
            })
            ->toJSON();
    }

    public function SaleReturnListTable()
    {
        $Query = Invoice::whereType('Sales Return')->whereCompanyId(Auth::user()->company_id)->orderBy('id', 'DESC');
        $this->i = 1;

        return Datatables::of($Query)
            ->addColumn('id', function ($data) {
                return $this->i++;
            })
            ->addColumn('contact_id', function ($data) {
                return $data->Contact ? $data->Contact->name : '';
            })
            ->addColumn('action', function ($data) {
                return '
            <a title="Invoice" class="btn btn-primary btn-sm mb-1" onclick="callInvoice('.$data->id.')" target="_blank">
                <i class="fas fa-eye text-white"></i>
            </a>
            <a title="Return" class="btn btn-warning btn-sm mb-1" href="'.route('inventory.sale-return', ['id' => $data->id]).'" data-id="'.$data->id.'">
                <i class="fas fa-undo-alt"></i>
            </a>
            ';
            })
            ->toJSON();
    }

    public function SaleListTable()
    {
        $Query = Invoice::whereType('Sales')->whereCompanyId(Auth::user()->company_id)->with(['Contact:id,name'])->orderBy('id', 'DESC');
        $this->i = 1;

        return Datatables::of($Query)
            ->addColumn('id', function ($data) {
                return $this->i++;
            })
            ->addColumn('contact_id', function ($data) {
                return $data->Contact ? $data->Contact->name : '';
            })
            ->addColumn('action', function ($data) {
                // return '
                // <a title="Transaction" class="btn btn-info btn-sm mb-1" href="'.route('accounts-module.customer-payment', ['invoice_code' => $data->code]).'">
                //     <i class="far fa-money-bill-alt"></i>
                // </a>
                // <a title="Invoice" class="btn btn-primary btn-sm mb-1" onclick="callInvoice('.$data->id.')" target="_blank">
                //     <i class="fas fa-eye text-white"></i>
                // </a>
                // <a title="Edit" class="btn btn-dark btn-sm mb-1" href="'.route('inventory.sales', ['id' => $data->id]).'" data-id="'.$data->id.'">
                //     <i class="fas fa-edit"></i>
                // </a>
                // <a title="Return" class="btn btn-warning btn-sm mb-1" href="'.route('inventory.sale-return', ['id' => $data->id]).'" data-id="'.$data->id.'">
                //     <i class="fas fa-undo-alt"></i>
                // </a>
                // <button title="Delete" class="btn btn-danger btn-sm mb-1" onclick="callDelete('.$data->id.')">
                //     <i class="fas fa-trash"></i>
                // </button>
                // ';
                $html = '<div class="dropdown"><button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                $html .= 'Action';
                $html .= '</button>';

                $html .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                $html .= '<a title="Transaction" class="dropdown-item btn btn-success btn-sm font-weight-bold  mb-1" href="'.route('accounts-module.customer-payment', ['invoice_code' => $data->code]).'"><i class="far fa-money-bill-alt"></i>&nbsp;Payment</a>';
                $html .= '<a title="Invoice" class="dropdown-item btn btn-warning btn-sm font-weight-bold  mb-1" onclick="callInvoice('.$data->id.')" target="_blank"> <i class="fas fa-eye "></i>&nbsp;View</a>';
                if (Auth::User()->can('edit sale')) {
                    $html .= '<a title="Edit" class="dropdown-item btn btn-success btn-sm font-weight-bold  mb-1" href="'.route('inventory.sales', ['id' => $data->id]).'" data-id="'.$data->id.'"><i class="fas fa-edit"></i>&nbsp;Edit</a>';
                }
                $html .= '<a title="Return" class="dropdown-item btn btn-warning btn-sm font-weight-bold  mb-1" href="'.route('inventory.sale-return', ['id' => $data->id]).'" data-id="'.$data->id.'"><i class="fas fa-undo-alt"></i>&nbsp;Return</a>';
                if (Auth::User()->can('delete sale')) {
                    $html .= '<button title="Delete" class="dropdown-item btn btn-danger btn-sm font-weight-bold  mb-1" onclick="callDelete('.$data->id.')"><i class="fas fa-trash"></i>&nbsp;Delete</button>';
                }

                $html .= '</div></div>';

                return $html;
            })
            ->rawColumns(['action'])
            ->toJSON();
    }

    public function PurchaseReturnListTable()
    {
        $Query = Invoice::whereType('Purchase Return')->whereCompanyId(Auth::user()->company_id)->orderBy('id', 'DESC');
        $this->i = 1;

        return Datatables::of($Query)
            ->addColumn('id', function ($data) {
                return $this->i++;
            })
            ->addColumn('contact_id', function ($data) {
                return $data->Contact ? $data->Contact->name : '';
            })
            ->addColumn('action', function ($data) {
                return '
            <a title="Invoice" class="btn btn-primary btn-sm mb-1" onclick="callInvoice('.$data->id.')" target="_blank">
                <i class="fas fa-eye text-white"></i>
            </a>
            <a title="Return" class="btn btn-warning btn-sm mb-1" href="'.route('inventory.purchase-return', ['id' => $data->invoice_id]).'" data-id="'.$data->id.'">
                <i class="fas fa-undo-alt"></i>
            </a>

            ';
            })
            ->toJSON();
    }

    public function PurchaseListTable()
    {
        $Query = Invoice::whereType('Purchase')->whereCompanyId(Auth::user()->company_id)->with(['Contact:id,name'])->orderBy('id', 'DESC');
        $this->i = 1;

        return Datatables::of($Query)
            ->addColumn('id', function ($data) {
                return $this->i++;
            })
            ->addColumn('contact_id', function ($data) {
                return $data->Contact ? $data->Contact->name : '';
            })
            ->addColumn('action', function ($data) {
                // return '
                // <a title="Transaction" class="btn btn-info btn-sm mb-1" href="'.route('accounts-module.supplier-payment', ['invoice_code' => $data->code]).'">
                //     <i class="far fa-money-bill-alt"></i>
                // </a>
                // <a title="Invoice" onclick="callInvoice('.$data->id.')" class="btn btn-primary btn-sm mb-1" target="_blank">
                //     <i class="fas fa-eye text-white"></i>
                // </a>
                // <a title="Edit" class="btn btn-dark btn-sm mb-1" href="'.route('inventory.purchase', ['id' => $data->id]).'" data-id="'.$data->id.'">
                //     <i class="fas fa-edit"></i>
                // </a>
                // <a title="Return" class="btn btn-warning btn-sm mb-1" href="'.route('inventory.purchase-return', ['id' => $data->id]).'" data-id="'.$data->id.'">
                //      <i class="fas fa-undo-alt"></i>
                // </a>
                // <button title="Delete" class="btn btn-danger btn-sm mb-1" onclick="callDelete('.$data->id.')">
                //     <i class="fas fa-trash"></i>
                // </button>
                // ';

                $html = '<div class="dropdown"><button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                $html .= 'Action';
                $html .= '</button>';
                $html .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                $html .= '<a title="Transaction" class="dropdown-item btn btn-success btn-sm font-weight-bold  mb-1" href="'.route('accounts-module.supplier-payment', ['invoice_code' => $data->code]).'"><i class="far fa-money-bill-alt"></i>&nbsp;Payment</a>';
                $html .= '<a title="Invoice" class="dropdown-item btn btn-warning btn-sm font-weight-bold  mb-1" onclick="callInvoice('.$data->id.')" target="_blank"> <i class="fas fa-eye "></i>&nbsp;View</a>';
                if (Auth::User()->can('edit purchase')) {
                    $html .= '<a title="Edit" class="dropdown-item btn btn-success btn-sm font-weight-bold  mb-1" href="'.route('inventory.purchase', ['id' => $data->id]).'" data-id="'.$data->id.'"><i class="fas fa-edit"></i>&nbsp;Edit</a>';
                }
                $html .= '<a title="Return" class="dropdown-item btn btn-warning btn-sm font-weight-bold  mb-1" href="'.route('inventory.purchase-return', ['id' => $data->id]).'" data-id="'.$data->id.'"><i class="fas fa-undo-alt"></i>&nbsp;Return</a>';
                if (Auth::User()->can('delete purchase')) {
                    $html .= '<button title="Delete" class="dropdown-item btn btn-danger btn-sm font-weight-bold  mb-1" onclick="callDelete('.$data->id.')"><i class="fas fa-trash"></i>&nbsp;Delete</button>';
                }

                $html .= '</div></div>';

                return $html;
            })
            ->rawColumns(['action'])
            ->toJSON();
    }

    public function ReceiptTable()
    {
        $Query = Receipt::orderBy('id', 'DESC')->whereCompanyId(Auth::user()->company_id);
        $this->i = 1;

        return Datatables::of($Query)
            ->addColumn('id', function ($data) {
                return $this->i++;
            })

            ->addColumn('entry_type_id', function ($data) {
                return $data->EntryType ? $data->EntryType->name : '';
            })
            ->addColumn('user_id', function ($data) {
                return $data->User ? $data->User->name : '';
            })
            ->addColumn('action', function ($data) {
                $html = '';

                $html .= '<a title="Invoice" onclick="callInvoice('.$data->id.')" class="btn btn-primary btn-sm"><i class="fas fa-eye text-white"></i></a>';
                if (Auth::User()->can('edit receipt')) {
                    $html .= '<a href="'.route('accounts-module.receipt', ['id' => $data->id]).'" data-id="'.$data->id.'" class="btn btn-dark btn-sm"><i class="fas fa-edit"></i></a>';
                }
                if (Auth::User()->can('delete receipt')) {
                    $html .= '<button title="Delete" class="btn btn-danger btn-sm" type="button" onclick="callDelete('.$data->id.')"><i class="fas fa-trash"></i></button>';
                }

                return $html;
            })
            ->toJSON();
    }

    public function EntryTypeTable()
    {
        $Query = EntryType::whereCompanyId(Auth::user()->company_id);

        return Datatables::of($Query)
            ->addColumn('status', function ($data) {
                return $data->status == 1 ? 'Active' : 'Inactive';
            })
            ->addColumn('action', function ($data) {
                // return '<a title="Assign Head" href="'.route('accounts-setting.entry_type_account_list', ['id' => $data->id]).'" data-id="'.$data->id.'" class="btn btn-info btn-sm tableEdit"><i class="fas fa-head-side"></i></a>
                // <button title="Edit" class="btn btn-dark btn-sm" onclick="callEdit('.$data->id.')"><i class="fas fa-edit"></i></button>
                //      <button title="Delete" class="btn btn-danger btn-sm" onclick="callDelete('.$data->id.')"><i class="fas fa-trash"></i></button>';

                $html = '<div class="dropdown"><button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                $html .= 'Action';
                $html .= '</button>';
                $html .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                $html .= '<a title="Assign Head" class="dropdown-item btn btn-warning btn-sm font-weight-bold  mb-1"href="'.route('accounts-setting.entry_type_account_list', ['id' => $data->id]).'" data-id="'.$data->id.'" class="btn btn-info btn-sm tableEdit"><i class="fas fa-head-side"></i>&nbsp;Assign Head</a>';
                if (Auth::User()->can('edit entry_type')) {
                    $html .= '<button title="Edit" class="dropdown-item btn btn-success btn-sm font-weight-bold  mb-1" onclick="callEdit('.$data->id.')"><i class="fas fa-edit"></i>&nbsp;Edit</button>';
                }
                if (Auth::User()->can('delete entry_type')) {
                    $html .= '<button title="Delete" class="dropdown-item btn btn-danger btn-sm font-weight-bold  mb-1"  onclick="callDelete('.$data->id.')"><i class="fas fa-trash"></i>&nbsp;Delete</button>';
                }
                $html .= '</div></div>';

                return $html;
            })
            ->rawColumns(['action'])
            ->toJSON();
    }

    public function UserTable()
    {
        $Query = User::query()->orderBy('id', 'desc');

        return Datatables::of($Query)
            ->addColumn('branch_id', function ($data) {
                return $data->Branch ? $data->Branch->name : '';
            })
            ->addColumn('company_id', function ($data) {
                return $data->Company ? $data->Company->name : '';
            })
            ->addColumn('action', function ($data) {
                // return '<button title="User Permission" class="btn btn-success btn-sm" onclick="callUserPermission('.$data->id.')"><i class="i-Folder-Refresh"> Permission </i></button>
                //         <button title="Edit" class="btn btn-primary btn-sm" onclick="callEdit('.$data->id.')"><i class="i-Folder-Refresh"> Edit </i></button>
                //         <button title="Password" class="btn btn-info btn-sm" onclick="passwordChange('.$data->id.')"><i class="i-Folder-Trash"> Password </i></button>
                //         <button title="Delete" class="btn btn-danger btn-sm" onclick="callDelete('.$data->id.')"><i class="i-Folder-Trash"> Delete </i></button>
                //         ';

                $html = '<div class="dropdown"><button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                $html .= 'Action';
                $html .= '</button>';

                $html .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                $html .= '<a title="Permission" class="dropdown-item btn btn-secondary btn-sm font-weight-bold  mb-1" href="'.route('profile-settings.user-restiction', ['id' => $data->id]).'" data-id="'.$data->id.'"><i class="fas fa-edit"></i>&nbsp;Permission</a>';
                $html .= '<button title="Edit" class="dropdown-item btn btn-success btn-sm font-weight-bold mb-1" onclick="callEdit('.$data->id.')"><i class="i-Folder-Refresh"></i>&nbsp;Edit</button>';
                $html .= '<button title="Password" class="dropdown-item btn btn-warning btn-sm font-weight-bold mb-1" onclick="passwordChange('.$data->id.')"><i class="i-Folder-Trash"></i>&nbsp;Password</button>';
                $html .= '<button title="Delete" class="dropdown-item btn btn-danger btn-sm font-weight-bold mb-1"  onclick="callDelete('.$data->id.')"><i class="i-Folder-Trash"></i>&nbsp;Delete</button>';
                $html .= '</div></div>';

                return $html;
            })
            ->rawColumns(['action'])
            ->toJSON();
    }

    public function CustomersTable()
    {
        $Query = ContactData::query()->orderBy('id', 'desc')->where('type', 'customer')->whereCompanyId(Auth::user()->company_id);
        $this->i = 1;

        return Datatables::of($Query)
            ->addColumn('id', function ($data) {
                return $this->i++;
            })
            // ->addColumn('status_id', function ($data) {
            //     return $data->status ? $data->status->name : '';
            // })
            ->addColumn('action', function ($data) {
                $html = '<div class="dropdown"><button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                $html .= 'Action';
                $html .= '</button>';
                $html .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                if (Auth::User()->can('edit contact')) {
                    $html .= '<button class="dropdown-item btn btn-success btn-sm font-size-14" onclick="callEdit('.$data->id.')"><i class="bx bx-edit font-size-18"></i> Edit</button>';
                }
                if (Auth::User()->can('delete contact')) {
                    if (!$data->StockManager && !$data->CheckStockManager && !$data->CheeckInvoice) {
                        $html .= '<button class="dropdown-item btn btn-danger btn-sm font-size-14" onclick="callDelete('.$data->id.')"><i class="bx bx-window-close font-size-18"></i> Delete</button>';
                    }
                }

                return $html;
            })
            ->toJSON();
    }

    public function SupplierTable()
    {
        $Query = ContactData::query()->orderBy('id', 'desc')->where('type', 'supplier')->whereCompanyId(Auth::user()->company_id);
        $this->i = 1;

        return Datatables::of($Query)
            ->addColumn('id', function ($data) {
                return $this->i++;
            })
            // ->addColumn('status_id', function ($data) {
            //     return $data->status ? $data->status->name : '';
            // })
            ->addColumn('action', function ($data) {
                $html = '<div class="dropdown"><button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                $html .= 'Action';
                $html .= '</button>';
                $html .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                if (Auth::User()->can('edit contact')) {
                    $html .= '<button class="dropdown-item btn btn-success btn-sm font-size-14" onclick="callEdit('.$data->id.')"><i class="bx bx-edit font-size-18"></i> Edit</button>';
                }
                if (Auth::User()->can('delete contact')) {
                    if (!$data->StockManager && !$data->CheckStockManager && !$data->CheeckInvoice) {
                        $html .= '<button class="dropdown-item btn btn-danger btn-sm font-size-14" onclick="callDelete('.$data->id.')"><i class="bx bx-window-close font-size-18"></i> Delete</button>';
                    }
                }

                return $html;
            })
            ->toJSON();
    }

    public function StaffTable()
    {
        $Query = ContactData::query()->orderBy('id', 'desc')->where('type', 'staff');
        $this->i = 1;

        return Datatables::of($Query)
            ->addColumn('id', function ($data) {
                return $this->i++;
            })
            // ->addColumn('status_id', function ($data) {
            //     return $data->status ? $data->status->name : '';
            // })
            ->addColumn('action', function ($data) {
                $html = '<div class="dropdown"><button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                $html .= 'Action';
                $html .= '</button>';
                $html .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                if (Auth::User()->can('edit contact')) {
                    $html .= '<button class="dropdown-item btn btn-success btn-sm font-size-14" onclick="callEdit('.$data->id.')"><i class="bx bx-edit font-size-18"></i> Edit</button>';
                }
                if (Auth::User()->can('delete contact')) {
                    if (!$data->StockManager && !$data->CheckStockManager && !$data->CheeckInvoice) {
                        $html .= '<button class="dropdown-item btn btn-danger btn-sm font-size-14" onclick="callDelete('.$data->id.')"><i class="bx bx-window-close font-size-18"></i> Delete</button>';
                    }
                }

                return $html;
            })
            ->toJSON();
    }

    public function OtherAccountsTable()
    {
        $Query = ContactData::query()->orderBy('id', 'desc')->where('type', 'others')->whereCompanyId(Auth::user()->company_id);
        $this->i = 1;

        return Datatables::of($Query)
            ->addColumn('id', function ($data) {
                return $this->i++;
            })
            // ->addColumn('status_id', function ($data) {
            //     return $data->status ? $data->status->name : '';
            // })
            ->addColumn('action', function ($data) {
                $html = '<div class="dropdown"><button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                $html .= 'Action';
                $html .= '</button>';
                $html .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                if (Auth::User()->can('edit contact')) {
                    $html .= '<button class="dropdown-item btn btn-success btn-sm font-size-14" onclick="callEdit('.$data->id.')"><i class="bx bx-edit font-size-18"></i> Edit</button>';
                }
                if (Auth::User()->can('delete contact')) {
                    if (!$data->StockManager && !$data->CheckStockManager && !$data->CheeckInvoice) {
                        $html .= '<button class="dropdown-item btn btn-danger btn-sm font-size-14" onclick="callDelete('.$data->id.')"><i class="bx bx-window-close font-size-18"></i> Delete</button>';
                    }
                }

                return $html;
            })
            ->toJSON();
    }

    public function BranchTable()
    {
        $Query = Branch::query()->orderBy('id', 'desc')->whereCompanyId(Auth::user()->company_id);
        $this->i = 1;

        return Datatables::of($Query)

            ->addColumn('id', function ($data) {
                return  $this->i++;
            })
            ->addColumn('company_id', function ($data) {
                return $data->Company ? $data->Company->name : '';
            })
            ->addColumn('currency_id', function ($data) {
                return $data->Currency ? $data->Currency->title : '';
            })
            ->addColumn('action', function ($data) {
                // if (Auth::User()->can('delete company')) {
                $html = '';
                if (Auth::User()->can('edit branch')) {
                    $html .= '<button title="Edit" class="btn btn-primary btn-sm" onclick="callEdit('.$data->id.')"><i class="fas fa-edit"></i></button>';
                }
                if (Auth::User()->can('delete branch')) {
                    $html .= '<button title="Delete" class="btn btn-danger btn-sm" onclick="callDelete('.$data->id.')"><i class="fas fa-trash"></i></button>';
                }

                return $html;
            })
            ->toJSON();
    }

    public function ChartOfSectionTable()
    {
        $Query = ChartOfSection::query()->orderBy('id', 'desc');
        $this->i = 1;

        return Datatables::of($Query)

            ->addColumn('id', function ($data) {
                return  $this->i++;
            })
            ->addColumn('status', function ($data) {
                return $data->status == 1 ? 'Active' : 'Inactive';
            })
            ->addColumn('action', function ($data) {
                $html = '';
                // if (Auth::User()->can('edit chart_of_section')) {
                //     $html .= '<button title="Edit" class="btn btn-primary btn-sm" onclick="callEdit(' . $data->id . ')"><i class="i-Folder-Refresh"> Edit </i></button>';
                // }
                // if (Auth::User()->can('delete chart_of_section')) {
                //     $html .= '<button title="Delete" class="btn btn-danger btn-sm" onclick="callDelete(' . $data->id . ')"><i class="i-Folder-Trash"> Delete </i></button>';
                // }
                return $html;
            })
            ->toJSON();
    }

    public function ChartOfGroupTable()
    {
        $Query = ChartOfGroup::query()->orderBy('id', 'desc');
        $this->i = 1;

        return Datatables::of($Query)

            ->addColumn('id', function ($data) {
                return  $this->i++;
            })
            ->addColumn('chart_of_section_id', function ($data) {
                return $data->ChartOfSection ? $data->ChartOfSection->name : '';
            })
            ->addColumn('status', function ($data) {
                return $data->status == 1 ? 'Active' : 'Inactive';
            })
            ->addColumn('action', function ($data) {
                $html = '';
                if (Auth::User()->can('edit chart_of_group')) {
                    $html .= '<button title="Edit" class="btn btn-dark btn-sm" onclick="callEdit('.$data->id.')"><i class="fas fa-edit"></i></button>';
                }
                if (Auth::User()->can('delete chart_of_group')) {
                    $html .= '<button title="Delete" class="btn btn-danger btn-sm" onclick="callDelete('.$data->id.')"><i class="fas fa-trash"></i></button>';
                }

                return $html;
            })
            ->toJSON();
    }

    public function chartOfAccountTable()
    {
        $Query = ChartOfAccount::query()->orderBy('id', 'desc');
        $this->i = 1;

        return Datatables::of($Query)
            ->addColumn('id', function ($data) {
                return $this->i++;
            })
            ->addColumn('chart_of_group_id', function ($data) {
                return $data->ChartOfGroup ? $data->ChartOfGroup->name : '';
            })
            ->addColumn('opening_balance', function ($data) {
                return $data->type ? $data->type.'-'.$data->opening_balance : '';
            })
            ->addColumn('action', function ($data) {
                $html = '';
                if (Auth::User()->can('edit chart_of_account')) {
                    $html .= '<button title="Edit" class="btn btn-dark btn-sm" onclick="callEdit('.$data->id.')"><i class="fas fa-edit"></i></button>';
                }
                if (Auth::User()->can('delete chart_of_account')) {
                    if (!$data->default_module && !$data->CrBalanceCheck && !$data->DrBalanceCheck) {
                        $html .= '<button title="Delete" class="btn btn-danger btn-sm ml-1" onclick="callDelete('.$data->id.')"><i class="fas fa-trash"></i></button>';
                    }
                }

                return $html;
            })
            ->toJSON();
    }

    public function CurrencyTable()
    {
        $Query = Currency::query()->orderBy('id', 'desc')->whereCompanyId(Auth::user()->company_id);
        $this->i = 1;

        return Datatables::of($Query)

            ->addColumn('id', function ($data) {
                return  $this->i++;
            })
            ->addColumn('branch_id', function ($data) {
                return $data->Branch ? $data->Branch->name : '';
            })
            ->addColumn('company_id', function ($data) {
                return $data->Company ? $data->Company->name : '';
            })
            ->addColumn('action', function ($data) {
                $html = '';
                if (Auth::User()->can('edit currency')) {
                    $html .= '<button title="Edit" class="btn btn-dark btn-sm" onclick="callEdit('.$data->id.')"><i class="fas fa-edit"></i></button>';
                }
                if (Auth::User()->can('delete currency')) {
                    $html .= '<button title="Delete" class="btn btn-danger btn-sm" onclick="callDelete('.$data->id.')"><i class="fas fa-trash"></i></button>';
                }

                return $html;
            })
            ->toJSON();
    }

    public function FinancialYearTable()
    {
        $Query = FinancialYear::query()->orderBy('id', 'desc')->whereCompanyId(Auth::user()->company_id);
        $this->i = 1;

        return Datatables::of($Query)

            ->addColumn('id', function ($data) {
                return  $this->i++;
            })
            ->addColumn('status', function ($data) {
                return $data->status == 1 ? 'Active' : 'Inactive';
            })
            ->addColumn('action', function ($data) {
                $html = '';
                if (Auth::User()->can('edit financial_year')) {
                    $html .= '<button title="Edit" class="btn btn-primary btn-sm" onclick="callEdit('.$data->id.')"><i class="fas fa-edit"></i></button>';
                }
                if (Auth::User()->can('edit financial_year')) {
                    $html .= '<button title="Delete" class="btn btn-danger btn-sm" onclick="callDelete('.$data->id.')"><i class="fas fa-trash"></i></button>';
                }

                return $html;
            })
            ->toJSON();
    }

    public function PaymentMethodTable()
    {
        $Query = PaymentMethod::query()->orderBy('id', 'desc');
        $this->i = 1;

        return Datatables::of($Query)
            ->addColumn('id', function ($data) {
                return  $this->i++;
            })
            // ->addColumn('status_id', function ($data) {
            //     return $data->status ? $data->status->name : '';
            // })
            ->addColumn('action', function ($data) {
                return '<button title="Edit" class="btn btn-primary btn-sm" onclick="callEdit('.$data->id.')"><i class="i-Folder-Refresh"> Edit </i></button>
                    <button title="Delete" class="btn btn-danger btn-sm" onclick="callDelete('.$data->id.')"><i class="i-Folder-Trash"> Delete </i></button>';
            })
            ->toJSON();
    }

    public function VatTable()
    {
        $Query = Vat::query()->orderBy('id', 'desc')->whereCompanyId(Auth::user()->company_id);
        $this->i = 1;

        return Datatables::of($Query)
            ->addColumn('branch_id', function ($data) {
                return $data->Branch ? $data->Branch->name : '';
            })
            ->addColumn('status', function ($data) {
                return $data->status == 1 ? 'Active' : 'Inactive';
            })
            ->addColumn('id', function ($data) {
                return  $this->i++;
            })
            // ->addColumn('status_id', function ($data) {
            //     return $data->status ? $data->status->name : '';
            // })
            ->addColumn('action', function ($data) {
                $html = '';
                if (Auth::User()->can('edit vat')) {
                    $html .= '<button title="Edit" class="btn btn-dark btn-sm" onclick="callEdit('.$data->id.')"><i class="fas fa-edit"></i></button>';
                }

                return $html;
            })
            ->toJSON();
    }

    public function WareHouseTable()
    {
        $Query = Warehouse::query()->orderBy('id', 'desc')->whereCompanyId(Auth::user()->company_id);
        $this->i = 1;

        return Datatables::of($Query)

            ->addColumn('id', function ($data) {
                return  $this->i++;
            })
            ->addColumn('branch_id', function ($data) {
                return $data->Branch ? $data->Branch->name : '';
            })
            ->addColumn('status', function ($data) {
                return $data->status == 1 ? 'Active' : 'Inactive';
            })
            ->addColumn('action', function ($data) {
                $html = '';

                if (Auth::User()->can('edit warehouse')) {
                    $html .= '<button title="Edit" class="btn btn-primary btn-sm" onclick="callEdit('.$data->id.')"><i class="fas fa-edit"></i></button>';
                }
                if (Auth::User()->can('delete warehouse')) {
                    $html .= '<button title="Delete" class="btn btn-danger btn-sm" onclick="callDelete('.$data->id.')"><i class="fas fa-trash"></i></button>';
                }

                return $html;
            })
            ->toJSON();
    }

    public function CategoryTable()
    {
        $Query = Category::query()->orderBy('id', 'desc')->whereCompanyId(Auth::user()->company_id);
        $this->i = 1;

        return Datatables::of($Query)

            ->addColumn('id', function ($data) {
                return  $this->i++;
            })
            ->addColumn('status', function ($data) {
                return $data->status == 1 ? 'Active' : 'Inactive';
            })
            ->addColumn('action', function ($data) {
                $html = '';
                if (Auth::User()->can('edit category')) {
                    $html .= '<button title="Edit" class="btn btn-dark btn-sm" onclick="callEdit('.$data->id.')"><i class="fas fa-edit"></i></button>';
                }
                if (Auth::User()->can('delete category')) {
                    if (!$data->StockManager) {
                        $html .= '<button title="Delete" class="btn btn-danger btn-sm" onclick="callDelete('.$data->id.')"><i class="fas fa-trash"></i></button>';
                    }
                }

                return $html;
            })
            ->toJSON();
    }

    public function UnitTable()
    {
        $Query = Unit::query()->orderBy('id', 'desc')->whereCompanyId(Auth::user()->company_id);
        $this->i = 1;

        return Datatables::of($Query)

            ->addColumn('id', function ($data) {
                return  $this->i++;
            })
            ->addColumn('action', function ($data) {
                $html = '';
                if (Auth::User()->can('edit unit')) {
                    $html .= '<button title="Edit" class="btn btn-dark btn-sm" onclick="callEdit('.$data->id.')"><i class="fas fa-edit"></i></button>';
                }
                if (Auth::User()->can('delete unit')) {
                    if (!$data->StockManager) {
                        $html .= '<button title="Delete" class="btn btn-danger btn-sm ml-1" onclick="callDelete('.$data->id.')"><i class="fas fa-trash"></i></button>';
                    }
                }

                return $html;
            })
            ->toJSON();
    }

    public function BrandTable()
    {
        $Query = Brand::query()->orderBy('id', 'desc')->whereCompanyId(Auth::user()->company_id);
        $this->i = 1;

        return Datatables::of($Query)

            ->addColumn('id', function ($data) {
                return  $this->i++;
            })
            // ->addColumn('status_id', function ($data) {
            //     return $data->status ? $data->status->name : '';
            // })
            ->addColumn('action', function ($data) {
                $html = '';
                if (Auth::User()->can('edit brand')) {
                    $html .= '<button title="Edit" class="btn btn-dark btn-sm" onclick="callEdit('.$data->id.')"><i class="fas fa-edit"></i></button>';
                }
                if (Auth::User()->can('delete brand')) {
                    $html .= '<button title="Delete" class="btn btn-danger btn-sm" onclick="callDelete('.$data->id.')"><i class="fas fa-trash"></i></button>';
                }

                return $html;
            })
            ->toJSON();
    }

    public function ItemTable()
    {
        $Query = Item::query()->whereType('Product', 'Material')->orderBy('id', 'desc')->whereCompanyId(Auth::user()->company_id);
        $this->i = 1;

        return Datatables::of($Query)

            ->addColumn('id', function ($data) {
                return  $this->i++;
            })

            ->addColumn('category_id', function ($data) {
                return $data->Category ? $data->Category->name : '';
            })

            ->addColumn('brand_id', function ($data) {
                return $data->Brand ? $data->Brand->name : '';
            })
            ->addColumn('action', function ($data) {
                $html = '';
                if (Auth::User()->can('edit item')) {
                    $html .= '<button title="Edit" class="btn btn-dark btn-sm" onclick="callEdit('.$data->id.')"><i class="fas fa-edit"></i></button>';
                }
                if (Auth::User()->can('delete item')) {
                    if (!$data->StockManager1) {
                        $html .= '<button title="Delete" class="btn btn-danger btn-sm ml-1" onclick="callDelete('.$data->id.')"><i class="fas fa-trash"></i></button>';
                    }
                }

                return $html;
            })
            ->rawColumns(['id', 'action'])
            ->toJSON();
    }

    public function ServiceNameTable()
    {
        $Query = Item::query()->orderBy('id', 'desc')->whereType('Service')->whereCompanyId(Auth::user()->company_id);
        $this->i = 1;

        return Datatables::of($Query)

            ->addColumn('id', function ($data) {
                return  $this->i++;
            })
            // ->addColumn('status_id', function ($data) {
            //     return $data->status ? $data->status->name : '';
            // })
            ->addColumn('action', function ($data) {
                $html = '';
                if (Auth::User()->can('edit service_name')) {
                    $html .= '<button title="Edit" class="btn btn-dark btn-sm" onclick="callEdit('.$data->id.')"><i class="fas fa-edit"></i></button>';
                }
                if (Auth::User()->can('delete service_name')) {
                    $html .= '<button title="Delete" class="btn btn-danger btn-sm ml-1" onclick="callDelete('.$data->id.')"><i class="fas fa-trash"></i></button>';
                }

                return $html;
            })
            ->toJSON();
    }

    public function StockManagerTable()
    {
        $Query = StockManager::query()->orderBy('id', 'desc')->whereCompanyId(Auth::user()->company_id);
        $this->i = 1;

        return Datatables::of($Query)

            ->addColumn('id', function ($data) {
                return  $this->i++;
            })
            // ->addColumn('status_id', function ($data) {
            //     return $data->status ? $data->status->name : '';
            // })
            ->addColumn('action', function ($data) {
                return '<button title="Edit" class="btn btn-primary btn-sm" onclick="callEdit('.$data->id.')"><i class="i-Folder-Refresh"> Edit </i></button>
                    <button title="Delete" class="btn btn-danger btn-sm" onclick="callDelete('.$data->id.')"><i class="i-Folder-Trash"> Delete </i></button>';
            })
            ->toJSON();
    }

    public function CompanyTable()
    {
        $Query = Company::query()->orderBy('id', 'desc');
        $this->i = 1;

        return Datatables::of($Query)

            ->addColumn('id', function ($data) {
                return  $this->i++;
            })

            // ->addColumn('status', function ($data) {
            //     return $data->status ? $data->status->name : '';
            // })

            ->addColumn('action', function ($data) {
                $html = '<div class="dropdown"><button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                $html .= 'Action';
                $html .= '</button>';
                $html .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                if (Auth::User()->can('edit company')) {
                    $html .= '<button class="dropdown-item btn btn-success btn-sm font-size-14" onclick="callEdit('.$data->id.')"><i class="bx bx-edit font-size-18"></i> Edit</button>';
                }
                if (Auth::User()->can('delete company')) {
                    if (!$data->CheckCompany) {
                        $html .= '<button class="dropdown-item btn btn-danger btn-sm font-size-14" onclick="callDelete('.$data->id.')"><i class="bx bx-window-close font-size-18"></i> Delete</button>';
                    }
                }

                return $html;
            })
            ->toJSON();
    }

    public function CustomerPaymentTable()
    {
        $Query = Transaction::query()->orderBy('id', 'desc')->whereType('Receive')->whereCompanyId(Auth::user()->company_id);
        $this->i = 1;

        return Datatables::of($Query)

            ->addColumn('id', function ($data) {
                return  $this->i++;
            })

            ->addColumn('chart_of_account_id', function ($data) {
                return $data->ChartOfAccount ? $data->ChartOfAccount->name : '';
            })
            ->addColumn('contact_id', function ($data) {
                return $data->Contact ? $data->Contact->name : '';
            })
            ->addColumn('invoice_id', function ($data) {
                return $data->Invoice ? $data->Invoice->code : '';
            })

            ->addColumn('action', function ($data) {
                $html = '<div class="dropdown"><button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                $html .= 'Action';
                $html .= '</button>';

                $html .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                $html .= '<a title="Invoice" class="dropdown-item btn btn-warning btn-sm font-weight-bold  mb-1" onclick="callInvoice('.$data->id.')" target="_blank"> <i class="fas fa-eye "></i>&nbsp;View</a>';
                if (Auth::User()->can('edit customer_payment')) {
                    $html .= '<button title="Edit" class="dropdown-item btn btn-success btn-sm font-weight-bold  mb-1" onclick="callEdit('.$data->id.')">.<i class="fas fa-edit"></i>&nbsp;Edit</button>';
                }
                if (Auth::User()->can('delete customer_payment')) {
                    $html .= '<button title="Delete" class="dropdown-item btn btn-danger btn-sm font-weight-bold  mb-1" onclick="callDelete('.$data->id.')"><i class="fas fa-trash"></i>&nbsp;Delete</button>';
                }
                $html .= '</div></div>';

                return $html;
            })
            ->rawColumns(['action'])
            ->toJSON();
    }

    public function SupplierPaymentTable()
    {
        $Query = Transaction::query()->orderBy('id', 'desc')->whereType('Payment')->whereCompanyId(Auth::user()->company_id);
        $this->i = 1;

        return Datatables::of($Query)
            ->addColumn('id', function ($data) {
                return  $this->i++;
            })

            ->addColumn('chart_of_account_id', function ($data) {
                return $data->ChartOfAccount ? $data->ChartOfAccount->name : '';
            })
            ->addColumn('contact_id', function ($data) {
                return $data->Contact ? $data->Contact->name : '';
            })
            ->addColumn('invoice_id', function ($data) {
                return $data->Invoice ? $data->Invoice->code : '';
            })

            ->addColumn('action', function ($data) {
                // return '
                //         <a title="Invoice" onclick="callInvoice('.$data->id.')" class="btn btn-primary btn-sm">
                //            <i class="fas fa-eye text-white"></i>
                //          </a>
                //         <button title="Edit" class="btn btn-dark btn-sm" onclick="callEdit('.$data->id.')">
                //            <i class="fas fa-edit"></i>
                //         </button>
                //         <button title="Delete" class="btn btn-danger btn-sm" onclick="callDelete('.$data->id.')">
                //            <i class="fas fa-trash"></i>
                //         </button>
                //         ';
                $html = '<div class="dropdown"><button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                $html .= 'Action';
                $html .= '</button>';

                $html .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                $html .= '<a title="Invoice" class="dropdown-item btn btn-warning btn-sm font-weight-bold  mb-1" onclick="callInvoice('.$data->id.')" target="_blank"> <i class="fas fa-eye "></i>&nbsp;View</a>';
                if (Auth::User()->can('edit supplier_payment')) {
                    $html .= '<button title="Edit" class="dropdown-item btn btn-success btn-sm font-weight-bold  mb-1" onclick="callEdit('.$data->id.')">.<i class="fas fa-edit"></i>&nbsp;Edit</button>';
                }
                if (Auth::User()->can('delete supplier_payment')) {
                    $html .= '<button title="Delete" class="dropdown-item btn btn-danger btn-sm font-weight-bold  mb-1" onclick="callDelete('.$data->id.')"><i class="fas fa-trash"></i>&nbsp;Delete</button>';
                }
                $html .= '</div></div>';

                return $html;
            })
            ->rawColumns(['action'])
            ->toJSON();
    }

    public function TagTable()
    {
        $Query = Tag::query()->orderBy('id', 'desc')->whereCompanyId(Auth::user()->company_id);
        $this->i = 1;

        return Datatables::of($Query)

            ->addColumn('id', function ($data) {
                return  $this->i++;
            })
            ->addColumn('status', function ($data) {
                return $data->status == 1 ? 'Active' : 'Inactive';
            })
            ->addColumn('action', function ($data) {
                $html = '';
                if (Auth::User()->can('edit tag')) {
                    $html .= '<button title="Edit" class="btn btn-primary btn-sm" onclick="callEdit('.$data->id.')"><i class="fas fa-edit"></i></button>';
                }
                if (Auth::User()->can('delete tag')) {
                    $html .= '<button title="Delete" class="btn btn-danger btn-sm" onclick="callDelete('.$data->id.')"><i class="fas fa-trash"></i></button>';
                }

                return $html;
            })
            ->toJSON();
    }
}
