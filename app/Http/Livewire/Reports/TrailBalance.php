<?php

namespace App\Http\Livewire\Reports;

use App\Models\Accounts\AccountManager;
use App\Models\AccountSettings\ChartOfSection;
use App\Models\AccountSettings\FinancialYear;
use Livewire\Component;

class TrailBalance extends Component
{
    public $financialYear;

    public function totalDrLedger($accountId, $isOpening = false, $isClosing = false)
    {
        $drAmount = AccountManager::whereDrAccountId($accountId);

        if ($isOpening) {
            $drAmount->whereDate('created_at', '<', $this->financialYear->start_datetime);
        } elseif (!$isClosing) {
            $drAmount->whereBetween('created_at', [$this->financialYear->start_datetime, $this->financialYear->end_datetime]);
        }

        return $drAmount->sum('amount');
    }

    public function totalCrLedger($accountId, $isOpening = false, $isClosing = false)
    {
        $crAmount = AccountManager::whereCrAccountId($accountId);

        if ($isOpening) {
            $crAmount->whereDate('created_at', '<', $this->financialYear->start_datetime);
        } elseif (!$isClosing) {
            $crAmount->whereBetween('created_at', [$this->financialYear->start_datetime, $this->financialYear->end_datetime]);
        }

        return $crAmount->sum('amount');
    }

    public function mount()
    {
        $this->financialYear = FinancialYear::whereStatus('Active')->first();
    }

    public function render()
    {
        return view('livewire.reports.trail-balance', [
            'ChartOfSectiion' => ChartOfSection::all(),
        ]);
    }
}
