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

	try {

		for($j=0; $j<count($current->images); ++$j)
		{

			$exif = exif_read_data('./img/'.$current->images[$j]->URL);
			$imageParams = array('style'=>'max-width: 150px; max-height: 150px; margin-top:50px; margin-bottom:50px;', 
				'class'=>'obs'.$current->id.'Image obsImage', 'data-obs-id' => $current->id, 
				'data-id' => $current->images[$j]->id, 'data-rotation' => $current->images[$j]->rotation);
			if(array_key_exists('GPSLatitude', $exif))
			{

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

				$imageLat = (($exif['GPSLatitudeRef'] == 'S') ? -1 : 1 ) * ($latDegrees + $latMinutes/60 + $latSeconds/3600);
				$imageLon = (($exif['GPSLongitudeRef'] == 'W') ? -1 : 1 ) * ($lonDegrees + $lonMinutes/60 + $lonSeconds/3600);
				$imageParams['data-lat'] = $imageLat;
				$imageParams['data-lon'] = $imageLon;

			}

			$img = HTML::image(Config::get('app.urlImg').$current->images[$j]->URL,'', $imageParams);
			echo '<div style="width: 250px; height:250px; text-align:center; display:inline-block;"><a href="'.Config::get('app.urlImg').$current->images[$j]->URL.'" data-lightbox="IASImages">'.$img.'</a>';
			if($current->canRotate)
			{

				echo '<div style="display:block;">';
				echo '<button type="button" class="btn btn-warning" style="display:inline-block;" onclick="rotateImageLeft('.$current->id.','.$current->images[$j]->id.')">
						<i class="fa fa-undo"></i>
					</button>';
				echo '<button type="button" class="btn btn-warning" style="display:inline-block;" onclick="rotateImageRight('.$current->id.','.$current->images[$j]->id.')">
						<i class="fa fa-repeat"></i>
					</button>';
				echo '<button type="button" class="btn btn-warning" style="display:inline-block;" onclick="saveImage('.$current->id.','.$current->images[$j]->id.')">
						<div class="saveImageText" data-image-id='.$current->images[$j]->id.'><i class="fa fa-floppy-o"></i></div><img src="'.Config::get('app.urlImg').'/loader.gif" class="saving" data-image-id='.$current->images[$j]->id.' style="display:none;"/>
					</button>';
				if($current->canDelete)
				{
					
					echo '<button type="button" class="btn btn-danger" onclick="deleteImage('.$current->id.','.$current->images[$j]->id.')">
						<div class="deleteImageText" data-image-id='.$current->images[$j]->id.'><i class="fa fa-trash-o"></i>'.Lang::get('ui.delete').'</div><img src="'.Config::get('app.urlImg').'/loader.gif" class="deleting" data-image-id='.$current->images[$j]->id.' style="display:none;"/></button>';

				}
				echo '</div>';

			}
			echo '</div>';

		}

	}
	catch(Exception $e)
	{

		echo $e->getMessage();

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

<?php

	if(((1 == $current->statusId) || (3 == $current->statusId)) && !$current->isAutoValidated)
	{
?>
							<h1>{{Lang::get('ui.obsValidationTextTitle')}}</h1>
							<div class="row">
								<div class="col-md-12">
									{{$current->validationText}}
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									{{$current->validatorName.' ('.$current->validatorOrg.'), '.$current->validatorTS}}
								</div>
							</div>
<?php
	}
?>