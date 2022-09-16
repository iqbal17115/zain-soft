        <!-- JAVASCRIPT -->
        <script src="{{ URL::asset('gull/dist-assets/js/plugins/jquery-3.3.1.min.js')}}"></script>
        <script src="{{ URL::asset('gull/dist-assets/js/plugins/bootstrap.bundle.min.js')}}"></script>
        <script src="{{ URL::asset('gull/dist-assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
        <script src="{{ URL::asset('gull/dist-assets/js/scripts/script.min.js')}}"></script>
        <script src="{{ URL::asset('gull/dist-assets/js/scripts/sidebar.large.script.min.js')}}"></script>
        <script src="{{ URL::asset('gull/dist-assets/js/plugins/echarts.min.js')}}"></script>

        <script src="{{ URL::asset('gull/dist-assets/js/plugins/datatables.min.js')}}"></script>
        <script src="{{ URL::asset('gull/dist-assets/js/scripts/datatables.script.min.js')}}"></script>
        <!-- Sweet Alerts js -->
        <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

        <!-- Sweet alert init js -->
        <script src="{{ URL::asset('assets/js/pages/sweet-alerts.init.js') }}"></script>
        @stack('scripts')

        @yield('script')

        {{-- @stack('modals') --}}
        <script>
            window.livewire.on('success', message => {
                Swal.fire({
                    title: message.title || 'Success',
                    text: message.text,
                    type: 'success',
                    confirmButtonColor: '#3b5de7'
                });
            });

            window.livewire.on('error', message => {
                Swal.fire({
                    title: message.title || 'Error',
                    text: message.text,
                    type: 'error',
                    confirmButtonColor: '#3b5de7'
                });
            });

            window.livewire.on('success_redirect', message => {
                Swal.fire({
                    title: message.title || 'Success',
                    text: message.text,
                    type: 'success',
                    confirmButtonColor: '#3b5de7'
                }).then(function () {
                    window.location = message.url;
                });
            });
            window.livewire.on('redirect', message => {
                    window.open(message.url,"_blank");
            });

            window.livewire.on('modal', message => {
                    $('#'+message).modal('toggle');
            });
        </script>

