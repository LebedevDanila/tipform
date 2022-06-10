<div class="feedback container page">
	<?php
        $breadcrumbs = [
            [
                'link' => '/',
                'name' => 'Главная',
            ],
            [
                'link' => '/contacts',
                'name' => 'Контакты',
            ],
            [
                'link' => $_SERVER['REQUEST_URI'],
                'name' => 'Обратная связь',
            ],
        ];
        echo view_block('breadcrumbs', ['data' => $breadcrumbs]);
    ?>
    <h1 class="feedback__title">Обратная связь</h1>
    <div class="feedback__form">
        <div class="feedback__form-wrapper flex-a">
            <div class="feedback__form-title">Обратная связь</div>
            <div class="feedback__form-content">
                <div class="feedback__form-top flex-b">
                    <input type="text" class="feedback__form-field _input js__feedbackName" placeholder="Имя:">
                    <input type="text" class="feedback__form-field _input js__feedbackEmail" placeholder="Ваша почта:">
                </div>
                <textarea class="feedback__form-field _textarea js__feedbackMessage" placeholder="Ваш вопрос или отзыв:"></textarea>
                <div class="feedback__form-submit flex-ajc js__feedbackSubmit">Отправить</div>
            </div>
        </div>
    </div>
</div>
