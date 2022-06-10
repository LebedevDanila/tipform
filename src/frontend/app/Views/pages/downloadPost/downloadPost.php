<div class="downloadPost download page js__downloadPost" data-is_safari="<?= $useragent->getBrowser() === 'Safari' ? 'true' : 'false' ?>">
	<div class="container">
		<?php
	        $breadcrumbs = [
	            [
	                'link' => '/',
	                'name' => 'Главная',
	            ],
	            [
	                'link' => $_SERVER['REQUEST_URI'],
	                'name' => 'Скачать фото',
	            ],
	        ];
	        echo view_block('breadcrumbs', ['data' => $breadcrumbs]);
	    ?>
	    <div class="download__title">Скачать фото из профиля Инстаграм анонимно</div>
	    <form class="download__form search js__downloadPostForm">
	    	<input class="js__downloadPostFormInput" type="text" placeholder="Вставьте ссылку на пост или фото">
	    	<button class="js__downloadPostFormSubmit flex-ajc"><img src="/static/img/blocks/search/icon.svg" alt="submit"></button>
	    </form>
	    <div class="download__desc">
            Для скачивания фото необходимо вставить в форму ссылку на пост, который вы хотите скачать. Загружая фото вы соглашаетесь, что изображения являются интеллектульной собственностью авторов
	    </div>
	    <div class="download__main">
            <div class="download__wait js__downloadPostWait flex-ajc">
                <img src="/static/img/blocks/header/wait.svg" alt="wait">
            </div>
	    	<div class="download__content flex js__downloadPostContent"></div>
	    </div>
	</div>
    <div class="main__faq container">
        <div class="main__faq-title big-title">Частые вопросы</div>
        <div class="main__faq-content" itemscope itemtype="http://schema.org/FAQPage">
            <div class="main__faq-item js__downloadFaqItem _active" itemprop="mainEntity" itemscope itemtype="http://schema.org/Question">
                <div class="main__faq-item-top flex-ab">
                    <div class="main__faq-item-title" itemprop="name">Как сохранить фото из инстаграм на компьютер, айфон или андроид?</div>
                    <img class="main__faq-item-dropdown" src="/static/img/pages/main/faq_dropdown.svg" alt="dropdown">
                </div>
                <div class="main__faq-item-desc" itemscope itemprop="acceptedAnswer" itemtype="http://schema.org/Answer">
                    <span itemprop="text">
                        Для сохранения фото вставьте ссылку на фото или пост и выберите фото для скачивания.
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>