var iosMargin = 20;
$(document).on('deviceready', function () {
    if (window.device && parseFloat(window.device.version) >= 7.0) {
        $('body').addClass('iOS7');
        $(".barraTitol").css("padding-top", "20px");
        $(".btTitol").css("margin-top", "20px");
        $('#menuPanel').css('margin-top', '20px');
    }
});