@extends("layouts.base")
	
@section('footer_includes')
	@parent
@stop
 
@section("title")
	{{Lang:get('ui.inici')}}
@stop

@section('section-title')
	{{Lang:get('ui.inici')}}
@stop

@section('main_wrapper')
	<div class="full-width">
	</div>
	@include('layouts.modals.signup')
	@include('layouts.modals.login')
	@include('layouts.modals.base')
@stop