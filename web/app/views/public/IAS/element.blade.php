<?php
	if(property_exists($data, 'image'))
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
	    		<div class="iasTitleText">
		    		<div style="font-size:32px; color:#5cb85c; font-weight: bold;">{{ $data->description->name }}</div>
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
	<div class="col-md-12" style="text-align:left;">
		<i class="fa fa-2x fa-info-circle"></i>
		{{ $data->description->shortDescription }}
<?php
	if('' != $data->description->sizeLongDescription)
		echo '<br><br><i class="fa fa-arrows fa-2x" style="margin-right: 10px;"></i>'.$data->description->sizeLongDescription;

	if('' != $data->description->infoLongDescription)
		echo '<br><br><i class="fa fa-info-circle fa-2x" style="margin-right: 10px;"></i>'.$data->description->infoLongDescription;

	if('' != $data->description->habitatLongDescription)
		echo '<br><br><i class="fa fa-globe fa-2x" style="margin-right: 10px;"></i>'.$data->description->habitatLongDescription;

	if('' != $data->description->confuseLongDescription)
		echo '<br><br><i class="fa fa-check fa-2x" style="margin-right: 10px;"></i>'.$data->description->confuseLongDescription;
?>
		{{ $data->description->longDescription }}
	</div>
</div>
<div class="row" style="margin-top: 15px;">
	<div class="col-md-12">
		<br >
<?php
	$numImg = count($data->images);
	$num = ($numImg < 8 ? $numImg : 8);
	$str = array();
	$img = HTML::image(Config::get('app.urlImg').$data->image->url,'', 
			array('style'=>'width: 200px; transform:rotate('.$data->image->rotation.'deg);  margin-left: 10px;margin-top: 10px;'));
	$str[] = '<a href="'.Config::get('app.urlImg').$data->image->url.'" data-lightbox="IASImages" data-title="'.$data->image->text.' - '.$data->image->attribution.'">'.$img.'</a>';

	for($i=0; $i<$num; ++$i)
	{

		$current = $data->images[$i];
		$img = HTML::image(Config::get('app.urlImg').$current->url,'', 
			array('style'=>'width: 200px; transform:rotate('.$data->image->rotation.'deg); margin-left: 10px;margin-top: 10px;'));
		$str[] = '<a href="'.Config::get('app.urlImg').$current->url.'" data-lightbox="IASImages" data-title="'.$current->text.' - '.$current->attribution.'">'.$img.'</a>';

	}

	for($i=8; $i<$numImg; ++$i)
	{

		$current = $data->images[$i];
		$img = HTML::image(Config::get('app.urlImg').$current->url,'', 
			array('style'=>'display: none; width: 200px; transform:rotate('.$data->image->rotation.'deg);  margin-left: 10px;margin-top: 10px;'));
		$str[] = '<a href="'.Config::get('app.urlImg').$current->url.'" data-lightbox="IASImages" data-title="'.$current->text.' - '.$current->attribution.'"></a>';

	}

	echo implode($str, '');

?>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<h1>{{mb_strtoupper(Lang::get('ui.observations'))}}</h1>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div id="IASObsMap" class="modalMap">
			Mapa
		</div>
	</div>
</div>
<?php
	$num = count($data->relatedDBs);
	if(0 != $num)
	{
?>
<div class="row">
	<div class="col-md-12">
		<h2>{{mb_strtoupper(Lang::get('ui.moreData'))}}</h2>
	</div>
</div>
<?php
		$str = array();
		for($i=0; $i<$num; ++$i)
		{

			$current = $data->relatedDBs[$i];
			$str[] = '<div class="row"><div class="col-md-12"><a href="'.$current->URL.'" target="_blank">'.$current->name.'</a> | <a href="'.$current->repoURL.'" target="_blank" title="'.$current->repoDesc.'">'.$current->repoName.'</a></div></div>';

		}

		echo implode($str, '');

	}

?>