$(document).ready(function() {

    let windowsHeight = $(window).height();
    let bodyHeight = $('body').height();

    if (windowsHeight > bodyHeight) 
    {
        $('.login_footer').css('bottom', '0');
        $('.login_footer').css('position', 'absolute');
        $('.login_footer').css('width', '100%');
    }

});