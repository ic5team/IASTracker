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
	{{ HTML::script('js/iastracker.api.js'); }}
	<script>
		var api = new IASTracker("<?php echo Config::get('app.url'); ?>");
	</script>
@stop

@section('head')
	<title>
		@yield('title')
	</title>

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

	<script>
		var loggedUserId = <?php echo (property_exists($data, 'usrId') ? $data->usrId : -1 ); ?>;
		var urlPublic = "<?php echo Config::get('app.url'); ?>";
		var urlImg = "<?php echo Config::get('app.urlImg'); ?>";
	</script>
@stop

