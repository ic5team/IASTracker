<div id="loginModal" class="modal fade">
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
						{{Lang::get('ui.loginText')}}
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<form role="form">
							<div class="form-group" id="form-email">
								<label for="email">{{Lang::get('ui.email')}}</label>
								<input name="email" type="text" class="form-control block" placeholder="me@example.com" id="input-email">
								<span id="error-email" class="help-block hidden"></span>
							</div>
							<div class="form-group" id="form-password">
								<label for="email">{{Lang::get('ui.password')}}</label>
								<input name="password" type="password" class="form-control block" placeholder="" id="input-password">
								<span id="error-password" class="help-block hidden"></span>
							</div>
							<label>
								<input type="checkbox" value="forever" id="checkForever">
								{{Lang::get('ui.rememberMeText')}}
							</label>
						</form>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="btn btn-lg btn-block btn-default" onclick="loginUsuari()">{{Lang::get('ui.loginAction')}}</div>
						<br>
						<p class="text-center">{{Lang::get('ui.notRegisteredQuestion')}}<a style="cursor:pointer" onclick="showSignup()">{{Lang::get('ui.notRegisteredAction')}}</a></p>
						<p class="text-center">{{Lang::get('ui.pwForgottenQuestion')}}<a style="cursor:pointer" onclick="showRememberPW()">{{Lang::get('ui.pwForgottenAction')}}</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>