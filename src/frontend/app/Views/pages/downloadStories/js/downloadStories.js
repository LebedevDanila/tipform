$(function () {
    if ($('.downloadStories').length === 0) {
        return false;
    }

    $('.js__downloadStoriesForm').submit(function (event) {
        event.preventDefault();

        let value = $('.js__downloadStoriesFormInput').val().toLowerCase();

        if (value.search('instagram.com/') > -1) {
            value = value.split('instagram.com/')[1];

            if (value.search(/\?utm_medium=copy_link/) > -1) {
                value = value.replace(/\?utm_medium=copy_link/g, '');
            }

            if (value.search('/') > -1) {
                value = value.replace(/\//g, '');
            }
        }

        if(value.match(/^[a-zA-Z0-9_.]{1,30}$/) === null)
        {
            return alert('Вы ввели невалидный профиль аккаунта');
        }

        window.location.href = '/profile/' + value;

        return false;
    });

    $('.js__downloadFaqItem').click(function () {
        $(this).toggleClass('_active');
    });
});
