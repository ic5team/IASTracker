@extends('layouts.base')

@section('main_wrapper')
	<div class="full-width">
		<div class="row">
			<div class="col-md-8 col-md-offset-2" style="text-align:center;">
				<img src="{{Config::get('app.url')}}/img/thumbs/logoComplet.png" />
				<h1>{{Lang::get('ui.notFound')}}</h1>
			</div>
		</div>
	</div>
@stop