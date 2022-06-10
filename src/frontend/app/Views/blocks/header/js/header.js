$(function(){
    if ($('.header').length == 0)
    {
        return false;
    }

    $('.js__headerMenu').click(function () {
        $('.js__headerMobileNav').fadeIn();
    });

    $('.js__headerMobileNavClose').click(function () {
        $('.js__headerMobileNav').fadeOut();
    });

    $('.js__headerSearchButton').click(function () {
        $('.js__search').slideToggle('fast');
    });
});
