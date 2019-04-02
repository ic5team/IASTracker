@extends('layouts.master')

@section('header_includes')
	{{ HTML::style('css/bootstrap.min.css'); }}
	{{ HTML::style('css/font-awesome.min.css'); }}
	{{ HTML::style('//fonts.googleapis.com/css?family=Raleway:400,600,300'); }}
	{{ HTML::style('css/iastracker.css'); }}
@stop

@section('footer_includes')
	{{ HTML::script('//code.jquery.com/jquery-1.11.0.min.js'); }}
	{{ HTML::script('//code.jquery.com/ui/1.10.4/jquery-ui.min.js'); }}
	{{ HTML::script('js/bootstrap.min.js'); }}
	{{ HTML::script('js/bootstrap-switch.min.js'); }}
	{{ HTML::script('js/common.js'); }}
	{{ HTML::script('js/pages/userNavbar.js'); }}
	{{ HTML::script('js/iastracker.api.js'); }}
	<script>
		var api = new IASTracker("<?php echo Config::get('app.url'); ?>");
	</script>
@stop

@section('head')
	<title>
		@yield('title')
	</title>
	<link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png">
	<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="/android-chrome-192x192.png" sizes="192x192">
	<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
	<link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
	<link rel="manifest" href="/manifest.json">
	<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="msapplication-TileImage" content="/mstile-144x144.png">
	<meta name="theme-color" content="#ffffff">

	@yield('header_includes')
	@section('page-metas')
		<!-- Open Graph data -->
		<meta property="og:title" content="<?php echo $data->webName; ?>"></meta>
		<meta property="og:type" content="article"></meta>
		<meta property="og:url" content="<?php echo Config::get('app.url')?>"></meta>
		<meta property="og:image" content=" <?php echo Config::get('app.publicURL').'images/thumbs/'.$data->logo; ?>"></meta>
		<meta property="og:description" content="<?php echo $data->description; ?>"></meta>
		<meta property="og:site_name" content="<?php echo $data->webName; ?>"></meta>
	@show

@stop

@section('body')
	@section('page_header')
		@include('layouts.widgets.user-navbar')
	@show

	@yield('main_wrapper')
	@include('layouts.modals.login')
	@include('layouts.modals.signup')
	@include('layouts.modals.remind')

	<script>
		var loggedUserId = <?php echo (property_exists($data, 'usrId') ? $data->usrId : -1 ); ?>;
		var urlPublic = "<?php echo Config::get('app.url'); ?>";
		var urlImg = "<?php echo Config::get('app.urlImg'); ?>";
	</script>
@stop
