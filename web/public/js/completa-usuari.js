var fotoPerfil;
var nom;

function ometre(){
    window.location.href= urlPublic;
}


function segPas2(){
    if(comprovarFormulari())
    {

        nom = $('#input-name').val();

        $('#pas1').addClass('hidden');
        $('#pas2').removeClass('hidden');

    }
}

function segPas3(){
    if(comprovarFoto()){
        fotoPerfil = $('#imgPerfilCompletar').data('url');

        $('#foto-final').attr('src', fotoPerfil);
        $('#nom-final').html($('#input-name').val());

        if($('#amIExpertCheckbox').is(':checked'))
        {

            $('#expert-final').html('<i class="fa fa-check" style="color: rgba(162,200,86,1); font-size: 50px"></i>');

        }
        else
        {

            $('#expert-final').html('<i class="fa fa-times" style="color: rgba(255,0,0,1); font-size: 50px"></i>');

        }

        var btn = '';
        $('.langButtons').each(function(index) {

            if($(this).hasClass('active'))
                btn = $(this);

        });
        $('#language-final').html(btn.html());

        $('#pas2').addClass('hidden');
        $('#pas3').removeClass('hidden');
    }
}

function antPas3(){
    $('#pas2').addClass('hidden');
    $('#pas1').removeClass('hidden');
}

function antPas4(){
    $('#pas3').addClass('hidden');
    $('#pas2').removeClass('hidden');
}

function guardarDadesUsr()
{

    var fullName = $('#input-name').val();
    var isExpert = $('#amIExpertCheckbox').is(':checked');
    var selectedLanguage = -1;
    var fullName = $('#input-name').val();

    $('.langButtons').each(function(index) {

        if($(this).hasClass('active'))
            selectedLanguage = $(this).attr('data');

    });

    if(fotoPerfil.indexOf("?") != -1)
        imatgeUsuari = fotoPerfil.substring(0,fotoPerfil.lastIndexOf('?'));
    else
        imatgeUsuari = fotoPerfil;

    api.addUserData(loggedUserId, {name : fullName, 
        language : selectedLanguage, isExpert : isExpert,
        imageURL : imatgeUsuari}, 
        function(data) {
            var obj = data;
            if (!obj.hasOwnProperty('error'))
            {
                $('#completar-dades-modal').modal('hide');
                $('#imgPerfilBarra').attr('src',fotoPerfil);
                var url = window.location.href;
                window.location.href = url.substr(0, url.indexOf(window.location.search)) + '?lang=' + selectedLanguage;
            }
            else{
                mostraErrorInesperat();    
            }
    });

}

function selImageLogo()
{
    tipusImatge = 4;
    $('#fileUploadImatge').focus().trigger('click');
}
