<div class="blogArticle container page" itemscope itemtype="https://schema.org/Article">
    <link itemprop="mainEntityOfPage" href="<?= $meta['og']['url'] ?>" />
    <link itemprop="image" href="image">
    <meta itemprop="headline name" content="<?= $article->title ?>">
    <meta itemprop="description" content="<?= $article->meta_description ?>">
    <meta itemprop="author" content="Персиков Юрий Антонович">
    <?php
        $date_published = date('Y-m-d', $article->date_create);
        $date_modified  = date('Y-m-d', ($article->date_create + 86400));
    ?>
    <meta itemprop="datePublished" datetime="<?= $date_published ?>" content="<?= $date_published ?>">
    <meta itemprop="dateModified" datetime="<?= $date_modified ?>" content="<?= $date_modified ?>">
	<?php
        $breadcrumbs = [
            [
                'link' => '/',
                'name' => 'Главная',
            ],
            [
                'link' => '/blog/'.$article->subject_link,
                'name' => $article->subject_name,
            ],
            [
                'link' => $_SERVER['REQUEST_URI'],
                'name' => $article->title,
            ],
        ];
        echo view_block('breadcrumbs', ['data' => $breadcrumbs]);
    ?>
    <div class="blogArticle__top" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
        <div class="blogArticle__props flex-a">
            <div class="blogArticle__props-item flex-a">
                <img src="/static/img/pages/blogArticle/clock.svg" alt="clock">
                <span>время чтения: <?= getReadtime($article->text) ?> мин.</span>
            </div>
            <div class="blogArticle__props-item flex-a">
                <img src="/static/img/pages/blogArticle/date.svg" alt="date">
                <span><?= getTextFormatDate($article->date_create) ?></span>
            </div>
            <div class="blogArticle__props-item flex-a">
                <img src="/static/img/pages/blogArticle/views.svg" alt="views">
                <span><?= $article->views ?></span>
            </div>
        </div>
        <h1 class="blogArticle__title"><?= $article->title ?></h1>
        <div class="blogArticle__preview" itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
            <img
                itemprop="url image"
                src="<?= CDN_DOMAIN . $article->image ?>"
                alt="<?= 'Изображение статьи:' . $article->title ?>"
                title="<?= 'Изображение статьи:' . $article->title ?>"
            >
        </div>
        <meta itemprop="name" content="instaprofi.ru">
        <meta itemprop="telephone" content="">
        <meta itemprop="address" content="Россия">
    </div>
    <div class="blogArticle__main flex-b">
    	<div class="blogArticle__content">
    		<div class="blogArticle__menu">
                <?php
                    $menu = renderH2Menu($article->text);
                ?>
                <?php if (!empty($menu)): ?>
    			    <div class="blogArticle__menu-title">Содержание:</div>
    			    <ol class="blogArticle__menu-content">
                        <?php foreach ($menu as $idx => $row): ?>
                            <li class="blogArticle__menu-item js__blogArticleMenuItem" data-id="<?= $idx ?>"><span><?= $idx+1 ?></span> <span><?= $row ?></span></li>
                        <?php endforeach; ?>
    			    </ol>
                <?php endif; ?>
    		</div>

            <?/*= view_block('ads', ['slot' => '9115886234', 'format' => 'fluid', 'layout' => 'in-article', 'container_styles' => 'margin-top: 20px;']) */?>
            <!-- Yandex.RTB R-A-1586459-2 -->
            <div id="yandex_rtb_R-A-1586459-2"></div>
            <script>window.yaContextCb.push(()=>{
                    Ya.Context.AdvManager.render({
                        renderTo: 'yandex_rtb_R-A-1586459-2',
                        blockId: 'R-A-1586459-2'
                    })
                })</script>

            <div class="blogArticle__text" itemprop="articleBody"><?= $article->text ?></div>

            <?/*= view_block('ads', ['slot' => '8656543621', 'format' => 'fluid', 'layout' => 'in-article', 'container_styles' => 'margin-top: 20px;']) */?>
    	</div>
    	<div class="blogArticle__sidebar">
    		<div class="blogArticle__links">
    			<div class="blogArticle__links-title">Другие полезные статьи</div>
    			<ul class="blogArticle__links-content">
                    <?php foreach ($popular_articles as $idx => $row): ?>
                        <?php if ($article->id !== $row->id): ?>
                            <li><a href="/blog/<?= $row->subject_link . '/' . $row->link ?>"><?= $row->title ?></a></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
    			</ul>
    		</div>
            <?php /*if (!$useragent->isMobile()): */?><!--
                <?/*= view_block('ads', ['slot' => '5185994489', 'format' => 'vertical', 'responsive' => true, 'container_styles' => 'margin-top: 20px;']) */?>
            --><?php /*endif; */?>
    	</div>
    </div>
</div>
