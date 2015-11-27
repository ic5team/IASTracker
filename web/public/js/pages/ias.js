var uploadedFiles = null;

$(document).ready(function() {

	Dropzone.autoDiscover = false;

	$('.IASAreaCheck').bootstrapSwitch({size: 'mini'});
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
			{ data: 'name' },
			{ data: 'taxonName' },
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
    } );
 
    // On each draw, loop over the `detailRows` array and show any child rows
    dt.on( 'draw', function () 
    {

        $.each( detailRows, function ( i, id ) {
            $('#'+id+' td.details-control').trigger( 'click' );
        } );

    });

});

function removeImage(imageRow)
{

	var iasId = $('.imageRow[data-row=' + imageRow + ']').attr('data-id');
	$('.imageRow[data-row=' + imageRow + ']').remove();

	if(null != uploadedFiles && null != uploadedFiles[iasId])
		delete uploadedFiles[iasId][imageRow];

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

	$('#imageContents'+iasId+' .imageRemove:last').attr('onclick', 'removeImage(' + num + ')');

	$('#imageContents'+iasId+' .imageRow:last').show();
	$('#imageContents'+iasId+' .imageRow:last').attr('id', num);
	$('#imageContents'+iasId+' .imageRow:last').attr('data-id', iasId);

}

function updateLastImageRow(num)
{

	$('.imageUpload:last').prop('id', 'imageUpload' + num);
	$('.imageUpload:last').attr('data-pos', num);
	$('.imageAttrib:last').prop('id', 'imageAttrib' + num);
	for(var i=0; i<languageNum; ++i)
	{

		$('.imageText[data-lang="' + i + '"]:last').attr('data-row', num);

	}

	var myDropzone = new Dropzone('#imageUpload' + num, {
		paramName: "image", // The name that will be used to transfer the file
		maxFilesize: 5, // MB
		maxFiles: 1,
		dictDefaultMessage: "Click here to add an image",
		init: function() {
			this.on("success", fileAdded);
			this.on("maxfilesexceeded", function(file) {
				this.removeAllFiles();
				this.addFile(file);
			});
		}
	});

}

function fileAdded(file, data)
{

	var pos = $(this.element).attr('data-pos');
	if(pos < uploadedFiles.length)
		uploadedFiles[pos] = data;
	else
		uploadedFiles.push(data);

	var num = $('.imageRow').length -1;
	$('#imageContents').append($('.imageRow:first').clone());
	updateLastImageRow(num);
	$('.imageRow:last').show();
	$('.imageRow:last').attr('id', num);
	$('.imageRemove:last').attr('data-id', num);

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
	var error = !hasLatinName || !hasName;

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
		for(var i=0; i<uploadedFiles.length; ++i)
		{

			var obj = new Object();
			obj.url = uploadedFiles[i];
			obj.attribution = $('#imageAttrib' + i).val();
			obj.langs = new Array();
			for(var j=0; j<languageNum; ++j)
			{

				var inp = $('.imageText[data-row="' + i + '"][data-lang="' + j + '"]:first');
				obj.langs.push({id: j, text: inp.val()});

			}

			images.push(obj)

		}

		var areas = new Array();
		$('.IASAreaCheck').each(function(index) {

			if($(this).bootstrapSwitch('state'))
			{
			
				var val = $(this).attr('data');
				areas.push(val);

			}

		});

		api.addIAS({latinName: latinName, taxon: taxon, descriptions: descriptions, images: images, areas: areas}, iasSaved);

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
	window.location.reload();

}

function checkEditForm(iasId)
{

	var hasLatinName = checkInput('scientificName' + iasId);
	var hasName = checkInput('name' + defaultLanguageId + '_' + iasId);
	var error = !hasLatinName || !hasName;

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

			if($(this).is(':checked'))
			{
			
				var val = $(this).attr('data-area');
				areas.push(val);

			}

		});

		api.editIAS(iasId, {latinName: latinName, taxon: taxon, descriptions: descriptions, images: images, areas: areas}, iasEdited);

	}
	else
	{

		$('#error-IAS').show();

	}

}

function iasEdited(data)
{

	$('#iasNewLoading').hide();
	$('#iasNewBtn').prop('disabled', false);
	$('#iasNewBtnText').show();
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