function comprovarFoto(){

    var ok = true;
    if ($('#imgPerfilCompletar').data('url') ==  urlImg + 'fotos/web/user.png')
    {

        $('#form-imgPerfilCompletar').addClass('has-error');
        $('#error-imgPerfilCompletar').removeClass('hidden');
        $('#form-imgPerfilCompletar .form-control-feedback').removeClass('hidden');
        $('#error-imgPerfilCompletar').html('Aquest camp és obligatori');

        ok = false;
    }
    else{
        $('#form-imgPerfilCompletar ' ).removeClass('has-error');
        $('#error-imgPerfilCompletar').addClass('hidden');
    }

    return ok;
}

function comprovarFormulari(){

    var ok = true;
    resetFormulariCompletar();

    if ($('#input-name').val() == '')
    {
        $('#form-name').addClass('has-error');
        $('#error-name').removeClass('hidden');
        $('#form-name .form-control-feedback').removeClass('hidden');
        $('#error-name').html('Aquest camp és obligatori');

        ok = false;
    }

    return ok;
}

function resetFormulariCompletar()
{

    $('#form-name ' ).removeClass('has-error');
    $('#error-name').addClass('hidden');
    
}