@extends("layouts.base")
 
@section('header_includes')
	@parent
	{{ HTML::style('css/bootstrap-switch.min.css'); }}
	{{ HTML::style('css/bootstrap-datetimepicker.min.css'); }}
	{{ HTML::style('css/iastracker.admin.css'); }}
@stop

@section('footer_includes')
	@parent
	{{ HTML::script('js/ca.js'); }}
	{{ HTML::script('js/transition.js'); }}
	{{ HTML::script('js/collapse.js'); }}
	{{ HTML::script('js/bootstrap-datetimepicker.min.js'); }}

	<script>
		$('.langButtons').each(function(index) {
			$(this).on('click', function(e) {
				$('.langButtons').removeClass('active');
				$(this).addClass('active');
			});
		});
	</script>

	{{ HTML::script('js/pages/admin.js'); }}
@stop

@section('main_wrapper')
	<div class="container" style="margin-top: 50px;">
		<div class="col-md-3 menu">
			<div class="row">
				<div class="col-md-12"><a href="admin" >{{Lang::get('ui.users')}}</a></div>
				<div class="col-md-12"><a href="admin/observations" >{{Lang::get('ui.obs')}}</a></div>
			</div>
		</div>
		<div class="col-md-9 menu">
			<div class="row">
				<div class="col-md-12">
					@yield('content')
				</div>
			</div>
		</div>
	</div>
@stop