var uploadedFiles = null;

$(document).ready(function() {

	Dropzone.autoDiscover = false;

	$('.IASNewAreaCheck').bootstrapSwitch({size: 'mini'});
	$('.IASNewValidatorCheck').bootstrapSwitch({size: 'mini'});
    $('.outOfAreaNewCheck').bootstrapSwitch({size: 'mini'});
	$('#imageContents').append($('.imageRow:first').clone());
	updateLastImageRow(0);
	$('.imageRow:last').show();

	dt = $('#dataContainer').DataTable({
		serverSide: true,
		ajax: function (data, callback, settings) {

			api.getIASList(data, callback);

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
			{ data: 'name',
			orderable:      false },
			{ data: 'taxonName',
			orderable:      false },
			{ data: 'created_at'},
			{ 
				data: null, 
				orderable: false,
				render: function ( data, type, row ) {
					var deleteBtn = '<button type="button" class="btn btn-danger" onclick="deleteIAS(' + row.id + ')"><i class="fa fa-trash-o"></i></button>';
					var loading = '<img src="' + urlImg + '/loader.gif" class="loading" data-id=' + row.id + ' style="display:none;"/>';
                    return '<div class="btns" data-id="' + row.id + '" >' + deleteBtn + '</div>' + loading;
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
            row.child( row.data().innerHtml ).show();
 
            // Add to the 'open' array
            if ( idx === -1 ) {
                detailRows.push( tr.attr('id') );
            }
        }

        $('.IASAreaCheck').bootstrapSwitch({size: 'mini'});
        $('.IASValidatorCheck').bootstrapSwitch({size: 'mini'});
        $('.outOfAreaCheck').bootstrapSwitch({size: 'mini'});
    } );
 
    // On each draw, loop over the `detailRows` array and show any child rows
    dt.on( 'draw', function () 
    {

        $.each( detailRows, function ( i, id ) {
            $('#'+id+' td.details-control').trigger( 'click' );
        } );

    });

});

function removeImage(id, imageRow)
{

	$('.imageRow[data-row=' + imageRow + '][data-id=' + id + ']').remove();

	if(null != uploadedFiles && null != uploadedFiles[iasId])
		delete uploadedFiles[iasId][imageRow];

}

function removeImageNew(imageRow)
{

	$('.imageRowNew[data-row=' + imageRow + ']').remove();

	if(null != uploadedFiles)
		delete uploadedFiles[imageRow];

}

function addImage(iasId)
{

	var num = -1;
	$('.imageRow[data-id='+iasId+']').each(function(index) {
		var dataRow = $(this).attr('data-row');
		if(num < dataRow)
			num = dataRow;
	});
	num = parseInt(num)+1;

	$('.imageRow[data-id='+iasId+']:last').after($('#imageContents'+iasId+' .imageRow:first').clone());

	$('#imageContents'+iasId+' .imageUpload:last').prop('id', 'imageUpload' + num);
	$('#imageContents'+iasId+' .imageUpload:last').attr('data-id', iasId);
	$('#imageContents'+iasId+' .imageUpload:last').attr('data-pos', num);
	$('#imageContents'+iasId+' .imageAttrib:last').prop('id', 'imageAttrib' + num);
	$('#imageContents'+iasId+' .imageOrder:last').prop('id', 'imageOrder' + num);

	var myDropzone = new Dropzone('#imageUpload' + num, {
		paramName: "image", // The name that will be used to transfer the file
		maxFilesize: 5, // MB
		maxFiles: 1,
		dictDefaultMessage: "Click here to add an image",
		init: function() {
			this.on("success", fileAddedToIAS);
			this.on("maxfilesexceeded", function(file) {
				this.removeAllFiles();
				this.addFile(file);
			});
		}
	});

	$('#imageContents'+iasId+' .imageRow:last').attr('data-row', num);
	$('#imageContents'+iasId+' .imageAttrib:last').attr('data-image-id', -1);
	$('#imageContents'+iasId+' .imageAttrib:last').attr('data-id', iasId);
	$('#imageContents'+iasId+' .imageOrder:last').attr('data-image-id', -1);
	$('#imageContents'+iasId+' .imageOrder:last').attr('data-id', iasId);

	for(var i=0; i<languageNum; ++i)
	{

		$('#imageContents'+iasId+' .imageText[data-lang="' + i + '"]:last').attr('data-row', num);
		$('#imageContents'+iasId+' .imageText[data-lang="' + i + '"]:last').attr('data-id', iasId);
		$('#imageContents'+iasId+' .imageText[data-lang="' + i + '"]:last').attr('data-image-id', -1);

	}

	$('#imageContents'+iasId+' .imageRemove:last').attr('onclick', 'removeImage(' + iasId + ',' + num + ')');

	$('#imageContents'+iasId+' .imageRow:last').show();
	$('#imageContents'+iasId+' .imageRow:last').attr('id', num);
	$('#imageContents'+iasId+' .imageRow:last').attr('data-id', iasId);

}

function addImageN()
{

	var num = -1;
	$('.imageRowNew').each(function(index) {
		var dataRow = $(this).attr('data-row');
		if(num < dataRow)
			num = dataRow;
	});
	num = parseInt(num)+1;

	$('.imageRowNew:last').after($('#imageContentsN .imageRowNew:first').clone());

	updateLastImageRow(num);

}

function updateLastImageRow(num)
{

	$('#imageContentsN .imageUpload:last').prop('id', 'imageUploadNew' + num);
	$('#imageContentsN .imageUpload:last').attr('data-pos', num);
	$('#imageContentsN .imageAttrib:last').prop('id', 'imageAttrib' + num);
	$('#imageContentsN .imageOrder:last').prop('id', 'imageOrder' + num);

	var myDropzone = new Dropzone('#imageUploadNew' + num, {
		paramName: "image", // The name that will be used to transfer the file
		maxFilesize: 5, // MB
		maxFiles: 1,
		dictDefaultMessage: "Click here to add an image",
		init: function() {
			this.on("success", fileAddedToNewIAS);
			this.on("maxfilesexceeded", function(file) {
				this.removeAllFiles();
				this.addFile(file);
			});
		}
	});

	$('#imageContentsN .imageRowNew:last').attr('data-row', num);

	for(var i=0; i<languageNum; ++i)
	{

		$('#imageContentsN .imageText[data-lang="' + i + '"]:last').attr('data-row', num);

	}

	$('#imageContentsN .imageRemove:last').attr('onclick', 'removeImageNew(' + num + ')');

	$('#imageContentsN .imageRowNew:last').show();
	$('#imageContentsN .imageRowNew:last').attr('id', num);

}

function fileAddedToIAS(file, data)
{

	var pos = $(this.element).attr('data-pos');
	var id = $(this.element).attr('data-id');

	if(null == uploadedFiles)
		uploadedFiles = new Array();

	if(!(id in uploadedFiles))
	{

		uploadedFiles[id] = new Array();

	}

	uploadedFiles[id][pos] = data;

}

function fileAddedToNewIAS(file, data)
{

	var pos = $(this.element).attr('data-pos');

	if(null == uploadedFiles)
		uploadedFiles = new Array();

	uploadedFiles[pos] = data;

}

function addIAS()
{

	uploadedFiles = new Array();
	$('#addIAS').show();
	$('#iasList').hide();

}

function dismiss()
{

	resetForm();
	$('#addIAS').hide();
	$('#iasList').show();

}

function resetForm()
{

	$('#input-scientificName').val('');
	$('#taxon').val(0);

	for(var i=0; i<languageNum; ++i)
	{

		$('#input-name' + (i+1)).val('');
		$('#input-shortDesc' + (i+1)).val('');
		$('#input-sizeDesc' + (i+1)).val('');
		$('#input-infoDesc' + (i+1)).val('');
		$('#input-infoHabitat' + (i+1)).val('');
		$('#input-infoConfuse' + (i+1)).val('');

	}

	$('#form-scientificName').removeClass('has-error');
	$('#error-scientificName').addClass('hidden');
	$('#form-name' + defaultLanguageId).removeClass('has-error');
	$('#error-name').addClass('hidden');
	$('#error-IAS').hide();
	$('.form-new-areaOrder').removeClass('has-error');
	$('.IASNewAreaCheck').bootstrapSwitch('state', false);

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

	var hasLatinName = checkInput('scientificName');
	var hasName = checkInput('name' + defaultLanguageId);
	
	var missingOrder = false;
	$('.IASNewAreaCheck').each(function(index) {

			if($(this).bootstrapSwitch('state'))
			{
			
				var areaId = $(this).attr('data');
				var order = $('.iasNewOrder[data-id=' + areaId + ']').val();
				missingOrder = missingOrder || ("" == order.trim()) || ("" != order.trim && !isValidInteger(order));

				if('' != order.trim() && isValidInteger(order))
				{

					$('.form-new-areaOrder[data=' + areaId + ']').removeClass('has-error');

				}
				else
				{

					$('.form-new-areaOrder[data=' + areaId + ']').addClass('has-error');

				}

			}

		});

	var error = (!hasLatinName || !hasName || missingOrder);

	return !error;

}

function store()
{

	if(checkForm())
	{

		$('#iasNewLoading').show();
		$('#iasNewBtn').prop('disabled', true);
		$('#iasNewBtnText').hide();

		var latinName = $('#input-scientificName').val();
		var taxon = $('#taxon').val();
		var descriptions = new Array();

		for(var i=0; i<languageNum; ++i)
		{

			//Warning: Assumes the languages id are successive and starting at 1
			//TODO: Use the language id instead
			var index = i+1;
			var name = $('#input-name' + index).val();

			if('' != name)
			{

				var obj = new Object();
				obj.id = index;
				obj.common = $('#input-name' + index).val();
				obj.shortDesc = $('#input-shortDesc' + index).val();
				obj.sizeDesc = $('#input-sizeDesc' + index).val();
				obj.infoDesc = $('#input-infoDesc' + index).val();
				obj.infoHabitat = $('#input-infoHabitat' + index).val();
				obj.infoConfuse = $('#input-infoConfuse' + index).val();
				descriptions.push(obj);

			}

		}

		var images = new Array();
		$('#imageContentsN .imageRowNew').each(function(index) {

			var obj = new Object();
			var dataRow = $(this).attr('data-row');
			obj.attribution = $('#imageContentsN #imageAttrib'+dataRow).val();
			obj.order = $('#imageContentsN #imageOrder'+dataRow).val();
			obj.langs = new Array();
			for(var j=0; j<languageNum; ++j)
			{

				var inp = $('#imageContentsN .imageText[data-row="' + dataRow + '"][data-lang="' + j + '"]:first');
				obj.langs.push({id: j+1, text: inp.val()});

			}

			if(null != uploadedFiles && null != uploadedFiles[dataRow])
				obj.url = uploadedFiles[dataRow];

			if(obj.hasOwnProperty('url') && 'undefined' != typeof obj.url)
				images.push(obj);

		});

		var areas = new Array();
		$('.IASNewAreaCheck').each(function(index) {

			if($(this).bootstrapSwitch('state'))
			{
			
				var val = $(this).attr('data');
				var order = $('.iasNewOrder[data-id=' + val + ']').val();
				areas.push({id: val, order: order});

			}

		});

		var validators = new Array();
		$('.IASNewValidatorCheck').each(function(index) {

			if($(this).bootstrapSwitch('state'))
			{
			
				var val = $(this).attr('data-validator');
				var outOfBounds = $('.outOfAreaNewCheck[data-validator=' + val + ']').bootstrapSwitch('state');
				validators.push({id: val, outOfBounds: outOfBounds});

			}

		});

		api.addIAS({latinName: latinName, taxon: taxon, descriptions: descriptions, images: images, areas: areas, validators: validators}, iasSaved);

	}
	else
	{

		$('#error-IAS').show();

	}

}

function iasSaved(data)
{

	$('#iasNewLoading').hide();
	$('#iasNewBtn').prop('disabled', false);
	$('#iasNewBtnText').show();

	if(!data.hasOwnProperty('error') && !(data.hasOwnProperty('ok') && !data.ok))
	{

		window.location.reload();

	}
	else
	{

		if(data.hasOwnProperty('error'))
			$('#error-IAS').html(data.error);
		else if(data.hasOwnProperty('internalMsg'))
			$('#error-IAS').html(data.internalMsg);
		$('#error-IAS').show();

	}

}

function checkEditForm(iasId)
{

	var hasLatinName = checkInput('scientificName' + iasId);
	var hasName = checkInput('name' + defaultLanguageId + '_' + iasId);

	var missingOrder = false;
	$('.IASAreaCheck[data-id=' + iasId + ']').each(function(index) {

		if($(this).is(':checked'))
		{
		
			var areaId = $(this).attr('data-area');
			var order = $('.iasOrder[data-id=' + areaId + ']').val();
			missingOrder = missingOrder || ("" == order.trim()) || ("" != order.trim && !isValidInteger(order));

			if('' != order.trim() && isValidInteger(order))
			{

				$('.form-areaOrder[data=' + areaId + ']').removeClass('has-error');

			}
			else
			{

				$('.form-areaOrder[data=' + areaId + ']').addClass('has-error');

			}

		}

	});

	var error = (!hasLatinName || !hasName || missingOrder);

	return !error;

}

function edit(iasId)
{

	if(checkEditForm(iasId))
	{

		$('#iasEditLoading'+iasId).show();
		$('#iasEditBtn'+iasId).prop('disabled', true);
		$('#iasEditBtnText'+iasId).hide();

		var latinName = $('#input-scientificName' + iasId).val();
		var taxon = $('#input-taxon' + iasId).val();
		var descriptions = new Array();

		for(var i=0; i<languageNum; ++i)
		{

			//Warning: Assumes the languages id are successive and starting at 1
			//TODO: Use the language id instead
			var index = i+1;
			var name = $('#input-name' + index + '_' + iasId).val();

			if('' != name)
			{

				var obj = new Object();
				obj.id = index;
				obj.common = $('#input-name' + index + '_' + iasId).val();
				obj.shortDesc = $('#input-shortDesc' + index + '_' + iasId).val();
				obj.sizeDesc = $('#input-sizeDesc' + index + '_' + iasId).val();
				obj.infoDesc = $('#input-infoDesc' + index + '_' + iasId).val();
				obj.infoHabitat = $('#input-infoHabitat' + index + '_' + iasId).val();
				obj.infoConfuse = $('#input-infoConfuse' + index + '_' + iasId).val();
				descriptions.push(obj);

			}

		}

		var images = new Array();
		$('#imageContents'+iasId+' .imageRow[data-id=' + iasId +']').each(function(index) {

			var imageId = $(this).attr('data-image-id');
			var obj = new Object();
			var dataRow = $(this).attr('data-row');
			obj.attribution = $('#imageContents'+iasId+' #imageAttrib'+dataRow).val();
			obj.order = $('#imageContents'+iasId+' #imageOrder'+dataRow).val();
			obj.langs = new Array();
			for(var j=0; j<languageNum; ++j)
			{

				var inp = $('#imageContents'+iasId+' .imageText[data-row="' + dataRow + '"][data-lang="' + j + '"]:first');
				obj.langs.push({id: j+1, text: inp.val()});

			}

			if('undefined' == typeof imageId)
			{

				//It's one of the new images
				if(null != uploadedFiles && null != uploadedFiles[iasId])
					obj.url = uploadedFiles[iasId][dataRow];

			}
			else
			{

				//It's one of the db images
				obj.id = imageId;
				obj.url = $('#imageContents'+iasId+' .ias-image[data-image-pos="' + dataRow + '"][data-id="' + iasId + '"]:first').attr('src');
				obj.url = obj.url.substr(obj.url.lastIndexOf('/')+1)

			}

			if(obj.hasOwnProperty('url') && 'undefined' != typeof obj.url)
				images.push(obj);

		});


		var areas = new Array();
		$('.IASAreaCheck[data-id=' + iasId + ']').each(function(index) {

			if($(this).bootstrapSwitch('state'))
			{
			
				var val = $(this).attr('data-area');
				var order = $('.iasOrder[data-id=' + val + ']').val();
				areas.push({id: val, order: order});

			}

		});

		var validators = new Array();
		$('.IASValidatorCheck[data-id=' + iasId + ']').each(function(index) {

			if($(this).bootstrapSwitch('state'))
			{
			
				var val = $(this).attr('data-validator');
				var outOfBounds = $('.outOfAreaCheck[data-validator=' + val + ']').bootstrapSwitch('state');
				validators.push({id: val, outOfBounds: outOfBounds});

			}

		});

		api.editIAS(iasId, {latinName: latinName, taxon: taxon, descriptions: descriptions, images: images, areas: areas, validators: validators}, iasEdited);

	}
	else
	{

		$('#error-IAS' + iasId).show();

	}

}

function iasEdited(data)
{

	dt.ajax.reload();

}

function deleteIAS(id)
{

	$('.btns[data-id=' + id + ']').hide();
	$('.loading[data-id=' + id + ']').show();
	api.deleteIAS(id, iasStateChanged);

}

function iasStateChanged(data)
{

	var obj = data;
	if(!obj.hasOwnProperty('ok') || obj.ok)
	{

		dt.ajax.reload();

	}
	else
	{

		$('.btns[data-id=' + id + ']').show();
		$('.loading[data-id=' + id + ']').hide();

	}

}