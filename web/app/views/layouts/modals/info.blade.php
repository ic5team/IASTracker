<div class="modal fade" id="completar-dades-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog" style="width:80%; max-width:1000px">
		<div class="modal-content" style="min-height:400px;">
			<div class="modal-header" style="background: rgba(162,200,86,1); color: #FFF;">
<?php
	if(property_exists($data, 'isComplete') && !$data->isComplete)
	{
?>
				<h3 id="modal-title-user-data">{{Lang::get('ui.completeUserData')}}</h3>
<?php
	}
	else
	{
?>
				<h3 id="modal-title-user-data">{{Lang::get('ui.updateData')}}</h3>
<?php
	}
?>
			</div>
			<div class="modal-body">
				<div id="pas1">
					<div class="row" style="min-height:210px">
						<div class="col-md-4" id="dataModalText">
							{{Lang::get('ui.welcomeText')}}
						</div>
						<div class="col-md-8">
							<div style="width: 100%; overflow: hidden;">
								<div class="pull-left tab-completar">1 - {{Lang::get('ui.personalData')}}</div>
								<div class="pull-left tab-completar no-selected">2 - {{Lang::get('ui.profilePicture')}}</div>
								<div class="pull-left tab-completar no-selected" style="width: 34%">3 - {{Lang::get('ui.endAction')}}</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<form role="form">
										<div class="form-group" id="form-name">
											<label for="name">{{Lang::get('ui.name')}}</label>
											<input name="name" type="text" class="form-control block" id="input-name">
											<span id="error-name" class="help-block hidden"></span>
										</div>
									</form>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 form-group has-error" id="fullNameError" style="display: none;">
									<div class="help-block with-errors">
										{{Lang::get('ui.requiredField')}}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<span>{{Lang::get('ui.areYouAnExpert')}}</span>
									<input type="checkbox" id="amIExpertCheckbox" class="IASCheck" checked>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									&nbsp;
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<label>{{Lang::get('ui.selectDefaultLanguage')}}</label>
								</div>
							</div>
							<div class="row">
								<div class="col-md-8 col-md-offset-2">
									<ul class="nav navbar-nav">
<?php
	for($i=0; $i<count($data->languages); ++$i)
	{
?>
										<li>
											<button type="button" data="{{ $data->languages[$i]->locale }}" 
												class="btn btn-default langButtons {{ ( $data->userLanguage == $data->languages[$i]->id) ? 'active' : '' }}">
												{{ HTML::image('img/thumbs/flags/'.$data->languages[$i]->img, $data->languages[$i]->name); }}
											</button>
										</li>
<?php
	}
?>
									</ul>
								</div>
							</div>
						</div> 
					</div>
					<div class="row" style="padding-top: 20px;">
						<button class="btn btn-primary pull-right" onclick="segPas2();">{{Lang::get('ui.next')}}</button>
						<button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{Lang::get('ui.omit')}}</button>
					</div>
				</div>

				<div id="pas2" class="hidden">
					<div class="row" style="min-height:210px">
						<div class="col-md-4">
							<h4>{{Lang::get('ui.selectImageText')}}</h4>
						</div>
						<div class="col-md-8">
							<div style="width: 100%; overflow: hidden;">
								<div class="pull-left tab-completar no-selected">1 - {{Lang::get('ui.personalData')}}</div>
								<div class="pull-left tab-completar">2 - {{Lang::get('ui.profilePicture')}}</div>
								<div class="pull-left tab-completar no-selected" style="width: 34%">3 - {{Lang::get('ui.endAction')}}</div>
							</div>
							<div class="form-group" id="form-imgalgo" style="padding: 30px; border: 1px solid #EEE; margin-bottom: 0">
								<div>
									<label for="input-imgPerfil"><h6>{{Lang::get('ui.selectProfileImage')}}</h6></label>
								</div>
								<div class="form-group" id="form-imgPerfilCompletar" style="margin: auto !important; cursor: pointer; text-align: center">
									<div id="imgPerfilCompletar" onClick="selImageLogo();" data-url="<?php echo Config::get('app.urlImg').'thumbs/void.png' ?>" style=" height: 250px; width: 250px; left: 30px; bottom: 30px; border: 2px solid #FFF; background-position: center; margin: auto; background-size: cover; background-image: url(<?php echo Config::get('app.urlImg').'thumbs/void.png' ?>)">
										<div id="imgPerfilCompletar-loading" class="hidden" style="height: 250px; background-color: rgba(255,255,255,.9); line-height: 160px; text-align: center;">
											<img src="<?php echo Config::get('app.urlImg') ?>/loader-big.gif">
										</div>
									</div>
									<input id="fileUploadImatge" type="file" accept="image/*" style="position:absolute; left: -9999px"/>
									<span id="error-imgPerfilCompletar" class="help-block hidden">Error.</span>
								</div>
							</div>
						</div> 
					</div>
					<div class="row" style="padding-top: 20px;">
						<button type="button" class="btn btn-primary pull-right" onclick="segPas3();">{{Lang::get('ui.next')}}</button>
						<button type="button" class="btn btn-default pull-right" onclick="antPas3();">{{Lang::get('ui.previous')}}</button>
					</div>
				</div>

				<div id="pas3" class="hidden">
					<div class="row" style="min-height:210px">
						<div class="col-md-4" style="text-align: center;">
							<i class="fa fa-check" style="color: rgba(162,200,86,1); font-size: 150px"></i>
							<br /><div class="btn btn-success" style="padding: 20px;" onclick="guardarDadesUsr();">{{Lang::get('ui.endAction')}}</div><hr /><h5>{{Lang::get('ui.personalDataCompleteText')}}</h5></h4>

						</div>
						<div class="col-md-8">
							<div style="width: 100%; overflow: hidden;">
								<div class="pull-left tab-completar no-selected">1 - {{Lang::get('ui.personalData')}}</div>
								<div class="pull-left tab-completar no-selected">2 - {{Lang::get('ui.profilePicture')}}</div>
								<div class="pull-left tab-completar" style="width: 34%">3 - {{Lang::get('ui.endAction')}}</div>
							</div>
							<div style="border: 1px solid #EEE; padding: 30px;">
								<h5>{{Lang::get('ui.personalDataValidationText')}}</h5>

								<div class="row" style="padding-top: 20px;">
									<div class="col-md-4">
										<img src="" id="foto-final" class="responsive" style="width:200px; height: 200px;">
									</div>
									<div class="col-md-8">
										<table class="table">
											<tr>
												<td style="text-align: left;">{{Lang::get('ui.name')}}</td>
												<td style="text-align: left;"><div id="nom-final"></div></td>
											</tr>
											<tr>
												<td style="text-align: left;">{{Lang::get('ui.areYouAnExpert')}}</td>
												<td style="text-align: left;"><div id="expert-final"></td>
											</tr>
											<tr>
												<td style="text-align: left;">{{Lang::get('ui.selectDefaultLanguage')}}</td>
												<td style="text-align: left;"><div id="language-final"></div></td>
											</tr>
										</table>
									</div>
								</div>
							</div>
						</div> 
					</div>
					<div class="row" style="padding-top: 20px;">
						<button type="button" class="btn btn-success pull-right" onclick="guardarDadesUsr();">{{Lang::get('ui.endAction')}}</button>
						<button type="button" class="btn btn-default pull-right" onclick="antPas4();">{{Lang::get('ui.previous')}}</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalCropImatge" style="z-index:1055;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog" style="width: 700px;">
    <div class="modal-content" style="width: 700px;">
      <div class="modal-header">
        <h4 class="modal-title">RETALLAR LA IMATGE</h4>
      </div>
      <div class="modal-body">
      	<div class="container" style="width: 100%;">
    		<div class="row">
        		<div class="col-md-12">
        			<div class="col-md-8">
						<div style="display:none">       
							<label>X1 <input type="text" size="4" id="x1" name="x1" /></label>
							<label>Y1 <input type="text" size="4" id="y1" name="y1" /></label>
							<label>X2 <input type="text" size="4" id="x2" name="x2" /></label>
							<label>Y2 <input type="text" size="4" id="y2" name="y2" /></label>
							<label>W <input type="text" size="4" id="w" name="w" /></label>
							<label>H <input type="text" size="4" id="h" name="h" /></label>
						</div>
						<h4 class="clearfix">Ajusta la teva imatge</h4>
						<img src="<?php echo Config::get('app.urlImgThumbs'); ?>web/void.png" id="target" />
					</div>
					<div class="col-md-4" style="margin-top: 48px;">
						<div id="preview-pane" style="margin-left: 30px;">
							<div class="preview-container">
								<img src="<?php echo Config::get('app.urlImgThumbs'); ?>web/void.png" class="jcrop-preview" alt="Preview" />
							</div>
						</div>
						<!--<img src="../data/assets/ajax-loader.gif" id="loadingCrop" style="display: none; float: right" />-->
						
					</div>
				</div>
	        </div>
	        <hr />
			<div class="row">
				<div class="col-md-12">
					<div id="ajustarButtons" style="float: right;">
						<div class="btn btn-success pull-right" onClick="cropAccepted()" style="margin-left: 10px;">Acceptar</div>
						<div class="btn btn-default pull-right" onClick="cropCanceled()">Cancel·lar</div>
					</div>
					<div  id="loadingCrop" class="hidden">
						<img src="<?php echo Config::get('app.urlImg') ?>/loader.gif" id="loadingCrop" style="float: right" />
					</div>
				</div>
			</div>
	    </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->