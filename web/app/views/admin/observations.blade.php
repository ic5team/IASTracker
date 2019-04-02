@extends("admin.index")

@section('header_includes')
	@parent
	{{ HTML::style('css/MarkerCluster.Default.css'); }}
	{{ HTML::style('css/MarkerCluster.css'); }}
	{{ HTML::style('css/jquery.dataTables.min.css'); }}
@stop
 
@section('content')

	<div class="row">
		<div class="col-md-12">
			<input type="checkbox" id="pendingCheckBox" class="IASCheck" checked>
			<span>{{Lang::get('ui.showPendingObs')}}</span>
			<input type="checkbox" id="validatedCheckBox" class="IASCheck">
			<span>{{Lang::get('ui.showValidatedObs')}}</span>
			<input type="checkbox" id="discardedCheckBox" class="IASCheck">
			<span>{{Lang::get('ui.showDiscardedObs')}}</span>
			<br />
			<input type="checkbox" id="deletedCheckBox" class="IASCheck">
			<span>{{Lang::get('ui.showDeletedObs')}}</span>
<?php
	if($data->canViewOutOfBounds)
	{
?>
			<input type="checkbox" id="outOfBoundsCheckBox" class="IASCheck" {{$data->outOfBoundsActive ? 'checked' : ''}}>
			<span>{{Lang::get('ui.showOutOfBoundsObs')}}</span>
<?php
	}
?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<table id="dataContainer" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th> <!--Expandible row button --> </th>
						<th><!--id (hidden) --></th>
						<th>{{ Lang::get('ui.scientificName'); }}</th>
						<th>{{ Lang::get('ui.user'); }}</th>
						<th>{{ Lang::get('ui.status'); }}</th>
						<th>{{ Lang::get('ui.created'); }}</th>
						<th> <!--Buttons --> </th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th> <!--Expandible row button --> </th>
						<th><!--id (hidden) --></th>
						<th>{{ Lang::get('ui.scientificName'); }}</th>
						<th>{{ Lang::get('ui.user'); }}</th>
						<th>{{ Lang::get('ui.status'); }}</th>
						<th>{{ Lang::get('ui.created'); }}</th>
						<th> <!--Buttons --> </th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	@include('layouts.modals.validateObservation')
	@include('layouts.modals.confirm')

@stop

@section('footer_includes')
	@parent

	<script>
		var mapDescriptors = {{$data->mapProviders}};
		var crsDescriptors = JSON.parse( '{{$data->crsDescriptors}}' );
		var mapCenter = JSON.parse('{{$data->center}}');
	</script>

	{{ HTML::script('js/leaflet.markercluster.js'); }}
	{{ HTML::script('js/iastrackermap.js'); }}
	{{ HTML::script('js/jquery.dataTables.min.js'); }}
	{{ HTML::script('js/jquery.rotate.js'); }}
	{{ HTML::script('js/pages/observations.js'); }}
@stop