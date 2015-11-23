@extends("layouts.base")
 
@section("title")
	{{Lang::get('ui.cookieTitle')}}
@stop

@section('section-title')
	{{Lang::get('ui.cookieTitle')}}
@stop

@section('breadcrumb-container')
@stop

@section('main_wrapper')
	<div class="full-width" style="overflow: hidden;">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div id="titol" style="text-align:center">
					<h2>{{Lang::get('ui.cookieTitle')}}</h2>
				</div>
				<div>
					{{Lang::get('ui.cookieText')}}
				</div>
				<div id="titol" style="text-align:center">
					<h2>{{Lang::get('ui.usedCookiesTitle')}}</h2>
				</div>
				<div>
					{{Lang::get('ui.usedCookiesText')}}
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
@stop