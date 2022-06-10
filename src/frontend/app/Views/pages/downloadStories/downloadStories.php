<div class="downloadStories download page">
    <div class="container">
        <?php
            $breadcrumbs = [
                [
                    'link' => '/',
                    'name' => 'Главная',
                ],
                [
                    'link' => $_SERVER['REQUEST_URI'],
                    'name' => 'Скачать истории',
                ],
            ];
            echo view_block('breadcrumbs', ['data' => $breadcrumbs]);
        ?>
        <div class="download__title">Скачать истории в Инстаграм анонимно без регистрации</div>
        <form class="download__form search js__downloadStoriesForm">
            <input class="js__downloadStoriesFormInput" type="text" placeholder="Например: kingjames">
            <button class="js__downloadStoriesFormSubmit flex-ajc"><img src="/static/img/blocks/search/icon.svg" alt="submit"></button>
        </form>
        <div class="download__desc">
            Чтобы скачать истории или хайлайст необходимо вставить в форму ник профиля Инстаграм и на открывшейся странице загрузить необходимое вам сторис. Выполняя поиск вы соглашаетесь с тем, что права на скачанные материалы остаются за их авторами, так как они являются их собственностью
        </div>
    </div>
    <div class="main__faq container">
        <div class="main__faq-title big-title">Частые вопросы</div>
        <div class="main__faq-content" itemscope itemtype="http://schema.org/FAQPage">
            <div class="main__faq-item js__downloadFaqItem _active" itemprop="mainEntity" itemscope itemtype="http://schema.org/Question">
                <div class="main__faq-item-top flex-ab">
                    <div class="main__faq-item-title" itemprop="name">Как скачать историю из инстаграма другого человека?</div>
                    <img class="main__faq-item-dropdown" src="/static/img/pages/main/faq_dropdown.svg" alt="dropdown">
                </div>
                <div class="main__faq-item-desc" itemscope itemprop="acceptedAnswer" itemtype="http://schema.org/Answer">
                    <span itemprop="text">
                        Для скачивания истории нужно вставить ссылку на профиль, либо ник пользовтаеля в поисковую строку и нажать поиск, после чего выбрать из списка ситорий нужную для скачивания. Так же на открывшейся странице можно скачать закрепленные истории (актуальные или хайлайст) анонимно.
                    </span>
                </div>
            </div>
            <div class="main__faq-item js__downloadFaqItem" itemprop="mainEntity" itemscope itemtype="http://schema.org/Question">
                <div class="main__faq-item-top flex-ab">
                    <div class="main__faq-item-title" itemprop="name">Как скачать историю из инстаграм на айфон и андроид?</div>
                    <img class="main__faq-item-dropdown" src="/static/img/pages/main/faq_dropdown.svg" alt="dropdown">
                </div>
                <div class="main__faq-item-desc" itemscope itemprop="acceptedAnswer" itemtype="http://schema.org/Answer">
                    <span itemprop="text">
                        Для этого необходимо открыть сайт https://instaprofi.ru/download-stories вставить ник пользователя и после загрузки историй нажать кнопку скачать под историей.
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>