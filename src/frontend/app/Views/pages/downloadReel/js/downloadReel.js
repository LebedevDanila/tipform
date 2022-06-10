$(function () {
    const $root = $('.js__downloadReel');

    if ($root.length === 0) {
        return false;
    }

    // global vars
    const STORE = {
        is_safari: $root.data('is_safari'),
    };
    const $content = $('.js__downloadReelContent');

    $('.js__downloadReelForm').submit(function (event) {
        event.preventDefault();

        const value = $('.js__downloadReelFormInput').val();
        if (value === '' || value.search('instagram.com/') === -1) {
            return alert('Вы ввели не правильную ссылку');
        }

        $('.js__downloadReelWait').show();

        const data = {url: value};
        $.ajax({
            type     : 'POST',
            url      : `/ajax/instagram/downloadReel`,
            dataType : 'json',
            data     : {'data': $.b64.encode(JSON.stringify(data))},
            success  : function (response) {
                if (response.error) {
                    return alert(response.error.message);
                }
                $('.js__downloadReelWait').hide();
                render(response.response.data);
            },
        });
    });

    function render(data) {
        $content.empty();

        $content.append(`<div class="download__item js__downloadReelItem">
            <video id="video_download" controls autoplay loop playsinline><source src="${STORE.is_safari ? GLOBAL.proxy_server_url+$.b64.encode(encodeURIComponent(data.content)) : data.content}" type="video/mp4"></video>
            <div class="download__item-downloadButton download__button flex-ajc js__downloadReelItemDownload" data-url="${$.b64.encode(encodeURIComponent(data.content))}">Скачать</div>
        </div>`);

        loadVideosForSafari();
    }

    function loadVideosForSafari() {
        const $videos = $content.find('#video_download');
        $.each($videos, (key, row) => {
            $(row).on('loadedmetadata', function() {
                this.currentTime=0.01;
                this.play();
            });
        });
    }

    $('.js__downloadReelContent').on('click', '.js__downloadReelItemDownload', function () {
        const url = $(this).data('url');
        window.location.href = `/download/${url}`;
    });

    $('.js__downloadFaqItem').click(function () {
        $(this).toggleClass('_active');
    });
});
