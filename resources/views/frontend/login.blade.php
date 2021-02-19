<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>Login</title>
    <meta name="description" content="HRIS">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html" />
    <link rel="icon" type="image/png" href="assets/img/favicon.png" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icon/192x192.png">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/main.css">
</head>

<body class="bg-white">

    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader no-border transparent position-absolute">
        <div class="left">
            <a href="/" class="headerButton goBack">
                <ion-icon name="arrow-back"></ion-icon>
            </a>
        </div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule" class="pt-10">

        <div class="login-form mt-1">
            <div class="section">
                <img src="assets/img/sample/photo/vector4.png" alt="image" class="form-image">
            </div>
            <div class="section mt-5">
                <h1>HRIS-Ku</h1>
                <h4>Masukkan NIP dan Password Anda</h4>
                @if($errors->any())
                    <div class="text-danger" style="text-align: center !important">
                        <strong>{{$errors->first('error')}}</strong>
                    </h6>
                @endif
            </div>
            <div class="section mt-1 mb-5">
                <form action="/login" method="post">
                    {{ csrf_field() }}
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="text" class="form-control {{ $errors->has('nip') ? 'is-invalid' : '' }}" id="nip" placeholder="NIP" name="nip" value="{{old('nip')}}">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                        @if ($errors->has('nip'))
                            <div class="text-danger">
                                <small>{{ $errors->first('nip') }}</small>
                            </div>
                        @endif
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" id="password" placeholder="Password" name="password">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                        @if ($errors->has('password'))
                            <div class="text-danger">
                                <small>{{ $errors->first('password') }}</small>
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <div class="">
                            <a href="#" class="text-muted">Lupa Password?</a>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-lg">Log in</button>

                </form>
            </div>
        </div>

    </div>
    <!-- * App Capsule -->

    <!-- ///////////// Js Files ////////////////////  -->
    <!-- Jquery -->
    <script src="assets/js/lib/jquery-3.4.1.min.js"></script>
    <!-- Bootstrap-->
    <script src="assets/js/lib/popper.min.js"></script>
    <script src="assets/js/lib/bootstrap.min.js"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.js"></script>
    <!-- Owl Carousel -->
    <script src="assets/js/plugins/owl-carousel/owl.carousel.min.js"></script>
    <!-- jQuery Circle Progress -->
    <script src="assets/js/plugins/jquery-circle-progress/circle-progress.min.js"></script>
    <!-- Base Js File -->
    <script src="assets/js/base.js"></script>

</body>

</html>