$( document ).ready(function() {

});

function activate(){

	var newPw = $('#input-password1').val();
	var newPw2 = $('#input-password2').val();
	var nick = $('#input-nick').val();
   
	if(checkForm(newPw, newPw2, nick))
	{

		$('#error-general').hide();
		api.activateUser(id, {token : token, pw1: newPw, pw2 : newPw2, 
			nick : nick}, null, '#activationContents');

	}
	else{
		//Error
	}

}

function checkForm(pw1, pw2, nick)
{

	var ok = true;

	if('' == nick || !isValidNickName(nick))
	{
		$('#form-nick').addClass('has-error');
		$('#error-nick').removeClass('hidden');
		$('#form-nick .form-control-feedback').removeClass('hidden');
		if('' == nick)
			$('#error-nick').html(requiredFieldError);
		else
			$('#error-nick').html(invalidNickError);

		ok = false;
	}
	 else{
		$('#form-nick').removeClass('has-error');
		$('#error-nick').addClass('hidden');
	}

	if('' ==  pw1 || !isValidPassword(pw1))
	{
		$('#form-password1').addClass('has-error');
		$('#error-password1').removeClass('hidden');
		$('#form-password1 .form-control-feedback').removeClass('hidden');

		if('' == pw1)
			$('#error-password1').html(requiredFieldError);
		else
			$('#error-password1').html(invalidPwError);

		ok = false;
	}
	 else{
		$('#form-password1 ' ).removeClass('has-error');
		$('#errorpassword1').addClass('hidden');
	}

	if('' ==  pw2 || !isValidPassword(pw2))
	{
		$('#form-password2').addClass('has-error');
		$('#error-password2').removeClass('hidden');
		$('#form-password2 .form-control-feedback').removeClass('hidden');
		if('' == pw2)
			$('#error-password2').html(requiredFieldError);
		else
			$('#error-password2').html(invalidPwError);

		ok = false;
	}
	 else{
		$('#form-password2 ' ).removeClass('has-error');
		$('#error-password2').addClass('hidden');
	}


	if (pw1 != pw2)
	{
		$('#error-general').show();
		$('#error-general').html(pwMismatchError);
		ok = false;
	}

	return ok;
}