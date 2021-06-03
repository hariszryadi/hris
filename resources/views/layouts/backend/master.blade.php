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
	<script type="text/javascript" src="{{asset('assets/admin/js/plugins/loaders/pace.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/admin/js/core/libraries/jquery.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/admin/js/core/libraries/bootstrap.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/admin/js/plugins/loaders/blockui.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/admin/js/plugins/notifications/sweet_alert.min.js')}}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script type="text/javascript" src="{{asset('assets/admin/js/plugins/forms/styling/uniform.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/admin/js/plugins/forms/selects/bootstrap_multiselect.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/admin/js/core/app.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/admin/js/plugins/forms/selects/select2.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/admin/js/plugins/tables/datatables/datatables.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/admin/js/plugins/tables/datatables/extensions/responsive.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/admin/js/pages/datatables_responsive.js')}}"></script>
	<!-- /theme JS files -->
</head>

<body class="navbar-top">

	<!-- Main navbar -->
	@include('layouts.backend.header')
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main sidebar -->
			@include('layouts.backend.sidebar')
			<!-- /main sidebar -->


			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4>
								<span class="text-semibold">
									@yield('title-header')
                                </span> 
                            </h4>
						</div>

					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="#"><i class="icon-home2 position-left"></i> Home</a></li>

                            <li class="active">
                                <a href="#">@yield('menus')</a> / @yield('submenus')
                            </li>
							
						</ul>
						
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
					@include('helper.alert')
					@yield('content')
				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->

	@yield('scripts')
</body>
</html>