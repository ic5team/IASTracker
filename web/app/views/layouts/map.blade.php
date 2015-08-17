@extends('layouts.base')

@section('header_includes')
	@parent
	{{ HTML::style('css/leaflet.css'); }}
	{{ HTML::style('css/bootstrap-switch.min.css'); }}
@stop

@section('footer_includes')
	@parent
	{{ HTML::script('js/leaflet.js'); }}
	{{ HTML::script('js/proj4-compressed.js'); }}
	{{ HTML::script('js/proj4leaflet.js'); }}
	{{ HTML::script('js/iastrackermap.js'); }}
	<script>
		var mapDescriptors = JSON.parse( {{$data->mapProviders}} );
		var crsDescriptors = JSON.parse( {{$data->crsDescriptors}} );
		var mapHandler = new MapHandler("map", "#layersControl", "#controls", mapDescriptors, crsDescriptors);
	</script>
@stop

@section('main_wrapper')
	<div class="full-width">
		<div id="map" class="map">
			<div id="controls" class="mapControls ui-draggable">
				<!-- Nav tabs -->
				<ul id="tabsControls" class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active">
						<a href="#layersControl" aria-controls="layersControl" role="tab" data-toggle="tab"><img src="img/layers.png"/></a>
					</li>
					<li role="presentation">
						<a href="#filter" aria-controls="filter" role="tab" data-toggle="tab"><i class="fa fa-2x fa-filter"></i></a>
					</li>
					<li role="presentation">
						<a href="#ias" aria-controls="ias" role="tab" data-toggle="tab"><i class="fa fa-2x fa-list"></i></a>
					</li>
				</ul>
				<!-- Tab panes -->
				<div class="tab-content" class="tabContent">
					<div role="tabpanel" class="tab-pane active" id="layersControl"></div>
					<div role="tabpanel" class="tab-pane" id="filter">
					</div>
					<div role="tabpanel" class="tab-pane" id="ias">
						<div class="row">
							<div class="form-group col-md-12">
								<span><b>{{Lang::get('ui.taxonomy')}}</b> <br /></span>
								<label for="input-grup">{{Lang::get('ui.group')}}</label>
								<select name="Sexe" id="input-grup" class="form-control">
									<option value="0" >{{Lang::get('ui.all')}}</option>
								</select>
							</div>
						</div>
						<div class="row" style="text-align: center;">
							<div class="col-md-12">
								<div class="btn-group" role="group" aria-label="...">
									<button type="button" class="btn btn-default">{{Lang::get('ui.commonName')}}</button>
									<button type="button" class="btn btn-default">{{Lang::get('ui.scientificName')}}</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop