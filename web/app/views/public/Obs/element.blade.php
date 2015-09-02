<div class="row">
	<div class="col-md-12">
		<h1>Observació</h1>
		<i class="{{$data->status->icon}}"></i>
	</div>
</div>
<div class="row">
	<div class="col-md-4">
		<div class="row">
			<div class="col-md-12">
				{{ HTML::image(Config::get('app.urlImg').$data->image->url, '', array("style" => "width: 100px;"))}}
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				{{ $data->image->text.' '.$data->image->attribution }}
			</div>
		</div>
	</div>
	<div class="col-md-8">
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
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		{{ $data->notes }}
	</div>
</div>
<div class="row">
	<div class="col-md-9">
<?php
	$numImg = count($data->images);
	$num = ($numImg < 8 ? $numImg : 8);
	$str = array();
	for($i=0; $i<$num; ++$i)
	{

		$current = $data->images[$i];
		$img = HTML::image(Config::get('app.urlImg').$current->URL,'', 
			array('style'=>'width: 100px;'));
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
	<div class="col-md-3">
		<div class="row">
			<div class="col-md-4">
				{{ HTML::image(Config::get('app.urlImg').$data->user->photoURL, '', array("style" => "width: 100px;"))}}
			</div>
			<div class="col-md-8">
				<div class="row">
					<div class="col-md-12">
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
</div>