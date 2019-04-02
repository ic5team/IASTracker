@extends("layouts.base")
 
@section('header_includes')
	@parent
	{{ HTML::style('css/bootstrap-switch.min.css'); }}
	{{ HTML::style('css/bootstrap-datetimepicker.min.css'); }}
	{{ HTML::style('css/lightbox.css'); }}
	{{ HTML::style('css/leaflet.css'); }}
	{{ HTML::style('css/iastracker.admin.css'); }}
@stop

@section('footer_includes')
	@parent
	{{ HTML::script('js/lightbox.min.js'); }}
	{{ HTML::script('js/leaflet.js'); }}
	{{ HTML::script('js/proj4-compressed.js'); }}
	{{ HTML::script('js/proj4leaflet.js'); }}
	{{ HTML::script('http://maps.google.com/maps/api/js?v=3.2&sensor=false')}}
	{{ HTML::script('js/moment.js'); }}
	{{ HTML::script('js/ca.js'); }}
	{{ HTML::script('js/transition.js'); }}
	{{ HTML::script('js/collapse.js'); }}
	{{ HTML::script('js/bootstrap-datetimepicker.min.js'); }}
	{{ HTML::script('js/catiline.js'); }}
	{{ HTML::script('js/leaflet.shapefile.js'); }}
	{{ HTML::script('js/leaflet.OverlappingMarkerSpiderfier.js'); }}

	<script>
		$('.langButtons').each(function(index) {
			$(this).on('click', function(e) {
				$('.langButtons').removeClass('active');
				$(this).addClass('active');
			});
		});
	</script>

@stop

@section('main_wrapper')
	<div class="container" style="margin-top: 50px;">
		<div class="col-md-2 menu">
			<div class="row">
				<div class="col-md-12"><a href="{{Config::get('app.url')}}admin/observations?lang={{App::getLocale()}}" >{{Lang::get('ui.obs')}}</a></div>
			</div>
<?php
	if($data->isAdmin)
	{
?>
			<div class="row">
				<div class="col-md-12"><a href="{{Config::get('app.url')}}admin/users?lang={{App::getLocale()}}" >{{Lang::get('ui.users')}}</a></div>
			</div>
			<div class="row">
				<div class="col-md-12"><a href="{{Config::get('app.url')}}admin/ias?lang={{App::getLocale()}}" >{{Lang::get('ui.ias')}}</a></div>
			</div>
			<div class="row">
				<div class="col-md-12"><a href="{{Config::get('app.url')}}admin/areas?lang={{App::getLocale()}}" >{{Lang::get('ui.areas')}}</a></div>
			</div>
<?php
	}
?>	
		</div>
		<div class="col-md-10 menu">
			<div class="row">
				<div class="col-md-12">
					@yield('content')
				</div>
			</div>
		</div>
	</div>
@stop