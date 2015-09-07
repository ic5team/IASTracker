var iasList = null;
var mapHandler = null;
var iasMapHandler = null;
var loadingImage = null;
var observations = null;
var userObservationsMarkers = null;
var userValidatedMarkers = null;
var otherUsersObservationsMarkers = null;
var otherUsersValidatedMarkers = null;

$(document).ready(function () {

	$("#observedCheckBox").attr("disabled", true);
	$("#validatedCheckBox").attr("disabled", true);
	$("#userObsCheckBox").attr("disabled", true);

	mapHandler = new MapHandler("map", mapDescriptors, crsDescriptors, "layersControl", "controls", "observationsControls");
	$('.datetimepicker').datetimepicker({
		locale: 'ca',
		format: 'DD/MM/YYYY'
	});
	$(".IASCheck").bootstrapSwitch({size: 'mini'});
	api.getIASMapFilter(function(data) { iasList = data; $(".IASCheck").bootstrapSwitch({size: 'mini'});}, "#iasContents");
	api.getObservations(addObservationMarkers);
	loadingImage = $('#contentModalContents').html();

});

function addObservationMarkers(data)
{

	var numObservacions = data.length;
	observations = data;
	observationMarkers = new Array();
	validatedMarkers = new Array();
	userMarkers = new Array();

	for(var i=0; i<numObservacions; ++i)
	{

		var current = data[i];
		var marker;
		if(1 == current.statusId)
		{

			var greenIcon = constructValidatedIcon();
			marker = mapHandler.createMarker(current.latitude, current.longitude, 
				current.accuracy, 'red', '#f03', 0.5, {id : current.id}, onMarkerClick, greenIcon);

			if(current.userId != loggedUserId)
				otherUsersValidatedMarkers.push(marker);
			else
				userValidatedMarkers.push(marker);

		}
		else
		{

			marker = mapHandler.createMarker(current.latitude, current.longitude, 
				current.accuracy, 'red', '#f03', 0.5, {id : current.id}, onMarkerClick);
			observationMarkers.push(marker);

			if(current.userId != loggedUserId)
				otherUsersObservationsMarkers.push(marker);
			else
				userObservationsMarkers.push(marker);

		}

	}

	showObservations();
	showValidatedObservations();

	$("#observedCheckBox").removeAttr("disabled");
	$("#validatedCheckBox").removeAttr("disabled");
	$("#userObsCheckBox").removeAttr("disabled");

}

function onMarkerClick(e)
{

	$('#contentModalContents').html(loadingImage);
	$('#contentModalTitle').html('')
	$('#contentModal').modal();
	api.getIASObservation(this.options.id, observationLoaded, '#contentModalContents');

}

function veureIAS(id)
{

	$('#contentModalContents').html(loadingImage);
	$('#contentModalTitle').html('')
	$('#contentModal').modal();
	api.getIAS(id, iasLoaded, '#contentModalContents');

}

function observationLoaded(data)
{

}

function iasLoaded(data)
{

	iasMapHandler = new MapHandler("IASObsMap", mapDescriptors, crsDescriptors);
	api.getIASObservations(data, addIASMarkers)

}

function addIASMarkers(data)
{

	var numObservacions = data.length;
	for(var i=0; i<numObservacions; ++i)
	{

		var current = data[i];
		if(1 == current.statusId)
		{

			var greenIcon = constructValidatedIcon();
			iasMapHandler.addMarker(current.latitude, current.longitude, 
				current.accuracy, 'red', '#f03', 0.5, {id : current.id}, null, greenIcon);

		}
		else
		{

			iasMapHandler.addMarker(current.latitude, current.longitude, 
				current.accuracy, 'red', '#f03', 0.5, {id : current.id});

		}
		

	}

}

function constructValidatedIcon()
{

	return L.icon({
	    iconUrl: 'js/images/greenMarker-icon.png',
	    shadowUrl: 'js/images/marker-shadow.png',

	    iconSize:     [25, 41], // size of the icon
	    shadowSize:   [41, 41], // size of the shadow
	    iconAnchor:   [13, 41], // point of the icon which will correspond to marker's location
	    shadowAnchor: [12, 40]  // the same for the shadow
	});

}

function showObservations()
{

	var onlyUserObs = $('#userObsCheckBox').is(':checked');
	showObservationsAux(onlyUserObs);

}

function showValidatedObservations()
{

	var onlyUserObs = $('#userObsCheckBox').is(':checked');
	showValidatedAux(onlyUserObs);

}

function showOnlyUserObservations()
{

	var onlyUserObs = $('#userObsCheckBox').is(':checked');
	showObservationsAux(onlyUserObs);
	showValidatedAux(onlyUserObs);

}

function showObservationsAux( onlyUserObs )
{

	if($('#userObsCheckBox').is(':checked'))
	{

		for(var i=0; i<userObservationsMarkers.length; ++i)
		{

			mapHandler.addMarker(userObservationsMarkers[i]);

		}

		if(!onlyUserObs)
		{

			for(var i=0; i<otherUsersObservationsMarkers.length; ++i)
			{

				mapHandler.addMarker(otherUsersObservationsMarkers[i]);

			}

		}

	}
	else
	{

		for(var i=0; i<userObservationsMarkers.length; ++i)
		{

			mapHandler.removeMarker(userObservationsMarkers[i]);

		}

		if(!onlyUserObs)
		{

			for(var i=0; i<otherUsersObservationsMarkers.length; ++i)
			{

				mapHandler.removeMarker(otherUsersObservationsMarkers[i]);

			}

		}

	}

}

function showValidatedAux( onlyUserObs )
{

	if($('#validatedCheckBox').is(':checked'))
	{

		for(var i=0; i<userValidatedMarkers.length; ++i)
		{

			mapHandler.addMarker(userValidatedMarkers[i]);

		}

		if(!onlyUserObs)
		{

			for(var i=0; i<otherUsersValidatedMarkers.length; ++i)
			{

				mapHandler.addMarker(otherUsersValidatedMarkers[i]);

			}

		}

	}
	else
	{

		for(var i=0; i<userValidatedMarkers.length; ++i)
		{

			mapHandler.removeMarker(userValidatedMarkers[i]);

		}

		if(!onlyUserObs)
		{

			for(var i=0; i<otherUsersValidatedMarkers.length; ++i)
			{

				mapHandler.removeMarker(otherUsersValidatedMarkers[i]);

			}

		}

	}

}