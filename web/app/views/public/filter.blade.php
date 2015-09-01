<div class="row">
	<div class="form-group col-md-12">
		<span><b>{{Lang::get('ui.taxonomy')}}</b> <br /></span>
		<label for="input-grup">{{Lang::get('ui.group')}}</label>
		{{Form::select('taxonomy', $taxonomies)}}
	</div>
</div>
<div class="row" style="text-align: center;">
	<div class="col-md-12">
		<div class="btn-group" role="group" aria-label="...">
			<button type="button" class="btn btn-default active">{{Lang::get('ui.commonName')}}</button>
			<button type="button" class="btn btn-default">{{Lang::get('ui.scientificName')}}</button>
		</div>
	</div>
</div>
<?php
	for($i=0; $i<count($data); ++$i)
	{

		$current = $data[$i];
?>

		<div class="col-md-2">
			{{ HTML::image($current->image, $current->imageText); }}
		</div>
		<div class="col-md-7">
			{{$current->scientificName}}
		</div>
		<div class="col-md-3">
			<input type="checkbox" id="IASCheck{{$i}}" class="IASCheck" onclick="activeIAS({{$i}});" checked>
		</div>

<?php

	}
?>