@extends('layouts.base')

@section('header_includes')
	@parent
	{{ HTML::style('css/lightbox.css'); }}
	{{ HTML::style('css/leaflet.css'); }}
	{{ HTML::style('css/MarkerCluster.Default.css'); }}
	{{ HTML::style('css/MarkerCluster.css'); }}
	{{ HTML::style('css/bootstrap-switch.min.css'); }}
	{{ HTML::style('css/bootstrap-datetimepicker.min.css'); }}
	<?php
if(property_exists($data, 'isComplete') && !$data->isComplete)
{
?>
	{{ HTML::style('js/jcrop/css/jquery.Jcrop.min.css'); }}
<?php
}
?>
@stop

@section('footer_includes')
	@parent
	{{ HTML::script('js/jquery.fileDownload.js'); }}
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
	{{ HTML::script('js/leaflet.markercluster.js'); }}
	{{ HTML::script('js/leaflet.OverlappingMarkerSpiderfier.js'); }}
	{{ HTML::script('js/jcrop/js/jquery.Jcrop.min.js'); }}
	{{ HTML::script('js/forms/completa-usuari.js'); }}
	{{ HTML::script('js/completa-usuari.js'); }}
	{{ HTML::script('js/pages/fotos-jcrop.js'); }}
	{{ HTML::script('js/iastrackermap.js'); }}

	<script>
		var mapDescriptors = {{$data->mapProviders}};
		var crsDescriptors = JSON.parse( '{{$data->crsDescriptors}}' );
		var mapCenter = JSON.parse('{{$data->center}}');
		var shapes = {{$shapes}};
		var shapeNames = {{$shapeNames}};
		var taxonChilds = new Array();
<?php
	if($data->isLogged)
	{
?>
		var isExpert = {{($data->amIExpert) ? 'true' : 'false'}};
		var fullName = "{{('' == $data->fullName) ? '' : $data->fullName}}";
<?php
	}
	$keys = array_keys($taxonChilds);
	for($i=0; $i<count($keys); ++$i)
	{

		echo 'taxonChilds['.$keys[$i].'] = ['.implode(',', $taxonChilds[$keys[$i]]).'];';
	}
?>

	$('.langButtons').each(function(index) {
		$(this).on('click', function(e) {
			$('.langButtons').removeClass('active');
			$(this).addClass('active');
		});
	});
<?php
	if(property_exists($data, 'isComplete') && !$data->isComplete)
	{
?>

		$('#completar-dades-modal').modal();
<?php
	}

	if(property_exists($data, 'error'))
	{

?>
		$('#loginModal').modal();

<?php
	}
?>
	</script>
	{{ HTML::script('js/pages/index.js'); }}
@stop

@section('main_wrapper')
	<div class="full-width">
		<div id="map" class="map" style="position: initial">
			<div id="controls" class="mapControls ui-draggable shadow">
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
								<select name="taxonomy" id="input-group" class="form-control">
									<option value="-1" >{{Lang::get('ui.all')}}</option>
<?php
	$keys = array_keys($taxonomies);
	$numTaxonomies = count($keys);
	$str = array();
	for($i=0; $i<$numTaxonomies; ++$i)
	{

		$str[] = '<option value="'.$keys[$i].'">'.$taxonomies[$keys[$i]].'</option>';

	}
	echo implode(' ', $str);
?>
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
								<label for="input-state">{{Lang::get('ui.state')}}</label>
								<select name="state" id="input-state" class="form-control">
									<option value="-1" >{{Lang::get('ui.allStates')}}</option>
<?php
	$numStates = count($states);
	$str = array();
	for($i=0; $i<$numStates; ++$i)
	{

		$str[] = '<option value="'.$states[$i]->id.'">'.$states[$i]->name.'</option>';

	}
	echo implode(' ', $str);
?>
								</select>
								<div id="regionAndAreaSelect">
								</div>
								<div id="filterSelectLoader" style="display: none; text-align:center;">
									{{ HTML::image('img/loader.gif', 'Loading...'); }}
								</div>
							</div>
						</div>
						<div class="row alert alert-warning" id="filterError" style="display: none;">
							<div class="col-md-12" id="filterErrorMsg">
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<button role="button" class="btn btn-large btn-primary" type="button" onclick="filterObs()">{{Lang::get('ui.filter')}}</button>
								<button role="button" class="btn btn-large btn-primary" type="button" onclick="cleanFilter()">{{Lang::get('ui.cleanFilter')}}</button>
								<button role="button" class="btn btn-large btn-primary" type="button" data-toggle="modal" data-target="#downloadTypeModal"><i class="fa fa-download"></i></button>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="ias">
						<div class="row" style="text-align: center; margin-top: 20px;">
							<div class="col-md-12" id="iasContents">
								{{ HTML::image('img/loader.gif', 'Loading...'); }}
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="observationsControls" class="obsControls ui-draggable shadow">
				<div class="row">
					<div class="form-group col-md-12">
						<h4>{{Lang::get('ui.iasTrackerObservations')}}</h4>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<input type="checkbox" id="observedCheckBox" class="IASCheck" onclick="showObservations" checked>
						<span class="observedCircle"></span>
						<span>{{Lang::get('ui.invasorObserved')}}</span>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<input type="checkbox" id="validatedCheckBox" class="IASCheck" onclick="showValidatedObservations" checked>
						<span class="validatedCircle"></span>
						<span>{{Lang::get('ui.observationValidated')}}</span>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<input type="checkbox" id="discardedCheckBox" class="IASCheck" onclick="showDiscardedObservations" checked>
						<span class="discardedCircle"></span>
						<span>{{Lang::get('ui.observationDiscarded')}}</span>
					</div>
				</div>
<?php
	if(Auth::check())
	{
?>
				<div class="row">
					<div class="col-md-12">
						<input type="checkbox" id="userObsCheckBox" class="IASCheck" onclick="showOnlyUserObservations">
						<span>{{Lang::get('ui.userObsOnly')}}</span>
					</div>
				</div>
<?php
	}

	$numExternal = count($data->externalSources);
	if(0 < $numExternal)
	{
?>
				<div class="row">
					<div class="form-group col-md-12">
						<h4>{{Lang::get('ui.otherSourcesObservations')}}</h4>
					</div>
				</div>
<?php
		for($i=0; $i<$numExternal; ++$i)
		{

			$current = $data->externalSources[$i];
?>
				<div class="row">
					<div class="col-md-12">
						<input type="checkbox" id="external{{$i}}" class="IASCheck" onclick="" checked>
						<span>{{$current->name}}</span>
					</div>
				</div>
<?php
		}

	}
?>
				<div class="row">
					<div class="form-group col-md-12">
						<h4>{{Lang::get('ui.iasTrackerAreas')}}</h4>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<input type="checkbox" id="areasCheckBox" class="IASCheck" onclick="showAreas">
						<span>{{Lang::get('ui.showAreas')}}</span>
					</div>
				</div>
			</div>
		</div>
		<div id="overlay" syle="display: none;">
			<div class="spinner">
				<div class="double-bounce1"></div>
				<div class="double-bounce2"></div>
			</div>
		</div>
		@include('layouts.modals.base')
		@include('layouts.modals.download')
<?php
	if(Auth::check())
	{
?>
		@include('layouts.modals.info')
<?php
	}
?>
	</div>
@stop