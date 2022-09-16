<div class="main-header">
    <style>
        select {

            /* styling */
            background-color: white;
            border: thin solid blue;
            border-radius: 4px;
            display: inline-block;
            font: inherit;
            line-height: 1.5em;
            padding: 0.5em 3.5em 0.5em 1em;

            /* reset */

            margin: 0;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            -webkit-appearance: none;
            -moz-appearance: none;
        }


        /* arrows */
        select.classic {
            background-image:
                linear-gradient(45deg, transparent 50%, rgb(255, 255, 255) 50%),
                linear-gradient(135deg, rgb(255, 255, 255) 50%, transparent 50%),
                linear-gradient(to right, #333, #333);
            background-position:
                calc(100% - 20px) calc(1em + 2px),
                calc(100% - 15px) calc(1em + 2px),
                100% 0;
            background-size:
                5px 5px,
                5px 5px,
                2.5em 2.5em;
            background-repeat: no-repeat;
        }

    </style>
    <div class="logo">
        <a href="{{ url('/dashboard') }}"><img
                @if ($profile_setting) src="{{ asset('storage/photo/' . $profile_setting->logo) }}" @endif
                alt=""></a>
    </div>
    <div class="menu-toggle">
        <div></div>
        <div></div>
        <div></div>
    </div>
    <div class="d-flex align-items-center">
        <!-- Mega menu -->
        <div class="dropdown mega-menu d-none d-md-block">
            <a href="#" class="btn text-muted dropdown-toggle mr-3" id="dropdownMegaMenuButton" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">Mega Menu</a>
            <div class="dropdown-menu text-left" aria-labelledby="dropdownMenuButton">
                <div class="row m-0">
                    <div class="col-md-4 p-4">
                        <p class="text-primary text--cap border-bottom-primary d-inline-block">Inventory</p>
                        <ul class="links">
                            <li class="nav-item"><a href="{{ route('inventory.category') }}"><i
                                        class="nav-icon i-Window"></i><span
                                        class="item-name">&nbsp;Category</span></a>
                            </li>
                            <li class="nav-item"><a href="{{ route('inventory.unit') }}"><i
                                        class="nav-icon i-Christmas-Ball"></i><span
                                        class="item-name">&nbsp;Unit</span></a></li>
                            <li class="nav-item"><a href="{{ route('inventory.brand') }}"><i
                                        class="nav-icon i-Structure"></i><span
                                        class="item-name">&nbsp;Brand</span></a>
                            </li>
                            <li class="nav-item"><a href="{{ route('inventory.item-name') }}"><i
                                        class="nav-icon i-Paper-Plane"></i><span class="item-name">&nbsp;Item
                                        Name</span></a></li>
                            <li class="nav-item"><a href="{{ route('inventory.service-name') }}"><i
                                        class="nav-icon i-Paint-Brush"></i><span class="item-name">&nbsp;Service
                                        Name</span></a></li>
                            <li class="nav-item"><a href="{{ route('inventory.generate-barcode') }}"><i
                                        class="nav-icon i-Bar-Code"></i><span class="item-name">&nbsp;Generate
                                        Barcode</span></a></li>
                            <li class="nav-item"><a href="{{ route('inventory.purchase') }}"><i
                                        class="nav-icon i-Coin"></i><span
                                        class="item-name">&nbsp;Purchase</span></a>
                            </li>
                            <li class="nav-item"><a href="{{ route('inventory.purchase-list') }}"><i
                                        class="nav-icon i-Coins"></i><span class="item-name">&nbsp;Purchase
                                        List</span></a></li>
                            <li class="nav-item"><a href="{{ route('inventory.sales') }}"><i
                                        class="nav-icon i-Claps"></i><span class="item-name">&nbsp;Sales</span></a>
                            </li>
                            <li class="nav-item"><a href="{{ route('inventory.sale-list') }}"><i
                                        class="nav-icon i-Credit-Card-2"></i><span class="item-name">&nbsp;Sale
                                        List</span></a></li>
                            <li class="nav-item"><a href="{{ route('inventory.quotation') }}"><i
                                        class="nav-icon i-Claps"></i><span
                                        class="item-name">&nbsp;Quotation</span></a>
                            </li>
                            <li class="nav-item"><a href="{{ route('inventory.quotation-list') }}"><i
                                        class="nav-icon i-Credit-Card-2"></i><span
                                        class="item-name">&nbsp;Quotation
                                        List</span></a></li>
                        </ul>
                    </div>

                    <div class="col-md-4 p-4">
                        <p class="text-primary text--cap border-bottom-primary d-inline-block">Inventory</p>
                        <ul class="links">
                            <li class="nav-item"><a href="{{ route('inventory.pos-terminal') }}"><i
                                        class="nav-icon i-Hotel"></i><span class="item-name">&nbsp;POS
                                        Terminal</span></a></li>
                            {{-- <li class="nav-item"><a href="{{route('inventory.delievery-list')}}"><i
                                        class="nav-icon i-Shoutwire"></i><span class="item-name">Delievery
                                        List</span></a></li> --}}

                            {{-- <li class="nav-item"><a href="{{route('inventory.quote')}}"><i
                                        class="nav-icon i-Yes"></i><span class="item-name">Quote</span></a></li> --}}
                            <li class="nav-item"><a href="{{ route('inventory.make-requisition') }}"><i
                                        class="nav-icon i-Yes"></i><span
                                        class="item-name">&nbsp;Requisition</span></a>
                            </li>
                            <li class="nav-item"><a href="{{ route('inventory.purchase-invoice') }}"><i
                                        class="nav-icon i-Calculator"></i><span class="item-name">&nbsp;Purchase
                                        Invoice</span></a></li>
                            <li class="nav-item"><a href="{{ route('inventory.sale-chalan') }}"><i
                                        class="nav-icon i-Calculator"></i><span class="item-name">&nbsp;Sale
                                        Chalan</span></a></li>
                            <li class="nav-item"><a href="{{ route('inventory.stock-adjustment') }}"><i
                                        class="nav-icon i-Calculator"></i><span class="item-name">&nbsp;Stock
                                        Adjustment</span></a></li>
                            {{-- <li class="nav-item"><a href="{{route('inventory.delievery-note')}}"><i
                                        class="nav-icon i-Calculator"></i><span class="item-name">Delievery
                                        Note</span></a></li> --}}
                        </ul>
                    </div>


                    <div class="col-md-4 p-4">
                        <p class="text-primary text--cap border-bottom-primary d-inline-block">Accounts Setting</p>
                        <ul class="links">
                            <li class="nav-item"><a href="{{ route('accounts-setting.company') }}"><i
                                        class="nav-icon i-Professor"></i><span class="item-name">&nbsp;Create
                                        Company</span></a></li>
                            <li class="nav-item"><a href="{{ route('accounts-setting.chart-of-section') }}"><i
                                        class="nav-icon i-Business-Man"></i><span class="item-name">&nbsp;Chart of
                                        Section</span></a></li>
                            <li class="nav-item"><a href="{{ route('accounts-setting.chart-of-group') }}"><i
                                        class="nav-icon i-Bank"></i><span class="item-name">&nbsp;Chart of
                                        Group</span></a></li>
                            <li class="nav-item"><a href="{{ route('accounts-setting.chart-of-account') }}"><i
                                        class="nav-icon i-Conference"></i><span class="item-name">&nbsp;Chart of
                                        Accounts</span></a></li>
                            <li class="nav-item"><a href="{{ route('accounts-setting.vat-setup') }}"><i
                                        class="nav-icon i-Wallet"></i><span class="item-name">&nbsp;Vat
                                        Setup</span></a>
                            </li>
                            <li class="nav-item"><a href="{{ route('accounts-setting.currency') }}"><i
                                        class="nav-icon i-Coins"></i><span
                                        class="item-name">&nbsp;Currency</span></a>
                            </li>
                            <li class="nav-item"><a href="{{ route('accounts-setting.invoice-setting') }}"><i
                                        class="nav-icon i-Credit-Card"></i><span class="item-name">&nbsp;Invoice
                                        Settings</span></a></li>
                            {{-- <li class="nav-item"><a href="{{route('accounts-setting.payment-method')}}"><i
                                        class="nav-icon i-Credit-Card-2"></i><span class="item-name">Payment
                                        Method</span></a></li> --}}
                            <li class="nav-item"><a href="{{ route('accounts-setting.branch') }}"><i
                                        class="nav-icon i-Post-Office"></i><span
                                        class="item-name">&nbsp;Branch</span></a></li>
                            <li class="nav-item"><a href="{{ route('accounts-setting.warehouse') }}"><i
                                        class="nav-icon i-Building"></i><span
                                        class="item-name">&nbsp;WareHouse</span></a></li>
                            <li class="nav-item"><a href="{{ route('accounts-setting.entry_type') }}"><i
                                        class="nav-icon i-Building"></i><span class="item-name">&nbsp;Entry
                                        Type</span></a></li>
                        </ul>
                    </div>

                    <div class="col-md-4 p-4">
                        <p class="text-primary text--cap border-bottom-primary d-inline-block">Reports</p>
                        <ul class="links">
                            <li><a href="{{ route('reports.receivable-report') }}"><i
                                        class="nav-icon i-Add-File"></i>&nbsp;Receiveable</a></li>
                            <li><a href="{{ route('reports.payable-report') }}"><i
                                        class="nav-icon i-Email"></i>&nbsp;Payable</a></li>
                            <li><a href="{{ route('reports.stock-report') }}"><i
                                        class="nav-icon i-Notepad-2"></i>&nbsp;Stock Report</a></li>
                            <li><a href="{{ route('reports.purchase-report') }}"><i
                                        class="nav-icon i-Notepad-2"></i>&nbsp;Purchase Report</a></li>
                            <li><a href="{{ route('reports.purchase-detail-report') }}"><i
                                        class="nav-icon i-Notepad-2"></i>&nbsp;Purchase Details Report</a></li>
                            <li><a href="{{ route('reports.purchase-return-report') }}"><i
                                        class="nav-icon i-Calendar-4"></i>&nbsp;Purchase Returns Report</a></li>
                            <li><a href="{{ route('reports.supplier-ledger-report') }}"><i
                                        class="nav-icon i-Calendar-4"></i>&nbsp;Supplier Ledger Reports</a></li>
                            <li><a href="{{ route('reports.bank-book') }}"><i class="nav-icon i-Bank"></i>&nbsp;Bank
                                    Book</a></li>
                            <li><a href="{{ route('reports.trail-balance') }}"><i
                                        class="nav-icon i-Coins"></i>&nbsp;Trail
                                    Balance</a></li>
                            <li><a href="{{ route('reports.balance-sheet') }}"><i
                                        class="nav-icon i-Calendar-4"></i>&nbsp;Balance Sheet</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 p-4">
                        <p class="text-primary text--cap border-bottom-primary d-inline-block">Reports</p>
                        <ul class="links">
                            <li><a href="{{ route('reports.sales-detail-report') }}"><i
                                        class="nav-icon i-Calendar-4"></i>&nbsp;Sales Details Report</a></li>
                            <li><a href="{{ route('reports.sales-return-report') }}"><i
                                        class="nav-icon i-Calendar-4"></i>&nbsp;Sales Return Report</a></li>
                            <li><a href="{{ route('reports.customer-ledger-report') }}"><i
                                        class="nav-icon i-Calendar-4"></i>&nbsp;Customer Ledger Reports</a></li>
                            <li><a href="{{ route('reports.profit-loss') }}"><i
                                        class="nav-icon i-Bar-Chart"></i>&nbsp;Profit Loss</a></li>
                            <li><a href="{{ route('reports.income-statement') }}"><i
                                        class="nav-icon i-Money"></i>&nbsp;Income Statement</a></li>
                            <li><a href="{{ route('reports.day-book') }}"><i class="nav-icon i-Home-2"></i>&nbsp;Day
                                    Book</a></li>
                        </ul>
                    </div>


                    <div class="col-md-4 p-4">
                        <p class="text-primary text--cap border-bottom-primary d-inline-block">Contact Us</p>
                        <ul class="links">
                            <li><a href="{{ route('contacts.customer-accounts') }}"><i class="i-Shop-4"></i>
                                    Customer Accounts</a></li>
                            <li><a href="{{ route('contacts.supplier-accounts') }}"><i class="i-Library"></i>
                                    Supplier Accounts</a></li>
                            <li><a href="{{ route('contacts.staff-accounts') }}"><i class="i-Drop"></i>
                                    Staff
                                    Accounts</a></li>
                            <li><a href="{{ route('contacts.others-accounts') }}"><i
                                        class="i-File-Clipboard-File--Text"></i> Others Accounts</a></li>
                        </ul>
                    </div>


                    <div class="col-md-4 p-4">
                        <p class="text-primary text--cap border-bottom-primary d-inline-block">Accounts Module</p>
                        <ul class="links">
                            <li><a href="{{ route('accounts-module.receipt') }}"><i
                                        class="i-Shop-4"></i>&nbsp;Receipt</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Mega menu -->
        <div class="search-bar">
            <input type="text" placeholder="Search">
            <i class="search-icon text-muted i-Magnifi-Glass1"></i>
        </div>
        {{-- @if (Auth::user()->hasAnyRole('admin')) --}}
        <div class="col-lg-4 col-md-4 mt-2">
            <div class="form-group">
                <select class="form-control form-select select2 updateTable classic" placeholder="Company"
                    name="company_id" style="width: 200px;" id="company_id">
                    <option value="">Select Company</option>
                    @foreach ($company_info as $company)
                        <option value="{{ $company->id }}" @if (Auth::user()->company_id && Auth::user()->company_id == $company->id) selected @endif>
                            {{ $company->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        {{-- @endif --}}
    </div>




    <div style="margin: auto"></div>
    <div class="header-part-right">
        <!-- Full screen toggle -->
        <i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen></i>
        <!-- Grid menu Dropdown -->
        <!-- Language -->
        <!-- Notificaiton End -->
        <!-- User avatar dropdown -->
        <div class="dropdown">
            <div class="user col align-self-end">
                <img @if ($profile_setting) src="{{ asset('storage/photo/' . $profile_setting->profile_photo) }}" @endif
                    id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <div class="dropdown-header">
                        <i class="i-Lock-User mr-1"></i> {{ Auth::user()->name }}
                    </div>
                    <a class="dropdown-item" href="{{ route('profile-settings.profile-setup') }}">Profile Setup</a>
                    <a class="dropdown-item" href="{{ route('profile-settings.users-management') }}">Users
                        Management</a>
                    <a class="dropdown-item" href="{{ route('profile-settings.change-password') }}">Change
                        Password</a>

                    <a class="log-out-btn dropdown-item text-danger" href="#"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">Sign Out</a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>

    <script>
        $('#company_id').on('change', function() {
            var com_id = $("#company_id").val();
            $.ajax({
                type: 'GET',
                url: "{{ route('data.company_update') }}",
                data: {
                    company_id: com_id
                },
                success: function(data) {
                    $("#msg").html(data.msg);
                    alert("Company Switched Successfully");
                    window.location.reload(1);
                }
            });
        });
    </script>


</div>
