		<div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group" id="form-scientificName{{$current->id}}">
						<label for="scientificName" data-id="{{$current->id}}">{{Lang::get('ui.scientificName')}}</label>
						<input name="scientificName" type="text" class="form-control block" id="input-scientificName{{$current->id}}" data-id="{{$current->id}}" value="{{$current->latinName}}">
						<span id="error-scientificName{{$current->id}}" class="help-block hidden">{{Lang::get('ui.requiredField')}}</span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group" id="form-taxon{{$current->id}}">
						<label for="taxon">{{Lang::get('ui.taxon')}}</label>
						<select id="input-taxon{{$current->id}}">
<?php
	for($i=0; $i<count($taxons); ++$i)
	{
?>
							<option value="{{$taxons[$i]->id}}" {{($taxons[$i]->id == $current->taxonId) ? 'selected' : '' }}>{{$taxons[$i]->name}}</option>
<?php

	}
?>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="panel-group" id="accordion{{$current->id}}" class="accordion" role="tablist" aria-multiselectable="true">
						<div id="panel" class="panel panel-default">
							<a role="button" data-toggle="collapse" data-parent="#accordion{{$current->id}}" href="#collapseDesc{{$current->id}}" aria-expanded="false" aria-controls="collapseDesc">
								<div class="panel-heading" role="tab" id="heading">
									<h4>
										{{Lang::get('ui.descriptions')}}
									</h4>
								</div>
							</a>
							<div id="collapseDesc{{$current->id}}" data-id="" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
								<div class="panel-body">
<?php
	for($i=0; $i<count($languages); ++$i)
	{

?>
									<div class="row" style="margin-bottom: 15px;">
										<div class="col-md-2">
											{{ HTML::image('img/thumbs/flags/'.$languages[$i]->flagURL, $languages[$i]->name, array('class' => 'navbar-logo-img')); }}
										</div>
										<div class="col-md-10">
											<div class="row">
												<div class="col-md-12">
													<div class="form-group" id="form-name{{$languages[$i]->id}}_{{$current->id}}">
														<label for="name">{{Lang::get('ui.commonName')}}</label>
														<input name="name" type="text" class="form-control block input-name" id="input-name{{$languages[$i]->id}}_{{$current->id}}" data-lang-id="{{$languages[$i]->id}}" data-id="{{$current->id}}" value="{{$current->description[$languages[$i]->id]->name}}">
														<span id="error-name{{$languages[$i]->id}}_{{$current->id}}" class="help-block hidden">{{Lang::get('ui.requiredField')}}</span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="form-group" id="form-shortDesc{{$languages[$i]->id}}_{{$current->id}}">
														<label for="shortDesc">{{Lang::get('ui.shortDescription')}}</label>
														<textarea name="shortDesc" type="text" class="form-control block input-shortDesc" id="input-shortDesc{{$languages[$i]->id}}_{{$current->id}}" data-lang-id="{{$languages[$i]->id}}" data-id="{{$current->id}}">{{$current->description[$languages[$i]->id]->shortDescription}}</textarea>
														<span id="error-shortDesc{{$languages[$i]->id}}_{{$current->id}}" class="help-block hidden">{{Lang::get('ui.requiredField')}}</span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="form-group" id="form-sizeDesc{{$languages[$i]->id}}_{{$current->id}}">
														<label for="sizeDesc">{{Lang::get('ui.sizeDescription')}}</label>
														<textarea name="sizeDesc" type="text" class="form-control block input-sizeDesc" id="input-sizeDesc{{$languages[$i]->id}}_{{$current->id}}" data-lang-id="{{$languages[$i]->id}}" data-id="{{$current->id}}">{{$current->description[$languages[$i]->id]->sizeDescription}}</textarea>
														<span id="error-sizeDesc{{$languages[$i]->id}}_{{$current->id}}" class="help-block hidden">{{Lang::get('ui.requiredField')}}</span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="form-group" id="form-infoDesc{{$languages[$i]->id}}_{{$current->id}}">
														<label for="infoDesc">{{Lang::get('ui.infoDescription')}}</label>
														<textarea name="infoDesc" type="text" class="form-control block input-infoDesc" id="input-infoDesc{{$languages[$i]->id}}_{{$current->id}}" data-lang-id="{{$languages[$i]->id}}" data-id="{{$current->id}}">{{$current->description[$languages[$i]->id]->infoDescription}}</textarea>
														<span id="error-infoDesc{{$languages[$i]->id}}_{{$current->id}}" class="help-block hidden">{{Lang::get('ui.requiredField')}}</span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="form-group" id="form-infoHabitat{{$languages[$i]->id}}_{{$current->id}}">
														<label for="infoHabitat">{{Lang::get('ui.habitatDescription')}}</label>
														<textarea name="infoHabitat" type="text" class="form-control block input-infoHabitat" id="input-infoHabitat{{$languages[$i]->id}}_{{$current->id}}" data-lang-id="{{$languages[$i]->id}}" data-id="{{$current->id}}">{{$current->description[$languages[$i]->id]->habitatDescription}}</textarea>
														<span id="error-infoHabitat{{$languages[$i]->id}}_{{$current->id}}" class="help-block hidden">{{Lang::get('ui.requiredField')}}</span>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="form-group" id="form-infoConfuse{{$languages[$i]->id}}_{{$current->id}}">
														<label for="infoConfuse">{{Lang::get('ui.notConfuseDescription')}}</label>
														<textarea name="infoConfuse" type="text" class="form-control block input-infoConfuse" id="input-infoConfuse{{$languages[$i]->id}}_{{$current->id}}" data-lang-id="{{$languages[$i]->id}}" data-id="{{$current->id}}">{{$current->description[$languages[$i]->id]->confuseDescription}}</textarea>
														<span id="error-infoConfuse{{$languages[$i]->id}}_{{$current->id}}" class="help-block hidden">{{Lang::get('ui.requiredField')}}</span>
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
							<a role="button" data-toggle="collapse" data-parent="#accordion{{$current->id}}" href="#collapseImages{{$current->id}}" aria-expanded="false" aria-controls="collapseImages">
								<div class="panel-heading" role="tab" id="heading">
									<h4>
										{{Lang::get('ui.images')}}
									</h4>
								</div>
							</a>
							<div id="collapseImages{{$current->id}}" data-id="" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
								<div class="panel-body" id="imageContents{{$current->id}}">
									<div class="row imageRow" style="display:none; margin-bottom: 50px;">
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
													<input type="text" class="imageAttrib" data-id="{{$current->id}}" />
												</label>
												<label>
													{{Lang::get('ui.order')}}
													<input type="text" class="imageOrder" data-id="{{$current->id}}" />
												</label>
											</div>
<?php
	for($i=0; $i<count($languages); ++$i)
	{

?>
											<div class="row" style="margin-bottom: 15px;">
												<div class="col-md-2">
													{{ HTML::image('img/thumbs/flags/'.$languages[$i]->flagURL, $languages[$i]->name, array('class' => 'navbar-logo-img')); }}
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
<?php
	for($i=0; $i<count($current->images); ++$i)
	{
?>
	
									<div class="row imageRow" data-image-id="{{$current->images[$i]->id}}" data-id="{{$current->id}}"  data-row="{{$i}}" style="margin-bottom: 50px;">
										<div class="col-md-4" style="min-height: 250px; text-align:center;">
											<div style="margin-top: 25px;">
												{{Html::image(Config::get('app.urlImg').$current->images[$i]->url, '', array('style' => 'width:100%;', 
													'class' => 'ias-image',  'data-image-pos' => $i, 'data-id' => $current->id))}}
											</div>
										</div>
										<div class="col-md-8">
											<div style="display:inline-block;">
												<label>
													{{Lang::get('ui.attribution')}}
													<input type="text" class="imageAttrib" id="imageAttrib{{$i}}" data-image-id="{{$current->images[$i]->id}}" data-id="{{$current->id}}" value="{{$current->images[$i]->attribution}}" />
												</label>
												<label>
													{{Lang::get('ui.order')}}
													<input type="text" class="imageOrder" id="imageOrder{{$i}}" data-image-id="{{$current->images[$i]->id}}" data-id="{{$current->id}}" value="{{$current->images[$i]->order}}" />
												</label>
											</div>
<?php
		for($j=0; $j<count($languages); ++$j)
		{

?>
											<div class="row" style="margin-bottom: 15px;">
												<div class="col-md-2">
													{{ HTML::image('img/thumbs/flags/'.$languages[$j]->flagURL, $languages[$j]->name, array('class' => 'navbar-logo-img')); }}
												</div>
												<div class="col-md-10">
													<label>
														{{Lang::get('ui.imageText')}}
													</label>
													<input type="text" style="width: 100%;" data-row="{{$i}}" data-lang="{{$j}}" data-id="{{$current->id}}" data-image-id="{{$current->images[$i]->id}}" class="imageText" value="{{$current->images[$i]->texts[$languages[$j]->id]}}" />
												</div>
											</div>
<?php
		}
?>
											<button class="btn btn-success imageRemove" style="float:right;" onclick="removeImage({{$current->id}}, {{$i}})">
												{{Lang::get('ui.removeIASImage')}}
											</button>
										</div>
									</div>

<?php
	}
?>
									<button class="btn btn-success imageAdd" style="float:right;" data-id="{{$current->id}}" onclick="addImage({{$current->id}})">
										{{Lang::get('ui.addIASImage')}}
									</button>
								</div>
							</div>
						</div>
						<div id="panel" class="panel panel-default">
							<a role="button" data-toggle="collapse" data-parent="#accordion{{$current->id}}" href="#collapseAreas{{$current->id}}" aria-expanded="false" aria-controls="collapseAreas">
								<div class="panel-heading" role="tab" id="heading">
									<h4>
										{{Lang::get('ui.areas')}}
									</h4>
								</div>
							</a>
							<div id="collapseAreas{{$current->id}}" data-id="" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
								<div class="panel-body">
<?php
	for($i=0; $i<count($areas); ++$i)
	{

?>
									<div class="row">
										<div class="col-md-6">
											<label>
												{{$areas[$i]->name}}
											</label>
										</div>
										<div class="col-md-1">
											<input type="checkbox" class="IASAreaCheck" data-area="{{$areas[$i]->id}}" data-id="{{$current->id}}" {{($areas[$i]->hasIAS ? 'checked' : '')}}>
										</div>
										<div class="col-md-5">
											<div class="form-group form-areaOrder" data="{{$areas[$i]->id}}">
												<label for="areaOrder">{{Lang::get('ui.order')}}</label>
												<input type="text" class="iasOrder form-control block" data-id="{{$areas[$i]->id}}" style="display: inline-block; width: 80%;"  value="{{$areas[$i]->hasIAS ? $areas[$i]->order : ''}}">
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
							<a role="button" data-toggle="collapse" data-parent="#accordion{{$current->id}}" href="#collapseValidators{{$current->id}}" aria-expanded="false" aria-controls="collapseValidators">
								<div class="panel-heading" role="tab" id="heading">
									<h4>
										{{Lang::get('ui.validators')}}
									</h4>
								</div>
							</a>
							<div id="collapseValidators{{$current->id}}" data-id="" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
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
											<input type="checkbox" class="IASValidatorCheck" data-id="{{$current->id}}" data-validator="{{$validators[$i]->userId}}" {{($validators[$i]->isChecked ? 'checked' : '' )}}>
										</div>
										<div class="col-md-7">
											<div class="form-group form-outOfBounds" data-id="{{$current->id}}">
												<label for="outOfBounds">{{Lang::get('ui.outOfBounds')}}</label>
												<input name="outOfBounds" type="checkbox" class="outOfAreaCheck" data-id="{{$current->id}}" data-validator="{{$validators[$i]->userId}}" style="display: inline-block;"  {{($validators[$i]->outOfBounds ? 'checked' : '' )}}>
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
			<div class="row alert alert-danger" id="error-IAS{{$current->id}}" style="display: none;">
				{{Lang::get('ui.errorStoring')}}
			</div>
			<div class="row" style="margin-bottom: 50px;">
				<div class="col-md-3 col-md-offset-9">
					<button id="iasEditBtn{{$current->id}}" class="btn btn-success" onclick="edit({{$current->id}})">
						<div id="iasEditBtnText{{$current->id}}"> {{Lang::get('ui.store')}} </div>
						<img id="iasEditLoading{{$current->id}}" src="<?php echo Config::get('app.urlImg') ?>/loader.gif" style="display:none;"/>
					</button>
				</div>
			</div>
		</div>