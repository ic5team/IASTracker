var iasList = null;
var mapHandler = null;
var iasMapHandler = null;
var userMapHandler = null;
var loadingImage = null;
var userMarkers = null;
var userObservationsMarkers = null;
var userValidatedMarkers = null;
var userDiscardedMarkers = null;
var otherUsersObservationsMarkers = null;
var otherUsersValidatedMarkers = null;
var otherUsersDiscardedMarkers = null;
var shapeLayers = null;
var activeTimeOut = null;

$(document).ready(function () {

	$().tooltip();
	$("#observedCheckBox").attr("disabled", true);
	$("#validatedCheckBox").attr("disabled", true);
	$("#userObsCheckBox").attr("disabled", true);

	$('#input-state').change(onStateChanged);

	mapHandler = new MapHandler("map", mapDescriptors, crsDescriptors, "layersControl", "controls", "observationsControls");
	$('.datetimepicker').datetimepicker({
		locale: 'ca',
		format: 'DD/MM/YYYY'
	});

	api.getIASMapFilter(getIASMapFilterOK, "#iasContents");
	loadingImage = $('#contentModalContents').html();
	configureShapes();
});

function getIASMapFilterOK(data)
{

	iasList = data;
	
	configureSwitch(".IASCheck");
	api.getObservations({}, addObservationMarkers);
	$('#taxonomyFilterSelect').change(onTaxonFilterChanged);

	$('#searchIAS').keyup(function() {

		if(null != activeTimeOut)
		clearTimeout(activeTimeOut);

		activeTimeOut = setTimeout(function() {searchIAS()}, 100);

	});

}

function onTaxonFilterChanged()
{

	searchIAS();

}

function searchIAS()
{

	var searchStr = $('#searchIAS').val();
	var val = $('#taxonomyFilterSelect').val();
	var taxonomies = taxonChilds[val];

	for(var i=0; i<iasList.length; ++i)
	{

		var current = iasList[i];
		var name = '';
		if($('#btnCommonName').hasClass('active'))
			name = current.description.name;
		else
			name = current.latinName;

		if((name.toLowerCase().indexOf(searchStr.toLowerCase()) > -1)
			&& ((current.taxonId == val) || (-1 == val) || (-1 != $.inArray(current.taxonId, taxonomies))))
			$('#IASRow'+ current.id).show();
		else
			$('#IASRow'+ current.id).hide();

	}

}

function showCommonName()
{

	$('#btnCommonName').addClass('active').siblings().removeClass('active');
	for(var i=0; i<iasList.length; ++i)
	{

		var current = iasList[i];
		$('#IASName'+ current.id).html(current.description.name);

	}

	searchIAS();

}

function showScientificName()
{

	$('#btnScientificName').addClass('active').siblings().removeClass('active');
	for(var i=0; i<iasList.length; ++i)
	{

		var current = iasList[i];
		$('#IASName'+ current.id).html(current.latinName);

	}

	searchIAS();

}

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

function configureSwitch(classId)
{

	$(classId).bootstrapSwitch({size: 'mini'});
	$(classId).each(function(index) {

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
	userObservationsMarkers = new Array();
	userValidatedMarkers = new Array();
	userDiscardedMarkers = new Array();
	otherUsersObservationsMarkers = new Array();
	otherUsersValidatedMarkers = new Array();
	otherUsersDiscardedMarkers = new Array();

	var greenIcon = constructValidatedIcon();
	var greyIcon = constructDiscardedIcon();

	for(var i=0; i<numObservacions; ++i)
	{

		var current = data[i];
		var marker;
		if(1 == current.statusId)
		{

			marker = mapHandler.createMarker(current.latitude, current.longitude, 
				current.accuracy, '#8a6d3b', '#fcf8e3', 0.5, {id : current.id, IASId: current.IASId}, onMarkerClick, greenIcon);

			if(current.userId != loggedUserId)
				otherUsersValidatedMarkers.push(marker);
			else
				userValidatedMarkers.push(marker);

		}
		else if(2 == current.statusId)
		{

			marker = mapHandler.createMarker(current.latitude, current.longitude, 
				current.accuracy, '#8a6d3b', '#fcf8e3', 0.5, {id : current.id, IASId: current.IASId}, onMarkerClick);

			if(current.userId != loggedUserId)
				otherUsersObservationsMarkers.push(marker);
			else
				userObservationsMarkers.push(marker);

		}
		else if(3 == current.statusId)
		{

			marker = mapHandler.createMarker(current.latitude, current.longitude, 
				current.accuracy, '#8a6d3b', '#fcf8e3', 0.5, {id : current.id, IASId: current.IASId}, onMarkerClick, greyIcon);

			if(current.userId != loggedUserId)
				otherUsersDiscardedMarkers.push(marker);
			else
				userDiscardedMarkers.push(marker);

		}

	}

	showObservations();
	showValidatedObservations();
	showDiscardedObservations();

	$("#observedCheckBox").bootstrapSwitch('disabled', false);
	$("#validatedCheckBox").bootstrapSwitch('disabled', false);
	$("#discardedCheckBox").bootstrapSwitch('disabled', false);
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

function showUser(id)
{

	$('#contentModalContents').html(loadingImage);
	$('#contentModalTitle').html('')
	$('#contentModal').modal();
	api.getUser(id, userLoaded, '#contentModalContents');

}

function showIAS(id)
{

	$('#contentModalContents').html(loadingImage);
	$('#contentModalTitle').html('')
	$('#contentModal').modal();
	api.getIAS(id, iasLoaded, '#contentModalContents');

}

function toggleIAS()
{

	var allIAS = $('#IASCheckAll').is(':checked');

	$('.IIASCheck').each(function(index) {

		if($(this).is(':checked') != allIAS)
		{

			$(this).click();

		}

	});

}

function observationLoaded(data)
{

}

function userLoaded(data)
{

	userMapHandler = new MapHandler("UserObsMap", mapDescriptors, crsDescriptors);
	api.getUserObservations(data.id, addUserMarkers);
	configureSwitch(".IASUserCheck");

}

function iasLoaded(data)
{

	iasMapHandler = new MapHandler("IASObsMap", mapDescriptors, crsDescriptors);
	api.getIASObservations(data, addIASMarkers);

}

function addIASMarkers(data)
{

	var numObservacions = data.length;
	var greenIcon = constructValidatedIcon();
	var greyIcon = constructDiscardedIcon();
	for(var i=0; i<numObservacions; ++i)
	{

		var current = data[i];
		var marker;
		if(1 == current.statusId)
		{

			marker = iasMapHandler.createMarker(current.latitude, current.longitude, 
				current.accuracy, '#8a6d3b', '#fcf8e3', 0.5, {id : current.id}, null, greenIcon);

		}
		else if(2 == current.statusId)
		{

			marker = iasMapHandler.createMarker(current.latitude, current.longitude, 
				current.accuracy, '#8a6d3b', '#fcf8e3', 0.5, {id : current.id}, null);

		}
		else if(3 == current.statusId)
		{

			marker = iasMapHandler.createMarker(current.latitude, current.longitude, 
				current.accuracy, '#8a6d3b', '#fcf8e3', 0.5, {id : current.id}, null, greyIcon);

		}

		iasMapHandler.addMarker(marker);

	}

}

function addUserMarkers(data)
{

	userMarkers = new Array();
	var numObservacions = data.length;
	var greenIcon = constructValidatedIcon();
	var greyIcon = constructValidatedIcon();
	for(var i=0; i<numObservacions; ++i)
	{

		var current = data[i];
		var marker;
		if(1 == current.statusId)
		{

			marker = userMapHandler.createMarker(current.latitude, current.longitude, 
				current.accuracy, '#8a6d3b', '#fcf8e3', 0.5, {id : current.id, IASId: current.IASId}, onMarkerClick, greenIcon);

		}
		else if(2 == current.statusId)
		{

			marker = userMapHandler.createMarker(current.latitude, current.longitude, 
				current.accuracy, '#8a6d3b', '#fcf8e3', 0.5, {id : current.id, IASId: current.IASId}, onMarkerClick);

		}
		else if(3 == current.statusId)
		{

			marker = userMapHandler.createMarker(current.latitude, current.longitude, 
				current.accuracy, '#8a6d3b', '#fcf8e3', 0.5, {id : current.id, IASId: current.IASId}, onMarkerClick, greyIcon);

		}

		userMarkers.push(marker);
		userMapHandler.addMarker(marker);

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

function constructDiscardedIcon()
{

	return L.icon({
	    iconUrl: 'js/images/greyMarker-icon.png',
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

function showDiscardedObservations()
{

	var onlyUserObs = (-1 != loggedUserId) && $('#userObsCheckBox').is(':checked');
	showDiscardedAux(onlyUserObs);

}

function showOnlyUserObservations()
{

	var onlyUserObs = (-1 != loggedUserId) && $('#userObsCheckBox').is(':checked');
	showObservationsAux(onlyUserObs);
	showValidatedAux(onlyUserObs);
	showDiscardedAux(onlyUserObs);

}

function showObservationsAux( onlyUserObs )
{

	if($('#observedCheckBox').is(':checked'))
	{

		for(var i=0; i<userObservationsMarkers.length; ++i)
		{

			var current = userObservationsMarkers[i];
			if($('#IASCheck' + current.marker.options.IASId).is(':checked'))
				mapHandler.addMarker(current);

		}

		if(!onlyUserObs)
		{

			for(var i=0; i<otherUsersObservationsMarkers.length; ++i)
			{

				var current = otherUsersObservationsMarkers[i];
				if($('#IASCheck' + current.marker.options.IASId).is(':checked'))
					mapHandler.addMarker(otherUsersObservationsMarkers[i]);

			}

		}
		else
		{

			for(var i=0; i<otherUsersObservationsMarkers.length; ++i)
			{

				var current = otherUsersObservationsMarkers[i];
				if($('#IASCheck' + current.marker.options.IASId).is(':checked'))
					mapHandler.removeMarker(otherUsersObservationsMarkers[i]);

			}

		}

	}
	else
	{

		for(var i=0; i<userObservationsMarkers.length; ++i)
		{

			var current = userObservationsMarkers[i];
			if($('#IASCheck' + current.marker.options.IASId).is(':checked'))
				mapHandler.removeMarker(userObservationsMarkers[i]);

		}

		for(var i=0; i<otherUsersObservationsMarkers.length; ++i)
		{

			var current = otherUsersObservationsMarkers[i];
			if($('#IASCheck' + current.marker.options.IASId).is(':checked'))
				mapHandler.removeMarker(otherUsersObservationsMarkers[i]);

		}

	}

}

function showValidatedAux( onlyUserObs )
{

	if($('#validatedCheckBox').is(':checked'))
	{

		for(var i=0; i<userValidatedMarkers.length; ++i)
		{

			var current = userValidatedMarkers[i];
			if($('#IASCheck' + current.marker.options.IASId).is(':checked'))
				mapHandler.addMarker(userValidatedMarkers[i]);

		}

		if(!onlyUserObs)
		{

			for(var i=0; i<otherUsersValidatedMarkers.length; ++i)
			{

				var current = otherUsersValidatedMarkers[i];
				if($('#IASCheck' + current.marker.options.IASId).is(':checked'))
					mapHandler.addMarker(otherUsersValidatedMarkers[i]);

			}

		}
		else
		{

			for(var i=0; i<otherUsersValidatedMarkers.length; ++i)
			{

				var current = otherUsersValidatedMarkers[i];
				if($('#IASCheck' + current.marker.options.IASId).is(':checked'))
					mapHandler.removeMarker(otherUsersValidatedMarkers[i]);

			}

		}

	}
	else
	{

		for(var i=0; i<userValidatedMarkers.length; ++i)
		{

			var current = userValidatedMarkers[i];
			if($('#IASCheck' + current.marker.options.IASId).is(':checked'))
				mapHandler.removeMarker(userValidatedMarkers[i]);

		}

		for(var i=0; i<otherUsersValidatedMarkers.length; ++i)
		{

			var current = otherUsersValidatedMarkers[i];
			if($('#IASCheck' + current.marker.options.IASId).is(':checked'))
				mapHandler.removeMarker(otherUsersValidatedMarkers[i]);

		}

	}

}

function showDiscardedAux( onlyUserObs )
{

	if($('#discardedCheckBox').is(':checked'))
	{

		for(var i=0; i<userDiscardedMarkers.length; ++i)
		{

			var current = userDiscardedMarkers[i];
			if($('#IASCheck' + current.marker.options.IASId).is(':checked'))
				mapHandler.addMarker(userDiscardedMarkers[i]);

		}

		if(!onlyUserObs)
		{

			for(var i=0; i<otherUsersDiscardedMarkers.length; ++i)
			{

				var current = otherUsersDiscardedMarkers[i];
				if($('#IASCheck' + current.marker.options.IASId).is(':checked'))
					mapHandler.addMarker(otherUsersDiscardedMarkers[i]);

			}

		}
		else
		{

			for(var i=0; i<otherUsersDiscardedMarkers.length; ++i)
			{

				var current = otherUsersDiscardedMarkers[i];
				if($('#IASCheck' + current.marker.options.IASId).is(':checked'))
					mapHandler.removeMarker(otherUsersDiscardedMarkers[i]);

			}

		}

	}
	else
	{

		for(var i=0; i<userDiscardedMarkers.length; ++i)
		{

			var current = userDiscardedMarkers[i];
			if($('#IASCheck' + current.marker.options.IASId).is(':checked'))
				mapHandler.removeMarker(userDiscardedMarkers[i]);

		}

		for(var i=0; i<otherUsersDiscardedMarkers.length; ++i)
		{

			var current = otherUsersDiscardedMarkers[i];
			if($('#IASCheck' + current.marker.options.IASId).is(':checked'))
				mapHandler.removeMarker(otherUsersDiscardedMarkers[i]);

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
	var regionId = $('#input-regions').val();
	var areaId = $('#input-areas').val();

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

function downloadObs()
{

	$('#overlay').show();

	var taxonomyId = $('#input-group').val();
	var fromDate = $('#fromDate').val();
	var toDate = $('#toDate').val();
	var stateId = $('#input-state').val();
	var regionId = $('#input-regions').val();
	var areaId = $('#input-areas').val();

	api.downloadFilteredObservations( 
		{
			taxonomyId : taxonomyId,
			fromDate : fromDate,
			toDate : toDate,
			stateId : stateId,
			regionId : regionId,
			areaId : areaId
		}
		,fileDownloaded, fileNotDownloaded
	);

}

function fileDownloaded()
{

	$('#filterError').hide();
	$('#overlay').hide();

}

function fileNotDownloaded(response)
{

	var obj = JSON.parse(response);
	$('#filterErrorMsg').html(obj.error);
	$('#filterError').show();
	$('#overlay').hide();

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

	for(var i=0; i<userDiscardedMarkers.length; ++i)
	{

		mapHandler.removeMarker(userDiscardedMarkers[i]);

	}

	for(var i=0; i<otherUsersDiscardedMarkers.length; ++i)
	{

		mapHandler.removeMarker(otherUsersDiscardedMarkers[i]);

	}

}

function activeUserIAS(id)
{

	if($('#IASUserCheck'+id).is(':checked'))
	{

		for(var i=0; i<userMarkers.length; ++i)
		{

			var current = userMarkers[i];
			if(current.marker.options.IASId == id)
				userMapHandler.addMarker(current);

		}

	}
	else
	{

		for(var i=0; i<userMarkers.length; ++i)
		{

			var current = userMarkers[i];
			if(current.marker.options.IASId == id)
				userMapHandler.removeMarker(current);

		}

	}

}

function activeIAS(id)
{

	var actius = $('.IIASCheck:checked').length;
	var totals = $('.IIASCheck').length;

	if(0 == actius)
	{

		$('#IASCheckAll').bootstrapSwitch('state', false);

	}
	else if(totals == actius)
	{

		$('#IASCheckAll').bootstrapSwitch('state', true);

	}

	if($('#IASCheck'+id).is(':checked'))
	{

		if(!$('#userObsCheckBox').is(':checked'))
		{

			if($('#validatedCheckBox').is(':checked'))
			{

				for(var i=0; i<otherUsersValidatedMarkers.length; ++i)
				{

					var current = otherUsersValidatedMarkers[i];
					if(current.marker.options.IASId == id)
						mapHandler.addMarker(current);

				}

			}

			if($('#observedCheckBox').is(':checked'))
			{

				for(var i=0; i<otherUsersObservationsMarkers.length; ++i)
				{

					var current = otherUsersObservationsMarkers[i];
					if(current.marker.options.IASId == id)
						mapHandler.addMarker(current);

				}

			}

			if($('#discardedCheckBox').is(':checked'))
			{

				for(var i=0; i<otherUsersDiscardedMarkers.length; ++i)
				{

					var current = otherUsersDiscardedMarkers[i];
					if(current.marker.options.IASId == id)
						mapHandler.addMarker(current);

				}

			}

		}

		if($('#validatedCheckBox').is(':checked'))
		{

			for(var i=0; i<userValidatedMarkers.length; ++i)
			{

				var current = userValidatedMarkers[i];
				if(current.marker.options.IASId == id)
					mapHandler.addMarker(current);

			}

		}

		if($('#observedCheckBox').is(':checked'))
		{

			for(var i=0; i<userObservationsMarkers.length; ++i)
			{

				var current = userObservationsMarkers[i];
				if(current.marker.options.IASId == id)
					mapHandler.addMarker(current);

			}

		}

		if($('#discardedCheckBox').is(':checked'))
		{

			for(var i=0; i<userDiscardedMarkers.length; ++i)
			{

				var current = userDiscardedMarkers[i];
				if(current.marker.options.IASId == id)
					mapHandler.addMarker(current);

			}

		}

	}
	else
	{

		if(!$('#userObsCheckBox').is(':checked'))
		{

			if($('#validatedCheckBox').is(':checked'))
			{

				for(var i=0; i<otherUsersValidatedMarkers.length; ++i)
				{

					var current = otherUsersValidatedMarkers[i];
					if(current.marker.options.IASId == id)
						mapHandler.removeMarker(current);

				}

			}

			if($('#observedCheckBox').is(':checked'))
			{

				for(var i=0; i<otherUsersObservationsMarkers.length; ++i)
				{

					var current = otherUsersObservationsMarkers[i];
					if(current.marker.options.IASId == id)
						mapHandler.removeMarker(current);

				}

			}

			if($('#discardedCheckBox').is(':checked'))
			{

				for(var i=0; i<otherUsersDiscardedMarkers.length; ++i)
				{

					var current = otherUsersDiscardedMarkers[i];
					if(current.marker.options.IASId == id)
						mapHandler.removeMarker(current);

				}

			}

		}

		if($('#validatedCheckBox').is(':checked'))
		{

			for(var i=0; i<userValidatedMarkers.length; ++i)
			{

				var current = userValidatedMarkers[i];
				if(current.marker.options.IASId == id)
					mapHandler.removeMarker(current);

			}

		}

		if($('#observedCheckBox').is(':checked'))
		{

			for(var i=0; i<userObservationsMarkers.length; ++i)
			{

				var current = userObservationsMarkers[i];
				if(current.marker.options.IASId == id)
					mapHandler.removeMarker(current);

			}

		}

		if($('#discardedCheckBox').is(':checked'))
		{

			for(var i=0; i<userDiscardedMarkers.length; ++i)
			{

				var current = userDiscardedMarkers[i];
				if(current.marker.options.IASId == id)
					mapHandler.removeMarker(current);

			}

		}

	}

}

function configureShapes()
{

	shapeLayers = new Array();
	for(var i=0; i<shapes.length; ++i)
	{

		var current = shapes[i];
		var layer = new L.Shapefile(current, {
			style : function(feature) {
				return {
					"color": randomColor(),
					"weight": 4,
					"opacity": 1
					};
			},
			onEachFeature: function(feature, layer) {
				layer.bindPopup("" + shapeNames[feature.properties.ID]);
			}
		});
		shapeLayers.push(layer);

	}

}

function randomColor() {
    // HSV to RBG adapted from: http://mjijackson.com/2008/02/rgb-to-hsl-and-rgb-to-hsv-color-model-conversion-algorithms-in-javascript
    var r, g, b;
    var h = Math.random();
    var i = ~~(h * 6);
    var f = h * 6 - i;
    var q = 1 - f;
    switch(i % 6){
        case 0: r = 1; g = f; b = 0; break;
        case 1: r = q; g = 1; b = 0; break;
        case 2: r = 0; g = 1; b = f; break;
        case 3: r = 0; g = q; b = 1; break;
        case 4: r = f; g = 0; b = 1; break;
        case 5: r = 1; g = 0; b = q; break;
    }
    var c = "#" + ("00" + (~ ~(r * 255)).toString(16)).slice(-2) + ("00" + (~ ~(g * 255)).toString(16)).slice(-2) + ("00" + (~ ~(b * 255)).toString(16)).slice(-2);
    return (c);
}

function showAreas()
{

	if($('#areasCheckBox').is(':checked'))
	{

		for(var i=0; i<shapeLayers.length; ++i)
		{

			mapHandler.addLayer(shapeLayers[i]);

		}

	}
	else
	{

		for(var i=0; i<shapeLayers.length; ++i)
		{

			mapHandler.removeLayer(shapeLayers[i]);

		}

	}	

}

function updateUserData()
{

	$('#dataModalText').html('');
	$('#input-name').val(fullName);
	$('#amIExpertCheckbox').bootstrapSwitch('state', isExpert);
	var img = $('#imgPerfilBarra').attr('src');
	$('#imgPerfilCompletar').data('url', img);
	$('#imgPerfilCompletar').css({'background-image': 'url(' + img + ')'});
	$('#completar-dades-modal').modal();
	$('#pas3').addClass('hidden');
	antPas3();

}

function cleanFilter()
{

	$('#input-group').val(-1);
	$('#fromDate').val('');
	$('#toDate').val('');
	$('#input-state').val(-1);
	$('#regionAndAreaSelect').html('');
	$('#filterSelectLoader').hide();
	filterObs();

}