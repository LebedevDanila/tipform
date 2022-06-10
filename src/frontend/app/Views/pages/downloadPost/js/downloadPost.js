$(function () {
    const $root = $('.js__downloadPost');

    if ($root.length === 0) {
        return false;
    }

    // global vars
    const STORE = {
        is_safari: $root.data('is_safari'),
    };
    const $content = $('.js__downloadPostContent');

    $('.js__downloadPostForm').submit(function (event) {
        event.preventDefault();

        const value = $('.js__downloadPostFormInput').val();
        if (value === '' || value.search('instagram.com/') === -1) {
            return alert('Вы ввели не правильную ссылку');
        }

        $('.js__downloadPostWait').show();

        const data = {url: value};
        $.ajax({
            type     : 'POST',
            url      : `/ajax/instagram/downloadPost`,
            dataType : 'json',
            data     : {'data': $.b64.encode(JSON.stringify(data))},
            success  : function (response) {
                if (response.error) {
                    return alert(response.error.message);
                }
                $('.js__downloadPostWait').hide();
                render(response.response.data.content);
            },
        });
    });

    function render(data) {
        $content.empty();

        $.each(data, (key, row) => {
            $content.append(`<div class="download__item ${data.length >= 3 ? '_three' : (data.length === 2 ? '_two' : '')} js__downloadPostItem">
                ${row.type === 'video'
                    ? `<video id="video_download" controls autoplay loop playsinline><source src="${STORE.is_safari ? GLOBAL.proxy_server_url+$.b64.encode(encodeURIComponent(row.data)) : row.data}" type="video/mp4"></video>`
                    : `<img src="${row.data}" alt="post">`
                }
                <div class="download__item-downloadButton download__button flex-ajc js__downloadPostItemDownload" data-url="${$.b64.encode(encodeURIComponent(row.data))}">Скачать</div>
            </div>`);

            if (row.type === 'video') {
                // для сафари
                loadVideosForSafari();
            }
        });
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

    $('.js__downloadPostContent').on('click', '.js__downloadPostItemDownload', function () {
        const url = $(this).data('url');
        window.location.href = `/download/${url}`;
    });

    $('.js__downloadFaqItem').click(function () {
        $(this).toggleClass('_active');
    });
});
