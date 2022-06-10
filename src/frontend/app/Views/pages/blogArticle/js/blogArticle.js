$(function() {
    if ($('.blogArticle').length == 0) {
        return false;
    }

    $('.js__blogArticleMenuItem').click(function () {
        const id = $(this).data('id');
        $("html, body").animate({
            scrollTop: $(`h2:eq(${id})`).offset().top - 15,
        }, 500);
    });

});
