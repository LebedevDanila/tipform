$(function () {

    if ($('.profile').length === 0) {
        return false;
    }

    // Global
    const $root = $('.js__profile');
    const STORE = {
        load             : $root.data('load'),
        username         : $root.data('username'),
        profile_id       : $root.data('profile_id'),
        profile_unique_id: $root.data('profile_unique_id'),
        is_safari        : $root.data('is_safari'),
        stories          : {
            items   : [],
            paginate: 0,
            ads     : false,
        },
        highlights: {
            content: [],
            items: [],
            load : false,
        },
        gallery: {
            key    : null,
            content: null,
            type   : null,
            entity : null,
        },
        posts: {
            items  : [],
            load   : false,
            ads    : false,
            gallery: {
                key    : null,
                content: null,
                display: {
                    key : null,
                    content: null,
                    type: null,
                },
            },
        },
    };

    setTimeout(function() {
        $('.js__profileStories').show();
        $('.js__profileWait').hide();
        init();
    }, 4000);

    function init() {
        if (STORE.load === 'ALL' || STORE.load === 'STORIES') {
            parseProfile();
        } else {
            getStoryList(STORE.profile_id);
        }
    }

    function parseProfile() {
        $('.js__profileAlertLoader').show();

        const data = {
            load: STORE.load,
            username: STORE.username,
            profile_id: STORE.profile_id
        };

        $.ajax({
            type     : 'POST',
            url      : '/ajax/instagram/parseProfile',
            dataType : 'json',
            data     : {'data': $.b64.encode(JSON.stringify(data))},
            success  : function (response) {
                $('.js__profileAlertLoader').hide();

                if (response.error) {
                    if (response.error.code === 380) {
                        getStoryList(data.profile_id);
                    }
                    showError(response.error.message);
                    return false;
                }

                const profile = response.response.data;

                addInfo(profile);

                if (profile.private) {
                    $('.js__profileAlertPrivate').show();
                    return false;
                }

                getStoryList(profile.id);
            },
        });
    }

    function addInfo(data) {
        STORE.profile_id = data.id;

        $('.js__profileMediaCount').text(data.media_count);
        $('.js__profileFollowers').text(createShortNumber(data.followers));
        $('.js__profileFollowing').text(createShortNumber(data.following));
        $('.js__profileBiography').text(data.biography);

        data.verified ? $('.js__profileVerified').show() : false;

        $('.js__profileAvatarPicture').attr('src', data.picture);

        $('.js__profileFavorite').attr('data-favorite', $.b64.encode(JSON.stringify({
            'username'  : data.username,
            'picture'   : data.picture,
            'followers' : data.followers,
            'is_static' : false,
        })));

        $('.js__profileContent').removeClass('_blur');
    }

    function getStoryList(profile_id) {
        $('.js__profileAlertLoader').show();

        const data = {
            profile_id
        };

        $.ajax({
            type     : 'POST',
            url      : '/ajax/instagram/getStoryList',
            dataType : 'json',
            data     : {'data': $.b64.encode(JSON.stringify(data))},
            success  : function (response) {
                $('.js__profileAlertLoader').hide();

                if (response.error) {
                    showError(response.error.message);
                    return false;
                }
                STORE.stories.items = response.response.data;

                if (STORE.stories.items.length > 0) {
                    $($('.js__profileStoriesTitle').show().find('span')).text('('+STORE.stories.items.length+')');

                    if (STORE.stories.items.length > 8) {
                        $('.js__profileStoriesMore').show();
                    }
                    paginateStoryList(8);

                    if (STORE.load === 'RELOAD') {
                        $('.js__profileStoriesReload').css('display', 'flex');
                    }
                } else {
                    $('.js__profileAlertEmpty').show();
                }

                removeClassTab('ob');
            },
        });
    }

    function paginateStoryList(count = 4) {
        const new_paginate = STORE.stories.paginate + count;

        let html = '';
        for(let i = STORE.stories.paginate; i < new_paginate; i++) {
            const row = STORE.stories.items[i];
            if (row === undefined) {
                $('.js__profileStoriesMore').hide();
                break;
            }

            /*if (i > 3 && STORE.stories.items.length > 7 && STORE.stories.ads === false) {
                STORE.stories.ads = true;
                html += `<div class="profile__stories-ads">
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="ca-pub-3466713921867030"
                         data-ad-slot="3791229759"
                         data-ad-format="auto"
                         data-full-width-responsive="true"></ins>
                    <script>
                         (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>`;
            }*/

            html += `<div class="profile__stories-item js__profileStoriesItem ${(new Date().getTime()/1000) > row.date_expire ? '_old' : '_new'}" data-key="${i}" data-type="${row.type}" data-content="${row.content}">
                <div class="profile__stories-item-wrap">
                    <img src="${row.preview}" alt="story">
                    <div class="profile__stories-item-download flex-ajc js__profileStoriesItemDownload" data-url="${$.b64.encode(encodeURIComponent(row.content))}">Скачать</div>
                    <span>${getTextFormatDate(row.date_create)}</span>
                </div>
            </div>`;
        }

        $('.js__profileStoriesContent').append(html);

        STORE.stories.paginate = new_paginate;
    }

    $('.js__profileTabStories').click(function () {
        removeClassTab('_active');
        $(this).addClass('_active');
        $('.js__profilePosts').hide();
        $('.js__profileHighlights').hide();
        $('.js__profileStories').show();
    });

    $('.js__profileTabHighlights').click(function () {
        removeClassTab('_active');
        $(this).addClass('_active');
        $('.js__profileStories').hide();
        $('.js__profilePosts').hide();
        $('.js__profileHighlights').show();
        if (STORE.highlights.load === false) {
            getHighlightList(STORE.profile_id);
            STORE.highlights.load = true;
        }
    });

    $('.js__profileTabPosts').click(function () {
        removeClassTab('_active');
        $(this).addClass('_active');
        $('.js__profileStories').hide();
        $('.js__profileHighlights').hide();
        $('.js__profilePosts').show();
        if (STORE.posts.load === false) {
            getPostList(STORE.profile_id);
            STORE.posts.load = true;
        }
    });

    function showError(text) {
        const $error      = $('.js__profileAlertError');
        const $error_text = $('.js__profileAlertErrorText');

        $error_text.html(text);
        $error.show();
    }

    function getHighlightList(profile_id) {
        $('.js__profileAlert').hide();
        $('.js__profileAlertLoader').show();

        const data = {
            profile_id,
        };

        $.ajax({
            type     : 'POST',
            url      : '/ajax/instagram/getHighlightList',
            dataType : 'json',
            data     : {'data': $.b64.encode(JSON.stringify(data))},
            success  : function (response) {
                $('.js__profileAlertLoader').hide();

                if (response.error) {
                    showError(response.error.message);
                    return false;
                }
                STORE.highlights.content = response.response.data;

                if (STORE.highlights.content.length > 0) {
                    $($('.js__profileHighlightsTitle').show().find('span')).text('('+STORE.highlights.content.length+')');
                    renderHighlightList(STORE.highlights.content);
                } else {
                    showError('У этого пользователя отсутствуют закрепленные истории');
                }
            },
        });
    }

    function renderHighlightList(data) {
        let html = '';
        $.each(data, (key, row) => {
            html += `<div class="profile__stories-highlights-item js__profileHighlightsItem" data-unique_id="${row.unique_id}">
                <div class="profile__stories-highlights-item-wrapper">
                    <div class="profile__stories-highlights-item-img">
                        <img src="${row.preview}" alt="highlight">
                    </div>
                    <div class="profile__stories-highlights-item-title">${row.title}</div>
                </div>
            </div>`;
        });
        $('.js__profileHighlightsContent').append(html);
    }

    function getPostList(profile_id) {
        $('.js__profileAlert').hide();
        $('.js__profileAlertLoader').show();

        const data = {
            profile_id
        };

        $.ajax({
            type     : 'POST',
            url      : '/ajax/instagram/getPostList',
            dataType : 'json',
            data     : {'data': $.b64.encode(JSON.stringify(data))},
            success  : function (response) {
                $('.js__profileAlertLoader').hide();

                if (response.error) {
                    showError(response.error.message);
                    return false;
                }
                STORE.posts.items = response.response.data;

                $($('.js__profilePostsTitle').show().find('span')).text('('+STORE.posts.items.length+')');

                renderPostList(STORE.posts.items);
            },
        });
    }

    function renderPostList(data) {
        let html = '';
        $.each(data, (key, row) => {
            /*if (key > 3 && STORE.posts.items.length > 3 && STORE.posts.ads === false) {
                STORE.posts.ads = true;
                html += `<div class="profile__stories-ads">
                    <ins class="adsbygoogle"
                        style="display:block; text-align:center;"
                        data-ad-layout="in-article"
                        data-ad-format="fluid"
                        data-ad-client="ca-pub-3466713921867030"
                        data-ad-slot="7251512901"></ins>
                    <script>
                         (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>`;
            }*/

            html += `<div class="profile__posts-item js__profilePostsItem" data-key="${key}" data-content="${$.b64.encode(JSON.stringify(row.content))}">
                <div class="profile__posts-item-wrap">
                    <img src="${row.preview}" alt="posts">
                    <span>${getTextFormatDate(row.date_create)}</span>
                </div>
            </div>`;
        });
        $('.js__profilePostsContent').append(html);
    }

    function removeClassTab(classname) {
        $.each($('.js__profileTab'), (key, row) => $(row).removeClass(classname));
    }

    $('.js__profileStoriesMore').click(function() {
        paginateStoryList(4);
    });

    $('.js__profileStoriesReload').click(function() {
        $('.js__profileStoriesContent').empty();
        $('.js__profileStoriesMore').hide();
        $(this).addClass('ob');
        STORE.stories = {
            items   : [],
            paginate: 0,
        };
        STORE.gallery = {
            key    : null,
            content: null,
            type   : null,
            entity : null,
        };
        parseProfile();
    });

    // gallery
    $('.js__profileStoriesModalClose').click(function() {
        $('.js__profileStoriesModal').fadeOut();
        $('.js__profileStoriesModalWindow').empty();
    });

    $('.js__profilePostsModalClose').click(function() {
        $('.js__profilePostsModal').fadeOut();
        $('.js__profilePostsModalWindow').empty();
    });

    $('.js__profileStoriesContent').on('click', '.js__profileStoriesItem', function () {
        const key     = $(this).data('key');
        const content = $(this).data('content');
        const type    = $(this).data('type');

        STORE.gallery = {key, content, type, entity: 'stories'};
        $('.js__profileStoriesModal').fadeIn();
        loadStoryGallery();
    });

    $('.js__profileHighlightsContent').on('click', '.js__profileHighlightsItem', function () {
        $('.js__loader').show();

        const data = {
            highlight_unique_id: $(this).data('unique_id')
        };

        $.ajax({
            type     : 'POST',
            url      : '/ajax/instagram/getHighlightStoryList',
            dataType : 'json',
            data     : {'data': $.b64.encode(JSON.stringify(data))},
            success  : function (response) {
                $('.js__loader').hide();

                if (response.error) {
                    showError(response.error.message);
                    return false;
                }
                STORE.highlights.items = response.response.data;

                STORE.gallery = {key: 0, content: STORE.highlights.items[0].content, type: STORE.highlights.items[0].type, entity: 'highlights'};
                $('.js__profileStoriesModal').fadeIn();
                loadStoryGallery();
            },
        });
    });

    $('.js__profilePostsContent').on('click', '.js__profilePostsItem', function () {
        const key     = $(this).data('key');
        const content = JSON.parse($.b64.decode($(this).data('content')));

        STORE.posts.gallery = {key, content, display: {key: 0, content: content[0].content, type: content[0].type}};
        $('.js__profilePostsModal').fadeIn();
        loadPostsGallery();
    });

    $('.js__profileStoriesContent').on('click', '.js__profileStoriesItemDownload', function (event) {
        event.stopPropagation();
        const url = $(this).data('url');
        window.location.href = `/download/${url}`;
    });

    $('.js__profileStoriesModalNext').click(function() {
        switchStoryGallery('next');
    });

    $('.js__profilePostsModalNext').click(function() {
        switchPostsGallery('next');
    });

    $('.js__profileStoriesModalPrev').click(function() {
        switchStoryGallery('prev');
    });

    $('.js__profilePostsModalPrev').click(function() {
        switchPostsGallery('prev');
    });

    $('.js__profilePostsModalCarouselPrev').click(function() {
        switchCarouselPosts('prev');
    });

    $('.js__profilePostsModalCarouselNext').click(function() {
        switchCarouselPosts('next');
    });

    function switchStoryGallery(action) {
        let key;
        if (action === 'next') {
            key = STORE.gallery.key + 1;
        }
        if (action === 'prev') {
            key = STORE.gallery.key - 1;
        }

        const story = STORE[STORE.gallery.entity].items[key];
        if (story === undefined) {
            return false;
        }

        STORE.gallery = {
            ...STORE.gallery,
            key     : key,
            content : story.content,
            type    : story.type,
        };

        loadStoryGallery();
    }

    function switchPostsGallery(action) {
        let key;
        if (action === 'next') {
            key = STORE.posts.gallery.key + 1;
        }
        if (action === 'prev') {
            key = STORE.posts.gallery.key - 1;
        }

        const post = STORE.posts.items[key];
        if (post === undefined) {
            return false;
        }

        STORE.posts.gallery = {
            key,
            content: post.content,
            display: {
                key    : 0,
                content: post.content[0].content,
                type   : post.content[0].type,
            }
        };

        loadPostsGallery();
    }

    function switchCarouselPosts(action) {
        let key;
        if (action === 'next') {
            key = STORE.posts.gallery.display.key + 1;
        }
        if (action === 'prev') {
            key = STORE.posts.gallery.display.key - 1;
        }

        const elem = STORE.posts.gallery.content[key];
        if (elem === undefined) {
            return false;
        }

        STORE.posts.gallery.display = {
            key,
            content: elem.content,
            type   : elem.type,
        };

        loadPostsGallery();
    }

    function loadStoryGallery() {
        const $window = $('.js__profileStoriesModalWindow');
        const $next   = $('.js__profileStoriesModalNext');
        const $prev   = $('.js__profileStoriesModalPrev');

        STORE.gallery.key === 0 ? $prev.css({'opacity': 0, 'pointer-events': 'none'}) : $prev.css({'opacity': 1, 'pointer-events': 'auto'});
        STORE.gallery.key === STORE[STORE.gallery.entity].items.length-1 ? $next.css({'opacity': 0, 'pointer-events': 'none'}) : $next.css({'opacity': 1, 'pointer-events': 'auto'});

        $window.empty();

        const url = (STORE.gallery.content.search(GLOBAL.proxy_worker_url) > -1) && STORE.is_safari ? GLOBAL.proxy_server_url+$.b64.encode(encodeURIComponent(STORE.gallery.content)) : STORE.gallery.content;
        if (STORE.gallery.type === 'video') {
            $window.append(`
                <video id="video_story" controls autoplay loop playsinline>
                    <source src="${url}" type="video/mp4">
                </video>
            `);

            // для сафари
            const $video = $($window.find('#video_story'));
            $video.on('loadedmetadata', function() {
                this.currentTime=0.01;
                this.play();
            });
        } else {
            $window.append(`
                <img src="${STORE.gallery.content}" alt="story">
            `);
        }

    }

    function loadPostsGallery() {
        const $window        = $('.js__profilePostsModalWindow');
        const $main_next     = $('.js__profilePostsModalNext');
        const $main_prev     = $('.js__profilePostsModalPrev');
        const $carousel_next = $('.js__profilePostsModalCarouselNext');
        const $carousel_prev = $('.js__profilePostsModalCarouselPrev');

        STORE.posts.gallery.key === 0 ? $main_prev.css({'opacity': 0, 'pointer-events': 'none'}) : $main_prev.css({'opacity': 1, 'pointer-events': 'auto'});
        STORE.posts.gallery.key === STORE.posts.items.length-1 ? $main_next.css({'opacity': 0, 'pointer-events': 'none'}) : $main_next.css({'opacity': 1, 'pointer-events': 'auto'});

        STORE.posts.gallery.display.key === 0 ? $carousel_prev.css({'opacity': 0, 'pointer-events': 'none'}) : $carousel_prev.css({'opacity': 1, 'pointer-events': 'auto'});
        STORE.posts.gallery.display.key === STORE.posts.gallery.content.length-1 ? $carousel_next.css({'opacity': 0, 'pointer-events': 'none'}) : $carousel_next.css({'opacity': 1, 'pointer-events': 'auto'});

        $window.empty();

        const url = STORE.is_safari ? GLOBAL.proxy_server_url+$.b64.encode(STORE.posts.gallery.display.content) : STORE.posts.gallery.display.content;
        if (STORE.posts.gallery.display.type === 'video') {
            $window.append(`
                <video id="video_posts" controls autoplay loop playsinline>
                    <source src="${url}" type="video/mp4">
                </video>
            `);

            // для сафари
            const $video = $($window.find('#video_posts'));
            $video.on('loadedmetadata', function() {
                this.currentTime=0.01;
                this.play();
            });
        } else {
            $window.append(`
                <img src="${STORE.posts.gallery.display.content}" alt="posts">
            `);
        }
    }

    $('.js__profileStoriesModalDownload').click(function() {
        window.location.href = `/download/${$.b64.encode(encodeURIComponent(STORE.gallery.content))}`;
    });

    $('.js__profilePostsModalDownload').click(function() {
        window.location.href = `/download/${$.b64.encode(encodeURIComponent(STORE.posts.gallery.display.content))}`;
    });

    $('.js__profileFavorite').click(function () {
        const $this = $(this);
        const data  = JSON.parse($.b64.decode($this.data('favorite')));

        if ($this.hasClass('_active')) {
            $.ajax({
                type     : 'POST',
                url      : '/ajax/favorites/delete',
                dataType : 'json',
                data     : {'data': $.b64.encode(JSON.stringify(data))},
                success  : function (response) {
                    if (response.error) {
                        return alert(response.error.message);
                    }
                    $this.removeClass('_active');
                    $($this.find('span')).html('Добавить в избранное');
                },
            });
        } else {
            $.ajax({
                type     : 'POST',
                url      : '/ajax/favorites/add',
                dataType : 'json',
                data     : {'data': $.b64.encode(JSON.stringify(data))},
                success  : function (response) {
                    if (response.error) {
                        return alert(response.error.message);
                    }
                    $this.addClass('_active');
                    $($this.find('span')).html('Убрать из избранного');
                },
            });
        }
    });

    // Helpers
    function createShortNumber(number) {
        let result;

        if(number >= 1000000){
            result = round(number / 1000000, 1) + 'М';
        } else if(number >= 10000) {
            result = round(number / 1000, 1) + 'К';
        } else {
            result = number;
        }

        return result;
    }

    function round(num, dec) {
        let sign = num >= 0 ? 1 : -1;
        return parseFloat((Math.round((num * Math.pow(10, dec)) + (sign * 0.0001)) / Math.pow(10, dec)).toFixed(dec));
    }

    function getTextFormatDate(date_create) {
        const ms   = parseInt(new Date().getTime()/1000);
        const pass = ms - date_create;

        const DAY    = 86400;
        const MONTHS = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];

        const time = new Date(date_create * 1000);
        const ham  = (time.getHours() > 10 ? time.getHours() : '0'+time.getHours()) + ':' + (time.getMinutes() > 10 ? time.getMinutes() : '0'+time.getMinutes());

        let date;
        if (pass <= DAY) {
            date = 'Сегодня в ' + ham;
        } else if (pass > DAY && pass < DAY*2) {
            date = 'Вчера в ' + ham;
        } else {
            date = ham + ' ' + time.getDate() + ' ' + MONTHS[time.getMonth()] + ' ' + time.getFullYear();
        }

        return date;
    }
});