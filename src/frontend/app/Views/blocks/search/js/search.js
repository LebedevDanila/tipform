$(function() {

    if ($('.search').length == 0)
    {
        return false;
    }

    $('.js__search').submit(function(event) {
        event.preventDefault();

        let value = $('.js__searchInput').val().toLowerCase().substr(1);

        if (value.search('instagram.com/') > -1) {
            value = value.split('instagram.com/')[1];

            if (value.search(/\?(.+)/) > -1) {
                value = value.replace(/\?(.+)/g, '');
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

    $('.js__searchInput').on('input', function() {
        let value = $(this).val().replace(/[Яа-яЁё]/, '');
        if (value[0] !== '@') {
            value = '@' + value;
        }
        $(this).val(value);
    });

});
