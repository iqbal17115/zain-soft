<?php

	namespace App\Traits;

use App\Models\Accounts\AccountManager;
use App\Models\AccountSettings\ChartOfAccount;
use Carbon\Carbon;

trait Receivable
	{
		public function getReceivable($data = [])
        {

            $openingBalance = 0;
            $DateRange = '';
            $receivableChartId = ChartOfAccount::whereDefaultModule(5)->first('id')->id;
            $Query = AccountManager::where("status", 1);

            if (isset($data['contact_id'])) {
                $Query->where("contact_id", $data['contact_id']);
            }
            if (isset($data['company_id'])) {
                $Query->where("company_id", $data['company_id']);
            }

            if (isset($data['invoice_id'])) {
                $Query->where("invoice_id", $data['invoice_id']);
            }

            if (isset($data['start_date']) && isset($data['end_date'])) {
                $openingDateEnd = Carbon::parse($data['start_date'])->sub(1, 'day')->format('y-m-d');
                $DateRange = " AND date(date) >= '" . $data['start_date'] . "' AND date(date) <= '" . $data['end_date'] . "' ";
                $OpeningDateRange = " AND date(date) <= '" . $openingDateEnd . "' ";
                $Query->selectRaw("(COALESCE(SUM(CASE WHEN `dr_account_id` = $receivableChartId $OpeningDateRange THEN amount END), 0)) AS `total_opening_debit`");
                $Query->selectRaw("(COALESCE(SUM(CASE WHEN `cr_account_id` = $receivableChartId $OpeningDateRange THEN amount END), 0)) AS `total_opening_credit`");
            }
            $Query->selectRaw("(COALESCE(SUM(CASE WHEN `dr_account_id` = $receivableChartId $DateRange THEN amount END), 0)) AS `total_receivable_debit`");
            $Query->selectRaw("(COALESCE(SUM(CASE WHEN `cr_account_id` = $receivableChartId $DateRange THEN amount END), 0)) AS `total_receivable_credit`");

            $Query->selectRaw("(COALESCE(SUM(CASE WHEN `dr_account_id` != $receivableChartId $DateRange THEN amount END), 0)) AS `total_debit`");
            $Query->selectRaw("(COALESCE(SUM(CASE WHEN `cr_account_id` != $receivableChartId $DateRange THEN amount END), 0)) AS `total_credit`");
            $Query = $Query->first();
            if (isset($data['start_date']) && isset($data['end_date'])) {
                $openingBalance = $Query->total_opening_debit - $Query->total_opening_credit;
            }
            $Query['opening_balance'] =  $openingBalance;
            $Query['current_balance'] = $Query->total_receivable_debit - $Query->total_receivable_credit;
            return $Query;
        }
	}
