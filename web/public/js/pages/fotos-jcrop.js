$('#fileUploadImatge').on('change', function()
{
    fileInput = $('#fileUploadImatge')[0];
    if(0 < fileInput.files.length)
    {
        if (tipusImatge == 0){
            $('#fotoPortada-loading').removeClass('hidden');
            $('#imatgeDestacada').addClass('hidden');
        }
        else if (tipusImatge == 1){
            $('#fotoLogo-loading').removeClass('hidden');
            $('#imatgeLogo').addClass('hidden');
        }
        else if (tipusImatge == 2){
            $('#fotoPortada-usuari-loading').removeClass('hidden');
        }
        else if (tipusImatge == 3){
            $('#fotoPerfil-loading').removeClass('hidden');
        }
        else if (tipusImatge == 4){
            $('#imgPerfilCompletar-loading').removeClass('hidden');
        }
        else if (tipusImatge == 5){
            $('#fotoCarta-loading').removeClass('hidden');
            $('#imatgeCarta').addClass('hidden');
        }

        var url = urlPublic + 'common/ajaxImageUpload.php';
        var fd = new FormData();
    
        fd.append( 'image', fileInput.files[0] );
        fd.append( 'x', $('#x1').val() );
        fd.append( 'y', $('#y1').val() );
        fd.append( 'w', $('#w').val() );
        fd.append( 'h', $('#h').val() );

        $.ajax({
            url : url,
            data : fd, 
            processData: false,
            contentType: false, 
            type: 'POST',
            success: function(data) {
                var obj = $.parseJSON(data);
                if('undefined' != typeof obj.url)
                {
                    $('#modalCropImatge').modal('show');
                    uploadURL = obj.url;

                }
                else
                {
                    if (tipusImatge == 0){
                        $('#fotoPortada-loading').addClass('hidden');
                        $('#imatgeDestacada').removeClass('hidden');
                    }
                    else if (tipusImatge == 1){
                        $('#fotoLogo-loading').addClass('hidden');
                        $('#imatgeLogo').removeClass('hidden');
                    }
                    else if (tipusImatge == 2){
                        $('#fotoPortada-usuari-loading').addClass('hidden');
                    }
                    else if (tipusImatge == 3){
                        $('#fotoPerfil-loading').addClass('hidden');
                    }
                    else if (tipusImatge == 4){
                        $('#imgPerfilCompletar-loading').addClass('hidden');
                    }
                    if (tipusImatge == 5){
                        $('#fotoCarta-loading').addClass('hidden');
                        $('#imatgeCarta').removeClass('hidden');
                    }

                    mostraErrorIntern(obj.error);   

                }
            }
        });

    }
});

$('#modalCropImatge').on('shown.bs.modal', function () {

    width = $('#preview-pane .preview-container').width();
    height = width;

    $('#x1').val(0);
    $('#y1').val(0);

    $('#x2').val(width);
    $('#y2').val(height);
    $('#w').val(width);
    $('#h').val(height);

    if (tipusImatge == 1 || tipusImatge == 3 || tipusImatge == 4){

    }
    else if (tipusImatge == 0 || tipusImatge == 2 ){
        $('#y2').val(height/ 2);
        $('#h').val(height/ 2);
        height = height / 2;

        $('#preview-pane .preview-container').css('width', width);
        $('#preview-pane .preview-container').css('height', height);
    }
    else if(tipusImatge == 5){
        $('#x2').val(height/ 1.5);
        $('#w').val(height/ 1.5);
        width = width / 1.5;

        $('#preview-pane .preview-container').css('width', width);
        $('#preview-pane .preview-container').css('height', height);
    }


    $('#target').attr('src', uploadURL);
    $('.jcrop-preview').attr('src', uploadURL);

    $('.jcrop-holder').find('img').attr('src', uploadURL);
    $('#fileUpload').removeAttr('disabled');
    bImageError = false;
    bSelectedImage = true;

    jQuery(function($)
    {   
        // Create variables (in this scope) to hold the API and image size
        var jcrop_api,
            boundx,
            boundy,
            // Grab some information about the preview pane
            $preview = $('#preview-pane'),
            $target = $('.jcrop-holder'),
            $pcnt = $('#preview-pane .preview-container'),
            $pimg = $('#preview-pane .preview-container img'),
            xsize = $pcnt.width(),
            ysize = $pcnt.height();

        $('#target').Jcrop(
        {
            boxWidth: 900, boxHeight: 300,
            onChange: updatePreview,
            onSelect: updatePreview,
            setSelect: [ $('#x1').val(), $('#y1').val(), $('#w').val(), $('#h').val()],
            aspectRatio: xsize / ysize,
          
        },function(){
            // Use the API to get the real image size
            var bounds = this.getBounds();
            boundx = bounds[0];
            boundy = bounds[1];
            // Store the API in the jcrop_api variable
            jcrop_api = this;
            // Move the preview into the jcrop container for css positioning
            $preview.appendTo(jcrop_api.ui.holder);
            $preview.css("width", "300px !important");
            $preview.css("height", "600px !important");

        });

        // Simple event handler, called from onChange and onSelect
        // event handlers, as per the Jcrop invocation above
        function showCoords(c)
        {
            $('#x1').val(c.x);
            $('#y1').val(c.y);
            $('#x2').val(c.x2);
            $('#y2').val(c.y2);
            $('#w').val(c.w);
            $('#h').val(c.h);
        };

        function clearCoords()
        {
            $('#coords input').val('');
        };

        function updatePreview(c)
        {
            showCoords(c);
            if (parseInt(c.w) > 0)
            {
                var rx = xsize / c.w;
                var ry = ysize / c.h;

                $pimg.css({
                width: Math.round(rx * boundx) + 'px',
                height: Math.round(ry * boundy) + 'px',
                marginLeft: '-' + Math.round(rx * c.x) + 'px',
                marginTop: '-' + Math.round(ry * c.y) + 'px'
                });
            }
        };
    });

});

function cropCanceled()
{
    $('#modalCropImatge').modal('hide');
    resetJCrop();

    if (tipusImatge == 0){
        $('#fotoPortada-loading').addClass('hidden');
        $('#imatgeDestacada').removeClass('hidden');
    }
    else if (tipusImatge == 1){
        $('#fotoLogo-loading').addClass('hidden');
        $('#imatgeLogo').removeClass('hidden');
    }
    else if (tipusImatge == 2){
        $('#fotoPortada-usuari-loading').addClass('hidden');
    }
    else if (tipusImatge == 3){
        $('#fotoPerfil-loading').addClass('hidden');
    }
    else if (tipusImatge == 4){
        $('#imgPerfilCompletar-loading').addClass('hidden');
    }
    else if (tipusImatge == 5){
        $('#fotoCarta-loading').addClass('hidden');
        $('#imatgeCarta').removeClass('hidden');
    }

}

function resetJCrop()
{
    var jcropApi = $('#target').data('Jcrop');
    jcropApi.destroy();

    //Tornem a afedir el preview-pane pq el jcrop se'l carrega...
    var html = '<div id="preview-pane">';
    html += '<div class="preview-container">';
    html += '<img src="" class="jcrop-preview" alt="Preview" />';
    html += '</div></div>'
    $('#target').after(html);
    $('#target').attr('style','');
    $('#target').attr('src','');

}

function cropAccepted()
{
    $('#ajustarButtons').fadeOut(400, function() { 
        $('#loadingCrop').fadeIn(400);
        $('#loadingCrop').removeClass('hidden'); 
    });
    

    var url = urlPublic + 'common/ajaxImageResize.php';
    var fd = new FormData();
    fd.append( 'image', $('.jcrop-preview').attr("src"));
    fd.append( 'x', $('#x1').val() );
    fd.append( 'y', $('#y1').val() );
    fd.append( 'w', $('#w').val() );
    fd.append( 'h', $('#h').val() );

    $.ajax({
        url : url,
        data : fd, 
        processData: false,
        contentType: false, 
        type: 'POST',
        success: function(data) {
            var obj = $.parseJSON(data);

            if('undefined' != typeof obj.urlThumbs)
            {
                $('#loadingCrop').fadeOut();
                $('#ajustarButtons').fadeIn();

                $('#loading').hide();
                $('#userImage').show();
                
                $('#userImage').show();
                $('#errorMsgImg').html('');
                $('#errorImg').hide();

                bImageError = false;

                urlThumbs = obj.urlThumbs;
                urlGrans = obj.urlGrans;

                if (tipusImatge == 0){
                    $('#fotoPortada-loading').addClass('hidden');
                    $('#imatgeDestacada').removeClass('hidden');
                    $('#imatgeDestacada').attr('src', obj.urlThumbs +'?' + Math.random());
                }
                else if (tipusImatge == 1){
                    $('#fotoLogo-loading').addClass('hidden');
                    $('#imatgeLogo').removeClass('hidden');
                    $('#imatgeLogo').attr('src', obj.urlThumbs +'?' + Math.random());
                }
                else if (tipusImatge == 2){
                    $('#fotoPortada').removeClass('hidden');
                    $('#fotoPortada-usuari-loading').addClass('hidden');
                    $('#fotoPortada').data('url', obj.urlGrans);
                    $('#fotoPortada').css("background-image", "url("+ urlGrans +")");
                    guardarImatgePortada();
                }
                else if (tipusImatge == 3){
                    $('#fotoPerfil').removeClass('hidden');
                    $('#fotoPerfil-loading').addClass('hidden');
                    $('#fotoPerfil').data('url', obj.urlGrans);
                    $('#fotoPerfil').css("background-image", "url("+ urlGrans +")");
                    guardarImatgePerfil();
                }
                else if (tipusImatge == 4){
                    $('#imgPerfilCompletar-loading').addClass('hidden');
                    $('#imgPerfilCompletar').removeClass('hidden');
                    $('#imgPerfilCompletar').data('url', obj.urlThumbs +'?' + Math.random());
                    $('#imgPerfilCompletar').css("background-image", "url("+ urlGrans +")");
                }
                else if (tipusImatge == 5){
                    $('#fotoCarta-loading').addClass('hidden');
                    $('#imatgeCarta').removeClass('hidden');
                    $('#imatgeCarta').attr('src', obj.urlThumbs +'?' + Math.random());
                }

                $('#frame-jcrop').removeAttr('disabled');

                $('#modalCropImatge').modal('hide');
                resetJCrop();
            }
            else
            {
                $("#fileUploadImatge").val('');
                jcrop_api.destroy();
                mostraErrorInesperat();    
            }
        }
    });
}