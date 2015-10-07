@extends("admin.index")
 
@section('content')

		<div class="row" style="margin-bottom: 50px;">
			<div class="col-md-3 col-md-offset-9">
				<button id="" class="btn btn-danger" onclick="" style="float: right;">
					<div id=""> {{Lang::get('ui.add')}} </div>
				</button>
			</div>
		</div>
		<div id="addArea" style="margin-bottom: 50px;">
			<div class="row">
				<div class="col-md-3">
					<label>
						{{Lang::get('ui.areaName')}}
					</label>
				</div>
				<div class="col-md-9">
					<input type="text" id=""  value="" />
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<label>
						{{Lang::get('ui.description')}}
					</label>
				</div>
				<div class="col-md-9">
					<textarea col="50" row="20" type="text" id=""  value="" /></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<label>
						{{Lang::get('ui.zIndex')}}
					</label>
				</div>
				<div class="col-md-9">
					<input type="text" id=""  value="" />
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<label>
						{{Lang::get('ui.polygon')}}
					<label>
				</div>
				<div class="col-md-9">
					<textarea col="50" row="20" type="text" id=""  value=""></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<h4>{{Lang::get('ui.validators')}}</h4>
				</div>
			</div>
<?php
	for($i=0; $i<count($data->validators); ++$i)
	{

?>
			<div class="row">
				<div class="col-md-6">
					<label>
						{{$data->validators[$i]->fullName}}
					</label>
				</div>
				<div class="col-md-6">
					<input type="checkbox" id="isUserExpert" class="UserExpertCheck" data="">
				</div>
			</div>
<?php
	}
?>
			<div class="row" style="margin-bottom: 50px;">
				<div class="col-md-3 col-md-offset-9">
					<button id="" class="btn btn-danger" onclick="" style="float: right;">
						<div id=""> {{Lang::get('ui.store')}} </div>
					</button>
				</div>
			</div>
		</div>
		<div id="areaList">
<?php

	for($i=0; $i<count($data->areas); ++$i)
	{

		$current = $data->areas[$i];
?>
			<div class="row" style="margin-bottom: 15px;">
				<div class="col-md-10">
					<div><b>{{$current->name}}</b></div>
				</div>
				<div class="col-md-2">
					<button id="userBtn{{$current->id}}" class="btn btn-primary" onclick="saveUser({{$current->id}})">
						<div id="userBtnText{{$current->id}}"> {{Lang::get('ui.edit')}} </div>
						<img id="userLoading{{$current->id}}" src="<?php echo Config::get('app.urlImg') ?>/loader.gif" style="display:none;"/>
					</button>
				</div>
			</div>
<?php

	}

?>
		</div>
	
@stop

@section('footer_includes')
	@parent
	{{ HTML::script('js/pages/users.js'); }}
@stop