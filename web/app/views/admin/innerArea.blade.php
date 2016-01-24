		<div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group" id="form-areaName{{$current->id}}">
						<label for="areaName" data-id="{{$current->id}}">{{Lang::get('ui.areaName')}}</label>
						<input name="areaName" type="text" class="form-control block" id="input-areaName{{$current->id}}" data-id="{{$current->id}}" value="{{$current->name}}">
						<span id="error-areaName{{$current->id}}" class="help-block hidden">{{Lang::get('ui.requiredField')}}</span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group" id="form-zIndex{{$current->id}}">
						<label for="zIndex" data-id="{{$current->id}}">{{Lang::get('ui.zIndex')}}</label>
						<input name="zIndex" type="text" class="form-control block" id="input-zIndex{{$current->id}}" data-id="{{$current->id}}" value="{{$current->zIndex}}">
						<span id="error-zIndex{{$current->id}}" class="help-block hidden">{{Lang::get('ui.requiredField')}}</span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group" id="form-shapeFile{{$current->id}}">
						<label for="shapeFile" data-id="{{$current->id}}">{{Lang::get('ui.shapeFile')}}<i style="margin-left: 10px;" class="fa fa-question-circle" data-toggle="tooltip" data-placement="right" title="{{Lang::get('ui.shapeFileInfo')}}"></i></label>
						<input name="currentShapeFile" type="text" class="form-control block" id="input-currentShapeFile{{$current->id}}" data-id="{{$current->id}}" value="{{$current->shapeFileURL}}" disabled>
						<input type="file" name="shapeFile" class="form-control block" id="input-shapeFile{{$current->id}}" accept=".zip">
						<span id="error-shapeFile{{$current->id}}" class="help-block hidden">{{Lang::get('ui.requiredField')}}</span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group" id="form-geom{{$current->id}}">
						<label for="geom">{{Lang::get('ui.polygon')}}<i style="margin-left: 10px;" class="fa fa-question-circle" data-toggle="tooltip" data-placement="right" title="{{Lang::get('ui.polygonInfo')}}"></i></label>
						<textarea name="geom" type="text" class="form-control block" id="input-geom{{$current->id}}" data-id="{{$current->id}}" rows=10>{{$current->geom}}</textarea>
						<span id="error-geom{{$current->id}}" class="help-block hidden">{{Lang::get('ui.requiredField')}}</span>
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
					<input type="checkbox" id="isAreaValidator" class="AreaValidatorCheck" data-id="{{$current->id}}" data-validator="{{$validators[$i]->userId}}" {{($validators[$i]->isChecked ? 'checked' : '' )}}>
				</div>
			</div>
<?php
	}
?>
			<div class="row alert alert-danger" id="error-Area{{$current->id}}" style="display: none;">
				{{Lang::get('ui.errorStoring')}}
			</div>
			<div class="row" style="margin-bottom: 50px;">
				<div class="col-md-3 col-md-offset-9">
					<button id="areaEditBtn{{$current->id}}" class="btn btn-success" onclick="edit({{$current->id}})">
						<div id="areaEditBtnText{{$current->id}}"> {{Lang::get('ui.store')}} </div>
						<img id="areaEditLoading{{$current->id}}" src="<?php echo Config::get('app.urlImg') ?>/loader.gif" style="display:none;"/>
					</button>
				</div>
			</div>
		</div>