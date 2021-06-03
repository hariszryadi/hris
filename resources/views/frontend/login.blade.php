<!doctype html>
<html lang="en">

<head>

    <!-- Basic Page Needs
    ================================================== -->
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Simplest is - Professional A unique and beautiful collection of UI elements">
    {{-- <link rel="icon" href="assets/images/favicon.png"> --}}

    <!-- CSS 
    ================================================== -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/uikit.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">

    <!-- icons
    ================================================== -->
    <link rel="stylesheet" href="{{asset('assets/css/icons.css')}}">
    <script src="https://kit.fontawesome.com/815e388c50.js" crossorigin="anonymous"></script>

    <!-- Google font
    ================================================== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

</head>

<body class="bg-white">

    <!-- Content
    ================================================== -->
    <div uk-height-viewport class="uk-flex uk-flex-middle">
        <div class="uk-width-2-3@m uk-width-1-2@s m-auto rounded uk-overflow-hidden shadow-lg">
            <div class="uk-child-width-1-2@m uk-grid-collapse bg-gradient-primary" uk-grid>

                <!-- column one -->
                <div class="uk-margin-auto-vertical uk-text-center uk-animation-scale-up p-3 uk-light">
                    <img src="{{asset('images/logo.png')}}" alt="">
                    {{-- <h3 class="mb-3 mt-lg-4"> Simplest</h3> --}}
                    {{-- <p>Share what's new and life moments with <br> your friends. </p> --}}
                </div>

                <!-- column two -->
                <div class="uk-card-default px-5 py-8">
                    <div class="mb-4 uk-text-center">
                        <h2 class="mb-0">Welcome To HRIS.TEDC</h3>
                        <p class="my-2">Masukkan NIP dan Password Anda.</p>
                        @if($errors->any())
                            <div class="text-danger" style="text-align: center !important">
                                <strong>{{$errors->first('error')}}</strong>
                            </h6>
                        @endif
                    </div>
                    <form action="{{route('login')}}" method="post">
                        {{ csrf_field() }}
                        <div class="uk-form-group">
                            <label class="uk-form-label" style="text-align: left;">NIP</label>

                            <div class="uk-position-relative w-100">
                                <span class="uk-form-icon">
                                    <i class="icon-feather-user"></i>
                                </span>
                                <input class="uk-input {{ $errors->has('nip') ? 'is-invalid' : '' }}" name="nip" type="text" placeholder="Masukkan NIP">
                            </div>
                            @if ($errors->has('nip'))
                                <div class="text-danger" style="text-align: left;">
                                    <small>{{ $errors->first('nip') }}</small>
                                </div>
                            @endif

                        </div>

                        <div class="uk-form-group">
                            <label class="uk-form-label" style="text-align: left;"> Password</label>

                            <div class="uk-position-relative w-100">
                                <span class="uk-form-icon">
                                    <i class="icon-feather-lock"></i>
                                </span>
                                <input class="uk-input {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" type="password" placeholder="Masukkan Password">
                            </div>
                            @if ($errors->has('password'))
                                <div class="text-danger" style="text-align: left;">
                                    <small>{{ $errors->first('password') }}</small>
                                </div>
                            @endif

                        </div>

                        <div class="mt-4 uk-flex-middle uk-grid-small" uk-grid>
                            <div class="uk-width-auto@s">
                                <button type="submit" class="button primary">Login</button>
                            </div>
                        </div>

                    </form>
                </div><!--  End column two -->

            </div>
        </div>
    </div>

    <!-- Content -End
    ================================================== -->

    <!-- javaScripts
    ================================================== -->
    <script src="{{asset('assets/js/uikit.js')}}"></script>
    <script src="{{asset('assets/js/simplebar.js')}}"></script>

</body>

</html>