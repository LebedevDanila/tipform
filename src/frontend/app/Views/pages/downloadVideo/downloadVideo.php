<div class="downloadVideo download page js__downloadVideo" data-is_safari="<?= $useragent->getBrowser() === 'Safari' ? 'true' : 'false' ?>">
    <div class="container">
        <?php
            $breadcrumbs = [
                [
                    'link' => '/',
                    'name' => 'Главная',
                ],
                [
                    'link' => $_SERVER['REQUEST_URI'],
                    'name' => 'Скачать видео',
                ],
            ];
            echo view_block('breadcrumbs', ['data' => $breadcrumbs]);
        ?>
        <div class="download__title">Скачать видео или IGTV из Инстаграм</div>
        <form class="download__form search js__downloadVideoForm">
            <input class="js__downloadVideoFormInput" type="text" placeholder="Вставьте ссылку на видео">
            <button class="js__downloadVideoFormSubmit flex-ajc"><img src="/static/img/blocks/search/icon.svg" alt="submit"></button>
        </form>
        <div class="download__desc">
            Чтобы скачать видео вставьте ссылку на пост, содержащий видео или ссылку на IGTV. Скачивая видео вы подтвержадете, что видео-контент является собственностью авторов.
        </div>
        <div class="download__main">
            <div class="download__wait js__downloadVideoWait flex-ajc">
                <img src="/static/img/blocks/header/wait.svg" alt="wait">
            </div>
            <div class="download__content flex js__downloadVideoContent"></div>
        </div>
    </div>
    <div class="main__faq container">
        <div class="main__faq-title big-title">Частые вопросы</div>
        <div class="main__faq-content" itemscope itemtype="http://schema.org/FAQPage">
            <div class="main__faq-item js__downloadFaqItem _active" itemprop="mainEntity" itemscope itemtype="http://schema.org/Question">
                <div class="main__faq-item-top flex-ab">
                    <div class="main__faq-item-title" itemprop="name">Как скачать видео с инстаграм на комьютер или телефон (айфон, андроид)</div>
                    <img class="main__faq-item-dropdown" src="/static/img/pages/main/faq_dropdown.svg" alt="dropdown">
                </div>
                <div class="main__faq-item-desc" itemscope itemprop="acceptedAnswer" itemtype="http://schema.org/Answer">
                    <span itemprop="text">
                        Чтобы скачать видео из инстаграма или IGTV необходимо вставить ссылку на видео или IGTV в строку поиска на сайте Instaprofi.ru и нажать ""Найти"". После чего нажать на кнопку ""Скачать"" под нужным для вас видео, контент сохраниться в галерею вашего смартфона или компьютера.
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>