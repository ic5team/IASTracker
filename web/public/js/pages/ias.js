var uploadedFiles = null;

$(document).ready(function() {

	Dropzone.autoDiscover = false;

	$('.IASAreaCheck').bootstrapSwitch({size: 'mini'});
	$('#imageContents').append($('.imageRow:first').clone());
	updateLastImageRow(0);
	$('.imageRow:last').show();

});

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

}

function addIAS()
{

	uploadedFiles = new Array();
	$('#addIAS').show();
	$('#iasList').hide();

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