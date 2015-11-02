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
			<input type="checkbox" id="deletedCheckBox" class="IASCheck">
			<span>{{Lang::get('ui.showDeletedObs')}}</span>
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
	<div id="validationModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body" id="contentModalContents">
					<div class="row">
						<div class="col-md-12">
							{{Lang::get('ui.addValidationText')}}
						</div>
					</div>
					<div class="row" style="text-align: center;">
						<div class="col-md-12">
							<textarea id="validationText" col="100" row="50" type="text" value="" style="width: 100%; height: 250px;"></textarea>
						</div>
					</div>
					<div id="validationTextError" class="row alert alert-danger" style="display:none;">
						<div class="col-md-12">
							{{Lang::get('ui.validationTextError')}}
						</div>
					</div>
					<div id="serverError" class="row alert alert-danger" style="display:none;">
						<div class="col-md-12" id="serverErrorMessage">
						</div>
					</div>
					<div class="modal-footer">
						<div id="modalButtons">
							<button id="validateButton" type="button" class="btn btn-success">{{Lang::get('ui.validate')}}</button>
							<button id="discardButton" type="button" class="btn btn-success" style="display:none;">{{Lang::get('ui.discard')}}</button>
							<button type="button" class="btn btn-danger" data-dismiss="modal">{{Lang::get('ui.dismissAction')}}</button>
						</div>
						<div id="modalLoading" style="display:none;">
							<img src="{{Config::get('app.urlImg')}}/loader.gif" />
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

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
	{{ HTML::script('js/pages/observations.js'); }}
@stop