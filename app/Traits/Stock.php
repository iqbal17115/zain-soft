<?php

namespace App\Traits;

use App\Models\Inventory\StockManager;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait Stock
{
    public function getStock($data = [])
    {
        $openingStock = 0;
        $openingStockAmount = 0;
        $DateRange = '';

        $Query = StockManager::where('status', 1);

        if (isset($data['contact_id'])) {
            $Query->where('contact_id', $data['contact_id']);
        }

        if (isset($data['invoice_id'])) {
            $Query->where('invoice_id', $data['invoice_id']);
        }

        if (isset($data['item_id'])) {
            $Query->where('item_id', $data['item_id']);
        }

        if (isset($data['start_date']) && isset($data['end_date'])) {
            $openingDateEnd = Carbon::parse($data['start_date'])->sub(1, 'day')->format('y-m-d');
            $DateRange = " AND date(date) >= '".$data['start_date']."' AND date(date) <= '".$data['end_date']."' ";
            $OpeningDateRange = " AND date(date) <= '".$openingDateEnd."' ";
            $Query->selectRaw("(COALESCE(SUM(CASE WHEN `flow` = 'In' $OpeningDateRange THEN quantity END), 0)) AS `total_opening_in`");
            $Query->selectRaw("(COALESCE(SUM(CASE WHEN `flow` = 'Out' $OpeningDateRange THEN quantity END), 0)) AS `total_opening_out`");
            $Query->selectRaw("(COALESCE(SUM(CASE WHEN `flow` = 'In' $OpeningDateRange THEN purchase_subtotal END), 0)) AS `total_opening_in_amount`");
            $Query->selectRaw("(COALESCE(SUM(CASE WHEN `flow` = 'Out' $OpeningDateRange THEN purchase_subtotal END), 0)) AS `total_opening_out_amount`");
        }
        $Query->selectRaw("(COALESCE(SUM(CASE WHEN `flow` = 'In' $DateRange THEN quantity END), 0)) AS `total_in`");
        $Query->selectRaw("(COALESCE(SUM(CASE WHEN `flow` = 'Out' $DateRange THEN quantity END), 0)) AS `total_out`");
        $Query->selectRaw("(COALESCE(SUM(CASE WHEN `flow` = 'In' $DateRange THEN purchase_subtotal END), 0)) AS `total_in_amount`");
        $Query->selectRaw("(COALESCE(SUM(CASE WHEN `flow` = 'Out' $DateRange THEN purchase_subtotal END), 0)) AS `total_out_amount`");
        $Query = $Query->first();
        $Query['current_stock'] = $Query->total_in - $Query->total_out;
        $Query['current_stock_amount'] = $Query->total_in_amount - $Query->total_out_amount;
        $Query['opening_stock_amount'] = $Query->total_opening_in_amount - $Query->total_opening_out_amount;
        $Query['closing_stock_amount'] = $Query['opening_stock_amount'] + $Query->total_in_amount - $Query->total_out_amount;
        if (isset($data['start_date']) && isset($data['end_date'])) {
            $Query['cost_of_goods'] = $Query->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('invoices')
                    ->whereRaw('invoices.id = stock_managers.invoice_id')
                    ->whereRaw('invoices.type =  "Sales"');
            })->where('date', '>=', Carbon::parse($data['start_date'])->format('Y-m-d'))->where('date', '<=', Carbon::parse($data['end_date'])->format('Y-m-d'))->sum('purchase_subtotal');
        } else {
            $Query['cost_of_goods'] = $Query->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('invoices')
                    ->whereRaw('invoices.id = stock_managers.invoice_id')
                    ->whereRaw('invoices.type =  "Sales"');
            })->sum('purchase_subtotal');
        }

        return $Query;
    }
}
