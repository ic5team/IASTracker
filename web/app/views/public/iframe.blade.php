@extends("layouts.base")
 
@section("title")
@stop

@section('section-title')
@stop

@section('breadcrumb-container')
@stop

@section('main_wrapper')
	<div class="container" style="overflow: hidden;">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<iframe src="{{$data->url}}" frameborder="0" scrolling="no" id="iframe" onload='resizeIframe(this);' style="width: 100%;"></iframe>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
@stop

@section('header_includes')
	@parent
	<script>
		function resizeIframe(obj) {
			obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
		}
	</script>
@stop