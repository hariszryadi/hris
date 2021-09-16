<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>HRIS.TEDC-Admin</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/admin/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/admin/css/bootstrap.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/admin/css/core.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/admin/css/components.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/admin/css/colors.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets/admin/css/main.css')}}" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="{{asset('assets/admin/js/core/libraries/jquery.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/admin/js/core/libraries/bootstrap.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/admin/js/plugins/loaders/blockui.min.js')}}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script type="text/javascript" src="{{asset('assets/admin/js/core/app.js')}}"></script>
	<!-- /theme JS files -->
</head>

<body class="page-container">
    <!-- Content area -->
    <div class="content d-flex justify-content-center align-items-center" style="margin-top: 100px;">

        <!-- Container -->
        <div class="flex-fill">

            <!-- Error title -->
            <div class="text-center">
				<h1 class="error-title">404</h1>
				<img src="{{asset('images/logo.png')}}" alt="" style="width: 200px;">
                <h3>Oops, Maaf halaman tidak ditemukan!</h3>
                @if (auth()->guard('user'))
					<a href="{{route('dashboard')}}"><h3>Kembali ke halaman Dashboard</h3></a>
				@else
					<a href="{{route('admin.dashboard')}}"><h3>Kembali ke halaman Dashboard</h3></a>
				@endif
            </div>
            <!-- /error title -->

        </div>
        <!-- /container -->

    </div>
    <!-- /content area -->
</body>