<div class="row">
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-12">
				<h1>{{ $data->name }}</h1>
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
				{{ HTML::image(Config.get('app.urlImg').$data->image)}}
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				{{ $data->imageText.' '.$data->imageAttribution }}
			</div>
		</div>
	</div>
	<div class="col-md-8">
		{{ $data->shortDesc }}
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		{{ $data->longDesc }}
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