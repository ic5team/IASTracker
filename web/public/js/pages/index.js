var iasList = null;
var mapHandler = null;
var iasMapHandler = null;
var loadingImage = null;

$(document).ready(function () {

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
	for(var i=0; i<numObservacions; ++i)
	{

		var current = data[i];
		if(1 == current.statusId)
		{

			var greenIcon = constructValidatedIcon();
			mapHandler.addMarker(current.latitude, current.longitude, 
				current.accuracy, 'red', '#f03', 0.5, {id : current.id}, onMarkerClick, greenIcon);

		}
		else
		{

			mapHandler.addMarker(current.latitude, current.longitude, 
				current.accuracy, 'red', '#f03', 0.5, {id : current.id}, onMarkerClick);

		}

	}

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