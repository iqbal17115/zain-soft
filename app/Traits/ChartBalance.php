<?php

namespace App\Traits;

use App\Models\Accounts\AccountManager;
use Carbon\Carbon;

trait ChartBalance
{
    public function getChartBalance($data = [])
    {
        $openingDebit = 0;
        $openingCredit = 0;
        $DateRange = '';
        $Query = AccountManager::where('status', 1);



        if (isset($data['dr_account_id'])) {
            $Query->where('dr_account_id', $data['dr_account_id']);
        }
        if (isset($data['cr_account_id'])) {
            $Query->where('cr_account_id', $data['cr_account_id']);
        }

        if (isset($data['start_date']) && isset($data['end_date'])) {
            $openingDateEnd = Carbon::parse($data['start_date'])->sub(1, 'day')->format('y-m-d');
            $DateRange = " AND date(date) >= '".$data['start_date']."' AND date(date) <= '".$data['end_date']."' ";
            $OpeningDateRange = " AND date(date) <= '".$openingDateEnd."' ";
            $Query->selectRaw("(COALESCE(SUM(CASE WHEN `type` = 'Debit'  $OpeningDateRange THEN amount END), 0)) AS `total_opening_debit`");
            $Query->selectRaw("(COALESCE(SUM(CASE WHEN `type` = 'Credit'  $OpeningDateRange THEN amount END), 0)) AS `total_opening_credit`");
        }
        $Query->selectRaw("(COALESCE(SUM(CASE WHEN `type` = 'Debit'  $DateRange THEN amount END), 0)) AS `total_debit`");
        $Query->selectRaw("(COALESCE(SUM(CASE WHEN `type` = 'Credit'  $DateRange THEN amount END), 0)) AS `total_credit`");
        $Query = $Query->first();
        if (isset($data['start_date']) && isset($data['end_date'])) {
            $openingDebit = $Query->total_opening_debit;
            $openingCredit = $Query->total_opening_credit;
        }
        $Query['opening_debit'] = $openingDebit;
        $Query['opening_credit'] = $openingCredit;
        $Query['current_dr_balance'] = $Query->total_debit;
        $Query['current_cr_balance'] = $Query->total_credit;

        return $Query;
    }
}
