$(function () {
    const $root = $('.js__downloadVideo');

    if ($root.length === 0) {
        return false;
    }

    // global vars
    const STORE = {
        is_safari: $root.data('is_safari'),
    };
    const $content = $('.js__downloadVideoContent');

    $('.js__downloadVideoForm').submit(function (event) {
        event.preventDefault();

        const value = $('.js__downloadVideoFormInput').val();
        if (value === '' || value.search('instagram.com/') === -1) {
            return alert('Вы ввели не правильную ссылку');
        }

        let method = null;
        if (value.search('/p/') > -1) {
            method = 'Post';
        } else if (value.search('/tv/') > -1) {
            method = 'Igtv';
        } else {
            return alert('Вы ввели не правильную ссылку');
        }

        $('.js__downloadVideoWait').show();

        const data = {url: value};
        $.ajax({
            type     : 'POST',
            url      : `/ajax/instagram/download${method}`,
            dataType : 'json',
            data     : {'data': $.b64.encode(JSON.stringify(data))},
            success  : function (response) {
                if (response.error) {
                    return alert(response.error.message);
                }
                $('.js__downloadVideoWait').hide();

                const data = response.response.data;
                if (Array.isArray(data.content)) {
                    renderPost(data.content);
                } else {
                    renderIgtv(data);
                }
            },
        });
    });

    function renderPost(content) {
        $content.empty();

        $.each(content, (key, row) => {
            $content.append(`<div class="download__item ${content.length >= 3 ? '_three' : (content.length === 2 ? '_two' : '')} js__downloadVideoItem">
                ${row.type === 'video'
                    ? `<video id="video_download" controls autoplay loop playsinline><source src="${STORE.is_safari ? GLOBAL.proxy_server_url+$.b64.encode(encodeURIComponent(row.data)) : row.data}" type="video/mp4"></video>`
                    : `<img src="${row.content}" alt="video">`
                }
                <div class="download__item-downloadButton download__button flex-ajc js__downloadVideoItemDownload" data-url="${$.b64.encode(encodeURIComponent(row.content))}">Скачать</div>
            </div>`);

            if (row.type === 'video') {
                loadVideosForSafari();
            }
        });
    }

    function renderIgtv(data) {
        $content.empty();

        $content.append(`<div class="download__item js__downloadVideoItem">
            <video id="video_download" controls autoplay loop playsinline><source src="${STORE.is_safari ? GLOBAL.proxy_server_url+$.b64.encode(encodeURIComponent(data.content)) : data.content}" type="video/mp4"></video>
            <div class="download__item-downloadButton download__button flex-ajc js__downloadVideoItemDownload" data-url="${$.b64.encode(encodeURIComponent(data.content))}">Скачать</div>
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

    $('.js__downloadVideoContent').on('click', '.js__downloadVideoItemDownload', function () {
        const url = $(this).data('url');
        window.location.href = `/download/${url}`;
    });

    $('.js__downloadFaqItem').click(function () {
        $(this).toggleClass('_active');
    });
});