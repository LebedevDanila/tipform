<div class="blogList flex <?= $z['class'] ?>">
    <?php foreach ($z['articles'] as $key => $row): ?>
        <div class="blogList__item">
            <a href="<?= '/blog/'.$row->subject_link.'/'.$row->link ?>" class="blogList__item-image flex-ajc">
                <img src="<?= CDN_DOMAIN . (empty($row->thumbnail) ? $row->image : $row->thumbnail) ?>" alt="blog_article_image">
            </a>
            <div class="blogList__item-content">
                <div class="blogList__item-date"><?= getTextFormatDate($row->date_create) ?></div>
                <a class="blogList__item-title" href="<?= '/blog/'.$row->subject_link.'/'.$row->link ?>"><?= $row->title ?></a>
                <div class="blogList__item-desc"><?= mb_substr(strip_tags($row->text), 0, 175); ?></div>
                <div class="blogList__item-bottom flex-ab">
                    <div class="blogList__item-readtime">
                        <span>время чтения: <?= getReadtime($row->text) ?> мин.</span>
                    </div>
                    <div class="blogList__item-views flex-a">
                        <img src="/static/img/blocks/blogList/views.svg" alt="views">
                        <span><?= $row->views ?></span>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
