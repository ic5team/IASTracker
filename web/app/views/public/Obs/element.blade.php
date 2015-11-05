<?php
	if(property_exists($data, 'image') || isset($data->image))
	{
?>
<div class="row" style="margin-top:15px;">
	<div class="col-md-12">
		<div class="row" style="height: 150px; overflow: hidden; 
				background-image: url({{Config::get('app.urlImg').$data->image->url}}); 
				background-position-y: -150px;
	    		background-repeat: no-repeat;
	    		background-size: cover;">
	    	<div class="iasTitleContainer">
	    		<div class="obsTitleText">
		    		<div style="font-size:32px; color:#5cb85c; font-weight: bold;">{{ $data->description->name }}<i class="fa fa-external-link" style="margin-left:15px; cursor:pointer;" title="{{Lang::get('ui.')}}" onclick="showIAS({{$data->id}})"></i></div>
					<div style="color:#337ab7; font-weight: bold;">{{ $data->latinName }}</div>
<?php
		$num = count($data->taxons);
		$str = array();
		for($i=0; $i<$num; ++$i)
		{

			$current = $data->taxons[$i];
			$str[] = '<div style="color:'.$current->appOuterColor.'; font-weight: bold; display: inline-block;">'.$current->name.'</div>';

		}

		echo implode($str, ',');

		if(1 == $data->status->id)
		{

			echo '<div class="row"><div class="col-md-3 alert alert-success" style="margin-left: 15px;"><i class="'.$data->status->icon.'" style="margin-right: 10px;"></i>'.Lang::get('ui.observationValidated').'</div></div>';

		}
		else
		{

			echo '<div class="row"><div class="col-md-3 alert alert-warning" style="margin-left: 15px;"><i class="'.$data->status->icon.'" style="margin-right: 10px;"></i>'.Lang::get('ui.invasorObserved').'</div></div>';

		}

?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12" style="font-weight: bold; font-size: 12px; text-align: right;">
				{{ $data->image->text.' '.$data->image->attribution }}
			</div>
		</div>
	</div>
</div>
<?php
	}
?>
<div class="row">
	<div class="col-md-12">
		<h1>{{mb_strtoupper(Lang::get('ui.description'))}}</h1>
		{{ $data->notes }}
	</div>
</div>
<div class="row" style="margin-top: 15px;">
	<div class="col-md-8">
<?php
	$numImg = count($data->images);
	$num = ($numImg < 8 ? $numImg : 8);
	$str = array();
	for($i=0; $i<$num; ++$i)
	{

		$current = $data->images[$i];
		$img = HTML::image(Config::get('app.urlImg').$current->URL,'', 
			array('style'=>'width: 200px; margin-left: 10px;'));
		$str[] = '<a href="'.Config::get('app.urlImg').$current->URL.'" data-lightbox="IASImages">'.$img.'</a>';

	}

	for($i=8; $i<$numImg; ++$i)
	{

		$current = $data->images[$i];
		$str[] = '<a href="'.Config::get('app.urlImg').$current->URL.'" data-lightbox="IASImages"></a>';

	}

	echo implode($str, '');
?>
	</div>
<?php

	if(property_exists($data, 'user') || isset($data->user))
	{

?>
	<div class="col-md-4" title="{{Lang::get('ui.viewUser')}}" onclick="showUser({{$data->user->id}})" style="cursor:pointer; margin-top: 70px;">
		<div class="row">
			<div class="col-md-4">
				{{ HTML::image(Config::get('app.urlImgThumbs').$data->user->photoURL, '', array("style" => "width: 100px;"))}}
			</div>
			<div class="col-md-8">
				<div class="row">
					<div class="col-md-12" style="margin-top:25px;">
						{{$data->user->username}}
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						{{$data->created_at}}
					</div>
				</div>
			</div>
		</div>
	</div>
<?php

	}
	else
	{

?>
	<div class="col-md-4">
	</div>

<?php
	}
?>

</div>