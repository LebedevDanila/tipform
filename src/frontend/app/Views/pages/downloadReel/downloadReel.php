<div class="downloadReel download page js__downloadReel" data-is_safari="<?= $useragent->getBrowser() === 'Safari' ? 'true' : 'false' ?>">
    <div class="container">
        <?php
        $breadcrumbs = [
            [
                'link' => '/',
                'name' => 'Главная',
            ],
            [
                'link' => $_SERVER['REQUEST_URI'],
                'name' => 'Скачать reels',
            ],
        ];
        echo view_block('breadcrumbs', ['data' => $breadcrumbs]);
        ?>
        <div class="download__title">Загрузить reels на свой телефон без водяного знака</div>
        <form class="download__form search js__downloadReelForm">
            <input class="js__downloadReelFormInput" type="text" placeholder="Вставьте ссылку на reel">
            <button class="js__downloadReelFormSubmit flex-ajc"><img src="/static/img/blocks/search/icon.svg" alt="submit"></button>
        </form>
        <div class="download__desc">
            На этой странице вы можете скачать Reels на свой телефон без регистрации. Скачивая Reels, вы соглашаетесь с тем, что контент является интеллектуальной собственностью авторов.
        </div>
        <div class="download__main">
            <div class="download__wait js__downloadReelWait flex-ajc">
                <img src="/static/img/blocks/header/wait.svg" alt="wait">
            </div>
            <div class="download__content flex js__downloadReelContent"></div>
        </div>
    </div>
    <div class="main__faq container">
        <div class="main__faq-title big-title">Частые вопросы</div>
        <div class="main__faq-content" itemscope itemtype="http://schema.org/FAQPage">
            <div class="main__faq-item js__downloadFaqItem _active" itemprop="mainEntity" itemscope itemtype="http://schema.org/Question">
                <div class="main__faq-item-top flex-ab">
                    <div class="main__faq-item-title" itemprop="name">Как скачать рилс из Инстаграм на телефон?</div>
                    <img class="main__faq-item-dropdown" src="/static/img/pages/main/faq_dropdown.svg" alt="dropdown">
                </div>
                <div class="main__faq-item-desc" itemscope itemprop="acceptedAnswer" itemtype="http://schema.org/Answer">
                    <span itemprop="text">
                        Для скачивания рилс на телефон необходимо вставить ссылку на рилс и скачать его на открвшейся странице.
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>