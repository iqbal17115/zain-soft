<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
        <ul class="navigation-left">
            <!--li class="nav-item"><a class="nav-item-hold" href="{{url('/dashboard')}}"><i class="nav-icon i-Bar-Chart"></i><span class="nav-text">Dashboard</span></a>
                <div class="triangle"></div>
            </li-->
            <li class="nav-item" data-item="contacts"><a class="nav-item-hold" href="#"><i class="nav-icon i-Conference"></i><span class="nav-text">Contacts</span></a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item" data-item="accounts-setting"><a class="nav-item-hold" href="#"><i class="nav-icon i-Magnet"></i><span class="nav-text">Accounts Setting</span></a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item" data-item="inventory"><a class="nav-item-hold" href="#"><i class="nav-icon i-Library"></i><span class="nav-text">Inventory</span></a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item" data-item="accounts-module"><a class="nav-item-hold" href="#"><i class="nav-icon i-Suitcase"></i><span class="nav-text">Accounts Module</span></a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item" data-item="reports"><a class="nav-item-hold" href="#"><i class="nav-icon i-Computer-Secure"></i><span class="nav-text">Reports</span></a>
                <div class="triangle"></div>
            </li>
        </ul>
    </div>
    <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
        <!-- Submenu Dashboards-->
        @can('view contact')
        <ul class="childNav" data-parent="contacts">
            <li class="nav-item"><a href="{{route('contacts.customer-accounts')}}"><i class="nav-icon i-Talk-Man"></i><span class="item-name">Customer Accounts</span></a></li>
            <li class="nav-item"><a href="{{route('contacts.supplier-accounts')}}"><i class="nav-icon i-Business-Man"></i><span class="item-name">Supplier Accounts</span></a></li>
            <li class="nav-item"><a href="{{route('contacts.staff-accounts')}}"><i class="nav-icon i-Find-User"></i><span class="item-name">Staff Accounts</span></a></li>
            <li class="nav-item"><a href="{{route('contacts.others-accounts')}}"><i class="nav-icon i-Engineering"></i><span class="item-name">Others Accounts</span></a></li>
        </ul>
        @endcan
        <ul class="childNav" data-parent="accounts-setting">
            @can('view company')
            <li class="nav-item"><a href="{{route('accounts-setting.company')}}"><i class="nav-icon i-Professor"></i><span class="item-name">Create Company</span></a></li>
            @endcan
            @can('view chart_of_section')
            <li class="nav-item"><a href="{{route('accounts-setting.chart-of-section')}}"><i class="nav-icon i-Business-Man"></i><span class="item-name">Chart of Section</span></a></li>
            @endcan
            @can('view chart_of_group')
            <li class="nav-item"><a href="{{route('accounts-setting.chart-of-group')}}"><i class="nav-icon i-Bank"></i><span class="item-name">Chart of Group</span></a></li>
            @endcan
            @can('view chart_of_account')
            <li class="nav-item"><a href="{{route('accounts-setting.chart-of-account')}}"><i class="nav-icon i-Conference"></i><span class="item-name">Chart of Accounts</span></a></li>
            @endcan
            @can('view vat')
            <li class="nav-item"><a href="{{route('accounts-setting.vat-setup')}}"><i class="nav-icon i-Wallet"></i><span class="item-name">Vat Setup</span></a></li>
            @endcan
            @can('view currency')
            <li class="nav-item"><a href="{{route('accounts-setting.currency')}}"><i class="nav-icon i-Coins"></i><span class="item-name">Currency</span></a></li>
            @endcan
            @can('view financial_year')
            <li class="nav-item"><a href="{{route('accounts-setting.financial-year')}}"><i class="nav-icon i-Bar-Chart"></i><span class="item-name">Financial Year</span></a></li>
            @endcan
            @can('view invoice_setting')
            <li class="nav-item"><a href="{{route('accounts-setting.invoice-setting')}}"><i class="nav-icon i-Credit-Card"></i><span class="item-name">Invoice Settings</span></a></li>
            @endcan
            {{-- <li class="nav-item"><a href="{{route('accounts-setting.payment-method')}}"><i class="nav-icon i-Credit-Card-2"></i><span class="item-name">Payment Method</span></a></li> --}}
            @can('view branch')
            <li class="nav-item"><a href="{{route('accounts-setting.branch')}}"><i class="nav-icon i-Post-Office"></i><span class="item-name">Branch</span></a></li>
            @endcan
            @can('view tag')
            <li class="nav-item"><a href="{{route('accounts-setting.tag')}}"><i class="nav-icon i-Newspaper-2"></i><span class="item-name">Tag</span></a></li>
            @endcan
            @can('view warehouse')
            <li class="nav-item"><a href="{{route('accounts-setting.warehouse')}}"><i class="nav-icon i-Building"></i><span class="item-name">WareHouse</span></a></li>
            @endcan
            @can('view entry_type')
            <li class="nav-item"><a href="{{route('accounts-setting.entry_type')}}"><i class="nav-icon i-Address-Book-2"></i><span class="item-name">Entry Type</span></a></li>
            @endcan
        </ul>
        <ul class="childNav" data-parent="inventory">
            @can('view category')
            <li class="nav-item"><a href="{{route('inventory.category')}}"><i class="nav-icon i-Window"></i><span class="item-name">Category</span></a></li>
            @endcan
            @can('view unit')
            <li class="nav-item"><a href="{{route('inventory.unit')}}"><i class="nav-icon i-Christmas-Ball"></i><span class="item-name">Unit</span></a></li>
            @endcan
            @can('view brand')
            <li class="nav-item"><a href="{{route('inventory.brand')}}"><i class="nav-icon i-Structure"></i><span class="item-name">Brand</span></a></li>
            @endcan
            @can('view item')
            <li class="nav-item"><a href="{{route('inventory.item-name')}}"><i class="nav-icon i-Paper-Plane"></i><span class="item-name">Item Name</span></a></li>
            @endcan
            @can('view service_name')
            <li class="nav-item"><a href="{{route('inventory.service-name')}}"><i class="nav-icon i-Paint-Brush"></i><span class="item-name">Service Name</span></a></li>
            @endcan
            {{-- <li class="nav-item"><a href="{{route('inventory.generate-barcode')}}"><i class="nav-icon i-Bar-Code"></i><span class="item-name">Generate Barcode</span></a></li> --}}
            @can('view purchase')
            <li class="nav-item"><a href="{{route('inventory.purchase')}}"><i class="nav-icon i-Coin"></i><span class="item-name">Purchase</span></a></li>
            <li class="nav-item"><a href="{{route('inventory.purchase-list')}}"><i class="nav-icon i-File-Horizontal-Text"></i><span class="item-name">Purchase List</span></a></li>
            <li class="nav-item"><a href="{{route('inventory.purchase-return-list')}}"><i class="nav-icon i-Coins"></i><span class="item-name">Purchase Return</span></a></li>
            @endcan
            @can('view sale')
            <li class="nav-item"><a href="{{route('inventory.sales')}}"><i class="nav-icon i-Claps"></i><span class="item-name">Sales</span></a></li>
            <li class="nav-item"><a href="{{route('inventory.sale-list')}}"><i class="nav-icon i-Receipt-4"></i><span class="item-name">Sale List</span></a></li>
            <li class="nav-item"><a href="{{route('inventory.sale-return-list')}}"><i class="nav-icon i-Receipt"></i><span class="item-name">Sale Return</span></a></li>
            @endcan
            @can('view quotation')
            <li class="nav-item"><a href="{{route('inventory.quotation')}}"><i class="nav-icon i-Credit-Card-2"></i><span class="item-name">Quotation</span></a></li>
            <li class="nav-item"><a href="{{route('inventory.quotation-list')}}"><i class="nav-icon i-Receipt-3"></i><span class="item-name">Quotation List</span></a></li>
            @endcan
            {{-- <li class="nav-item"><a href="{{route('inventory.pos-terminal')}}"><i class="nav-icon i-Hotel"></i><span class="item-name">POS Terminal</span></a></li> --}}
            {{-- <li class="nav-item"><a href="{{route('inventory.delievery-list')}}"><i class="nav-icon i-Shoutwire"></i><span class="item-name">Delievery List</span></a></li> --}}
            @can('view requisition')
            <li class="nav-item"><a href="{{route('inventory.make-requisition')}}"><i class="nav-icon i-Yes"></i><span class="item-name">Requisition</span></a></li>
            <li class="nav-item"><a href="{{route('inventory.requisition-list')}}"><i class="nav-icon i-Big-Data"></i><span class="item-name">Requisition List</span></a></li>
            @endcan
            {{-- <li class="nav-item"><a href="{{route('inventory.stock-adjustment')}}"><i class="nav-icon i-Calculator"></i><span class="item-name">Stock Adjustment</span></a></li> --}}
            {{-- <li class="nav-item"><a href="{{route('inventory.delievery-note')}}"><i class="nav-icon i-Calculator"></i><span class="item-name">Delievery Note</span></a></li> --}}
        </ul>
        <ul class="childNav" data-parent="accounts-module">
            @can('view customer_payment')
            <li class="nav-item"><a href="{{route('accounts-module.customer-payment')}}"><i class="nav-icon i-Money-Bag"></i><span class="item-name">Customer Payment</span></a></li>
            @endcan
            @can('view supplier_payment')
            <li class="nav-item"><a href="{{route('accounts-module.supplier-payment')}}"><i class="nav-icon i-Money-Bag"></i><span class="item-name">Supplier Payment</span></a></li>
            @endcan
            @can('view receipt')
            <li class="nav-item"><a href="{{route('accounts-module.receipt-list')}}"><i class="nav-icon i-Check"></i><span class="item-name">Receipt</span></a></li>
            @endcan
            @can('view bank_reconsilation')
            <li class="nav-item"><a href="{{route('reports.bank-reconsilation-report')}}"><i class="nav-icon i-Calendar-4"></i><span class="item-name">Bank Reconsilation</span></a></li>
            @endcan
            {{-- <li class="nav-item"><a href="{{route('accounts-module.customer-payment-invoice')}}"><i class="nav-icon i-Check"></i><span class="item-name">Customer Payment Invoice</span></a></li> --}}
        </ul>
        <ul class="childNav" data-parent="reports">
            @can('view receivable_report')
            <li class="nav-item"><a href="{{route('reports.receivable-report-new')}}"><i class="nav-icon i-Add-File"></i><span class="item-name">Receivable New</span></a></li>
            @endcan
            @can('view payable_report')
            <li class="nav-item"><a href="{{route('reports.payable-report-new')}}"><i class="nav-icon i-Add-File"></i><span class="item-name">Payable New</span></a></li>
            @endcan
            @can('view stock_report')
            <li class="nav-item"><a href="{{route('reports.stock-report-new')}}"><i class="nav-icon i-Add-File"></i><span class="item-name">Stock Report New</span></a></li>
            @endcan
            @can('view low_stock_alert_report')
            <li class="nav-item"><a href="{{route('reports.low-stock-report-new')}}"><i class="nav-icon i-Add-File"></i><span class="item-name">Low Stock Report New</span></a></li>
            @endcan
            @can('view purchase_report')
            <li class="nav-item"><a href="{{route('reports.purchase-report-new')}}"><i class="nav-icon i-Add-File"></i><span class="item-name">Purchase Report New</span></a></li>
            @endcan
            @can('view purchase_detail_report')
            <li class="nav-item"><a href="{{route('reports.purchase-detail-report-new')}}"><i class="nav-icon i-Add-File"></i><span class="item-name">Purchase Detail Report New</span></a></li>
            <li class="nav-item"><a href="{{route('reports.purchase-return-report-new')}}"><i class="nav-icon i-Add-File"></i><span class="item-name">Purchase Return Report New</span></a></li>
            @endcan
            {{-- @can('view supplier_ledger_report')
            <li class="nav-item"><a href="{{route('reports.supplier-ledger-report-new')}}"><i class="nav-icon i-Add-File"></i><span class="item-name">Supplier Ledger Report New</span></a></li>
            @endcan --}}
            @can('view sale_report')
            <li class="nav-item"><a href="{{route('reports.sale-report-new')}}"><i class="nav-icon i-Add-File"></i><span class="item-name">Sale Report New</span></a></li>
            @endcan
            @can('view sale_detail_report')
            <li class="nav-item"><a href="{{route('reports.sale-detail-report-new')}}"><i class="nav-icon i-Add-File"></i><span class="item-name">Sale Detail Report New</span></a></li>
            <li class="nav-item"><a href="{{route('reports.sale-return-report-new')}}"><i class="nav-icon i-Add-File"></i><span class="item-name">Sale Return Report New</span></a></li>
            @endcan
            {{-- @can('view customer_ledger_report')
            <li class="nav-item"><a href="{{route('reports.customer-ledger-report-new')}}"><i class="nav-icon i-Add-File"></i><span class="item-name">Customer Ledger Report New</span></a></li>
            @endcan --}}
            @can('view profit_loss_report')
            <li class="nav-item"><a href="{{route('reports.profit-loss-report-new')}}"><i class="nav-icon i-Add-File"></i><span class="item-name">Profit Loss Report New</span></a></li>
            @endcan

            @can('view general_ledger_report')
            <li class="nav-item"><a href="{{route('reports.general-ledger')}}"><i class="nav-icon i-Diploma"></i><span class="item-name">General Ledger</span></a></li>
            @endcan
            @can('view supplier_ledger_report')
            <li class="nav-item"><a href="{{route('reports.supplier-ledger-report')}}"><i class="nav-icon i-Factory"></i><span class="item-name">Supplier Ledger Reports</span></a></li>
            @endcan

            @can('view sale_detail_report')
            {{-- <li class="nav-item"><a href="{{route('reports.sales-detail-report')}}"><i class="nav-icon i-Letter-Open"></i><span class="item-name">Sales Details Report</span></a></li> --}}
            {{-- <li class="nav-item"><a href="{{route('reports.sales-return-report')}}"><i class="nav-icon i-Reload"></i><span class="item-name">Sales Return Report</span></a></li> --}}
            @endcan
            @can('view customer_ledger_report')
            <li class="nav-item"><a href="{{route('reports.customer-ledger-report-new')}}"><i class="nav-icon i-Bag"></i><span class="item-name">Customer Ledger Reports</span></a></li>
            @endcan
            @can('view profit_loss_report')
            {{-- <li class="nav-item"><a href="{{route('reports.profit-loss')}}"><i class="nav-icon i-Bar-Chart"></i><span class="item-name">Profit Loss</span></a></li> --}}
            @endcan
            @can('view income_statement_report')
            <li class="nav-item"><a href="{{route('reports.income-statement')}}"><i class="nav-icon i-Money"></i><span class="item-name">Income Statement</span></a></li>
            @endcan
            @can('view day_book_report')
            <li class="nav-item"><a href="{{route('reports.day-book')}}"><i class="nav-icon i-Home-2"></i><span class="item-name">Day Book</span></a></li>
            @endcan
            @can('view bank_book_report')
            <li class="nav-item"><a href="{{route('reports.bank-book')}}"><i class="nav-icon i-Bank"></i><span class="item-name">Bank Book</span></a></li>
            @endcan
            @can('view trial_balance_report')
            <li class="nav-item"><a href="{{route('reports.trail-balance')}}"><i class="nav-icon i-Macro"></i><span class="item-name">Trail Balance</span></a></li>
            <li class="nav-item"><a href="{{route('reports.balance-sheet')}}"><i class="nav-icon i-No-Flash"></i><span class="item-name">Balance Sheet</span></a></li>
            @endcan
            @can('view vat_collection_report')
            <li class="nav-item"><a href="{{route('reports.vat-collection-report')}}"><i class="nav-icon i-Filter"></i><span class="item-name">Vat Collection</span></a></li>
            @endcan
            @can('view vat_return_report')
            <li class="nav-item"><a href="{{route('reports.vat-return-report')}}"><i class="nav-icon i-Compass-Rose"></i><span class="item-name">Vat Return</span></a></li>
            @endcan
            @can('view balance_sheet_report')
            <li class="nav-item"><a href="{{route('reports.balance-sheet-old')}}"><i class="nav-icon i-Cash-Register"></i><span class="item-name">Balance Sheet old</span></a></li>
            @endcan
        </ul>
    </div>
    <div class="sidebar-overlay"></div>
</div>
