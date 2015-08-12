@extends("layouts.map")
 
@section("title")
	{{Lang::get('ui.inici')}}
@stop

@section('section-title')
	{{Lang::get('ui.inici')}}
@stop

@section('main_wrapper')
	@parent
	@include('layouts.modals.signup')
	@include('layouts.modals.login')
	@include('layouts.modals.base')
@stop