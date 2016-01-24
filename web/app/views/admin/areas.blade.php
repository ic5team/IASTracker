@extends("admin.index")

@section('header_includes')
	@parent
	{{ HTML::style('css/jquery.dataTables.min.css'); }}
@stop
 
@section('content')

	<div class="row" style="margin-bottom: 50px;">
		<div class="col-md-3 col-md-offset-9">
			<button id="" class="btn btn-danger" onclick="addArea()" style="float: right;">
				<div id=""> {{Lang::get('ui.add')}} </div>
			</button>
		</div>
	</div>
	<div class="row" id="areaList">
		<div class="col-md-12">
			<table id="dataContainer" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th> <!--Expandible row button --> </th>
						<th><!--id (hidden) --></th>
						<th>{{ Lang::get('ui.areaName'); }}</th>
						<th>{{ Lang::get('ui.zIndex'); }}</th>
						<th>{{ Lang::get('ui.created'); }}</th>
						<th> <!--Buttons --> </th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th> <!--Expandible row button --> </th>
						<th><!--id (hidden) --></th>
						<th>{{ Lang::get('ui.areaName'); }}</th>
						<th>{{ Lang::get('ui.zIndex'); }}</th>
						<th>{{ Lang::get('ui.created'); }}</th>
						<th> <!--Buttons --> </th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	<div id="addArea" style="display:none;">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group" id="form-areaName">
					<label for="areaName">{{Lang::get('ui.areaName')}}</label>
					<input name="areaName" type="text" class="form-control block" id="input-areaName" value="">
					<span id="error-areaName" class="help-block hidden">{{Lang::get('ui.requiredField')}}</span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group" id="form-zIndex">
					<label for="zIndex" >{{Lang::get('ui.zIndex')}}</label>
					<input name="zIndex" type="text" class="form-control block" id="input-zIndex" value="">
					<span id="error-zIndex" class="help-block hidden">{{Lang::get('ui.requiredField')}}</span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group" id="form-shapeFile">
					<label for="shapeFile" >{{Lang::get('ui.shapeFile')}}<i style="margin-left: 10px;" class="fa fa-question-circle" data-toggle="tooltip" data-placement="right" title="{{Lang::get('ui.shapeFileInfo')}}"></i></label>
					<input type="file" name="shapeFile" class="form-control block" id="input-shapeFile">
					<span id="error-shapeFile" class="help-block hidden">{{Lang::get('ui.requiredField')}}</span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group" id="form-geom">
					<label for="geom">{{Lang::get('ui.polygon')}}<i style="margin-left: 10px;" class="fa fa-question-circle" data-toggle="tooltip" data-placement="right" title="{{Lang::get('ui.polygonInfo')}}"></i></label>
					<textarea name="geom" type="text" class="form-control block" id="input-geom"></textarea>
					<span id="error-geom" class="help-block hidden">{{Lang::get('ui.requiredField')}}</span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<h4>{{Lang::get('ui.validators')}}</h4>
			</div>
		</div>
<?php
for($i=0; $i<count($validators); ++$i)
{

?>
		<div class="row">
			<div class="col-md-6">
				<label>
					{{$validators[$i]->fullName}}
				</label>
			</div>
			<div class="col-md-6">
				<input type="checkbox" id="isAreaValidator" class="NewAreaValidatorCheck" data="" {{($validators[$i]->isChecked ? 'checked' : '' )}}>
			</div>
		</div>
<?php
}
?>
		<div class="row alert alert-danger" id="error-Area" style="display: none;">
			{{Lang::get('ui.errorStoring')}}
		</div>
		<div class="row" style="margin-bottom: 50px;">
			<div class="col-md-3 col-md-offset-9">
				<button id="" class="btn btn-danger" onclick="dismiss()" style="float: right;">
					<div id=""> {{Lang::get('ui.dismissAction')}} </div>
				</button>
				<button id="areaNewBtn" class="btn btn-success" onclick="store()">
					<div id="areaNewBtnText"> {{Lang::get('ui.store')}} </div>
					<img id="areaNewLoading" src="<?php echo Config::get('app.urlImg') ?>/loader.gif" style="display:none;"/>
				</button>
			</div>
		</div>
	</div>
	@include('layouts.modals.confirm')
@stop

@section('footer_includes')
	@parent
	{{ HTML::script('js/jquery.dataTables.min.js'); }}
	{{ HTML::script('js/pages/areas.js'); }}
@stop