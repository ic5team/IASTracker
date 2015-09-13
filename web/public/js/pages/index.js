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

	$('#input-state').change(onStateChanged);

	mapHandler = new MapHandler("map", mapDescriptors, crsDescriptors, "layersControl", "controls", "observationsControls");
	$('.datetimepicker').datetimepicker({
		locale: 'ca',
		format: 'DD/MM/YYYY'
	});

	api.getIASMapFilter(function(data) { iasList = data; configureSwitch();}, "#iasContents");
	api.getObservations(addObservationMarkers);
	loadingImage = $('#contentModalContents').html();

});

function onStateChanged()
{

	$('#regionAndAreaSelect').hide();
	$('#filterSelectLoader').show();
	var id = $('#input-state').val();
	api.getStateRegions(id, stateRegionsOk, '#regionAndAreaSelect');

}

function stateRegionsOk(data)
{

	$('#input-regions').change(onRegionChanged);
	$('#filterSelectLoader').hide();
	$('#regionAndAreaSelect').show();

}

function onRegionChanged()
{

	$('#areaSelect').hide();
	$('#filterSelectLoader').show();
	var id = $('#input-regions').val();
	api.getRegionAreas(id, areaRegionsOk, '#areaSelect');

}

function areaRegionsOk(data)
{

	$('#filterSelectLoader').hide();
	$('#areaSelect').show();

}

function configureSwitch()
{

	$(".IASCheck").bootstrapSwitch({size: 'mini'});
	$(".IASCheck").each(function(index) {

		var functionString = $(this).attr('onclick');
		if("" != functionString)
		{

			var func = window[functionString];
			if("function" === typeof func)
			{

				var arg = $(this).attr('data');
				if(undefined !== typeof arg)
					$(this).on('switchChange.bootstrapSwitch', function() { func.apply(null, [arg]); });
				else
					$(this).on('switchChange.bootstrapSwitch', func);

			}

		}

	});

}

function addObservationMarkers(data)
{

	var numObservacions = data.length;
	observations = data;
	userObservationsMarkers = new Array();
	userValidatedMarkers = new Array();
	otherUsersObservationsMarkers = new Array();
	otherUsersValidatedMarkers = new Array();

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

			if(current.userId != loggedUserId)
				otherUsersObservationsMarkers.push(marker);
			else
				userObservationsMarkers.push(marker);

		}

	}

	showObservations();
	showValidatedObservations();

	$("#observedCheckBox").bootstrapSwitch('disabled', false);
	$("#validatedCheckBox").bootstrapSwitch('disabled', false);
	$("#userObsCheckBox").bootstrapSwitch('disabled', false);

	$('#overlay').hide();
}

function onMarkerClick(e)
{

	$('#contentModalContents').html(loadingImage);
	$('#contentModalTitle').html('')
	$('#contentModal').modal();
	api.getIASObservation(this.options.id, observationLoaded, '#contentModalContents');

}

function showIAS(id)
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
		var marker;
		if(1 == current.statusId)
		{

			var greenIcon = constructValidatedIcon();
			marker = iasMapHandler.createMarker(current.latitude, current.longitude, 
				current.accuracy, 'red', '#f03', 0.5, {id : current.id}, onMarkerClick, greenIcon);

		}
		else
		{

			marker = iasMapHandler.createMarker(current.latitude, current.longitude, 
				current.accuracy, 'red', '#f03', 0.5, {id : current.id}, onMarkerClick);

		}

		iasMapHandler.addMarker(marker);

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

	var onlyUserObs = (-1 != loggedUserId) && $('#userObsCheckBox').is(':checked');
	showObservationsAux(onlyUserObs);

}

function showValidatedObservations()
{

	var onlyUserObs = (-1 != loggedUserId) && $('#userObsCheckBox').is(':checked');
	showValidatedAux(onlyUserObs);

}

function showOnlyUserObservations()
{

	var onlyUserObs = (-1 != loggedUserId) && $('#userObsCheckBox').is(':checked');
	showObservationsAux(onlyUserObs);
	showValidatedAux(onlyUserObs);

}

function showObservationsAux( onlyUserObs )
{

	if($('#observedCheckBox').is(':checked'))
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

function filterObs()
{

	clearObservations();
	$('#overlay').show();

	var taxonomyId = $('#input-group').val();
	var fromDate = $('#fromDate').val();
	var toDate = $('#toDate').val();
	var stateId = $('#input-state').val();
	var regionId = $('#input-region').val();
	var areaId = $('#input-area').val();

	api.getFilteredObservations( 
		{
			taxonomyId : taxonomyId,
			fromDate : fromDate,
			toDate : toDate,
			stateId : stateId,
			regionId : regionId,
			areaId : areaId
		}
		,addObservationMarkers
	);

}

function clearObservations()
{

	for(var i=0; i<userObservationsMarkers.length; ++i)
	{

		mapHandler.removeMarker(userObservationsMarkers[i]);

	}

	for(var i=0; i<otherUsersObservationsMarkers.length; ++i)
	{

		mapHandler.removeMarker(otherUsersObservationsMarkers[i]);

	}

	for(var i=0; i<userValidatedMarkers.length; ++i)
	{

		mapHandler.removeMarker(userValidatedMarkers[i]);

	}

	for(var i=0; i<otherUsersValidatedMarkers.length; ++i)
	{

		mapHandler.removeMarker(otherUsersValidatedMarkers[i]);

	}

}

function activeIAS(i)
{

	alert('clicked');

}