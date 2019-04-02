$(document).ready(function() {
	
	$("#navbar-loguejat").on("mouseover", function () {
		$('#panell-usuari').removeClass('hidden');
	});

	$("#navbar-loguejat").on("mouseleave", function () {
		$('#panell-usuari').addClass('hidden');
	});

	$(".languageSelector").change(function() {
		var url = window.location.href;
		window.location.href = url.substr(0, url.indexOf(window.location.search)) + $(this).find("option:selected").val();
	});

});

function showLogInModal()
{

	$('#loginModal').modal();

}

function showLogIn()
{

	$('#loginModal').modal();
	$('#signupModal').modal('hide');

}

function showSignUpModal()
{

	$('#signupDesc').show();
	$('#signupPanel').show();
	$('#signupDone').hide();
	$('#input-signupEmail').val('');
	$('#form-signupEmail').removeClass('has-error');
	$('#error-usedEmail').addClass('hidden');
	$('#error-invalidEmail').addClass('hidden');
	$('#signupModal').modal();

}

function showSignUp()
{

	$('#loginModal').modal('hide');
	$('#signupModal').modal();

}

function loginUsuari()
{

	$('#loginForm').submit();

}

function userSignUp()
{

	var val = $('#input-signupEmail').val();

	$('#form-signupEmail').removeClass('has-error');
	$('#error-usedEmail').addClass('hidden');
	$('#error-invalidEmail').addClass('hidden');

	if(isValidEmail(val))
	{

		$('#error-invalidEmail').addClass('hidden');
		$('#signupPanel').hide();
		$('#signupLoading').show();
		api.addUser(val, userRegistered);

	}
	else
	{

		$('#signupPanel').show();
		$('#signupLoading').hide();
		$('#error-usedEmail').addClass('hidden');
		$('#form-signupEmail').addClass('has-error');
		$('#error-invalidEmail').removeClass('hidden');

	}

}

function userRegistered(data)
{

	$('#signupLoading').hide();
	if(data.hasOwnProperty('error'))
	{

		$('#signupPanel').show();
		$('#form-signupEmail').addClass('has-error');
		$('#error-usedEmail').removeClass('hidden');

	}
	else
	{
	
		$('#signupDesc').hide();
		$('#signupDone').show();

	}

}

function showRememberPw()
{

	$('#signupModal').modal('hide');
	$('#loginModal').modal('hide');

	$('#remindPasswordDesc').show();
	$('#remindPasswordPanel').show();
	$('#remindPasswordDone').hide();
	$('#input-reminderEmail').val('');
	$('#form-reminderEmail').removeClass('has-error');
	$('#error-notUsedEmail').addClass('hidden');
	$('#error-invalidEmail').addClass('hidden');

	$('#remindModal').modal();

}

function remindPassword()
{

	var val = $('#input-reminderEmail').val();

	$('#form-reminderEmail').removeClass('has-error');
	$('#error-notUsedEmail').addClass('hidden');
	$('#error-invalidEmail').addClass('hidden');

	if(isValidEmail(val))
	{

		$('#error-invalidEmail').addClass('hidden');
		$('#remindPasswordPanel').hide();
		$('#remindPasswordLoading').show();
		api.remindUser(val, userReminded);

	}
	else
	{

		$('#remindPasswordPanel').show();
		$('#remindPasswordLoading').hide();
		$('#error-notUsedEmail').addClass('hidden');
		$('#form-reminderEmail').addClass('has-error');
		$('#error-invalidEmail').removeClass('hidden');

	}

}

function userReminded(data)
{

	$('#remindPasswordLoading').hide();
	if(data.hasOwnProperty('error'))
	{

		$('#remindPasswordPanel').show();
		$('#form-reminderEmail').addClass('has-error');
		$('#error-notUsedEmail').removeClass('hidden');

	}
	else
	{
	
		$('#remindPasswordDesc').hide();
		$('#remindPasswordDone').show();

	}

}