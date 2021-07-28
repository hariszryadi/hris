<!doctype html>
<html lang="en">

<head>

    <!-- Basic Page Needs -->
    @yield('title')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- <link rel="icon" href="assets/images/favicon.png"> --}}

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

    <!-- firebase integration started -->
    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase.js"></script>
    <!-- Firebase App is always required and must be first -->
    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase-app.js"></script>

    <!-- Add additional services that you want to use -->
    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase-database.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase-firestore.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase-messaging.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase-functions.js"></script>

    <!-- firebase integration end -->
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
                    <div class="footer-wrapper-sidebar mt-4" style="padding-left: 8px; padding-right: 8px; padding-bottom: 32px;">
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
    <script src="{{asset('js/firebase.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script>
        function loadingproses() {
            $('.body').addClass('loader');
        }

        function loadingproses_close() {
            $('.body').removeClass('loader');
        }

        $('.close').on('click', function () {
            location.reload();
        })

        $('.delete-notification').on('click', function () {
            var id = $(this).attr('data-id');
            var parent = $(this).closest('li');
            loadingproses();

            $.ajax({
                url: "{{route('destroy-notification')}}",
                method: "POST",
                data: {id:id},
                success: function (resp) {
                    // console.log(resp);
                    parent.remove();
                    loadingproses_close();
                },
                error: function (err) {
                    console.log(err)
                }
            })
        })
    </script>
    @yield('scripts')

</body>

</html>