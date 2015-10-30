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
										<div>{{Lang::get('ui.user').': '.(null != $current->user ? $current->user->username.' ('.$current->user->observations.' '.Lang::get('ui.observations').' | '.$current->user->validated.' '.Lang::get('ui.validated').' )' : Lang::get('ui.userUnknown'))}}</div>
									</div>
									<div class="col-md-3">
										<button onclick="showValidationModal({{$current->id}}, true)" class="btn btn-success insideCollapseButton" >{{Lang::get('ui.validate')}}</button>
										<button onclick="showValidationModal({{$current->id}}, false)" class="btn btn-danger insideCollapseButton" >{{Lang::get('ui.discard')}}</button>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12" style="text-align:center;">
										<i id="obs{{$current->id}}Arrow" class="fa fa-angle-down"></i>
									</div>
								</div>
							</a>
						</h4>
					</div>
					<div id="collapse{{$current->id}}" data-id="{{$current->id}}" data-lat="{{$current->latitude}}" data-lon="{{$current->longitude}}" data-acc="{{$current->accuracy}}" class="panel-collapse collapse obsCollapse" role="tabpanel" aria-labelledby="headingOne">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">
									<h1>{{Lang::get('ui.obsDescriptionTitle')}}</h1>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									{{$current->notes}}
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<h1>{{Lang::get('ui.obsImageTitle')}}</h1>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
<?php
			for($j=0; $j<count($current->images); ++$j)
			{

				$exif = exif_read_data('./img/'.$current->images[$j]->URL);
				$coordArray = explode('/', $exif['GPSLatitude'][0]);
				$latDegrees = (count($coordArray>1) ? floatval($coordArray[0])/floatval($coordArray[1]) : $coordArray[0]);
				$coordArray = explode('/', $exif['GPSLatitude'][1]);
				$latMinutes = (count($coordArray>1) ? floatval($coordArray[0])/floatval($coordArray[1]) : $coordArray[0]);
				$coordArray = explode('/', $exif['GPSLatitude'][2]);
				$latSeconds = (count($coordArray>1) ? floatval($coordArray[0])/floatval($coordArray[1]) : $coordArray[0]);
				$coordArray = explode('/', $exif['GPSLongitude'][0]);
				$lonDegrees = (count($coordArray>1) ? floatval($coordArray[0])/floatval($coordArray[1]) : $coordArray[0]);
				$coordArray = explode('/', $exif['GPSLongitude'][1]);
				$lonMinutes = (count($coordArray>1) ? floatval($coordArray[0])/floatval($coordArray[1]) : $coordArray[0]);
				$coordArray = explode('/', $exif['GPSLongitude'][2]);
				$lonSeconds = (count($coordArray>1) ? floatval($coordArray[0])/floatval($coordArray[1]) : $coordArray[0]);
				$imageLat = null;
				$imageParams = array('style'=>'width: 150px;', 'class'=>'obs'.$current->id.'Image');
				if(array_key_exists('GPSLatitude', $exif))
				{

					$imageLat = (($exif['GPSLatitudeRef'] == 'S') ? -1 : 1 ) * ($latDegrees + $latMinutes/60 + $latSeconds/3600);
					$imageLon = (($exif['GPSLongitudeRef'] == 'W') ? -1 : 1 ) * ($lonDegrees + $lonMinutes/60 + $lonSeconds/3600);
					$imageParams['data-lat'] = $imageLat;
					$imageParams['data-lon'] = $imageLon;

				}

				$img = HTML::image(Config::get('app.urlImg').$current->images[$j]->URL,'', $imageParams);
				echo '<a href="'.Config::get('app.urlImg').$current->images[$j]->URL.'" data-lightbox="IASImages">'.$img.'</a>';

			}
?>
								</div>
							</div>
<?php
			if(0 != count($current->images))
			{
?>
							<div id="obs{{$current->id}}ImageWarning" class="row alert alert-warning" style="display:none;">
								<div class="col-md-12">
									{{Lang::get('ui.observationImagesWarning')}}
								</div>
							</div>
							<div id="obs{{$current->id}}ImageError" class="row alert alert-danger" style="display:none;">
								<div class="col-md-12">
									{{Lang::get('ui.observationImagesError')}}
								</div>
							</div>
<?php
			}
			else
			{

?>
							<div class="row">
								<div class="col-md-12">
									{{Lang::get('ui.noObservationImages')}}
								</div>
							</div>
<?php

			}
?>
							<h1>{{Lang::get('ui.obsMapTitle')}}</h1>
							<div id="obsMap{{$current->id}}" style="width: 100%; height: 500px;"></div>
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

	{{ HTML::script('js/iastrackermap.js'); }}
	{{ HTML::script('js/pages/observations.js'); }}
@stop