<?php

namespace App\Providers;

use App\Models\AccountSettings\Currency;
use App\Models\AccountSettings\InvoiceSetting;
use App\Models\AccountSettings\ProfileSetting;
use App\Models\Setting\Company;
use App\Models\Billing\Invoice;
use App\Models\Contact\Contact;
use App\Models\Stock\Item;
use App\Models\User;
use App\Traits\Payable;
use App\Traits\Receivable;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    use Receivable;
    use Payable;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $view->with('currencySymbol', Currency::whereStatus(1)
                ->first());
            $view->with('profile_setting', ProfileSetting::first());
            $view->with('invoice_setting', InvoiceSetting::first());
            $view->with('company_info', Company::get());
        });
        View::composer('livewire.dashboard', function ($view) {
            //Dashboard Query

            // Start Purchase
            $view->with('total_purchase', Invoice::whereType('Purchase')->whereCompanyId(Auth::user()->company_id)->sum('subtotal'));
            $view->with('today_purchase', Invoice::whereType('Purchase')->whereCompanyId(Auth::user()->company_id)->where('date', date('Y-m-d'))->sum('subtotal'));
            $view->with('total_purchase_return', Invoice::whereType('Purchase Return')->whereCompanyId(Auth::user()->company_id)->sum('subtotal'));
            $view->with('today_purchase_return', Invoice::whereType('Purchase Return')->whereCompanyId(Auth::user()->company_id)->where('date', date('Y-m-d'))->sum('subtotal'));
            //  End Purchase

            // Start Sales
            $view->with('total_sale', Invoice::whereType('Sales')->whereCompanyId(Auth::user()->company_id)->sum('subtotal'));
            $view->with('today_sale', Invoice::whereType('Sales')->whereCompanyId(Auth::user()->company_id)->where('date', date('Y-m-d'))->sum('subtotal'));
            $view->with('total_sale_return', Invoice::whereType('Sales Return')->whereCompanyId(Auth::user()->company_id)->sum('subtotal'));
            $view->with('today_sale_return', Invoice::whereType('Sales Return')->whereCompanyId(Auth::user()->company_id)->where('date', date('Y-m-d'))->sum('subtotal'));
            // End Sales
            // Start Invoice
            $view->with('total_invoice', Invoice::whereCompanyId(Auth::user()->company_id)->count());
            // End Invoice
            $view->with('total_customer', Contact::whereCompanyId(Auth::user()->company_id)->whereType('Customer')->count());
            $view->with('total_user', User::whereCompanyId(Auth::user()->company_id)->count());
            $view->with('total_item', Item::whereCompanyId(Auth::user()->company_id)->count());

            $view->with('total_receiveable', $this->getReceivable(['company_id'=>Auth::user()->company_id])->current_balance);
            $view->with('total_payable', $this->getPayable(['company_id'=>Auth::user()->company_id])->current_balance);
            $view->with('invoices', Invoice::whereType('Sales')->whereCompanyId(Auth::user()->company_id)->whereDueDate(Carbon::now()->format('Y-m-d'))->get());

            // Start Month Wise Sell
            $year = date('Y');
            $totalSale = Invoice::whereCompanyId(Auth::user()->company_id)->whereBetween('date', [$year . '-01-1', $year . '-12-31'])->sum('amount_to_pay');
            $jan = Invoice::whereCompanyId(Auth::user()->company_id)->whereBetween('date', [$year . '-01-01', $year . '-01-31'])->sum('amount_to_pay');
            $feb = Invoice::whereCompanyId(Auth::user()->company_id)->whereBetween('date', [$year . '-02-01', $year . '-02-29'])->sum('amount_to_pay');
            $mar = Invoice::whereCompanyId(Auth::user()->company_id)->whereBetween('date', [$year . '-03-01', $year . '-03-31'])->sum('amount_to_pay');
            $apr = Invoice::whereCompanyId(Auth::user()->company_id)->whereBetween('date', [$year . '-04-01', $year . '-04-30'])->sum('amount_to_pay');
            $may = Invoice::whereCompanyId(Auth::user()->company_id)->whereBetween('date', [$year . '-05-01', $year . '-05-31'])->sum('amount_to_pay');
            $jun = Invoice::whereCompanyId(Auth::user()->company_id)->whereBetween('date', [$year . '-06-01', $year . '-06-30'])->sum('amount_to_pay');
            $jul = Invoice::whereCompanyId(Auth::user()->company_id)->whereBetween('date', [$year . '-07-01', $year . '-07-31'])->sum('amount_to_pay');
            $aug = Invoice::whereCompanyId(Auth::user()->company_id)->whereBetween('date', [$year . '-08-01', $year . '-08-31'])->sum('amount_to_pay');
            $sep = Invoice::whereCompanyId(Auth::user()->company_id)->whereBetween('date', [$year . '-09-01', $year . '-09-30'])->sum('amount_to_pay');
            $oct = Invoice::whereCompanyId(Auth::user()->company_id)->whereBetween('date', [$year . '-10-01', $year . '-10-31'])->sum('amount_to_pay');
            $nov = Invoice::whereCompanyId(Auth::user()->company_id)->whereBetween('date', [$year . '-11-01', $year . '-11-30'])->sum('amount_to_pay');
            $dec = Invoice::whereCompanyId(Auth::user()->company_id)->whereBetween('date', [$year . '-12-01', $year . '-12-31'])->sum('amount_to_pay');

            if ($totalSale == 0) {
                $totalSale = 1;
            }
            $view->with('totalSale', $totalSale);
            $view->with('jan', $jan);
            $view->with('feb', $feb);
            $view->with('mar', $mar);
            $view->with('apr', $apr);
            $view->with('may', $may);
            $view->with('jun', $jun);
            $view->with('jul', $jul);
            $view->with('aug', $aug);
            $view->with('sep', $sep);
            $view->with('oct', $oct);
            $view->with('nov', $nov);
            $view->with('dec', $dec);


            // End Month Wise Sell

        });
    }
}
