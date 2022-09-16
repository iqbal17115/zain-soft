<?php

namespace App\Http\Livewire\Reports;
use App\Models\Setting\Company;
use Livewire\Component;

class DayBook extends Component
{
    public $from_date;
    public $to_date;
    public function render()
    {
        return view('livewire.reports.day-book',[
            'CompanyInfo' => Company::get(),
        ]);
    }
}
