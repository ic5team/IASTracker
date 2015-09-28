@extends("admin.index")
 
@section('content')

		<div class="panel-group" id="accordion" class="accordion" role="tablist" aria-multiselectable="true">

<?php

	$rows = array();
	if(count($data->obs))
	{

		for($i=0; $i<count($data->obs); ++$i)
		{

			$current = $data->obs[$i];
?>
				<div id="panel{{$current->id}}" class="panel panel-default">
					<div class="panel-heading" role="tab" id="heading">
						<h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$current->id}}" aria-expanded="false" aria-controls="collapse{{$current->id}}">
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
										<div id="obs{{$current->id}}Buttons">
											<button onclick="validate({{$current->id}})">{{Lang::get('ui.validate')}}</button>
											<button onclick="discard({{$current->id}})">{{Lang::get('ui.discard')}}</button>
										</div>
										<div id="loading{{$current->id}}" style="display:none;">
											<img src="{{Config::get('app.urlImg')}}/loader.gif">
										</div>
									</div>
								</div>
							</a>
						</h4>
					</div>
					<div id="collapse{{$current->id}}" data-id="{{$current->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
						<div class="panel-body">
							<h1>{{Lang::get('ui.obsDescriptionTitle')}}</h1>
							{{$current->notes}}
							<h1>{{Lang::get('ui.obsImageTitle')}}</h1>
<?php
			for($j=0; $j<count($current->images); ++$j)
			{
?>
							<img src="{{Config::get('app.urlImg').$current->images[$j]->URL}}" style="width: 150px;" />
<?php
			}
?>
						</div>
					</div>
				</div>
<?php

		}

	}
	else
	{

?>

		{{Lang::get('ui.noObservationsToValidate')}}

<?php
	}

?>
		</div>
	
@stop

@section('footer_includes')
	@parent

	<script>
		var mapDescriptors = {{$data->mapProviders}};
		var crsDescriptors = JSON.parse( '{{$data->crsDescriptors}}' );
		var mapCenter = JSON.parse('{{$data->center}}');
	</script>

	{{ HTML::script('js/iastrackermap.js'); }}
	{{ HTML::script('js/pages/observations.js'); }}
@stop