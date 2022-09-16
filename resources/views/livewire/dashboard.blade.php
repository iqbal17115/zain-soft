<x-app-layout>
    <style>
        /* List */
        table.errorlist .counter {
            text-align: right;
        }

        table.errorlist .counter span {
            background-color: #eee;
            border-radius: 2px;
            padding: 1px 5px;
        }

        /* Summaries*/
        table.summaries td {
            padding-right: 40px;
        }

        table.summaries td.critical {
            color: #e6614f;
        }

        table.summaries div.value {
            font-size: 40px;
            margin-top: 10px;
        }

        .card-style {
            background-color: #e8f2ff;
            border-right: 3px solid #30336b;
            border-bottom: 3px solid #30336b;
            border-top: 3px solid #30336b;
            border-left: 3px solid #30336b;
            transition: 0.75s;
        }

        /* Bar Chart */
        .barchart {
            font-size: 9px;
            line-height: 15px;
            table-layout: fixed;
            text-align: center;
            width: 100%;
            height: 226px;
        }

        .barchart tr:nth-child(1) td {
            vertical-align: bottom;
            height: 200px;
        }

        .barchart .bar {
            background: #37b3ad;
            padding: 0px 2px 0;
            width:  40px;
        }

        .barchart .bar1 {
            background: #0da547;
            padding: 0px 2px 0;
        }

        .barchart .label {
            background-color: black;
            margin-top: -30px;
            padding: 0 3px;
            color: white;
            border-radius: 4px;
        }

        .first_card {
            background: -webkit-linear-gradient(110deg, #48dbd4 60%, #7ee2dd 60%);
            background: -o-linear-gradient(110deg, #48dbd4 60%, #7ee2dd 60%);
            background: -moz-linear-gradient(110deg, #48dbd4 60%, #7ee2dd 60%);
            background: linear-gradient(110deg, #48dbd4 60%, #7ee2dd 60%);
        }

        .second_card {
            background: -webkit-linear-gradient(110deg, #2ccce9 60%, #8ddae7 60%);
            background: -o-linear-gradient(110deg, #2ccce9 60%, #8ddae7 60%);
            background: -moz-linear-gradient(110deg, #2ccce9 60%, #8ddae7 60%);
            background: linear-gradient(110deg, #2ccce9 60%, #8ddae7 60%);
        }

        .third_card {
            background: -webkit-linear-gradient(110deg, #94DAFF 60%, #7dc6ee 60%);
            background: -o-linear-gradient(110deg, #94DAFF 60%, #7dc6ee 60%);
            background: -moz-linear-gradient(110deg, #94DAFF 60%, #7dc6ee 60%);
            background: linear-gradient(110deg, #94DAFF 60%, #7dc6ee 60%);
        }

        .fourth_card {
            background: -webkit-linear-gradient(110deg, #e99a9a 60%, #e6acac 60%);
            background: -o-linear-gradient(110deg, #e99a9a 60%, #e6acac 60%);
            background: -moz-linear-gradient(110deg, #e99a9a 60%, #e6acac 60%);
            background: linear-gradient(110deg, #e99a9a 60%, #e6acac 60%);
        }

        .fifth_card {
            background: -webkit-linear-gradient(110deg, #baa4ee 60%, #c7bbe9 60%);
            background: -o-linear-gradient(110deg, #baa4ee 60%, #c7bbe9 60%);
            background: -moz-linear-gradient(110deg, #baa4ee 60%, #c7bbe9 60%);
            background: linear-gradient(110deg, #baa4ee 60%, #c7bbe9 60%);
        }

        .sixth_card {
            background: -webkit-linear-gradient(110deg, #94DAFF 60%, #9cebec 60%);
            background: -o-linear-gradient(110deg, #94DAFF 60%, #9cebec 60%);
            background: -moz-linear-gradient(110deg, #94DAFF 60%, #9cebec 60%);
            background: linear-gradient(110deg, #94DAFF 60%, #9cebec 60%);
        }

        .seventh_card {
            background: -webkit-linear-gradient(110deg, #7fbbe6 60%, #a1d0f5 60%);
            background: -o-linear-gradient(110deg, #7fbbe6 60%, #a1d0f5 60%);
            background: -moz-linear-gradient(110deg, #7fbbe6 60%, #a1d0f5 60%);
            background: linear-gradient(110deg, #7fbbe6 60%, #a1d0f5 60%);
        }

        .eighth_card {
            background: -webkit-linear-gradient(110deg, #e9a566 60%, #d6ad87 60%);
            background: -o-linear-gradient(110deg, #e9a566 60%, #d6ad87 60%);
            background: -moz-linear-gradient(110deg, #e9a566 60%, #d6ad87 60%);
            background: linear-gradient(110deg, #e9a566 60%, #d6ad87 60%);
        }

        .nineth_card {
            background: -webkit-linear-gradient(110deg, #95e2d8 60%, #c0ebe5 60%);
            background: -o-linear-gradient(110deg, #95e2d8 60%, #c0ebe5 60%);
            background: -moz-linear-gradient(110deg, #95e2d8 60%, #c0ebe5 60%);
            background: linear-gradient(110deg, #95e2d8 60%, #c0ebe5 60%);
        }

        .tenth_card {
            background: -webkit-linear-gradient(110deg, #b6c7a9 60%, #c8d8bd 60%);
            background: -o-linear-gradient(110deg, #b6c7a9 60%, #c8d8bd 60%);
            background: -moz-linear-gradient(110deg, #b6c7a9 60%, #c8d8bd 60%);
            background: linear-gradient(110deg, #b6c7a9 60%, #c8d8bd 60%);
        }

        .eleventh_card {
            background: -webkit-linear-gradient(110deg, #7fc5ee 60%, #a6d4ee 60%);
            background: -o-linear-gradient(110deg, #7fc5ee 60%, #a6d4ee 60%);
            background: -moz-linear-gradient(110deg, #7fc5ee 60%, #a6d4ee 60%);
            background: linear-gradient(110deg, #7fc5ee 60%, #a6d4ee 60%);
        }

        .twelveth_card {
            background: -webkit-linear-gradient(110deg, #eba3d3 60%, #e4b3d4 60%);
            background: -o-linear-gradient(110deg, #eba3d3 60%, #e4b3d4 60%);
            background: -moz-linear-gradient(110deg, #eba3d3 60%, #e4b3d4 60%);
            background: linear-gradient(110deg, #eba3d3 60%, #e4b3d4 60%);
        }

        .thirteen_card {
            background: -webkit-linear-gradient(110deg, #94DAFF 60%, #7dc6ee 60%);
            background: -o-linear-gradient(110deg, #94DAFF 60%, #7dc6ee 60%);
            background: -moz-linear-gradient(110deg, #94DAFF 60%, #7dc6ee 60%);
            background: linear-gradient(110deg, #94DAFF 60%, #7dc6ee 60%);
        }

        .fourteen_card {
            background: -webkit-linear-gradient(110deg, #a9d3c1 60%, #a5c4b7 60%);
            background: -o-linear-gradient(110deg, #a9d3c1 60%, #a5c4b7 60%);
            background: -moz-linear-gradient(110deg, #a9d3c1 60%, #a5c4b7 60%);
            background: linear-gradient(110deg, #a9d3c1 60%, #a5c4b7 60%);
        }

        .fifteen_card {
            background: -webkit-linear-gradient(110deg, #eba3d3 60%, #e9b2d7 60%);
            background: -o-linear-gradient(110deg, #eba3d3 60%, #e9b2d7 60%);
            background: -moz-linear-gradient(110deg, #eba3d3 60%, #e9b2d7 60%);
            background: linear-gradient(110deg, #eba3d3 60%, #e9b2d7 60%);
        }

        .sixteen_card {
            background: -webkit-linear-gradient(110deg, #e99a9a 60%, #e6acac 60%);
            background: -o-linear-gradient(110deg, #e99a9a 60%, #e6acac 60%);
            background: -moz-linear-gradient(110deg, #e99a9a 60%, #e6acac 60%);
            background: linear-gradient(110deg, #e99a9a 60%, #e6acac 60%);
        }

        /* Start PI Chart */
        #chartdiv {
            width: 100%;
            height: 245px;
        }

        /* End PI Chart */
    </style>
    <x-slot name="title">
        {{ __('DASHBOARD') }}
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('DASHBOARD') }}
        </h2>
    </x-slot>
    <div class="app-admin-wrap layout-sidebar-large">
        <!-- =============== Left side End ================-->
        <div class="sidenav-open d-flex flex-column">
            <!-- ============ Body content start ============= -->
            <div class="">
                <div class="breadcrumb">
                    <div class="p-1 rounded text-center" style="width: 100%;background-color: #e6ebeb;font-size: 16px;">
                        <a href="{{ route('dashboard') }}" class="pt-1 font-weight-bold"
                            style="font-family: Times, serif;color: #000000;">Welcome To
                          @if(isset(Auth::user()->Company->name)) {{Auth::user()->Company->name}}@endif</a>
                    </div>
                </div>
                <div class="separator-breadcrumb border-top"></div>
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <!-- CARD ICON-->
                        <div class="row">
                            {{-- Start Card --}}
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="card card-icon mb-4 shadow first_card">
                                    <div class="card-body text-center"><i class="i-Checkout-Basket text-dark"></i>
                                        <p class="text-muted mt-2 mb-2">Total Purchase</p>
                                        <p class="text-primary text-24 line-height-1 m-0">{{$total_purchase}}</p>
                                    </div>
                                </div>
                            </div>
                            {{-- End Card --}}
                            {{-- Start Card --}}
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="card card-icon mb-4 shadow second_card">
                                    <div class="card-body text-center"><i class="i-Remove-Basket text-dark"></i>
                                        <p class="text-muted mt-2 mb-2">Total Purchase Return</p>
                                        <p class="text-primary text-24 line-height-1 m-0">{{$total_purchase_return}}</p>
                                    </div>
                                </div>
                            </div>
                            {{-- End Card --}}
                            {{-- Start Card --}}
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="card card-icon mb-4 shadow third_card">
                                    <div class="card-body text-center"><i class="i-Bag-Coins text-dark"></i>
                                        <p class="text-muted mt-2 mb-2">Total Sales</p>
                                        <p class="text-primary text-24 line-height-1 m-0">{{$total_sale}}</p>
                                    </div>
                                </div>
                            </div>
                            {{-- End Card --}}
                            {{-- Start Card --}}
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="card card-icon mb-4 shadow fourth_card">
                                    <div class="card-body text-center"><i class="i-Dollar text-dark"></i>
                                        <p class="text-muted mt-2 mb-2">Total Sales Return</p>
                                        <p class="text-primary text-24 line-height-1 m-0">{{$total_sale_return}}</p>
                                    </div>
                                </div>
                            </div>
                            {{-- End Card --}}
                            {{-- Start Card --}}
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="card card-icon mb-4 shadow fifth_card">
                                    <div class="card-body text-center"><i class="i-Add-Cart text-dark"></i>
                                        <p class="text-muted mt-2 mb-2">Today Purchase</p>
                                        <p class="text-primary text-24 line-height-1 m-0">{{$today_purchase}}</p>
                                    </div>
                                </div>
                            </div>
                            {{-- End Card --}}
                            {{-- Start Card --}}
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="card card-icon mb-4 shadow sixth_card">
                                    <div class="card-body text-center"><i class="i-Remove-Cart text-dark"></i>
                                        <p class="text-muted mt-2 mb-2">Today Purchase Return</p>
                                        <p class="text-primary text-24 line-height-1 m-0">{{$today_purchase_return}}</p>
                                    </div>
                                </div>
                            </div>
                            {{-- End Card --}}
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="card mb-4 shadow border border-primary">
                            <div class="card-body p-0">
                                <h5 class="card-title m-0 p-3">Month Wise Sales Rate</h5>
                                {{-- Start Graph --}}
                                <table class="barchart" cellpadding="1" cellspacing="0" style="height: 280px;">
                                    <tr>
                                        <td title="{{$jan}}">
                                            <span class="label">{{intval(($jan*100)/$totalSale)}}%</span>
                                            <div class="bar" style="height:{{intval(($jan*100)/$totalSale)}}%"></div>
                                        </td>
                                        <td title="{{$feb}}">
                                            <span class="label">{{intval(($feb*100)/$totalSale)}}%</span>
                                            <div class="bar" style="height:{{intval(($feb*100)/$totalSale)}}%"></div>
                                        </td>
                                        <td title="{{$mar}}">
                                            <span class="label">{{intval(($mar*100)/$totalSale)}}%</span>
                                            <div class="bar" style="height:{{intval(($mar*100)/$totalSale)}}%"></div>
                                        </td>
                                        <td title="{{$apr}}">
                                            <span class="label">{{intval(($apr*100)/$totalSale)}}%</span>
                                            <div class="bar" style="height:{{intval(($apr*100)/$totalSale)}}%"></div>
                                        </td>
                                        <td title="{{$may}}">
                                            <span class="label">{{intval(($may*100)/$totalSale)}}%</span>
                                            <div class="bar" style="height:{{intval(($may*100)/$totalSale)}}%"></div>
                                        </td>
                                        <td title="{{$jun}}">
                                            <span class="label">{{intval(($jun*100)/$totalSale)}}%</span>
                                            <div class="bar" style="height:{{intval(($jun*100)/$totalSale)}}%"></div>
                                        </td>
                                        <td title="{{$jul}}">
                                            <span class="label">{{intval(($jul*100)/$totalSale)}}%</span>
                                            <div class="bar" style="height:{{intval(($jul*100)/$totalSale)}}%"></div>
                                        </td>
                                        <td title="{{$aug}}">
                                            <span class="label">{{intval(($aug*100)/$totalSale)}}%</span>
                                            <div class="bar" style="height:{{intval(($aug*100)/$totalSale)}}%"></div>
                                        </td>
                                        <td title="{{$sep}}">
                                            <span class="label">{{intval(($sep*100)/$totalSale)}}%</span>
                                            <div class="bar" style="height:{{intval(($sep*100)/$totalSale)}}%"></div>
                                        </td>
                                        <td title="{{$oct}}">
                                            <span class="label">{{intval(($oct*100)/$totalSale)}}%</span>
                                            <div class="bar" style="height:{{intval(($oct*100)/$totalSale)}}%"></div>
                                        </td>
                                        <td title="{{$nov}}">
                                            <span class="label">{{intval(($nov*100)/$totalSale)}}%</span>
                                            <div class="bar" style="height:{{intval(($nov*100)/$totalSale)}}%"></div>
                                        </td>
                                        <td title="{{$dec}}">
                                            <span class="label">{{intval(($dec*100)/$totalSale)}}%</span>
                                            <div class="bar" style="height:{{intval(($dec*100)/$totalSale)}}%"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jan</td>
                                        <td>Feb</td>
                                        <td>Mar</td>
                                        <td>Apr</td>
                                        <td>May</td>
                                        <td>June</td>
                                        <td>July</td>
                                        <td>Aug</td>
                                        <td>Sept</td>
                                        <td>Oct</td>
                                        <td>Nov</td>
                                        <td>Dec</td>
                                    </tr>
                                </table>
                                {{-- End Graph --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <!-- CARD ICON-->
                        <div class="row">
                            {{-- Start Card --}}
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="card card-icon mb-4 shadow seventh_card">
                                    <div class="card-body text-center"><i class="i-Coin text-dark"></i>
                                        <p class="text-muted mt-2 mb-2">Today Sales</p>
                                        <p class="text-primary text-24 line-height-1 m-0">{{$today_sale}}</p>
                                    </div>
                                </div>
                            </div>
                            {{-- End Card --}}
                            {{-- Start Card --}}
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="card card-icon mb-4 shadow eighth_card">
                                    <div class="card-body text-center"><i class="i-Remove-Bag text-dark"></i>
                                        <p class="text-muted mt-2 mb-2">Today Sales Return</p>
                                        <p class="text-primary text-24 line-height-1 m-0">{{$total_sale_return}}</p>
                                    </div>
                                </div>
                            </div>
                            {{-- End Card --}}
                            {{-- Start Card --}}
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="card card-icon mb-4 shadow nineth_card">
                                    <div class="card-body text-center"><i class="i-Coins text-dark"></i>
                                        <p class="text-muted mt-2 mb-2">Current Receivable</p>
                                        <p class="text-primary text-24 line-height-1 m-0">{{$total_receiveable}}</p>
                                    </div>
                                </div>
                            </div>
                            {{-- End Card --}}
                            {{-- Start Card --}}
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="card card-icon mb-4 shadow tenth_card">
                                    <div class="card-body text-center"><i class="i-Money-Bag text-dark"></i>
                                        <p class="text-muted mt-2 mb-2">Overdue Receivable</p>
                                        <p class="text-primary text-24 line-height-1 m-0">{{$total_sale_return}}</p>
                                    </div>
                                </div>
                            </div>
                            {{-- End Card --}}
                            {{-- Start Card --}}
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="card card-icon mb-4 shadow eleventh_card">
                                    <div class="card-body text-center"><i class="i-ATM text-dark"></i>
                                        <p class="text-muted mt-2 mb-2">Current Payable</p>
                                        <p class="text-primary text-24 line-height-1 m-0">{{$total_payable}}</p>
                                    </div>
                                </div>
                            </div>
                            {{-- End Card --}}
                            {{-- Start Card --}}
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="card card-icon mb-4 shadow twelveth_card">
                                    <div class="card-body text-center"><i class="i-Back1 text-dark"></i>
                                        <p class="text-muted mt-2 mb-2">Overdue Payable</p>
                                        <p class="text-primary text-24 line-height-1 m-0">0</p>
                                    </div>
                                </div>
                            </div>
                            {{-- End Card --}}
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="card mb-4 shadow border border-primary">
                            <div class="card-body">
                                <div class="card-title">Month Wise Sales Rate</div>
                                <div class="minwidth">
                                    {{-- Start PI Chart --}}
                                    <input id="january" value="{{(($jan*100)/$totalSale)}}" hidden />
                                    <input id="february" value="{{(($feb*100)/$totalSale)}}" hidden />
                                    <input id="march" value="{{(($mar*100)/$totalSale)}}" hidden />
                                    <input id="april" value="{{(($apr*100)/$totalSale)}}" hidden />
                                    <input id="may" value="{{(($may*100)/$totalSale)}}" hidden />
                                    <input id="june" value="{{(($jun*100)/$totalSale)}}" hidden />
                                    <input id="july" value="{{(($jul*100)/$totalSale)}}" hidden />
                                    <input id="august" value="{{(($aug*100)/$totalSale)}}" hidden />
                                    <input id="september" value="{{(($sep*100)/$totalSale)}}" hidden />
                                    <input id="october" value="{{(($oct*100)/$totalSale)}}" hidden />
                                    <input id="november" value="{{(($nov*100)/$totalSale)}}" hidden />
                                    <input id="december" value="{{(($dec*100)/$totalSale)}}" hidden />
                                    <div id="chartdiv"></div>
                                    {{-- End PI Chart --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end of row-->
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <!-- CARD ICON-->
                        <div class="row">
                            {{-- Start Card --}}
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="card card-icon mb-4 shadow thirteen_card">
                                    <div class="card-body text-center"><i class="i-Full-Cart text-dark"></i>
                                        <p class="text-muted mt-2 mb-2">Total Invoice</p>
                                        <p class="text-primary text-24 line-height-1 m-0">{{$total_invoice}}</p>
                                    </div>
                                </div>
                            </div>
                            {{-- End Card --}}
                            {{-- Start Card --}}
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="card card-icon mb-4 shadow fourteen_card">
                                    <div class="card-body text-center"><i class="i-Add-User text-dark"></i>
                                        <p class="text-muted mt-2 mb-2">Total Customer</p>
                                        <p class="text-primary text-24 line-height-1 m-0">{{$total_customer}}</p>
                                    </div>
                                </div>
                            </div>
                            {{-- End Card --}}
                            {{-- Start Card --}}
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="card card-icon mb-4 shadow fifteen_card">
                                    <div class="card-body text-center"><i class="i-Engineering text-dark"></i>
                                        <p class="text-muted mt-2 mb-2">Total Users</p>
                                        <p class="text-primary text-24 line-height-1 m-0">{{$total_user}}</p>
                                    </div>
                                </div>
                            </div>
                            {{-- End Card --}}
                            {{-- Start Card --}}
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="card card-icon mb-4 shadow sixteen_card">
                                    <div class="card-body text-center"><i class="i-Shopping-Cart text-dark"></i>
                                        <p class="text-muted mt-2 mb-2">Total Item</p>
                                        <p class="text-primary text-24 line-height-1 m-0">{{$total_item}}</p>
                                    </div>
                                </div>
                            </div>
                            {{-- End Card --}}
                        </div>
                    </div>
                    <!-- end of col-->
                    <div class="col-lg-6 col-md-12">
                        <div class="card o-hidden mb-4 shadow border border-primary">
                            <div class="card-header d-flex align-items-center">
                                <h3 class="w-50 float-left card-title m-0">Due Over Date Invoice</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table dataTable-collapse text-center" id="sales_table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Invoice</th>
                                                <th scope="col">Mobile</th>
                                                <th scope="col">Due Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $i=0;
                                            @endphp
                                            @foreach ($invoices as $invoice)
                                            <tr>
                                                <th scope="row">{{++$i}}</th>
                                                <td>{{$invoice->Contact->name}}</td>
                                                <td>
                                                    {{$invoice->code}}
                                                </td>
                                                <td>
                                                    {{$invoice->Contact->mobile}}
                                                </td>
                                                <td>{{$invoice->due_amount}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end of col-->

                </div>
                <!-- end of row-->
                <!-- end of main-content -->
            </div><!-- Footer Start -->

            <!-- fotter end -->
        </div>
    </div>

    @section('script')
    <script src="{{ URL::asset('gull/')}}/dist-assets/js/scripts/script.min.js"></script>
    {{-- <script src="{{ URL::asset('gull/')}}/dist-assets/js/scripts/sidebar.large.script.min.js"></script> --}}
    <script src="{{ URL::asset('gull/')}}/dist-assets/js/plugins/echarts.min.js"></script>
    <script src=".{{ URL::asset('gull/')}}/dist-assets/js/scripts/echart.options.min.js"></script>
    <script src="{{ URL::asset('gull/')}}/dist-assets/js/scripts/dashboard.v1.script.min.js"></script>
    {{-- <script src="{{ URL::asset('gull/dist-assets/js/plugins/bootstrap.bundle.min.js')}}"></script> --}}
    <!-- Resources -->
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

    <!-- Chart code -->
    <script>
        am5.ready(function() {

// Create root element
var root = am5.Root.new("chartdiv");


// Set themes
root.setThemes([
  am5themes_Animated.new(root)
]);


// Create chart
var chart = root.container.children.push(am5percent.PieChart.new(root, {
  layout: root.verticalLayout
}));


// Create series
var series = chart.series.push(am5percent.PieSeries.new(root, {
  valueField: "value",
  categoryField: "category"
}));

var january=document.getElementById("january").value;
var february=document.getElementById("february").value;
var march=document.getElementById("march").value;
var april=document.getElementById("april").value;
var may=document.getElementById("may").value;
var june=document.getElementById("june").value;
var july=document.getElementById("july").value;
var august=document.getElementById("august").value;
var september=document.getElementById("september").value;
var october=document.getElementById("october").value;
var november=document.getElementById("november").value;
var december=document.getElementById("december").value;
// Set data
// https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data
series.data.setAll([
  { value: january, category: "Jan" },
  { value: february, category: "Feb" },
  { value: march, category: "Mar" },
  { value: april, category: "Apr" },
  { value: may, category: "May" },
  { value: june, category: "Jun" },
  { value: july, category: "Jul" },
  { value: august, category: "Aug" },
  { value: september, category: "Sep" },
  { value: october, category: "Oct" },
  { value: november, category: "Nov" },
  { value: december, category: "Dec" },
]);


// Play initial series animation
// https://www.amcharts.com/docs/v5/concepts/animations/#Animation_of_series
series.appear(1000, 100);

}); // end am5.ready()
    </script>
    @endsection
</x-app-layout>
