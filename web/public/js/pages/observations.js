var mapHandlers = {};
var dt;
var cameraMarker = L.icon({
    iconUrl: '../js/images/cameraMarker-icon.png',
    shadowUrl: '../js/images/marker-shadow.png',

    iconSize:     [25, 41], // size of the icon
    shadowSize:   [41, 41], // size of the shadow
    iconAnchor:   [13, 41], // point of the icon which will correspond to marker's location
    shadowAnchor: [12, 40]  // the same for the shadow
});

$(document).ready(function() {

	dt = $('#dataContainer').DataTable({
		serverSide: true,
		ajax: function (data, callback, settings) {

			data.viewPending = $('#pendingCheckBox').is(':checked');
			data.viewValidated = $('#validatedCheckBox').is(':checked');
			data.viewDiscarded = $('#discardedCheckBox').is(':checked');
			data.viewDeleted = $('#deletedCheckBox').is(':checked');

			api.getObservations(data, callback);

		},
		columns: [
			{
                class:          "details-control",
                orderable:      false,
                data:           null,
                defaultContent: ""
            },
            { 
            	data: 'id',
            	visible: false
        	},
        	{ data: 'latinName' },
			{ data: 'fullName' },
			{ 	data: 'status',
				orderable: false,
				render: function ( data, type, row ) 
				{

					var icon = '<i class="' + row.statusIcon + '"></i>';
					if(4 == row.statusId)
						icon = '<i class="fa fa-trash-o fa-2x"></i>'
                    return icon;
                }
			},
			{ data: 'observations.created_at'},
			{ 
				data: null, 
				orderable: false,
				render: function ( data, type, row ) {
					var validateBtn = '<button onclick="showValidationModal(' + row.id + ', true)" class="btn btn-success insideCollapseButton" >Validate</button>';
					var discardBtn = '<button onclick="showValidationModal(' + row.id + ', false)" class="btn btn-danger insideCollapseButton" >Discard</button>';
					var deleteBtn = '<button type="button" class="btn btn-danger" onclick="deleteObs(' + row.id + ')"><i class="fa fa-trash-o"></i></button>';
					var loading = '<img src="' + urlImg + '/loader.gif" class="loading" data-id=' + row.id + ' style="display:none;"/>';
                    return (4 != row.statusId) ? '<div class="btns" data-id="' + row.id + '" >' + ((2 == row.statusId) ? validateBtn + discardBtn : '' ) + deleteBtn + '</div>' + loading : '';
                } 
            }
		],
		order: [[5, 'desc']]
	});

	// Array to track the ids of the details displayed rows
    var detailRows = [];
 
    $('#dataContainer tbody').on( 'click', 'tr td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = dt.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRows );
 
        if ( row.child.isShown() ) {
            tr.removeClass( 'details' );
            row.child.hide();
 
            // Remove from the 'open' array
            detailRows.splice( idx, 1 );
        }
        else {
            tr.addClass( 'details' );
            row.child( childRow( row.data() ) ).show();
            initRow(row.data());
 
            // Add to the 'open' array
            if ( idx === -1 ) {
                detailRows.push( tr.attr('id') );
            }
        }
    } );
 
    // On each draw, loop over the `detailRows` array and show any child rows
    dt.on( 'draw', function () 
    {

        $.each( detailRows, function ( i, id ) {
            $('#'+id+' td.details-control').trigger( 'click' );
        } );

    });

    $('#pendingCheckBox').click(function() { dt.ajax.reload(); });
    $('#validatedCheckBox').click(function() { dt.ajax.reload(); });
    $('#discardedCheckBox').click(function() { dt.ajax.reload(); });
    $('#deletedCheckBox').click(function() { dt.ajax.reload(); });

});

function childRow(data)
{

	return data.innerHtml;

}

function initRow(data)
{

	var id = parseInt(data.id);
	var lat = parseFloat(data.latitude);
	var lon = parseFloat(data.longitude);
	var acc = parseFloat(data.accuracy);

	/*if(id in mapHandlers)
	{

		mapHandlers[id].fitBounds(mapHandlers[id].imageMarkers);

	}
	else
	{*/

	
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

		mapHandlers[id].imageMarkers = imageMarkers;
		mapHandlers[id].fitBounds(imageMarkers);

	//}

}

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

function deleteObs(id)
{

	api.deleteObservation(id, obsStateChanged);

}

function obsStateChanged(data)
{

	var obj = data;
	if(!obj.hasOwnProperty('ok') || obj.ok)
	{

		$('#validationModal').modal('hide');
		dt.ajax.reload();

	}
	else
	{

		$('#serverErrorMessage').html(obj.msg + ': ' + obj.internalMsg);
		$('#serverError').show();

	}

}