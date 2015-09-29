$(document).ready(function() {

	$('.UserExpertCheck').bootstrapSwitch({size: 'mini'});

});

function saveUser(id)
{

	var isExpert = $('#isUserExpert' + id).bootstrapSwitch('state');
	var isAdmin = $('#isUserAdmin' + id).bootstrapSwitch('state');
	var isValidator = $('#isUserValidator' + id).bootstrapSwitch('state');
	var userOrganization = $('#userOrganization' + id).val();

	$('#userLoading' + id).show();
	$('#userBtn' + id).prop('disabled', true);
	$('#userBtnText' + id).hide();
	api.addUserData(id, {expert: isExpert, admin: isAdmin, validator: isValidator, organization: userOrganization}, userSaved);

}

function userSaved(data)
{

	$('#userLoading' + data).hide();
	$('#userBtn' + data).prop('disabled', false);
	$('#userBtnText' + data).show();

}

