<div class="row">
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-12">
				<h1>{{ $data->description->name }}</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<h1>{{ $data->latinName }}</h1>
			</div>
		</div>
	</div>
	<div class="col-md-6">
<?php
	$num = count($data->taxons);
	$str = array();
	for($i=0; $i<$num; ++$i)
	{

		$current = $data->taxons[$i];
		$str[] = $current->name;

	}

	echo implode($str, ',');

?>
	</div>
</div>
<div class="row">
	<div class="col-md-4">
		<div class="row">
			<div class="col-md-12">
				{{ HTML::image(Config::get('app.urlImg').$data->image->url, '', array('style'=>'width: 100px;'))}}
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				{{ $data->image->text.' '.$data->image->attribution }}
			</div>
		</div>
	</div>
	<div class="col-md-8">
		{{ $data->description->shortDescription }}
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		{{ $data->description->longDescription }}
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div id="IASObsMap" class="map">
			Mapa
		</div>
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
		$img = HTML::image(Config::get('app.urlImg').$current->url,'', 
			array('style'=>'width: 100px;'));
		$str[] = '<a href="'.Config::get('app.urlImg').$current->url.'" data-lightbox="IASImages" data-title="'.$current->text.' '.$current->attribution.'">'.$img.'</a>';

	}

	for($i=8; $i<$numImg; ++$i)
	{

		$current = $data->images[$i];
		$str[] = '<a href="'.Config::get('app.urlImg').$current->url.'" data-lightbox="IASImages" data-title="'.$current->text.' '.$current->attribution.'"></a>';

	}

	echo implode($str, '');

?>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<h2>{{Lang::get('ui.moreData')}}</h2>
	</div>
</div>
<?php
	$num = count($data->relatedDBs);
	$str = array();
	for($i=0; $i<$num; ++$i)
	{

		$current = $data->relatedDBs[$i];
		$str[] = '<div class="row"><div class="col-md-12"><a href="'.$current->URL.'" target="_blank">'.$current->name.'</a> <a href="'.$current->repoURL.'" target="_blank">'.$current->repoName.'</a></div></div>';

	}

	echo implode($str, '');

?>