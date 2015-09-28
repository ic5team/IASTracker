var mapHandler = null;
$(document).ready(function() {

});

function validate(id)
{

	$('obs' + id + 'Button').hide();
	$('loading' + id).show();
	api.validateObservation(id, obsStateChanged);

}

function discard(id)
{

	$('obs' + id + 'Button').hide();
	$('loading' + id).show();
	api.discardObservation(id, obsStateChanged);

}

function obsStateChanged(data)
{

	var obj = data;
	if (!obj.hasOwnProperty('error'))
	{

		$('#panel'+obj).remove();
		$('#collapse'+obj).remove();

	}

}