        @stack('css')
        @yield('css')
        <!-- App css -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
        <link href="{{ URL::asset('gull/dist-assets/css/themes/lite-purple.min.css')}}" rel="stylesheet" />
        <link href="{{ URL::asset('gull/dist-assets/css/plugins/perfect-scrollbar.min.css')}}" rel="stylesheet" />
        <link rel="stylesheet" href="{{ URL::asset('gull/dist-assets/css/plugins/datatables.min.css')}}" />
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
        @livewireStyles
        <script src="{{ mix('js/app.js') }}" defer></script>
        @livewireScripts
