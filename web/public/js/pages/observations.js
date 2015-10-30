var mapHandlers = {};
$(document).ready(function() {

	var cameraMarker = L.icon({
	    iconUrl: '../js/images/cameraMarker-icon.png',
	    shadowUrl: '../js/images/marker-shadow.png',

	    iconSize:     [25, 41], // size of the icon
	    shadowSize:   [41, 41], // size of the shadow
	    iconAnchor:   [13, 41], // point of the icon which will correspond to marker's location
	    shadowAnchor: [12, 40]  // the same for the shadow
	});

	$('.insideCollapseButton').click(function(e) {
		e.stopPropagation();
	});

	$('.obsCollapse').on('show.bs.collapse', function() {
		var id = $(this).attr('data-id');

		$('#obs' + id + 'Arrow').removeClass('fa-angle-down');
		$('#obs' + id + 'Arrow').addClass('fa-angle-up');

	});

	$('.obsCollapse').on('hide.bs.collapse', function() {
		var id = $(this).attr('data-id');

		$('#obs' + id + 'Arrow').removeClass('fa-angle-up');
		$('#obs' + id + 'Arrow').addClass('fa-angle-down');
		
	});

	$('.obsCollapse').on('shown.bs.collapse', function () {

		var id = $(this).attr('data-id');
		var lat = $(this).attr('data-lat');
		var lon = $(this).attr('data-lon');
		var acc = $(this).attr('data-acc');

		if(id in mapHandlers)
		{

		}
		else
		{
		
			mapHandlers[id] = new MapHandler('obsMap' + id, mapDescriptors, crsDescriptors);

			//IAS marker
			var marker = mapHandlers[id].createMarker(lat, lon, acc, 'red', '#f03', 0.5);
			mapHandlers[id].addMarker(marker);

			//Images marker
			var imagesOk = true;
			var imageMarkers = new Array();
			imageMarkers.push(marker.marker);
			$('.obs'+id+'Image').each(function(index) {

				var lat = $(this).attr('data-lat');
				var lon = $(this).attr('data-lon');
				imagesOk = imagesOk && ('undefined' != typeof lat) 
					&& ('undefined' != typeof lon);

				if(imagesOk)
				{

					var imageMarker = mapHandlers[id].createMarker(lat, lon, 0, 'red', '#f03', 0.5, {}, null, cameraMarker);
					mapHandlers[id].addMarker(imageMarker);
					imageMarkers.push(imageMarker.marker);

				}

			});

			if(imagesOk)
			{

				$('#obs'+id+'ImageWarning').show();

			}
			else
			{

				$('#obs'+id+'ImageError').show();

			}

			mapHandlers[id].fitBounds(imageMarkers);

		}

	});

});

function showValidationModal(id, isValidation)
{

	if(isValidation)
	{
	
		$('#validateButton').attr('onclick', 'validate(' + id + ')');
		$('#discardButton').hide();
		$('#validateButton').show();

	}
	else
	{

		$('#discardButton').attr('onclick', 'discard(' + id + ')');
		$('#discardButton').show();
		$('#validateButton').hide();

	}

	$('#validationTextError').hide();
	$('#serverError').hide();
	$('#modalButtons').show();
	$('#modalLoading').hide();
	$('#validationText').val('');

	$('#validationModal').modal();

}

function validate(id)
{

	$('#modalButtons').hide();
	$('#modalLoading').show();
	var text = $('#validationText').val();
	api.validateObservation(id, text, obsStateChanged);

}

function discard(id)
{

	var text = $.trim($('#validationText').val());
	if('' != text)
	{

		$('#modalButtons').hide();
		$('#modalLoading').show();

		api.discardObservation(id, text, obsStateChanged);

	}
	else
	{

		$('#validationTextError').show();

	}

}

function obsStateChanged(data)
{

	var obj = data;
	if (!obj.hasOwnProperty('ok'))
	{

		$('#validationModal').modal('hide');
		$('#panel'+obj).remove();
		$('#collapse'+obj).remove();

	}
	else
	{

		$('#serverErrorMessage').html(obj.msg + ': ' + obj.internalMsg);
		$('#serverError').show();

	}

}