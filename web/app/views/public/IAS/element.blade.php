<div class="row">
	<div class="col-md-12">
		<div style="display:inline-block; font-size:32px; color:#5cb85c; font-weight: bold;">{{ $data->description->name }}</div>
		<div style="display:inline-block; color:#337ab7; font-weight: bold;">{{ $data->latinName }}</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
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
<div class="row" style="margin-top:15px;">
	<div class="col-md-5">
		<div class="row">
			<div class="col-md-12">
<?php
	if(property_exists($data->image, 'url'))
	{
?>
				{{ HTML::image(Config::get('app.urlImg').$data->image->url, '', array('style'=>'width: 300px;'))}}
<?php
	}
?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12" style="font-weight: bold; font-size: 12px;">
<?php
	if(property_exists($data->image, 'url'))
	{
?>
				{{ $data->image->text.' '.$data->image->attribution }}
<?php
	}
?>
			</div>
		</div>
	</div>
	<div class="col-md-7" style="text-align:left;margin-top:40px;">
		<i class="fa fa-2x fa-info-circle"></i>
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
		<div id="IASObsMap" class="modalMap">
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
<?php
	$num = count($data->relatedDBs);
	if(0 != $num)
	{
?>
<div class="row">
	<div class="col-md-12">
		<h2>{{Lang::get('ui.moreData')}}</h2>
	</div>
</div>
<?php
		$str = array();
		for($i=0; $i<$num; ++$i)
		{

			$current = $data->relatedDBs[$i];
			$str[] = '<div class="row"><div class="col-md-12"><a href="'.$current->URL.'" target="_blank">'.$current->name.'</a> | <a href="'.$current->repoURL.'" target="_blank">'.$current->repoName.'</a></div></div>';

		}

		echo implode($str, '');

	}

?>