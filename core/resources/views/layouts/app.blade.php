<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Tell the browser to be responsive to screen width -->
		  <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="apple-touch-icon" sizes="57x57" href="{{asset('image/favicon.png')}}">
		<link rel="apple-touch-icon" sizes="60x60" href="{{asset('image/favicon.png')}}">
		<link rel="apple-touch-icon" sizes="72x72" href="{{asset('image/favicon.png')}}">
		<link rel="apple-touch-icon" sizes="76x76" href="{{asset('image/favicon.png')}}">
		<link rel="apple-touch-icon" sizes="114x114" href="{{asset('image/favicon.png')}}">
		<link rel="apple-touch-icon" sizes="120x120" href="{{asset('image/favicon.png')}}">
		<link rel="apple-touch-icon" sizes="144x144" href="{{asset('image/favicon.png')}}">
		<link rel="apple-touch-icon" sizes="152x152" href="{{asset('image/favicon.png')}}">
		<link rel="apple-touch-icon" sizes="180x180" href="{{asset('image/favicon.png')}}">
		<link rel="icon" type="image/png" sizes="192x192"  href="{{asset('image/favicon.png')}}">
		<link rel="icon" type="image/png" sizes="32x32" href="{{asset('image/favicon.png')}}">
		<link rel="icon" type="image/png" sizes="96x96" href="{{asset('image/favicon.png')}}">
		<link rel="icon" type="image/png" sizes="16x16" href="{{asset('image/favicon.png')}}">
		
		  <!-- Font Awesome -->
		  <link rel="stylesheet" href="{{ asset('css/plugins/fontawesome-free/css/all.min.css') }}">
		  <!-- Ionicons -->
		  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
		  <!-- daterange picker -->
		  <link rel="stylesheet" href="{{ asset('css/plugins/jquery-ui/jquery-ui.min.css') }}">
		  <link rel="stylesheet" href="{{ asset('css/plugins/daterangepicker/daterangepicker.css') }}">
	
		  <!-- iCheck for checkboxes and radio inputs -->
		  <link rel="stylesheet" href="{{ asset('css/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
		  <!-- Bootstrap Color Picker -->
		  <link rel="stylesheet" href="{{ asset('css/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
		  <!-- Tempusdominus Bbootstrap 4 -->
		  <link rel="stylesheet" href="{{ asset('css/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
		  <!-- Select2 -->
		  <link rel="stylesheet" href="{{ asset('css/plugins/select2/css/select2.min.css') }}">
		  <link rel="stylesheet" href="{{ asset('css/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
		  <!-- Bootstrap4 Duallistbox -->
		  <link rel="stylesheet" href="{{ asset('css/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
		  <!-- DataTables -->
			<link rel="stylesheet" href="{{ asset('css/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
			<link rel="stylesheet" href="{{ asset('css/plugins/bootstrap/css/responsive.bootstrap.min.css') }}">
		  <!-- Theme style -->
		  <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
	
		  <link rel="stylesheet" href="{{ asset('css/plugins/summernote/summernote-bs4.css') }}">
		  <link rel="stylesheet" href="{{ asset('css/bootstrap-toggle.min.css') }}">
		

		  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
		  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
		  <link rel="stylesheet" href="{{ asset('css/mdi/css/materialdesignicons.min.css') }}">
		  <!-- <link rel="stylesheet" href="{{ asset('css/mdi/css/vendor.bundle.base.css') }}"> -->
		  <!-- Google Font: Source Sans Pro -->
		  <!-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
		   -->
		<!-- jQuery -->
		<script src="{{ asset('css/plugins/jquery/jquery.min.js') }}"></script>
		<script src="{{ asset('css/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
		<script src="{{ asset('css/plugins/datatables/jquery.dataTables.js') }}"></script>
		<!-- DataTables -->
		<script src="{{ asset('css/plugins/datatables/jquery.dataTables.js') }}"></script>
		<script src="{{ asset('css/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
		<script src="{{ asset('css/plugins/datatables/dataTables.responsive.min.js') }}"></script>
		<script src="{{ asset('css/plugins/datatables/responsive.bootstrap.min.js') }}"></script>
		<!-- ChartJS -->
		<script src="{{ asset('js/chart.js/Chart.min.js') }}"></script>
		<!-- Sparkline -->
		<script src="{{ asset('js/sparklines/sparkline.js') }}"></script>
		<script src="{{ asset('js/jqvmap/jquery.vmap.min.js') }}"></script>
		<script src="{{ asset('js/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
		<script src="{{ asset('js/jquery-knob/jquery.knob.min.js') }}"></script>
		<script src="{{ asset('js/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
		<script src="{{ asset('js/dashboard.js') }}"></script>
		<script src="{{ asset('js/bootstrap-toggle.min.js') }}"></script>

    </head>
<body class="hold-transition sidebar-mini">
<style>
#load{
    width:100%;
    height:100%;
    position:fixed;
    z-index:9999;
    background:url("{{asset('images/ajax-loader.gif')}}") no-repeat center center rgba(0,0,0,0.25)
}
</style>
<div class="wrapper">
@include('layouts.header')
	<div class="content-wrapper">
			@yield('content')
	</div>
	@include('layouts.footer')
</div>
<script>
// document.onreadystatechange = function () {
	// var state = document.readyState
		// if (state == 'interactive') {
		   // //
		// } else if (state == 'complete') {
			// setTimeout(function(){
				// document.getElementById('load').style.visibility="hidden";
			// },1000);
		// }
	// }
</script>
    </body>
</html>
