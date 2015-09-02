var iasList = null;
var mapHandler = null;
var iasMapHandler = null;
var loadingImage = null;

$(document).ready(function () {

	mapHandler = new MapHandler("map", "layersControl", "controls", mapDescriptors, crsDescriptors);
	$('.datetimepicker').datetimepicker({
		locale: 'ca',
		format: 'DD/MM/YYYY'
	});
	$(".IASCheck").bootstrapSwitch();
	api.getIASMapFilter(function(data) { iasList = data; $(".IASCheck").bootstrapSwitch();}, "#iasContents");
	api.getObservations(addObservationMarkers);
	loadingImage = $('#contentModalContents').html();

});

function addObservationMarkers(data)
{

	var numObservacions = data.length;
	for(var i=0; i<numObservacions; ++i)
	{

		var current = data[i];
		mapHandler.addMarker(current.latitude, current.longitude, 
			current.accuracy, 'red', '#f03', 0.5, {id : current.id}, onMarkerClick);

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

	iasMapHandler = new MapHandler("IASObsMap", null, null, mapDescriptors, crsDescriptors);
	api.getIASObservations(data, addIASMarkers)

}

function addIASMarkers(data)
{

	var numObservacions = data.length;
	for(var i=0; i<numObservacions; ++i)
	{

		var current = data[i];
		iasMapHandler.addMarker(current.latitude, current.longitude, 
			current.accuracy, 'red', '#f03', 0.5, {id : current.id});

	}

}