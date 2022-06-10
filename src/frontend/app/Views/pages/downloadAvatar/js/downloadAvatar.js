$(function () {
    const $root = $('.js__downloadAvatar');

    if ($root.length === 0) {
        return false;
    }

    // global vars
    const STORE = {
        is_safari: $root.data('is_safari'),
    };
    const $content = $('.js__downloadAvatarContent');

    $('.js__downloadAvatarForm').submit(function (event) {
        event.preventDefault();

        let value = $('.js__downloadAvatarFormInput').val().toLowerCase().substr(1);;

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

        $('.js__downloadAvatarWait').show();

        const data = {username: value};
        $.ajax({
            type     : 'POST',
            url      : `/ajax/instagram/downloadAvatar`,
            dataType : 'json',
            data     : {'data': $.b64.encode(JSON.stringify(data))},
            success  : function (response) {
                if (response.error) {
                    return alert(response.error.message);
                }
                $('.js__downloadAvatarWait').hide();
                render(response.response.data);
            },
        });
    });

    $('.js__downloadAvatarFormInput').on('input', function() {
        let value = $(this).val().replace(/[Яа-яЁё]/, '');
        if (value[0] !== '@') {
            value = '@' + value;
        }
        $(this).val(value);
    });

    function render(data) {
        $content.empty();

        $content.append(`<div class="download__item _avatar js__downloadAvatarItem">
            <img src="${STORE.is_safari ? GLOBAL.proxy_server_url+$.b64.encode(encodeURIComponent(data.picture)) : data.picture}" alt="post">
            <div class="download__item-downloadButton download__button flex-ajc js__downloadAvatarItemDownload" data-url="${$.b64.encode(encodeURIComponent(data.picture))}">Скачать</div>
        </div>`);
    }

    $('.js__downloadAvatarContent').on('click', '.js__downloadAvatarItemDownload', function () {
        const url = $(this).data('url');
        window.location.href = `/download/${url}`;
    });
});
