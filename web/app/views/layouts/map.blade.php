@extends('layouts.base')

@section('header_includes')
	@parent
	{{ HTML::style('css/leaflet.css'); }}
	{{ HTML::style('css/bootstrap-switch.min.css'); }}
	{{ HTML::style('css/bootstrap-datetimepicker.min.css'); }}
@stop

@section('footer_includes')
	@parent
	{{ HTML::script('js/leaflet.js'); }}
	{{ HTML::script('js/proj4-compressed.js'); }}
	{{ HTML::script('js/proj4leaflet.js'); }}
	{{ HTML::script('js/moment.js'); }}
	{{ HTML::script('js/ca.js'); }}
	{{ HTML::script('js/transition.js'); }}
	{{ HTML::script('js/collapse.js'); }}
	{{ HTML::script('js/bootstrap-datetimepicker.min.js'); }}
	{{ HTML::script('js/iastrackermap.js'); }}
	{{ HTML::script('js/iastracker.api.js'); }}
	<script>
		var mapDescriptors = {{$data->mapProviders}};
		var crsDescriptors = JSON.parse( '{{$data->crsDescriptors}}' );
		var mapCenter = JSON.parse('{{$data->center}}');
		var api = new IASTracker("<?php echo Config::get('app.urlPublic'); ?>");
	</script>
	{{ HTML::script('js/pages/index.js'); }}
@stop

@section('main_wrapper')
	<div class="full-width">
		<div id="map" class="map">
			<div id="controls" class="mapControls ui-draggable">
				<!-- Nav tabs -->
				<ul id="tabsControls" class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active">
						<a href="#filter" aria-controls="filter" role="tab" data-toggle="tab"><i class="fa fa-2x fa-filter"></i></a>
					</li>
					<li role="presentation">
						<a href="#layersControl" aria-controls="layersControl" role="tab" data-toggle="tab"><img src="img/layers.png"/></a>
					</li>
					<li role="presentation">
						<a href="#ias" aria-controls="ias" role="tab" data-toggle="tab"><i class="fa fa-2x fa-list"></i></a>
					</li>
				</ul>
				<!-- Tab panes -->
				<div class="tab-content" class="tabContent">
					<div role="tabpanel" class="tab-pane" id="layersControl"></div>
					<div role="tabpanel" class="tab-pane active" id="filter">
						<div class="row">
							<div class="form-group col-md-12">
								<span><b>{{Lang::get('ui.taxonomy')}}</b> <br /></span>
								<label for="input-grup">{{Lang::get('ui.group')}}</label>
								<select name="taxonomy" id="input-grup" class="form-control">
									<option value="0" >{{Lang::get('ui.all')}}</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-12">
								<span><b>{{Lang::get('ui.date')}}</b> <br /></span>
								<label for="input-grup">{{Lang::get('ui.from')}}</label>
								<div class="input-group date datetimepicker">
									<input type='text' class="form-control" name="fromDate" id="fromDate"/>
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
								<label for="input-grup">{{Lang::get('ui.to')}}</label>
								<div class="input-group date datetimepicker">
									<input type="text" class="form-control" name="toDate" id="toDate"/>
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-12">
								<span><b>{{Lang::get('ui.location')}}</b> <br /></span>
								<label for="input-grup">{{Lang::get('ui.state')}}</label>
								<select name="state" id="input-grup" class="form-control">
									<option value="0" >{{Lang::get('ui.allStates')}}</option>
								</select>
								<label for="input-grup">{{Lang::get('ui.region')}}</label>
								<select name="regions" id="input-grup" class="form-control">
									<option value="0" >{{Lang::get('ui.allRegions')}}</option>
								</select>
								<label for="input-grup">{{Lang::get('ui.areas')}}</label>
								<select name="areas" id="input-grup" class="form-control">
									<option value="0" >{{Lang::get('ui.allAreas')}}</option>
								</select>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="ias">
						<div class="row" style="text-align: center; margin-top: 20px;" id="iasContents">
							<div class="col-md-12" >
								{{ HTML::image('img/loader.gif', 'Loading...'); }}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop