@push('css')
<style>
    .textfont {
        font-size: 15px;
        font-weight: bold;
    }
</style>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
@endpush

<div>
    <x-slot name="title">INCOME STATEMENT REPORT</x-slot>
    <x-slot name="header">INCOME STATEMENT REPORT</x-slot>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="search-box mr-2  d-inline-block">
                                <div class="position-relative">
                                    <h4 class="card-title" id="header-text-design">Income Statement</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">Select Date</label>
                                <input type="text" id="reportrange" name="reportrange" class="form-control" />
                            </div>
                        </div> --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">Start Date</label>
                                <input type="date" wire:model.lazy="start_date" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">End Date</label>
                                <input type="date" wire:model.lazy="end_date" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">Branch</label>
                                <select class="form-control">
                                    <option>Select one Branch</option>
                                    @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="basicpill-firstname-input">Company</label>
                                <select class="form-control">
                                    <option>Select Company</option>
                                    @foreach ($Company as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- <div class="col-lg-4">
                            <div wire:ignore class="form-group">
                                <label for="basicpill-firstname-input">Select Company</label>
                                <select class="form-control form-select select2 updateTable"
                                    placeholder="Customer" name="" id="">
                                    <option value="">Select Company</option>
                                    @foreach ($CompanyInfo as $CompanyInfo)
                                    <option value="{{ $CompanyInfo->id }}">{{ $CompanyInfo->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Start Report --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable-buttons" class="table table-striped table-bordered nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead style="background-color: #06A5AA;font-weight: bold;">
                        <tr class="text-center">
                            <th>Account Details</th>
                            <th>Sub-Total</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $netIncome=0;
                        @endphp
                        <tr style="background-color: #74A6F9;font-size: 16px;">
                            <td class="text-center text-white font-weight-bold">Sales</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="text-center">
                            <td>Opening Stock</td>
                            <td>
                                {{ $this->getStock(['start_date'=>$start_date,'end_date'=>$end_date])->opening_stock_amount}}

                            </td>
                            <td></td>
                        </tr>

                        <tr class="text-center">
                            <td>Sales Amount</td>
                            <td>{{$saleTotal}}</td>
                            <td></td>
                        </tr>

                        <tr class="text-center">
                            <td>Sales Discount (-)</td>
                            <td>{{$saleDiscount}}</td>
                            <td></td>
                        </tr>

                        {{-- <tr class="text-center">
                            <td>Sales Shipping Charge (+)</td>
                            <td>{{$shippingCharge}}</td>
                            <td></td>
                        </tr>


                        <tr class="text-center">
                            <td>Purchase (-)</td>
                            <td>{{$purchaseTotal}}</td>
                            <td></td>
                        </tr> --}}
                        <tr class="text-center">
                            <td>Cost of Goods (-)</td>
                            <td>
                                {{ $this->getStock(['start_date'=>$start_date,'end_date'=>$end_date])->cost_of_goods}}
                            </td>
                            <td></td>
                        </tr>

                        <tr class="text-center">
                            <td>Closing Stock (-)</td>
                            <td>
                                 {{ $this->getStock(['start_date'=>$start_date,'end_date'=>$end_date])->closing_stock_amount}}
                            </td>
                            <td></td>
                        </tr>

                        <tr class="text-center" style="background-color: #b9d4d7;">
                            <td class="font-weight-bold" style="font-size: 16px;">Gross Margin (+/-)</td>
                            <td>-</td>
                            <td>
                              {{($saleTotal-$saleDiscount) - ($this->getStock(['start_date'=>$start_date,'end_date'=>$end_date])->cost_of_goods)}}
                            </td>
                        </tr>

                        <tr style="background-color: #74A6F9;font-size: 16px;">
                            <td class="text-center text-white font-weight-bold">Operating Expense</td>
                            <td></td>
                            <td></td>
                        </tr>
                        @php
                            $totalexpense=0;
                        @endphp
                        @foreach ($ExpenseChart as $expense)
                            @php
                                $totalexpense+= ($this->getChartBalance(['dr_account_id'=> $expense->id,'start_date'=>$start_date,'end_date'=>$end_date])->current_dr_balance)-($this->getChartBalance(['cr_account_id'=> $expense->id,'start_date'=>$start_date,'end_date'=>$end_date])->current_cr_balance);
                            @endphp
                            <tr class="text-center">
                                <td>{{$expense->name}}</td>
                                <td>{{$expense->amount}}</td>
                                <td>
                                     {{ ($this->getChartBalance(['dr_account_id'=> $expense->id,'start_date'=>$start_date,'end_date'=>$end_date])->current_dr_balance)-($this->getChartBalance(['cr_account_id'=> $expense->id,'start_date'=>$start_date,'end_date'=>$end_date])->current_cr_balance)}}

                                </td>
                            </tr>
                        @endforeach
                        <tr class="text-center">
                            <td class="textfont" colspan="2">Total Expense (-)</td>
                            <td>{{$totalexpense}}</td>
                        </tr>

                        <tr style="background-color: #74A6F9;font-size: 16px;">
                            <td class="text-center text-white font-weight-bold">Operating Income</td>
                            <td></td>
                            <td></td>
                        </tr>
                        @php
                        $totalIncome=0;
                       @endphp
                        @foreach ($IncomeChart as $income)
                        @php
                            $totalIncome+=  ($this->getChartBalance(['cr_account_id'=> $income->id,'start_date'=>$start_date,'end_date'=>$end_date])->current_cr_balance)-($this->getChartBalance(['dr_account_id'=> $income->id,'start_date'=>$start_date,'end_date'=>$end_date])->current_dr_balance);
                        @endphp
                        <tr class="text-center">
                            <td>{{ $income->name }}</td>
                            <td>{{$income->amount}}</td>
                            <td>
                                {{ ($this->getChartBalance(['cr_account_id'=> $income->id,'start_date'=>$start_date,'end_date'=>$end_date])->current_cr_balance)-($this->getChartBalance(['dr_account_id'=> $income->id,'start_date'=>$start_date,'end_date'=>$end_date])->current_dr_balance)}}
                            </td>
                        </tr>
                        @endforeach

                        <tr class="text-center">
                            <td class="textfont" colspan="2">Total Income (+)</td>
                            <td>{{$totalIncome}}</td>
                        </tr>

                        <tr class="text-center">
                            <td class="textfont">Net Income (+/-)</td>
                            <td>-</td>
                            <td>
                              {{($saleTotal-$saleDiscount) - ($this->getStock(['start_date'=>$start_date,'end_date'=>$end_date])->cost_of_goods)+ ($totalIncome-$totalexpense)}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div><br>
    {{-- End Report --}}
</div>
