@extends("admin.index")
 
@section('content')

<?php

	$rows = array();
	for($i=0; $i<count($data->obs); ++$i)
	{

		$current = $data->obs[$i];
?>
		<div class="row">
			<div class="col-md-3">
				<img src="{{Config::get('app.urlImg').$current->ias->image->url}}" style="width:100px;" />
			</div>
			<div class="col-md-6">
				<div><b>{{$current->ias->latinName}}</b></div>
				<div>{{$current->ias->description->name}}</div>
				<div>{{Lang::get('ui.howMany').' '.(1 == $current->howMany ? Lang::get('ui.one') : (2 == $current->howMany) ? Lang::get('ui.few') : Lang::get('ui.several'))}}</div>
				<div>{{$current->created_at}}</div>
			</div>
			<div class="col-md-3">
				<button>{{Lang::get('ui.validate')}}</button>
				<button>{{Lang::get('ui.discard')}}</button>
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