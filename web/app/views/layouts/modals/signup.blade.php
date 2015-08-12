<div id="signupModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						{{ HTML::image('img/'.$data->logo, $data->logoAlt, array('class' => 'navbar-logo-img', 'pull-left', 'id' => 'imgLogoBarra')); }}
					</div>
					<div class="col-md-6">
						{{Lang::get('ui.signupText')}}
					</div>
				</div>
				<div class="row">
					<div class="col-md-8">
						<form role="form">
							<div class="form-group" id="form-email2">
								<input name="email2" type="text" class="form-control block" placeholder="me@example.com" id="input-email2">
								<span id="error-email2" class="help-block hidden"></span>
							</div>
						</form>
					</div>
					<div class="col-md-4">
						<div class="btn btn-default" onclick="registrarUsuari()">{{Lang::get('ui.signupAction')}}</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<p class="text-center">{{Lang::get('ui.userExistsQuestion')}}<a style="cursor:pointer" onclick="showLogin()">{{Lang::get('ui.userExistsAction')}}</a></p>
						<p class="text-center">{{Lang::get('ui.pwForgottenQuestion')}}<a style="cursor:pointer" onclick="showRememberPW()">{{Lang::get('ui.pwForgottenAction')}}</a></p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						{{$data->signupClause}}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>