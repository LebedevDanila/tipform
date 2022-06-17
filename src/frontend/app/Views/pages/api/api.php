<div class="api">
    <div class="api__container container">
        <?php
            $breadcrumbs = [
                [
                    'link' => '/',
                    'name' => 'Главная',
                ],
                [
                    'link' => $_SERVER['REQUEST_URI'],
                    'name' => 'API',
                ],
            ];
            echo view_block('breadcrumbs', ['data' => $breadcrumbs]);
        ?>
        <div class="api__main flex-jcsb">
            <div class="api__nav">
                <a class="api__nav-item" href="#">
                    <div class="api__nav-item-top flex-aic">
                        <img src="/static/img/pages/api/arrow.svg" alt="arrow">
                        <span>Главная</span>
                    </div>
                </a>
                <a class="api__nav-item" href="#">
                    <div class="api__nav-item-top flex-aic">
                        <img src="/static/img/pages/api/arrow.svg" alt="arrow">
                        <span>Получение токена и подключение к API</span>
                    </div>
                </a>
                <a class="api__nav-item _active" href="#">
                    <div class="api__nav-item-top flex-aic">
                        <img src="/static/img/pages/api/arrow.svg" alt="arrow">
                        <span>Основные методы</span>
                    </div>
                </a>
                <a class="api__nav-item" href="#">
                    <div class="api__nav-item-top flex-aic">
                        <img src="/static/img/pages/api/arrow.svg" alt="arrow">
                        <span>Тарифные планы</span>
                    </div>
                </a>
            </div>
            <div class="api__content">
                <div class="api__title big-title">Метод для получения списка вариантов адреса (GET)</div>
                <div class="api__text">
                    Метод позволяет получить список вариантов полного адреса объекта по указанному приблизительному тексту.
                </div>
            </div>
            <div class="api__menu"></div>
        </div>
    </div>
</div>