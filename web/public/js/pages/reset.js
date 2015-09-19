$( document ).ready(function() {

});

function reset(){

	var newPw = $('#input-password1').val();
	var newPw2 = $('#input-password2').val();
   
	if(checkForm(newPw, newPw2))
	{

		$('#error-general').hide();
		api.resetUserPassword(id, {token : token, pw1: newPw, pw2 : newPw2}, 
			null, '#resetContents');

	}
	else{
		//Error
	}

}

function checkForm(pw1, pw2)
{

	var ok = true;

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