<div class="row">
	<div class="col-md-12" style="text-align: left;font-size: 32px;">
		<i class="fa fa-2x fa-eye" style="margin-right: 15px;"></i>{{Lang::get('ui.observation')}}
		<i class="{{$data->status->icon}}"></i>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div style="display:inline-block; font-size:32px; color:#5cb85c; font-weight: bold;">{{ $data->description->name }}</div>
		<div style="display:inline-block; color:#337ab7; font-weight: bold;">{{ $data->latinName }}</div>
	</div>
</div>
<div class="row">
	<div class="col-md-5">
		<div class="row">
			<div class="col-md-12">
				{{ HTML::image(Config::get('app.urlImg').$data->image->url, '', array("style" => "width: 300px;"))}}
			</div>
		</div>
		<div class="row">
			<div class="col-md-12" style="font-weight: bold; font-size: 12px;">
				{{ $data->image->text.' '.$data->image->attribution }}
			</div>
		</div>
	</div>
	<div class="col-md-7">
		<div class="row">
			<div class="col-md-12" style="text-align: left;">
				{{ $data->notes }}
			</div>
		</div>
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
	<div class="col-md-4">
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