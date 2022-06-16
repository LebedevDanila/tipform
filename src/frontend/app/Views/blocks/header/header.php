<header class="header <?=$useragent->isMobile() ? '_fixed' : ($content === 'main' ?: '_fixed')?>">
    <div class="header__container container flex-aic flex-jcsb">
        <div class="header__button _burger">
            <div class="header__button-wrapper">
                <div class="header__button-content">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
        <div class="header__logo"></div>
        <div class="header__button _auth">
            <div class="header__button-wrapper">
                <img src="/static/img/blocks/header/user-mobile.svg" alt="user">
            </div>
        </div>
        <ul class="header__nav flex-aic">
            <li><a href="#">Главная</a></li>
            <li><a href="#">Тарифы</a></li>
            <li><a href="#">API</a></li>
            <li><a href="#">FAQ</a></li>
            <li><a href="#">Контакты</a></li>
        </ul>
        <div class="header__auth">
            <div class="header__auth-wrapper flex-aic">
                <div class="header__auth-login">Войти</div>
                <div class="header__auth-registration btn">
                    <img src="/static/img/blocks/header/user.svg" alt="user">
                    <span>Регистрация</span>
                </div>
            </div>
        </div>
    </div>
</header>