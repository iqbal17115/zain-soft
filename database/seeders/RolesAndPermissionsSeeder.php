<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\PermissionCategories;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        Role::create(['name' => 'superadmin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
        Role::create(['name' => 'editor']);

        $users = User::all();
        foreach ($users as $user) {
            $user->assignRole('admin');
        }

        $permissionLists = [

            [
                'name' => "contact",
                'title' => "Contact"
            ],
            [
                'name' => "company",
                'title' => "Create Company"
            ],
            [
                'name' => "chart_of_section",
                'title' => "Chart Of Section"
            ],
            [
                'name' => "chart_of_group",
                'title' => "Chart Of Group"
            ],
            [
                'name' => "chart_of_account",
                'title' => "Chart Of Account"
            ],
            [
                'name' => "vat",
                'title' => "Vat"
            ],
            [
                'name' => "currency",
                'title' => "Currency"
            ],
            [
                'name' => "financial_year",
                'title' => "Financial Year"
            ],
            [
                'name' => "invoice_setting",
                'title' => "Invoice Setting"
            ],
            [
                'name' => "branch",
                'title' => "Branch"
            ],
            [
                'name' => "tag",
                'title' => "Tag"
            ],
            [
                'name' => "warehouse",
                'title' => "Warehouse"
            ],
            [
                'name' => "entry_type",
                'title' => "Entry Type"
            ],
            [
                'name' => "category",
                'title' => "Category"
            ],
            [
                'name' => "unit",
                'title' => "Unit"
            ],
            [
                'name' => "brand",
                'title' => "Brand"
            ],
            [
                'name' => "item",
                'title' => "Item"
            ],
            [
                'name' => "service_name",
                'title' => "Service Name"
            ],
            [
                'name' => "purchase",
                'title' => "Purchase"
            ],
            [
                'name' => "sale",
                'title' => "Sale"
            ],
            [
                'name' => "quotation",
                'title' => "Quotation"
            ],
            [
                'name' => "requisition",
                'title' => "Requisition"
            ],
            [
                'name' => "customer_payment",
                'title' => "Customer Payment"
            ],
            [
                'name' => "supplier_payment",
                'title' => "Supplier Payment"
            ],
            [
                'name' => "receipt",
                'title' => "Receipt"
            ],
            [
                'name' => "bank_reconsilation",
                'title' => "Bank Reconsilation"
            ],
            [
                'name' => "general_ledger_report",
                'title' => "General Ledger Report"
            ],
            [
                'name' => "receivable_report",
                'title' => "Receivable Report"
            ],
            [
                'name' => "payable_report",
                'title' => "Payable Report"
            ],
            [
                'name' => "payable_report",
                'title' => "Payable Report"
            ],
            [
                'name' => "stock_report",
                'title' => "Stock Report"
            ],
            [
                'name' => "low_stock_alert_report",
                'title' => "Low Stock Alert Report"
            ],
            [
                'name' => "sale_report",
                'title' => "Sale Report"
            ],
            [
                'name' => "sale_detail_report",
                'title' => "Sale Detail Report"
            ],
            [
                'name' => "customer_ledger_report",
                'title' => "Customer Ledger Report"
            ],
            [
                'name' => "purchase_report",
                'title' => "Purchase Report"
            ],
            [
                'name' => "purchase_detail_report",
                'title' => "Purchase Detail Report"
            ],
            [
                'name' => "supplier_ledger_report",
                'title' => "Supplier Ledger Report"
            ],
            [
                'name' => "profit_loss_report",
                'title' => "Profit Loss Report"
            ],
            [
                'name' => "income_statement_report",
                'title' => "Income Statement Report"
            ],
            [
                'name' => "day_book_report",
                'title' => "Day Book Report"
            ],
            [
                'name' => "bank_book_report",
                'title' => "Bank Book Report"
            ],
            [
                'name' => "trial_balance_report",
                'title' => "Trial Balance Report"
            ],
            [
                'name' => "balance_sheet_report",
                'title' => "Balance Sheet Report"
            ],
            [
                'name' => "vat_collection_report",
                'title' => "Vat Collection Report"
            ],
            [
                'name' => "vat_return_report",
                'title' => "Vat Return Report"
            ],
        ];

        foreach ($permissionLists as $key => $value) {
            $permissionCategory = PermissionCategories::where('name', $value['name'])->first();
            if (!$permissionCategory) {
                $permissionCategory = new PermissionCategories;
                $permissionCategory->name = $value['name'];
                $permissionCategory->title = $value['title'];
                $permissionCategory->type = 'ba';
                $permissionCategory->status = 'Active';
                $permissionCategory->save();

                Permission::create(['name' => 'view ' . $value['name']]);
                Permission::create(['name' => 'view_all ' . $value['name']]);
                Permission::create(['name' => 'edit ' . $value['name']]);
                Permission::create(['name' => 'delete ' . $value['name']]);
            }
        }
    }
}
