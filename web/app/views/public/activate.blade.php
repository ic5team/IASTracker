@extends("layouts.base")

@section('footer_includes')
	@parent
	{{ HTML::script('js/pages/activate.js'); }}
	<script>
		var token = '{{ $token or '' }}';
		var id = '{{ $userId or '' }}';
		var requiredFieldError = '{{Lang::get('ui.requiredField')}}';
		var pwMismatchError = '{{Lang::get('ui.pwMismatch')}}';
		var invalidPwError = '{{Lang::get('ui.invalidPw')}}';
		var invalidNickError = '{{Lang::get('ui.invalidNick')}}';
	</script>
@stop
 
@section("title")
	{{Lang::get('ui.activateAccount')}}
@stop

@section('section-title')
@stop

@section('breadcrumb-container')
@stop

@section('main_wrapper')
	<div class="full-width">
		<div class="row" id="activationForm">
			<div class="col-md-4 col-md-offset-4">
					<div id="titol" style="text-align:center">
						<h2>{{Lang::get('ui.activateAccount')}}</h2>
					</div>

					<form role="formulari" data-toggle="validator">
						<div class="form-group" id="form-nick">
							<label for="input-nick">{{Lang::get('ui.selectNick')}}*</label>
							<input type="text" data-minlength="3" class="form-control" id="input-nick" placeholder="{{Lang::get('ui.nickname')}}">
							<div class="help-block with-errors"></div>
							<span id="error-nick" class="help-block hidden">Error.</span>
						</div>
						<div class="form-group" id="form-password1">
							<label for="input-password1">{{Lang::get('ui.password')}}*</label>
							<input type="password" data-minlength="6" class="form-control" id="input-password1" placeholder="">
							<div class="help-block with-errors"></div>
							<span id="error-password1" class="help-block hidden">Error.</span>
						</div>
						<div class="form-group" id="form-password2">
							<label for="input-password2">{{Lang::get('ui.passwordRepeat')}}*</label>
							<input type="password" class="form-control" id="input-password2" data-match="#input-password1" placeholder="">
							<div class="help-block with-errors"></div>
							<span id="error-password2" class="help-block hidden">Error.</span>
						</div>
					</form>
					<div class="form-group has-error">
						<span id="error-general" class="help-block with-errors"></span>
					</div>

					<div class="form-group" style="text-align:center">
						<div class="btn btn-primary btn-block" style="margin: 0; height: 34px;" onClick="activate();">{{Lang::get('ui.activateAction')}}</div>
					</div>
			</div>
			<div class="col-md-4"></div>
		</div>
		<div class="row" id="activationResult">
			<div class="col-md-4 col-md-offset-4 form-group has-error" id="activationContents">
			</div>
			<div class="col-md-4"></div>
		</div>
	</div>
@stop