$(function() {
    if ($('.main').length == 0) {
        return false;
    }

    // Аккордион ответов на частые вопросы
    $('.js__mainFaqItem').click(function () {
        $(this).toggleClass('_active');
    });

    // фокус на форму поиска
    //$('.js__searchInput').focus();

    // табы популярных аккаунтов
    (function () {
        let last_id = 0;
        $('.js__mainPopularAccountsTab').click(function () {
            const current_id = parseInt($(this).data('id'));
            if(current_id === last_id)
            {
                return false;
            }

            const $content_list    = $('.js__mainPopularAccountsContent');
            const $tab_list        = $('.js__mainPopularAccountsTab');
            const $current_content = $($content_list[current_id]);
            const $current_tab     = $(this);
            const $last_content    = $($content_list[last_id]);
            const $last_tab        = $($tab_list[last_id]);

            $current_tab.addClass('_active');
            $last_tab.removeClass('_active');
            $current_content.addClass('_active');
            $last_content.removeClass('_active');

            if (screen.width <= 1100) {
                const more = $('.js__mainPopularAccountsMore');
                const ids  = more.data('ids');
                if (!ids) {
                    more.data('ids', []);
                } else if (ids.includes(current_id)) {
                    more.hide();
                } else {
                    more.show();
                    more.attr('data-id', current_id);
                }
            }

            last_id = current_id;
        });
    })();

    $('.js__mainPopularAccountsMore').click(function () {
        const id               = parseInt($(this).attr('data-id'));
        const $content_list    = $('.js__mainPopularAccountsContent');
        const $current_content = $($content_list[id]);
        const $items           = $($current_content.find('.js__mainPopularAccountsItem'));

        $.each($items, (key, row) => {
            $(row).removeClass('_close');
        });

        const ids = $(this).data('ids');
        if (!ids) {
            $(this).data('ids', [id]);
        } else {
            $(this).data('ids', [...ids, id]);
        }

        $(this).hide();
    });

    (function () {
        $('.js__mainPopularAccountsItemAdd').click(function (event) {
            event.preventDefault();

            const $this = $(this);
            const data  = {
                'username'  : $this.data('username'),
                'picture'   : $this.data('picture'),
                'followers' : $this.data('followers'),
                'is_static' : true,
            };

            $.ajax({
                type: 'POST',
                url: '/ajax/favorites/add',
                dataType: 'json',
                data: {'data': $.b64.encode(JSON.stringify(data))},
                success: function(response) {
                    if (response.error) {
                        return alert(response.error.error_text);
                    }

                    $this.addClass('_active');
                },
            });
        });
    })();

    $('.js__mainSearch').click(function(e) {
        e.preventDefault();

        const link = $(this).attr('href');
        $("html, body").animate({
            scrollTop: $(link).offset().top - 15
        }, 800);
    });

    $('.js__mainExampleAccount').click(function () {
        const value = $(this).data('value');
        return console.log(value);

        $('.js__searchInput').val(value);
        $('.js__searchSubmit').trigger('click');
    });

    $('.js__mainInstructionVideo').click(function () {
        const $this = $(this);
        $this.empty().append(`
            <iframe
                width="560"
                height="315"
                src="https://www.youtube.com/embed/dm-uH68KaU4?autoplay=1"
                title="YouTube video player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
            </iframe>
        `);
        $this.off('click');

    });
});
