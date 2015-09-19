<div id="remindModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<div class="row" id="remindPasswordDesc">
					<div class="col-md-6">
						{{ HTML::image('img/'.$data->logo, $data->logoAlt, array('class' => 'navbar-logo-img', 'pull-left', 'id' => 'imgLogoBarra')); }}
					</div>
					<div class="col-md-6">
						{{Lang::get('ui.passwordReminderText')}}
					</div>
				</div>
				<div id="remindPasswordPanel">
					<div class="row">
						<div class="col-md-8">
							<form role="form">
								<div class="form-group" id="form-reminderEmail">
									<input name="email" type="text" class="form-control block" placeholder="me@example.com" id="input-reminderEmail">
									<span id="error-invalidEmail" class="help-block hidden">{{Lang::get('ui.invalidEmail')}}</span>
									<span id="error-notUsedEmail" class="help-block hidden">{{Lang::get('ui.notUsedEmail')}}</span>
								</div>
							</form>
						</div>
						<div class="col-md-4">
							<div class="btn btn-default" onclick="remindPassword()">{{Lang::get('ui.remindPasswordAction')}}</div>
						</div>
					</div>
				</div>
				<div id="remindPasswordLoading" style="display: none;">
					<div class="row" style="min-height:210px">
						<div class="col-md-12" style="text-align: center;">
							<img src="<?php echo Config::get('app.urlImg') ?>/loader.gif" id="loadingCrop" />
						</div> 
					</div>
				</div>
				<div id="remindPasswordDone" style="display: none;">
					<div class="row" style="min-height:210px">
						<div class="col-md-4" style="text-align: center;">
							<i class="fa fa-check" style="color: rgba(162,200,86,1); font-size: 150px"></i>
						</div>
						<div class="col-md-8" id="signupMessage">
							{{Lang::get('ui.remindPasswordDone')}}	
						</div> 
					</div>
					<div class="row">
						<div class="col-md-4 col-md-offset-8">
							<div class="btn btn-success" data-dismiss="modal">{{Lang::get('ui.acceptAction')}}</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>