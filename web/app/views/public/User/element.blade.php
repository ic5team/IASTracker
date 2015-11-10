<div class="row">
	<div class="col-md-3">
		{{ HTML::image(Config::get('app.urlImgThumbs').$data->photoURL, '', array('style'=>'width: 150px;'))}}
	</div>
	<div class="col-md-9" style="text-align: left; margin-top:30px;">
		<b>{{$data->username}}</b><br>
		{{$data->obsNum.' '.Lang::get('ui.observations').' '.$data->validatedObsNum.' '.Lang::get('ui.validated')}}<br>
		{{Lang::get('ui.lastObservation').' '.(new DateTime($data->lastObservation))->format('d/m/Y H:i:s')}}<br>
		{{Lang::get('ui.lastConnection').' '.(new DateTime($data->lastConnection))->format('d/m/Y H:i:s')}}
	</div>
</div>
<div class="row">
	<h1>{{mb_strtoupper(Lang::get('ui.observations'))}}</h1>
	<div class="col-md-8">
		<div id="UserObsMap" class="modalMap">
			Mapa
		</div>
	</div>
	<div class="col-md-4">
		<div id="UserIASList" style="height: calc(50vh); overflow-y: auto; overflow-x: hidden;">
<?php
	for($i=0; $i<count($ias); ++$i)
	{

		$current = $ias[$i];
?>
			<div class="row">
				<div class="col-md-4">
					{{ HTML::image(Config::get('app.urlImg').$current->image->url, $current->name, array('style' => 'width: 100px;')); }}
				</div>
				<div class="col-md-5" style="margin-top:30px;">
					{{$current->name}}
				</div>
				<div class="col-md-3" style="margin-top:30px;">
					<input type="checkbox" class="IASUserCheck" id="IASUserCheck{{$current->id}}" onclick="activeUserIAS" data="{{$current->id}}" checked>
				</div>
			</div>
<?php

	}
?>
		</div>
	</div>
</div>
<div class="row" style="margin-top: 15px;">
	<div class="col-md-12">
<?php
	$numImg = count($data->images);
	$num = ($numImg < 8 ? $numImg : 8);
	$str = array();
	for($i=0; $i<$num; ++$i)
	{

		$current = $data->images[$i];
		$img = HTML::image(Config::get('app.urlImg').$current->URL,'', 
			array('style'=>'width: 200px; margin-left: 10px;'));
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