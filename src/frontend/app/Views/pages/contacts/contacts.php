<div class="contacts container page">
    <?php
        $breadcrumbs = [
            [
                'link' => '/',
                'name' => 'Главная',
            ],
            [
                'link' => $_SERVER['REQUEST_URI'],
                'name' => 'Контакты',
            ],
        ];
        echo view_block('breadcrumbs', ['data' => $breadcrumbs]);
    ?>
    <h1 class="contacts__title">Контакты</h1>
    <div class="contacts__content flex-b">
        <div class="contacts__item">
            <div class="contacts__item-content">
                <div class="contacts__item-title">Тех. поддержка</div>
                <div class="contacts__item-field">
                    <div class="contacts__item-field-title">Почта</div>
                    <a href="mailto:info@instaprofi.ru" class="contacts__item-field-content _blue">info@instaprofi.ru</a>
                </div>
                <div class="contacts__item-info">
                    Время работы: с 10:00 до 16:00
                    с ПН по ПТ, выходные СБ и ВС
                </div>
            </div>
        </div>
        <div class="contacts__item">
            <div class="contacts__item-content">
                <div class="contacts__item-title">Партнерство</div>
                <div class="contacts__item-field">
                    <div class="contacts__item-field-title">Почта</div>
                    <a href="mailto:info@instaprofi.ru" class="contacts__item-field-content _blue">info@instaprofi.ru</a>
                </div>
                <div class="contacts__item-info">
                    Время работы: с 10:00 до 16:00
                    с ПН по ПТ, выходные СБ и ВС
                </div>
            </div>
        </div>
        <div class="contacts__item">
            <div class="contacts__item-content">
                <div class="contacts__item-title">Задать вопрос</div>
                <div class="contacts__item-info">
                    Вы также можете задать вопрос или просто оставить отзыв через специальную форму на сайте
                </div>
                <a href="/feedback" class="contacts__item-btn flex-ajc">Задать вопрос ></a>
            </div>
        </div>
    </div>
</div>
