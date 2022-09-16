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
        @yield('css')
        <script src="{{ mix('js/app.js') }}" defer></script>

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
                    @yield('content')
                </div>
                <!-- Footer Start -->
                <div class="flex-grow-1"></div>
                @include('layouts.footer')
                <!-- fotter end -->
            </div>
        </div>
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
        <link href="{{ URL::asset('assets/libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- Sweet alert init js -->
        <script src="{{ URL::asset('assets/js/pages/sweet-alerts.init.js') }}"></script>

        <script>
            $(document).ready(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function (xhr, status) {
                        removeErrorMessages();
                    },
                    beforeSubmit: function (formData, jqForm, options) {
                        loadingButton(jqForm.find("button[type=submit]"), 'loading');
                    }
                });
            });

                formBeforeSend = function (xhr, status, o) {
                    removeErrorMessages();
                };

                formBeforeSubmit = function (formData, jqForm, options) {
                    loadingButton(jqForm.find("button[type=submit]"), 'loading');
                };

                $(document).on("click", "button[type=submit]", function () {
                    $(this).addClass('active');
                });

                loadingButton = function (button, loadingText) {
                    button.data("original-content", button.html())
                        .text(loadingText)
                        .addClass("disabled")
                        .attr('disabled', "disabled");

                };

                removeLoadingButton = function (button) {
                    button.html(button.data("original-content"))
                        .removeClass("disabled")
                        .removeAttr("disabled")
                        .removeAttr("rel");
                };



                formError = function (xhr, status, error, $form) {

                    var obj = JSON.parse(xhr.responseText);

                    swal("Errors!", obj.message, "error");

                    removeLoadingButton($form.find("button[type=submit]"));

                    $.each(obj.errors, function (key, error) {
                        if (document.getElementById(key)) {
                            if ($form.find(":input[id=" + key + "]")) {
                                displayErrorMessage($form.find(":input[id=" + key + "]"), error[0]);
                            } else if ($form.find(":select[id=" + key + "]")) {
                                displayErrorMessage($form.find(":select[id=" + key + "]"), error[0]);
                            } else if ($form.find(":textarea[id=" + key + "]")) {
                                displayErrorMessage($form.find(":textarea[id=" + key + "]"), error[0]);
                            }
                        } else {
                            if ($form.find(":input[name=" + key + "]")) {
                                displayErrorMessage($form.find(":input[name=" + key + "]"), error[0]);
                            } else if ($form.find(":select[name=" + key + "]")) {
                                displayErrorMessage($form.find(":select[name=" + key + "]"), error[0]);
                            } else if ($form.find(":textarea[name=" + key + "]")) {
                                displayErrorMessage($form.find(":textarea[name=" + key + "]"), error[
                                0]);
                            }
                        }
                    });
                };


                formSuccess = function (responseText, statusText, xhr, $form) {
                    swal("Success!", responseText.message, "success");
                    removeLoadingButton($form.find("button[type=submit]"));
                };


                removeErrorMessages = function () {
                    $("form input").removeClass('form-control-danger').removeClass('form-control-success');
                    $(".form-control-feedback").remove();
                };

                displayErrorMessage = function (element, message) {
                    element.addClass('form-control-danger').removeClass('form-control-success');
                    if (typeof message !== "undefined") {
                        element.after(
                            $("<div class='form-control-feedback'>" + message + "</div>")
                        );
                    }
                };


            $(document).ready(function () {


                var date = new Date();
                var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
                var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
                $('.currentDate').val(getDateFormat());
                $('.firstDate').val(getDateFormat(firstDay));
                $('.lastDate').val(getDateFormat(lastDay));
            });

            function getDateFormat(date = null) {
                if (date) {
                    var now = new Date(date);
                } else {
                    var now = new Date();
                }
                var month = (now.getMonth() + 1);
                var day = now.getDate();
                if (month < 10)
                    month = "0" + month;
                if (day < 10)
                    day = "0" + day;
                var today = now.getFullYear() + '-' + month + '-' + day;
                return today;
            }

            var delay = (function () {
                var timer = 0;
                return function (callback, ms) {
                    clearTimeout(timer);
                    timer = setTimeout(callback, ms);
                };
            })();


            function IDGenerator(value = 10) {

                this.length = value;
                this.timestamp = +new Date;

                var _getRandomInt = function (min, max) {
                    return Math.floor(Math.random() * (max - min + 1)) + min;
                }

                this.generate = function () {
                    var ts = this.timestamp.toString();
                    var parts = ts.split("").reverse();
                    var id = "";

                    for (var i = 0; i < this.length; ++i) {
                        var index = _getRandomInt(0, parts.length - 1);
                        id += parts[index];
                    }

                    return id;
                }
            }

        </script>

        @yield('scripts')
        @stack('scripts')
    </body>
</html>
