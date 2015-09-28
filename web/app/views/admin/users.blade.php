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
			<div class="col-md-6">
				<div><b>{{$current->fullName}}</b></div>
				<div>{{Lang::get('ui.observationsNumber', array('num' => $current->numObs))}}</div>
				<div>{{Lang::get('ui.validatedNumber', array('num' => $current->numValidated))}}</div>
				<div>{{Lang::get('ui.areYouAnExpert').' '.(($current->amIExpert) ? Lang::get('ui.yes') : Lang::get('ui.no'))}}</div>
			</div>
			<div class="col-md-3">
				<label>
					{{Lang::get('ui.isExpert')}}
					<input type="checkbox" class="UserExpertCheck" data="{{$current->id}}" {{ $current->isExpert ? 'checked' : '' }} >
				</label>
				<label>
					{{Lang::get('ui.isAdmin')}}
					<input type="checkbox" class="UserExpertCheck" data="{{$current->id}}" {{ $current->isAdmin ? 'checked' : '' }} >
				</label>
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