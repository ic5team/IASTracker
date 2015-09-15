<div class="row">
	<div class="col-md-3">
		{{ HTML::image(Config::get('app.urlImg').$data->photoURL, '', array('style'=>'width: 300px;'))}}
		{{$data->username}}
	</div>
	<div class="col-md-3">
		{{$data->obsNum.' '.Lang::get('ui.observations').' '.number_format((float)($data->validatedObsNum/$data->obsNum), 2, '.', '').' '.Lang::get('ui.validated')}}
	</div>
	<div class="col-md-3">
		{{Lang::get('ui.lastObservation').' '.(new DateTime($data->lastObservation))->format('d/m/Y H:i:s')}}
	</div>
	<div class="col-md-3">
		{{Lang::get('ui.lastConnection').' '.(new DateTime($data->lastConnection))->format('d/m/Y H:i:s')}}
	</div>
</div>
<div class="row">
	<div class="col-md-8">
		<div id="UserObsMap" class="modalMap">
			Mapa
		</div>
	</div>
	<div class="col-md-4">
<?php
	for($i=0; $i<count($ias); ++$i)
	{

		$current = $ias[$i];
?>
		<div class="row">
			<div class="col-md-2">
				{{ HTML::image(Config::get('app.urlImg').$current->image->url, $current->name, array('style' => 'width: 20px;')); }}
			</div>
			<div class="col-md-6">
				{{$current->name}}
			</div>
			<div class="col-md-4">
				<input type="checkbox" class="IASUserCheck" id="IASUserCheck{{$current->id}}" onclick="activeUserIAS" data="{{$current->id}}" checked>
			</div>
		</div>
<?php

	}
?>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
<?php
	$numImg = count($data->images);
	$num = ($numImg < 8 ? $numImg : 8);
	$str = array();
	for($i=0; $i<$num; ++$i)
	{

		$current = $data->images[$i];
		$img = HTML::image(Config::get('app.urlImg').$current->URL,'', 
			array('style'=>'width: 100px;'));
		$str[] = '<a href="'.Config::get('app.urlImg').$current->URL.'" data-lightbox="IASImages" data-title="">'.$img.'</a>';

	}

	for($i=8; $i<$numImg; ++$i)
	{

		$current = $data->images[$i];
		$str[] = '<a href="'.Config::get('app.urlImg').$current->URL.'" data-lightbox="IASImages" data-title=""></a>';

	}

	echo implode($str, '');

?>
	</div>
</div>