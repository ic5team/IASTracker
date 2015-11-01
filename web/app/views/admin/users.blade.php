@extends("admin.index")
 
@section('content')

<?php

	$rows = array();
	for($i=0; $i<count($data->users); ++$i)
	{

		$current = $data->users[$i];
?>
		<div class="row">
			<div class="col-md-3">
				<img src="{{Config::get('app.urlImgThumbs').$current->photoURL}}" style="width:100px;" />
			</div>
			<div class="col-md-5">
				<div><b>{{$current->fullName or Lang::get('ui.noNameUser')}}</b></div>
				<div>{{Lang::get('ui.observationsNumber', array('num' => $current->numObs))}}</div>
				<div>{{Lang::get('ui.validatedNumber', array('num' => $current->numValidated))}}</div>
				<div>{{Lang::get('ui.areYouAnExpert').' '.(($current->amIExpert) ? Lang::get('ui.yes') : Lang::get('ui.no'))}}</div>
			</div>
			<div class="col-md-4">
				<label>
					{{Lang::get('ui.isExpert')}}
					<input type="checkbox" id="isUserExpert{{$current->id}}" class="UserExpertCheck" data="{{$current->id}}" {{ $current->isExpert ? 'checked' : '' }} >
				</label>
				<label>
					{{Lang::get('ui.isAdmin')}}
					<input type="checkbox" id="isUserAdmin{{$current->id}}" class="UserExpertCheck" data="{{$current->id}}" {{ $current->isAdmin ? 'checked' : '' }} >
				</label>
				<label>
					{{Lang::get('ui.isValidator')}}
					<input type="checkbox" id="isUserValidator{{$current->id}}" class="UserExpertCheck" data="{{$current->id}}" {{ $current->isValidator ? 'checked' : '' }} >
				</label>
				<label>
					{{Lang::get('ui.organization')}}
					<input type="text" id="userOrganization{{$current->id}}"  value="{{$current->organization}}" />
				</label>
				<button id="userBtn{{$current->id}}" class="btn btn-primary" onclick="saveUser({{$current->id}})">
					<div id="userBtnText{{$current->id}}"> {{Lang::get('ui.store')}} </div>
					<img id="userLoading{{$current->id}}" src="<?php echo Config::get('app.urlImg') ?>/loader.gif" style="display:none;"/>
				</button>
				
			</div>
		</div>
<?php

	}

?>
	
@stop

@section('footer_includes')
	@parent
	{{ HTML::script('js/pages/users.js'); }}
@stop