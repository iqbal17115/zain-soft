<?php

use App\Http\Controllers\DatatableController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PrintInvoiceController;
use App\Http\Controllers\ReportController;
use App\Http\Livewire\AccountsModule\CustomerPayment;
use App\Http\Livewire\AccountsModule\CustomerPaymentInvoice;
use App\Http\Livewire\AccountsModule\Receipt;
use App\Http\Livewire\AccountsModule\ReceiptInvoice;
use App\Http\Livewire\AccountsModule\ReceiptList;
use App\Http\Livewire\AccountsModule\SupplierPayment;
use App\Http\Livewire\AccountsModule\SupplierPaymentInvoice;
use App\Http\Livewire\AccountsSetting\Branch;
use App\Http\Livewire\AccountsSetting\ChartOfAccount;
use App\Http\Livewire\AccountsSetting\ChartOfGroup;
use App\Http\Livewire\AccountsSetting\ChartOfSection;
use App\Http\Livewire\AccountsSetting\Company;
use App\Http\Livewire\AccountsSetting\Currency;
use App\Http\Livewire\AccountsSetting\EntryType;
use App\Http\Livewire\AccountsSetting\EntryTypeAccountList;
use App\Http\Livewire\AccountsSetting\FinancialYear;
use App\Http\Livewire\AccountsSetting\InvoiceSetting;
use App\Http\Livewire\AccountsSetting\PaymentMethod;
use App\Http\Livewire\AccountsSetting\Tag;
use App\Http\Livewire\AccountsSetting\VatSetup;
use App\Http\Livewire\AccountsSetting\Warehouse;
use App\Http\Livewire\Contacts\CustomerAccounts;
use App\Http\Livewire\Contacts\OthersAccounts;
use App\Http\Livewire\Contacts\StaffAccounts;
use App\Http\Livewire\Contacts\SupplierAccounts;
use App\Http\Livewire\Inventory\AddStockAdjustment;
use App\Http\Livewire\Inventory\Brand;
use App\Http\Livewire\Inventory\Category;
use App\Http\Livewire\Inventory\GenerateBarcode;
use App\Http\Livewire\Inventory\ItemName;
use App\Http\Livewire\Inventory\PosTerminal;
use App\Http\Livewire\Inventory\Purchase;
use App\Http\Livewire\Inventory\PurchaseInvoice;
use App\Http\Livewire\Inventory\PurchaseList;
use App\Http\Livewire\Inventory\PurchaseReturn;
use App\Http\Livewire\Inventory\PurchaseReturnInvoice;
use App\Http\Livewire\Inventory\PurchaseReturnList;
use App\Http\Livewire\Inventory\Quotation;
use App\Http\Livewire\Inventory\QuotationInvoice;
use App\Http\Livewire\Inventory\QuotationList;
use App\Http\Livewire\Inventory\Requisition;
use App\Http\Livewire\Inventory\RequisitionInvoice;
use App\Http\Livewire\Inventory\RequisitionList;
use App\Http\Livewire\Inventory\SaleChalan;
use App\Http\Livewire\Inventory\SaleInvoice;
use App\Http\Livewire\Inventory\SaleList;
use App\Http\Livewire\Inventory\SaleReturn;
use App\Http\Livewire\Inventory\SaleReturnInvoice;
use App\Http\Livewire\Inventory\SaleReturnList;
use App\Http\Livewire\Inventory\Sales;
use App\Http\Livewire\Inventory\ServiceName;
use App\Http\Livewire\Inventory\StockAdjustment;
use App\Http\Livewire\Inventory\TaxInvoice;
use App\Http\Livewire\Inventory\Unit;
use App\Http\Livewire\ProfileSetting\ChangePassword;
use App\Http\Livewire\ProfileSetting\ProfileSetup;
use App\Http\Livewire\ProfileSetting\UsersManagement;
use App\Http\Livewire\ProfileSetting\UsersPermission;
use App\Http\Livewire\Reports\BalanceSheet;
use App\Http\Livewire\Reports\BalanceSheetOld;
use App\Http\Livewire\Reports\BankBook;
use App\Http\Livewire\Reports\BankReconsilation;
use App\Http\Livewire\Reports\CustomerLedgerReport;
use App\Http\Livewire\Reports\DayBook;
use App\Http\Livewire\Reports\GeneralLedger;
use App\Http\Livewire\Reports\IncomeStatement;
use App\Http\Livewire\Reports\LowStockAlert;
use App\Http\Livewire\Reports\PayableReport;
use App\Http\Livewire\Reports\ProfitLoss;
use App\Http\Livewire\Reports\PurchaseDetailReport;
use App\Http\Livewire\Reports\PurchaseReport;
use App\Http\Livewire\Reports\PurchaseReturnReport;
use App\Http\Livewire\Reports\ReceivableReport;
use App\Http\Livewire\Reports\SalesDetailReport;
use App\Http\Livewire\Reports\SalesReturnReport;
use App\Http\Livewire\Reports\StockReports;
use App\Http\Livewire\Reports\SupplierLedgerReport;
use App\Http\Livewire\Reports\TrailBalance;
use App\Http\Livewire\Reports\VatCollectionReport;
use App\Http\Livewire\Reports\VatReturnReport;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('livewire.dashboard');
})->name('dashboard');

Route::get('payment-invoice', [PrintInvoiceController::class, 'payment-invoice']);

Route::group(['prefix' => 'member', 'middleware' => ['auth']], function () {
    Route::group(['prefix' => 'profile-settings', 'as' => 'profile-settings.'], function () {
        Route::get('profile-setup', ProfileSetup::class)->name('profile-setup');
        Route::get('users-management', UsersManagement::class)->name('users-management');
        Route::get('users-permission', UsersPermission::class)->name('users-permission');
        Route::get('change-password', ChangePassword::class)->name('change-password');
        Route::get('user-restiction/{id?}', [HomeController::class, 'userRestiction'])->name('user-restiction');
        Route::post('user_restiction/update', [HomeController::class, 'UserRectictionsUpdate'])->name('user_restictions.update');
    });
    Route::group(['prefix' => 'contacts', 'as' => 'contacts.'], function () {
        Route::get('customer-accounts', CustomerAccounts::class)->name('customer-accounts');
        Route::get('supplier-accounts', SupplierAccounts::class)->name('supplier-accounts');
        Route::get('staff-accounts', StaffAccounts::class)->name('staff-accounts');
        Route::get('others-accounts', OthersAccounts::class)->name('others-accounts');
    });
    Route::group(['prefix' => 'accounts-setting', 'as' => 'accounts-setting.'], function () {
        Route::get('branch', Branch::class)->name('branch');
        Route::get('chart-of-section', ChartOfSection::class)->name('chart-of-section');
        Route::get('chart-of-group', ChartOfGroup::class)->name('chart-of-group');
        Route::get('chart-of-account', ChartOfAccount::class)->name('chart-of-account');
        Route::get('vat-setup', VatSetup::class)->name('vat-setup');
        Route::get('currency', Currency::class)->name('currency');
        Route::get('financial-year', FinancialYear::class)->name('financial-year');
        Route::get('invoice-setting', InvoiceSetting::class)->name('invoice-setting');
        Route::get('payment-method', PaymentMethod::class)->name('payment-method');
        Route::get('warehouse', Warehouse::class)->name('warehouse');
        Route::get('company', Company::class)->name('company');
        Route::get('entry_type', EntryType::class)->name('entry_type');
        Route::get('tag', Tag::class)->name('tag');
        Route::get('entry_type_account_list/{id}', EntryTypeAccountList::class)->name('entry_type_account_list');
    });

    Route::group(['prefix' => 'inventory', 'as' => 'inventory.'], function () {
        Route::get('category', Category::class)->name('category');
        Route::get('unit', Unit::class)->name('unit');
        Route::get('brand', Brand::class)->name('brand');
        Route::get('item-name', ItemName::class)->name('item-name');
        Route::get('service-name', ServiceName::class)->name('service-name');
        Route::get('generate-barcode', GenerateBarcode::class)->name('generate-barcode');
        Route::get('purchase/{id?}', Purchase::class)->name('purchase');
        Route::get('purchase-list', PurchaseList::class)->name('purchase-list');
        Route::get('purchase-return-list', PurchaseReturnList::class)->name('purchase-return-list');
        Route::get('sales/{id?}', Sales::class)->name('sales');
        Route::get('sale-return/{id?}', SaleReturn::class)->name('sale-return');
        Route::get('sale-list', SaleList::class)->name('sale-list');
        Route::get('sale-return-list', SaleReturnList::class)->name('sale-return-list');
        Route::get('pos-terminal', PosTerminal::class)->name('pos-terminal');
        Route::get('make-requisition/{id?}', Requisition::class)->name('make-requisition');
        Route::get('requisition-list', RequisitionList::class)->name('requisition-list');
        Route::get('requisition-invoice/{id?}', RequisitionInvoice::class)->name('requisition-invoice');
        Route::get('stock-adjustment', StockAdjustment::class)->name('stock-adjustment');
        Route::get('add-stock-adjustment', AddStockAdjustment::class)->name('add-stock-adjustment');
        Route::get('delievery-note', 'MainController@delievery_note')->name('delievery-note');
        Route::get('purchase-invoice/{id?}', PurchaseInvoice::class)->name('purchase-invoice');
        Route::get('purchase-return/{id?}', PurchaseReturn::class)->name('purchase-return');
        Route::get('quotation/{id?}', Quotation::class)->name('quotation');
        Route::get('quotation-list', QuotationList::class)->name('quotation-list');
        Route::get('quotation-invoice/{id?}', QuotationInvoice::class)->name('quotation-invoice');
        Route::get('sale-chalan', SaleChalan::class)->name('sale-chalan');
        Route::get('sale-invoice/{id?}', SaleInvoice::class)->name('sale-invoice');
        Route::get('tax-invoice', TaxInvoice::class)->name('tax-invoice');
        Route::get('sale-return-invoice/{id?}', SaleReturnInvoice::class)->name('sale-return-invoice');
        Route::get('purchase-return-invoice/{id?}', PurchaseReturnInvoice::class)->name('purchase-return-invoice');
    });

    Route::group(['prefix' => 'reports', 'as' => 'reports.'], function () {
        Route::get('receivable-report-new', [ReportController::class, 'ReceivableReport'])->name('receivable-report-new');
        Route::get('receivable-report-data', [ReportController::class, 'ReceivableReportData'])->name('receivable-report-data');

        Route::get('payable-report-new', [ReportController::class, 'PayableReport'])->name('payable-report-new');
        Route::get('payable-report-data', [ReportController::class, 'PayableReportData'])->name('payable-report-data');

        Route::get('stock-report-new', [ReportController::class, 'StockReport'])->name('stock-report-new');
        Route::get('stock-report-data', [ReportController::class, 'StockReportData'])->name('stock-report-data');

        Route::get('low-stock-report-new', [ReportController::class, 'LowStockReport'])->name('low-stock-report-new');
        Route::get('low-stock-report-data', [ReportController::class, 'LowStockReportData'])->name('low-stock-report-data');

        Route::get('purchase-report-new', [ReportController::class, 'PurchaseReport'])->name('purchase-report-new');
        Route::get('purchase-report-data', [ReportController::class, 'PurchaseReportData'])->name('purchase-report-data');

        Route::get('purchase-detail-report-new', [ReportController::class, 'PurchaseDetailReport'])->name('purchase-detail-report-new');
        Route::get('purchase-detail-report-data', [ReportController::class, 'PurchaseDetailReportData'])->name('purchase-detail-report-data');

        Route::get('purchase-return-report-new', [ReportController::class, 'PurchaseReturnReport'])->name('purchase-return-report-new');
        Route::get('purchase-return-report-data', [ReportController::class, 'PurchaseReturnReportData'])->name('purchase-return-report-data');

        Route::get('supplier-ledger-report-new', [ReportController::class, 'SupplierLedgerReport'])->name('supplier-ledger-report-new');
        Route::get('supplier-ledger-report-data', [ReportController::class, 'SupplierLedgerReportData'])->name('supplier-ledger-report-data');

        Route::get('customer-ledger-report-new', [ReportController::class, 'CustomerLedgerReport'])->name('customer-ledger-report-new');
        Route::get('customer-ledger-report-data', [ReportController::class, 'CustomerLedgerReportData'])->name('customer-ledger-report-data');

        Route::get('sale-report-new', [ReportController::class, 'SaleReport'])->name('sale-report-new');
        Route::get('sale-report-data', [ReportController::class, 'SaleReportData'])->name('sale-report-data');

        Route::get('sale-detail-report-new', [ReportController::class, 'SaleDetailReport'])->name('sale-detail-report-new');
        Route::get('sale-detail-report-data', [ReportController::class, 'SaleDetailReportData'])->name('sale-detail-report-data');

        Route::get('sale-return-report-new', [ReportController::class, 'SaleReturnReport'])->name('sale-return-report-new');
        Route::get('sale-return-report-data', [ReportController::class, 'SaleReturnReportData'])->name('sale-return-report-data');

        Route::get('profit-loss-report-new', [ReportController::class, 'ProfitLossReport'])->name('profit-loss-report-new');
        Route::get('profit-loss-report-data', [ReportController::class, 'ProfitLossReportData'])->name('profit-loss-report-data');

        Route::get('general-ledger', GeneralLedger::class)->name('general-ledger');
        Route::get('receivable-report', ReceivableReport::class)->name('receivable-report');
        Route::get('payable-report', PayableReport::class)->name('payable-report');
        Route::get('stock-report', StockReports::class)->name('stock-report');
        Route::get('low-stock-alert-report', LowStockAlert::class)->name('low-stock-alert-report');
        Route::get('purchase-report', PurchaseReport::class)->name('purchase-report');
        Route::get('purchase-detail-report', PurchaseDetailReport::class)->name('purchase-detail-report');
        Route::get('purchase-return-report', PurchaseReturnReport::class)->name('purchase-return-report');
        Route::get('supplier-ledger-report', SupplierLedgerReport::class)->name('supplier-ledger-report');
        Route::get('sales-detail-report', SalesDetailReport::class)->name('sales-detail-report');
        Route::get('sales-return-report', SalesReturnReport::class)->name('sales-return-report');
        Route::get('customer-ledger-report', CustomerLedgerReport::class)->name('customer-ledger-report');
        Route::get('profit-loss', ProfitLoss::class)->name('profit-loss');
        Route::get('income-statement', IncomeStatement::class)->name('income-statement');
        Route::get('day-book', DayBook::class)->name('day-book');
        Route::get('bank-book', BankBook::class)->name('bank-book');
        Route::get('trail-balance', TrailBalance::class)->name('trail-balance');
        Route::get('balance-sheet', BalanceSheet::class)->name('balance-sheet');
        Route::get('vat-collection-report', VatCollectionReport::class)->name('vat-collection-report');
        Route::get('vat-return-report', VatReturnReport::class)->name('vat-return-report');
        Route::get('bank-reconsilation-report', BankReconsilation::class)->name('bank-reconsilation-report');
        Route::get('balance-sheet-old', BalanceSheetOld::class)->name('balance-sheet-old');
    });
    Route::group(['prefix' => 'accounts-module', 'as' => 'accounts-module.'], function () {
        Route::get('customer-payment', CustomerPayment::class)->name('customer-payment');
        Route::get('supplier-payment', SupplierPayment::class)->name('supplier-payment');
        Route::get('receipt/{id?}', Receipt::class)->name('receipt');
        Route::get('receipt-list', ReceiptList::class)->name('receipt-list');
        Route::get('customer-payment-invoice/{id?}', CustomerPaymentInvoice::class)->name('customer-payment-invoice');
        Route::get('supplier-payment-invoice/{id?}', SupplierPaymentInvoice::class)->name('supplier-payment-invoice');
        Route::get('receipt-invoice/{id?}', ReceiptInvoice::class)->name('receipt-invoice');
        Route::get('payment-invoice', 'PrintInvoiceController@payment_invoice')->name('payment-invoice');
    });

    Route::group(['prefix' => 'data', 'as' => 'data.'], function () {
        Route::get('user-table', [DatatableController::class, 'UserTable'])->name('user-table');
        Route::get('customer-table', [DatatableController::class, 'CustomersTable'])->name('customer-table');
        Route::get('supplier-table', [DatatableController::class, 'SupplierTable'])->name('supplier-table');
        Route::get('staff-table', [DatatableController::class, 'StaffTable'])->name('staff-table');
        Route::get('other-account-table', [DatatableController::class, 'OtherAccountsTable'])->name('other-account-table');
        Route::get('branch-table', [DatatableController::class, 'BranchTable'])->name('branch-table');
        Route::get('chart-of-section-table', [DatatableController::class, 'ChartOfSectionTable'])->name('chart-of-section-table');
        Route::get('chart-of-group-table', [DatatableController::class, 'ChartOfGroupTable'])->name('chart-of-group-table');
        Route::get('chart-of-accounts-table', [DatatableController::class, 'chartOfAccountTable'])->name('chart_of_accounts_table');
        Route::get('currency-table', [DatatableController::class, 'CurrencyTable'])->name('currency-table');
        Route::get('financial-year-table', [DatatableController::class, 'FinancialYearTable'])->name('financial-year-table');
        Route::get('payment-method-table', [DatatableController::class, 'PaymentMethodTable'])->name('payment-method-table');
        Route::get('vat-table', [DatatableController::class, 'VatTable'])->name('vat-table');
        Route::get('ware-house-table', [DatatableController::class, 'WareHouseTable'])->name('ware-house-table');
        Route::get('category-table', [DatatableController::class, 'CategoryTable'])->name('category-table');
        Route::get('unit-table', [DatatableController::class, 'UnitTable'])->name('unit-table');
        Route::get('brand-table', [DatatableController::class, 'BrandTable'])->name('brand-table');
        Route::get('item-table', [DatatableController::class, 'ItemTable'])->name('item-table');
        Route::get('service-name-table', [DatatableController::class, 'ServiceNameTable'])->name('service-name-table');
        Route::get('barcode-generator-table', [DatatableController::class, 'BarcodeGenerateTable'])->name('barcode-generator-table');
        Route::get('purchase-list-table', [DatatableController::class, 'PurchaseListTable'])->name('purchase-list-table');
        Route::get('purchase-return-list-table', [DatatableController::class, 'PurchaseReturnListTable'])->name('purchase-return-list-table');
        Route::get('sale-list-table', [DatatableController::class, 'SaleListTable'])->name('sale-list-table');
        Route::get('sale-return-list-table', [DatatableController::class, 'SaleReturnListTable'])->name('sale-return-list-table');
        Route::get('quotation-list-table', [DatatableController::class, 'QuotationListTable'])->name('quotation-list-table');
        Route::get('requisition-list-table', [DatatableController::class, 'RequisitionListTable'])->name('requisition-list-table');
        Route::get('opening-balance-table', [DatatableController::class, 'OpeningBalanceTable'])->name('opening-balance-table');
        Route::get('stock-manager-table', [DatatableController::class, 'StockManagerTable'])->name('stock-manager-table');
        Route::get('company-table', [DatatableController::class, 'CompanyTable'])->name('company-table');
        Route::get('receipt-list-table', [DatatableController::class, 'ReceiptTable'])->name('receipt_list_table');
        //Account Modules
        Route::get('entry-type-table', [DatatableController::class, 'EntryTypeTable'])->name('entry_type_table');
        Route::get('customer-payment-table', [DatatableController::class, 'CustomerPaymentTable'])->name('customer-payment-table');
        Route::get('supplier-payment-table', [DatatableController::class, 'SupplierPaymentTable'])->name('supplier-payment-table');
        Route::get('tag-table', [DatatableController::class, 'TagTable'])->name('tag-table');
        Route::get('company_update', [DatatableController::class, 'CompanyUpdate'])->name('company_update');
    });
});
