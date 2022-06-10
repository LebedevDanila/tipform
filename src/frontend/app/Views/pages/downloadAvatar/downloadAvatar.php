<div class="downloadAvatar download page js__downloadAvatar" data-is_safari="<?= $useragent->getBrowser() === 'Safari' ? 'true' : 'false' ?>">
    <div class="container">
        <?php
            $breadcrumbs = [
                [
                    'link' => '/',
                    'name' => 'Главная',
                ],
                [
                    'link' => $_SERVER['REQUEST_URI'],
                    'name' => 'Скачать фото профиля',
                ],
            ];
            echo view_block('breadcrumbs', ['data' => $breadcrumbs]);
        ?>
        <div class="download__title">Скачать фотографию профиля Инстаграм</div>
        <form class="download__form search js__downloadAvatarForm">
            <input class="js__downloadAvatarFormInput" type="text" placeholder="Например: buzova86">
            <button class="js__downloadAvatarFormSubmit flex-ajc"><img src="/static/img/blocks/search/icon.svg" alt="submit"></button>
        </form>
        <div class="download__desc">
            Сервис позволяет скачать фотографию из профиля пользовтаеля Instagram бесплатно и без регистрации
        </div>
        <div class="download__main">
            <div class="download__wait js__downloadAvatarWait flex-ajc">
                <img src="/static/img/blocks/header/wait.svg" alt="wait">
            </div>
            <div class="download__content flex js__downloadAvatarContent flex-ajc"></div>
        </div>
    </div>
</div>