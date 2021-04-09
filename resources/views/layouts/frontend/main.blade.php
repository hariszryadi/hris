<!doctype html>
<html lang="en">

<head>

    <!-- Basic Page Needs -->
    <title>HRIS-Ku</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- <link rel="icon" href="assets/images/favicon.png"> --}}

    <!-- CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/uikit.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">

    <!-- icons -->
    <link rel="stylesheet" href="{{asset('assets/css/icons.css')}}">
    <script src="https://kit.fontawesome.com/815e388c50.js" crossorigin="anonymous"></script>

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{asset('assets/bootstrap/bootstrap.min.css')}}">
</head>

<body>
    <div class="body">
        <!-- Wrapper -->
        <div id="wrapper">

            <!-- sidebar -->
            <div class="main_sidebar">
                @include('layouts.frontend.sidebar')
            </div>

            <!-- contents -->
            <div class="main_content">

                <!-- header -->
                <div id="main_header">
                    @include('layouts.frontend.header')
                </div>

                <div class="main_content_wrapper">
                    @yield('content')

                    <!-- Footer menus-->
                    <div class="footer-wrapper-sidebar mt-4">
                        @include('layouts.frontend.footer')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- javaScripts -->
    <script src="{{asset('assets/js/uikit.js')}}"></script>
    <script src="{{asset('assets/js/simplebar.js')}}"></script>
    <script src="{{asset('assets/jquery/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('assets/bootstrap/popper.min.js')}}"></script>
    <script src="{{asset('assets/bootstrap/bootstrap.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>
    <script>
        function loadingproses() {
            $('.body').addClass('loader');
        }

        function loadingproses_close() {
            $('.body').removeClass('loader');
        }
    </script>
    @yield('scripts')

</body>

</html>