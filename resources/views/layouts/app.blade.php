<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>{{$title ?? ''}} | {{config('app.name')}}</title>
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <meta content="Premium Multipurpose Accounting & Inventory Management Software" name="description" />
        <meta content="Md. Mozammel Hoque" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ URL::asset('gull/dist-assets/images/favicon.ico')}}">
        @include('layouts.head-script')
        @livewireStyles
        <script src="{{ mix('js/app.js') }}" defer></script>
        @livewireScripts
<style>
    #header-text-design{
        font-size: 18px;
        background: -webkit-linear-gradient(rgb(192, 56, 56), rgb(76, 26, 170));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>
    </head>
    @section('body')
    @show

    <body class="text-left">
        <div class="app-admin-wrap layout-sidebar-large">
            @include('layouts.topbar')
            <!-- =============== Main Header End ================-->
            @include('layouts.sidebar')
            <!-- =============== Left side End ================-->
            <div class="main-content-wrap sidenav-open d-flex flex-column">
                <!-- ============ Body content start ============= -->
                <div class="main-content">
                    {{ $slot }}
                </div>

                <!-- Footer Start -->
                <div class="flex-grow-1"></div>
                @include('layouts.footer')
                <!-- fotter end -->
            </div>
        </div>
        <!-- JAVASCRIPT -->
        @include('layouts.footer-script')
    </body>
</html>
