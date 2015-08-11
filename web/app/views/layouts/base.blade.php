@extends('layouts.master')

@section('header_includes')
	{{ HTML::script('//code.jquery.com/jquery-1.11.0.min.js'); }}
	{{ HTML::script('//code.jquery.com/jquery-1.11.0.min.js'); }}
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

<?php
	if(isset($data->js))
	{
	
		for($i=0; $i<count($data->js); ++$i)
		{
?>
			{{ HTML::script('js/'.$data->js[$i]); }}
<?php
		}	
	}
?>

	@section('footer_includes')
		{{-- SCRIPTS DEL FOOTER --}}
		<script>
			var urlPublic = "<?php echo Config::get('app.urlPublic'); ?>";
			var urlImg = "<?php echo Config::get('app.urlImg'); ?>";
		</script>
	@show
@stop

