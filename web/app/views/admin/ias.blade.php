@extends("admin.index")
 
@section('header_includes')
	@parent
	{{ HTML::style('css/jquery.dataTables.min.css'); }}
@stop
 
@section('content')

	<div class="row" style="margin-bottom: 50px;">
		<div class="col-md-3 col-md-offset-9">
			<button id="" class="btn btn-danger" onclick="addIAS()" style="float: right;">
				<div id=""> {{Lang::get('ui.add')}} </div>
			</button>
		</div>
	</div>
	<div class="row" id="iasList">
		<div class="col-md-12">
			<table id="dataContainer" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th> <!--Expandible row button --> </th>
						<th><!--id (hidden) --></th>
						<th>{{ Lang::get('ui.scientificName'); }}</th>
						<th>{{ Lang::get('ui.commonName'); }}</th>
						<th>{{ Lang::get('ui.taxon'); }}</th>
						<th>{{ Lang::get('ui.created'); }}</th>
						<th> <!--Buttons --> </th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th> <!--Expandible row button --> </th>
						<th><!--id (hidden) --></th>
						<th>{{ Lang::get('ui.scientificName'); }}</th>
						<th>{{ Lang::get('ui.commonName'); }}</th>
						<th>{{ Lang::get('ui.taxon'); }}</th>
						<th>{{ Lang::get('ui.created'); }}</th>
						<th> <!--Buttons --> </th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	<div id="addIAS" style="display:none;">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group" id="form-scientificName">
					<label for="scientificName">{{Lang::get('ui.scientificName')}}</label>
					<input name="scientificName" type="text" class="form-control block" id="input-scientificName">
					<span id="error-scientificName" class="help-block hidden">{{Lang::get('ui.requiredField')}}</span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group" id="form-taxon">
					<label for="taxon">{{Lang::get('ui.taxon')}}</label>
					<select id="taxon">
<?php
for($i=0; $i<count($data->taxons); ++$i)
{
?>
						<option value="{{$data->taxons[$i]->id}}">{{$data->taxons[$i]->name}}</option>
<?php

}
?>
					</select>
					<span id="error-taxon" class="help-block hidden"></span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel-group" id="accordion" class="accordion" role="tablist" aria-multiselectable="true">
					<div id="panel" class="panel panel-default">
						<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseDesc" aria-expanded="false" aria-controls="collapseDesc">
							<div class="panel-heading" role="tab" id="heading">
								<h4>
									{{Lang::get('ui.descriptions')}}
								</h4>
							</div>
						</a>
						<div id="collapseDesc" data-id="" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">
<?php
for($i=0; $i<count($data->languages); ++$i)
{

?>
								<div class="row" style="margin-bottom: 15px;">
									<div class="col-md-2">
										{{ HTML::image('img/thumbs/flags/'.$data->languages[$i]->img, $data->languages[$i]->name, array('class' => 'navbar-logo-img')); }}
									</div>
									<div class="col-md-10">
										<div class="row">
											<div class="col-md-12">
												<div class="form-group" id="form-name{{$data->languages[$i]->id}}">
													<label for="name">{{Lang::get('ui.commonName')}}</label>
													<input name="name" type="text" class="form-control block" id="input-name{{$data->languages[$i]->id}}">
													<span id="error-name{{$data->languages[$i]->id}}" class="help-block hidden">{{Lang::get('ui.requiredField')}}</span>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="form-group" id="form-shortDesc">
													<label for="shortDesc">{{Lang::get('ui.shortDescription')}}</label>
													<textarea name="shortDesc" type="text" class="form-control block" id="input-shortDesc{{$data->languages[$i]->id}}"></textarea>
													<span id="error-shortDesc" class="help-block hidden">{{Lang::get('ui.requiredField')}}</span>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="form-group" id="form-sizeDesc">
													<label for="sizeDesc">{{Lang::get('ui.sizeDescription')}}</label>
													<textarea name="sizeDesc" type="text" class="form-control block" id="input-sizeDesc{{$data->languages[$i]->id}}"></textarea>
													<span id="error-sizeDesc" class="help-block hidden">{{Lang::get('ui.requiredField')}}</span>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="form-group" id="form-infoDesc">
													<label for="infoDesc">{{Lang::get('ui.infoDescription')}}</label>
													<textarea name="infoDesc" type="text" class="form-control block" id="input-infoDesc{{$data->languages[$i]->id}}"></textarea>
													<span id="error-infoDesc" class="help-block hidden">{{Lang::get('ui.requiredField')}}</span>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="form-group" id="form-infoHabitat">
													<label for="infoHabitat">{{Lang::get('ui.habitatDescription')}}</label>
													<textarea name="infoHabitat" type="text" class="form-control block" id="input-infoHabitat{{$data->languages[$i]->id}}"></textarea>
													<span id="error-infoHabitat" class="help-block hidden">{{Lang::get('ui.requiredField')}}</span>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="form-group" id="form-infoConfuse">
													<label for="infoConfuse">{{Lang::get('ui.notConfuseDescription')}}</label>
													<textarea name="infoConfuse" type="text" class="form-control block" id="input-infoConfuse{{$data->languages[$i]->id}}"></textarea>
													<span id="error-infoConfuse" class="help-block hidden">{{Lang::get('ui.requiredField')}}</span>
												</div>
											</div>
										</div>
									</div>
								</div>
<?php

}
?>
							</div>
						</div>
					</div>
					<div id="panel" class="panel panel-default">
						<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseImages" aria-expanded="false" aria-controls="collapseImages">
							<div class="panel-heading" role="tab" id="heading">
								<h4>
									{{Lang::get('ui.images')}}
								</h4>
							</div>
						</a>
						<div id="collapseImages" data-id="" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body" id="imageContentsN">
								<div class="row imageRowNew" style="margin-bottom: 50px; display:none;" data-row="-1">
									<div class="col-md-4" style="border: dashed 1px; min-height: 250px; text-align:center;">
										<div style="margin-top: 110px;">
											<form action="{{Config::get('app.url')}}/common/obsImageUpload.php" class="dropzone imageUpload" id="imageUpload">
											</form>
										</div>
									</div>
									<div class="col-md-8">
										<div style="display:inline-block;">
											<label>
												{{Lang::get('ui.attribution')}}
												<input type="text" class="imageAttrib" data-id="" />
											</label>
											<label>
												{{Lang::get('ui.order')}}
												<input type="text" class="imageOrder" data-id="" />
											</label>
										</div>
<?php
for($i=0; $i<count($data->languages); ++$i)
{

?>
										<div class="row" style="margin-bottom: 15px;">
											<div class="col-md-2">
												{{ HTML::image('img/thumbs/flags/'.$data->languages[$i]->img, $data->languages[$i]->name, array('class' => 'navbar-logo-img')); }}
											</div>
											<div class="col-md-10">
												<label>
													{{Lang::get('ui.imageText')}}
												</label>
												<input type="text" style="width: 100%;" data-row="" data-lang="{{$i}}" class="imageText" value="" />													
											</div>
										</div>
<?php
}
?>

										<button class="btn btn-success imageRemove" style="float:right;" onclick="">
											{{Lang::get('ui.removeIASImage')}}
										</button>
									</div>
								</div>
								<div class="row imageRowNew" style="margin-bottom: 50px;" data-row="0">
									<div class="col-md-4" style="border: dashed 1px; min-height: 250px; text-align:center;">
										<div style="margin-top: 110px;">
											<form action="{{Config::get('app.url')}}/common/obsImageUpload.php" class="dropzone imageUpload" id="imageUpload0">
											</form>
										</div>
									</div>
									<div class="col-md-8">
										<div style="display:inline-block;">
											<label>
												{{Lang::get('ui.attribution')}}
												<input type="text" class="imageAttrib" data-id="" id="imageAttrib0"/>
											</label>
											<label>
												{{Lang::get('ui.order')}}
												<input type="text" class="imageOrder" data-id="" id="imageAttrib0" />
											</label>
										</div>
<?php
for($i=0; $i<count($data->languages); ++$i)
{

?>
										<div class="row" style="margin-bottom: 15px;">
											<div class="col-md-2">
												{{ HTML::image('img/thumbs/flags/'.$data->languages[$i]->img, $data->languages[$i]->name, array('class' => 'navbar-logo-img')); }}
											</div>
											<div class="col-md-10">
												<label>
													{{Lang::get('ui.imageText')}}
												</label>
												<input type="text" style="width: 100%;" data-row="" data-lang="{{$i}}" class="imageText" value="" />													
											</div>
										</div>
<?php
}
?>
										<button class="btn btn-success imageRemove" style="float:right;" onclick="removeImageNew(0);">
											{{Lang::get('ui.removeIASImage')}}
										</button>
									</div>
								</div>
								<button class="btn btn-success imageAdd" style="float:right;" data-id="" onclick="addImageN()">
									{{Lang::get('ui.addIASImage')}}
								</button>
							</div>
						</div>
					</div>
					<div id="panel" class="panel panel-default">
						<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseAreas" aria-expanded="false" aria-controls="collapseAreas">
							<div class="panel-heading" role="tab" id="heading">
								<h4>
									{{Lang::get('ui.areas')}}
								</h4>
							</div>
						</a>
						<div id="collapseAreas" data-id="" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">
<?php
for($i=0; $i<count($data->areas); ++$i)
{

?>
								<div class="row">
									<div class="col-md-4">
										<label>
											{{$data->areas[$i]->name}}
										</label>
									</div>
									<div class="col-md-3">
										<input type="checkbox" class="IASNewAreaCheck" data="{{$data->areas[$i]->id}}">
									</div>
									<div class="col-md-5">
										<div class="form-group form-new-areaOrder" data="{{$data->areas[$i]->id}}">
											<label for="areaOrder">{{Lang::get('ui.order')}}</label>
											<input type="text" class="iasNewOrder form-control block" data-id="{{$data->areas[$i]->id}}" style="display: inline-block; width: 80%;">
										</div>
									</div>
								</div>
<?php
}
?>
							</div>
						</div>
					</div>
					<div id="panel" class="panel panel-default">
						<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseValidators" aria-expanded="false" aria-controls="collapseValidators">
							<div class="panel-heading" role="tab" id="heading">
								<h4>
									{{Lang::get('ui.validators')}}
								</h4>
							</div>
						</a>
						<div id="collapseValidators" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">
<?php
for($i=0; $i<count($validators); ++$i)
{

?>
								<div class="row">
									<div class="col-md-4">
										<label>
											{{$validators[$i]->fullName}}
										</label>
									</div>
									<div class="col-md-1">
										<input type="checkbox" class="IASNewValidatorCheck" data-validator="{{$validators[$i]->userId}}">
									</div>
									<div class="col-md-7">
										<div class="form-group form-new-outOfBounds">
											<label for="outOfBounds">{{Lang::get('ui.outOfBounds')}}</label>
											<input name="outOfBounds" type="checkbox" class="outOfAreaNewCheck" data-validator="{{$validators[$i]->userId}}" style="display: inline-block;">
										</div>
									</div>
								</div>
<?php
}
?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row alert alert-danger" id="error-IAS" style="display: none;">
			{{Lang::get('ui.errorStoring')}}
		</div>
		<div class="row" style="margin-bottom: 50px;">
			<div class="col-md-3 col-md-offset-9">
				<button id="" class="btn btn-danger" onclick="dismiss()" style="float: right;">
					<div id=""> {{Lang::get('ui.dismissAction')}} </div>
				</button>
				<button id="iasNewBtn" class="btn btn-success" onclick="store()">
					<div id="iasNewBtnText"> {{Lang::get('ui.store')}} </div>
					<img id="iasNewLoading" src="<?php echo Config::get('app.urlImg') ?>/loader.gif" style="display:none;"/>
				</button>
			</div>
		</div>
	</div>
	
@stop

@section('footer_includes')
	@parent
	<script>
		var defaultLanguageId = {{$data->defaultLanguageId}};
		var languageNum = {{count($data->languages)}};
	</script>
	{{ HTML::script('js/jquery.dataTables.min.js'); }}
	{{ HTML::script('js/dropzone.js'); }}
	{{ HTML::script('js/pages/ias.js'); }}

@stop