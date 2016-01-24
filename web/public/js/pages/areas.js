var dt;

$(document).ready(function() {

	$('.NewAreaValidatorCheck').bootstrapSwitch({size: 'mini'});
	$('[data-toggle="tooltip"]').tooltip();
	dt = $('#dataContainer').DataTable({
		serverSide: true,
		ajax: function (data, callback, settings) {

			api.getAreasList(data, callback);

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
        	{ data: 'name' },
			{ data: 'zIndex' },
			{ data: 'created_at'},
			{ 
				data: null, 
				orderable: false,
				render: function ( data, type, row ) {
					var deleteBtn = '<button type="button" class="btn btn-danger" onclick="deleteArea(' + row.id + ')"><i class="fa fa-trash-o"></i></button>';
					var loading = '<img src="' + urlImg + '/loader.gif" class="loading" data-id=' + row.id + ' style="display:none;"/>';
                    return '<div class="btns" data-id="' + row.id + '" >' + deleteBtn + '</div>' + loading;
                } 
            }
		],
		order: [[4, 'desc']]
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

});

function initRow(row)
{

	$('[data-toggle="tooltip"]').tooltip();
	$('.AreaValidatorCheck').bootstrapSwitch({size: 'mini'});

}

function childRow(data)
{

	return data.innerHtml;

}

function addArea()
{

	uploadedFiles = new Array();
	$('#addArea').show();
	$('#areaList').hide();

}

function dismiss()
{

	resetForm();
	$('#addArea').hide();
	$('#areaList').show();

}

function resetForm()
{

	$('#input-areaName').val('');
	$('#form-areaName').removeClass('has-error');
	$('#error-areaName').addClass('hidden');
	$('#input-zIndex').val('');
	$('#form-zIndex').removeClass('has-error');
	$('#error-zIndex').addClass('hidden');
	$('#input-shapeFile').val('');
	$('#form-shapeFile').removeClass('has-error');
	$('#error-shapeFile').addClass('hidden');
	$('#input-geom').val('');
	$('#form-geom').removeClass('has-error');
	$('#error-geom').addClass('hidden');

	$('#error-Area').hide();
	$('.AreaValidatorCheck').bootstrapSwitch('state', false);

}

function checkInput(id)
{

	var ret = false;
	var val = $('#input-' + id).val();
	if('' != val)
	{

		$('#form-' + id).removeClass('has-error');
		$('#input-' + id).removeClass('has-error');
		$('#error-' + id).addClass('hidden');
		ret = true;

	}
	else
	{

		$('#form-' + id).addClass('has-error');
		$('#input-' + id).addClass('has-error');
		$('#error-' + id).removeClass('hidden');

	}

	return ret;

}

function checkForm()
{

	var hasName = checkInput('areaName');
	var hasZIndex = checkInput('zIndex');
	var hasGeom = checkInput('geom');

	var error = (!hasName || !hasZIndex || !hasGeom);

	return !error;

}

function store()
{

	if(checkForm())
	{

		$('#areaEditLoading').show();
		$('#areaEditBtn').prop('disabled', true);
		$('#areaEditBtnText').hide();

		var name = $('#input-areaName').val();
		var zIndex = $('#input-zIndex').val();
		var geom = $('#input-geom').val();

		var validators = new Array();
		$('.NewAreaValidatorCheck').each(function(index) {

			if($(this).bootstrapSwitch('state'))
			{
			
				var val = $(this).attr('data-validator');
				validators.push(val);

			}

		});

		uploadZipFile('', {name: name, zIndex: zIndex, geom: geom, validators: validators}, true, false);

	}
	else
	{

		$('#error-Area').show();

	}

}

function areaSaved(data)
{

	$('#areaNewLoading').hide();
	$('#areaNewBtn').prop('disabled', false);
	$('#areaNewBtnText').show();

	if(!data.hasOwnProperty('error') && !(data.hasOwnProperty('ok') && !data.ok))
	{

		window.location.reload();

	}
	else
	{

		if(data.hasOwnProperty('error'))
			$('#error-Area').html(data.error);
		else if(data.hasOwnProperty('internalMsg'))
			$('#error-Area').html(data.internalMsg);
		$('#error-Area').show();

	}

}

function checkEditForm(areaId)
{

	var hasName = checkInput('areaName' + areaId);
	var hasZIndex = checkInput('zIndex' + areaId);
	var hasGeom = checkInput('geom' + areaId);

	var error = (!hasName || !hasZIndex || !hasGeom);

	return !error;

}

function edit(areaId)
{

	if(checkEditForm(areaId))
	{

		$('#areaEditLoading'+areaId).show();
		$('#areaEditBtn'+areaId).prop('disabled', true);
		$('#areaEditBtnText'+areaId).hide();

		var name = $('#input-areaName' + areaId).val();
		var zIndex = $('#input-zIndex' + areaId).val();
		var geom = $('#input-geom' + areaId).val();

		var validators = new Array();
		$('.AreaValidatorCheck[data-id=' + areaId + ']').each(function(index) {

			if($(this).bootstrapSwitch('state'))
			{
			
				var val = $(this).attr('data-validator');
				validators.push(val);

			}

		});

		uploadZipFile(areaId, {name: name, zIndex: zIndex, geom: geom, validators: validators}, false, true);

	}
	else
	{

		$('#error-Area' + iasId).show();

	}

}

function uploadZipFile(idIn, dataIn, required, isEdit)
{

	var id = idIn;
	if(!isEdit)
		id = '';

	var fileInput = $('#input-shapeFile' + id)[0];
	if(0 < fileInput.files.length)
	{

		var url = urlPublic + 'common/ajaxShapeUpload.php';
		var fd = new FormData();
	
		fd.append( 'zip', fileInput.files[0] );

		$.ajax({
			url : url,
			data : fd, 
			processData: false,
			contentType: false, 
			type: 'POST',
			success: function(data) {

				zipUploaded(id, dataIn, data, isEdit)

			}

		});

	}
	else if(!required)
	{

		zipUploaded(id, dataIn, '', isEdit);

	}
	else
	{

		$('#form-shapeFile' + id).addClass('has-error');
		$('#input-shapeFile' + id).addClass('has-error');
		$('#error-shapeFile' + id).removeClass('hidden');

		$('#error-Area' + id).show();

	}

}

function zipUploaded(id, dataIn, ret, isEdit)
{

	if('undefined' === typeof ret || '' == ret)
	{

	}
	else
	{

		var data = JSON.parse(ret);
		if(data.hasOwnProperty('error'))
		{

			$('#error-Area' + id).html(data.error);
			$('#error-Area' + id).show();

		}
		else
		{

			dataIn.shapeFile = data.url;

		}

	}

	if(isEdit)
	{

		api.editArea(id, dataIn, areaEdited);

	}
	else
	{

		api.addArea(dataIn, areaSaved);

	}

}

function areaEdited(data)
{

	$('#error-Area' + data.id).hide();
	$('#areaEditBtn' + data.id).prop('disabled', false);
	$('#areaEditBtnText' + data.id).show();
	$('#areaEditLoading' + data.id).hide();

	if(!data.hasOwnProperty('error') && !(data.hasOwnProperty('ok') && !data.ok))
	{

		window.location.reload();

	}
	else
	{

		if(data.hasOwnProperty('error'))
			$('#error-Area' + data.id).html(data.error);
		else if(data.hasOwnProperty('internalMsg'))
			$('#error-Area' + data.id).html(data.internalMsg);
		$('#error-Area' + data.id).show();

	}	

}

function deleteArea(id)
{

	$('#confirmButtons').show();
	$('#confirmLoading').hide ();
	$('#confirmButton').attr('onclick', 'deleteAreaAux(' + id + ')');
	$('#confirmModal').modal();

}

function deleteAreaAux(id)
{

	$('#confirmButtons').hide();
	$('#confirmLoading').show();
	api.deleteArea(id, areaDeleted);
	$('#confirmModal').modal();

}

function areaDeleted(data)
{

	var obj = data;
	if(!obj.hasOwnProperty('ok') || obj.ok)
	{

		$('#confirmModal').modal('hide');
		dt.ajax.reload();

	}
	else
	{

		$('#serverDeleteErrorMessage').html(obj.msg + ': ' + obj.internalMsg);
		$('#serverDeleteError').show();

	}

}