<div class="profile js__profile" data-load="<?= $load ?>" data-username="<?= $username ?>" data-profile_id="<?= $profile->id ?? 'null' ?>" data-is_safari="<?= $useragent->getBrowser() === 'Safari' ? 'true' : 'false' ?>">
    <div class="profile__modal js__profileStoriesModal">
        <div class="profile__modal-close flex-ajc js__profileStoriesModalClose">
            <img src="/static/img/pages/profile/close.svg" alt="close">
        </div>
        <div class="profile__modal-main flex-ajc">
            <div class="profile__modal-view flex-a">
                <img src="/static/img/pages/profile/arrow.svg" class="profile__modal-arrow _prev js__profileStoriesModalPrev">
                <div class="profile__modal-content flex-ajc">
                    <div class="profile__modal-download flex-a js__profileStoriesModalDownload">
                        <img src="/static/img/pages/profile/download.svg" alt="download">
                        <span>Скачать историю</span>
                    </div>
                    <div class="profile__modal-window js__profileStoriesModalWindow"></div>
                </div>
                <img src="/static/img/pages/profile/arrow.svg" class="profile__modal-arrow _next js__profileStoriesModalNext">
            </div>
        </div>
    </div>
    <div class="profile__modal js__profilePostsModal">
        <div class="profile__modal-close flex-ajc js__profilePostsModalClose">
            <img src="/static/img/pages/profile/close.svg" alt="close">
        </div>
        <div class="profile__modal-main flex-ajc">
            <div class="profile__modal-view flex-a">
                <img src="/static/img/pages/profile/arrow.svg" class="profile__modal-arrow _prev js__profilePostsModalPrev">
                <div class="profile__modal-content flex-ajc">
                    <div class="profile__modal-download flex-a js__profilePostsModalDownload">
                        <img src="/static/img/pages/profile/download.svg" alt="download">
                        <span>Скачать публикацию</span>
                    </div>
                    <div class="profile__modal-carousel js__profilePostsModalCarousel flex-ajc">
                        <div class="profile__modal-carousel-arrow flex-ajc _prev js__profilePostsModalCarouselPrev">
                            <span class="<?= !$useragent->isMobile() ? '_icon' : '' ?>"><?= $useragent->isMobile() ? 'Предыдущая' : '&#187;' ?></span>
                        </div>
                        <div class="profile__modal-window js__profilePostsModalWindow"></div>
                        <div class="profile__modal-carousel-arrow flex-ajc _next js__profilePostsModalCarouselNext">
                            <span class="<?= !$useragent->isMobile() ? '_icon' : '' ?>"><?= $useragent->isMobile() ? 'Следующая' : '&#187;' ?></span>
                        </div>
                    </div>
                </div>
                <img src="/static/img/pages/profile/arrow.svg" class="profile__modal-arrow _next js__profilePostsModalNext">
            </div>
        </div>
    </div>
    <div class="profile__container container">
        <div class="profile__top">
            <?/*= view_block('ads', ['slot' => '6245263048', 'format' => 'auto', 'responsive' => true, 'container_styles' => 'margin-bottom: 20px;']) */?>
            <!-- Yandex.RTB R-A-1586459-2 -->
            <div id="yandex_rtb_R-A-1586459-2"></div>
            <script>window.yaContextCb.push(()=>{
                Ya.Context.AdvManager.render({
                    renderTo: 'yandex_rtb_R-A-1586459-2',
                    blockId: 'R-A-1586459-2'
                })
            })</script>
            <div class="profile__content flex-a js__profileContent <?= empty($profile->username) ? '_blur' : '' ?>">
                <div class="profile__avatar flex-ajc js__profileAvatar">
                    <div class="profile__avatar-content">
                        <img class="js__profileAvatarPicture" src="<?= isset($profile->picture) ? $profile->picture : '/static/img/pages/profile/nobody.jpg' ?>" alt="icon-username">
                    </div>
                </div>
                <div class="profile__info">
                    <div class="profile__name flex-a">
                        <div class="profile__name-text flex">
                            <h1><?= isset($profile->username) ? $profile->username : $username ?></h1>
                            <img class="js__profileVerified" style="display: <?= isset($profile->verified) && $profile->verified === true ? 'block' : 'none' ?>;" src="/static/img/pages/profile/verify.svg" alt="verify">
                        </div>
                    </div>
                    <? if( ! $useragent->isMobile()): ?>
                        <div class="profile__data flex-a">
                            <div class="profile__data-item">
                                <span class="js__profileMediaCount"><?= isset($profile->media_count) ? createShortNumber($profile->media_count) : '...' ?></span>
                                публикаций
                            </div>
                            <div class="profile__data-item">
                                <span class="js__profileFollowers"><?= isset($profile->followers) ? createShortNumber($profile->followers) : '...' ?></span>
                                подписчиков
                            </div>
                            <div class="profile__data-item">
                                <span class="js__profileFollowing"><?= isset($profile->following) ? createShortNumber($profile->following) : '...' ?></span>
                                подписок
                            </div>
                        </div>
                        <div class="profile__desc js__profileBiography"><?= isset($profile->biography) && is_string($profile->biography) ? $profile->biography : '...' ?></div>
                        <?php
                            $favorite = null;
                            if (!empty($profile->username))
                            {
                                $favorite = base64_encode(json_encode([
                                    'username'  => $profile->username,
                                    'picture'   => $profile->picture,
                                    'followers' => $profile->followers,
                                    'is_static' => false,
                                ]));
                            }
                        ?>
                        <div class="profile__favorites js__profileFavorite flex-ajc <?= !$is_favorite ?: '_active' ?>" data-favorite="<?= $favorite ?>">
                            <img src="/static/img/blocks/header/favorites.svg" alt="favorites">
                            <span><?= $is_favorite ? 'Убрать из избранного' : 'Добавить в избранное' ?></span>
                        </div>
                    <? endif; ?>
                </div>
                <? if(isset($next_profile)): ?>
                    <a class="profile__nextProfile flex-ajc" href="https://instaprofi.ru/profile/<?= $next_profile ?>">
                        <img src="/static/img/pages/profile/next.svg" alt="next">
                    </a>
                <? endif; ?>
            </div>
        </div>
        <? if($useragent->isMobile()): ?>
            <div class="profile__desc js__profileBiography"><?= isset($profile->biography) && is_string($profile->biography) ? $profile->biography : '...' ?></div>
            <div class="profile__data flex-a">
                <div class="profile__data-item">
                    <span class="js__profileMediaCount"><?= isset($profile->media_count) ? createShortNumber($profile->media_count) : '...' ?></span>
                    публикаций
                </div>
                <div class="profile__data-item">
                    <span class="js__profileFollowers"><?= isset($profile->followers) ? createShortNumber($profile->followers) : '...' ?></span>
                    подписчиков
                </div>
                <div class="profile__data-item">
                    <span class="js__profileFollowing"><?= isset($profile->following) ? createShortNumber($profile->following) : '...' ?></span>
                    подписок
                </div>
            </div>
        <? endif; ?>

        <?/*= view_block('ads', ['slot' => '9256362741', 'layout' => 'in-article', 'format' => 'fluid', 'element_styles' => 'text-align:center;', 'container_styles' => 'margin: 20px 0;']) */?>

        <ul class="profile__tabs tabs">
            <div class="profile__tabs-wrapper tabs__wrapper flex-ajc">
                <li class="js__profileTab js__profileTabStories _active ob">Истории</li>
                <li class="js__profileTab js__profileTabHighlights ob">Закрепленные истории</li>
                <li class="js__profileTab js__profileTabPosts ob">Публикации</li>
            </div>
        </ul>

        <div class="profile__wait js__profileWait flex-ajc">
            <img src="/static/img/blocks/header/wait.svg" alt="wait">
        </div>

        <div class="profile__stories js__profileStories">
            <div class="profile__stories-top flex-ab">
                <div class="profile__title js__profileStoriesTitle">
                    Истории за все время <span>()</span>
                </div>
                <?php if ($load === 'RELOAD'): ?>
                    <div class="profile__stories-reload flex-ajc js__profileStoriesReload">
                        <img src="/static/img/pages/profile/reload.svg" alt="reload">
                        <span>Обновить истории</span>
                    </div>
                <?php endif; ?>
            </div>
            <div class="profile__stories-main">
                <div class="profile__stories-content js__profileStoriesContent flex"></div>
            </div>
            <div class="profile__more js__profileStoriesMore">
                <div class="profile__more-content flex-ajc">
                    <svg width="30" height="29" viewBox="0 0 30 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.0215 12.4645H26.0215V6.46448" stroke="#F08F48" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M6.22168 8.22183C7.24312 7.20038 8.45576 6.39013 9.79034 5.83733C11.1249 5.28452 12.5553 5 13.9999 5C15.4444 5 16.8748 5.28452 18.2094 5.83733C19.544 6.39013 20.7566 7.20038 21.778 8.22183L26.0207 12.4645" stroke="#F08F48" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9.97852 17.5355H3.97852V23.5355" stroke="#F08F48" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M23.7775 21.7782C22.7561 22.7996 21.5434 23.6099 20.2088 24.1627C18.8743 24.7155 17.4439 25 15.9993 25C14.5548 25 13.1244 24.7155 11.7898 24.1627C10.4552 23.6099 9.2426 22.7996 8.22116 21.7782L3.97852 17.5355" stroke="#F08F48" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="profile__more-title">Смотреть еще</span>
                </div>
            </div>
        </div>

        <div class="profile__stories profile__stories-highlights js__profileHighlights">
            <div class="profile__stories-top profile__stories-highlights-top flex-a">
                <div class="profile__title js__profileHighlightsTitle">
                    Закрепленные истории <span>()</span>
                </div>
            </div>
            <div class="profile__stories-highlights-content js__profileHighlightsContent flex-a"></div>
        </div>

        <div class="profile__posts js__profilePosts">
            <div class="profile__posts-top flex-ab">
                <div class="profile__title js__profilePostsTitle">
                    Последние публикации <span>()</span>
                </div>
            </div>
            <div class="profile__posts-main">
                <div class="profile__posts-content js__profilePostsContent flex"></div>
            </div>
        </div>

        <div class="profile__alert _loader js__profileAlert js__profileAlertLoader">
            <div class="profile__alert-content flex-ajc">
                <img class="profile__alert-img" src="/static/img/pages/profile/loader.svg" alt="loader">
                <div class="profile__alert-text">Идет загрузка контента.<br>Это может занять некоторое время.</div>
            </div>
        </div>
        <div class="profile__alert _error js__profileAlert js__profileAlertError">
            <div class="profile__alert-content flex-ajc">
                <img class="profile__alert-img" src="/static/img/pages/profile/error.svg" alt="error">
                <div class="profile__alert-text js__profileAlertErrorText"></div>
            </div>
        </div>
        <div class="profile__alert _empty js__profileAlert js__profileAlertEmpty">
            <div class="profile__alert-content flex-ajc">
                <img class="profile__alert-img" src="/static/img/pages/profile/empty.svg" alt="empty">
                <div class="profile__alert-text">У этого пользователя отсутствуют истории</div>
            </div>
        </div>
        <div class="profile__alert _private js__profileAlert js__profileAlertPrivate">
            <div class="profile__alert-content flex-ajc">
                <img class="profile__alert-img" src="/static/img/pages/profile/private.svg" alt="private">
                <div class="profile__alert-text">К сожалению, у этого пользователя<br> закрытый аккаунт :(</div>
            </div>
        </div>

        <?php if ($useragent->isMobile()): ?>
            <div id="adfox_16439724742259226"></div>
            <script>
                window.yaContextCb.push(()=>{
                    Ya.adfoxCode.createAdaptive({
                        ownerId: 389280,
                        containerId: 'adfox_16439724742259226',
                        params: {
                            pp: 'bsvk',
                            ps: 'flpi',
                            p2: 'hmjt'
                        }
                    }, ['tablet', 'phone'], {
                        tabletWidth: 1023,
                        phoneWidth: 768,
                        isAutoReloads: true
                    })
                })
            </script>
        <?php endif;?>

        <?/*= view_block('ads', ['slot' => '6608964783', 'format' => 'auto', 'responsive' => true, 'container_styles' => 'margin-top: 20px;']) */?>

        <div class="profile__text">
            На этой странице вы можете скачать или анонимно посмотреть недавно добавленные сторис публичных профилей Инстаграм.
            Для этого достаточно указать ссылку на профиль или имя пользователя и нажать кнопку "Загрузить". Сервис совершенно бесплатный
            и не требует регистрации. Доступен на всех устройствах с современными веб браузерами.
        </div>
    </div>
</div>
