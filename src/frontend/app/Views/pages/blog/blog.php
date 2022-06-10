<div class="blog page">
	<div class="blog__container container">
		<?php
	        $breadcrumbs = [
	            [
	                'link' => '/',
	                'name' => 'Главная',
	            ],
	            [
	                'link' => $_SERVER['REQUEST_URI'],
	                'name' => isset($name) ? $name : 'Полезные статьи',
	            ],
	        ];
	        echo view_block('breadcrumbs', ['data' => $breadcrumbs]);
	    ?>
	    <h1 class="blog__title"><?= isset($name) ? $name : 'Полезные статьи' ?></h1>

	    <?/*= view_block('ads', ['slot' => '2159342051', 'format' => 'auto', 'responsive' => true]) */?>
        <!-- Yandex.RTB R-A-1586459-2 -->
        <div id="yandex_rtb_R-A-1586459-2"></div>
        <script>window.yaContextCb.push(()=>{
            Ya.Context.AdvManager.render({
                renderTo: 'yandex_rtb_R-A-1586459-2',
                blockId: 'R-A-1586459-2'
            })
        })</script>

	    <div class="blog__categories flex-a">
	    	<a href="/blog" class="blog__categories-item <?= $_SERVER['REQUEST_URI'] === '/blog' ? '_active' : '' ?>">Главная</a>
	    	<?php foreach ($subjects as $row): ?>
	    		<a href="/blog/<?= $row->link ?>" class="blog__categories-item <?= isset($url_link) && $url_link === $row->link ? '_active' : '' ?>"><?= $row->name ?></a>
	    	<?php endforeach ?>
	    </div>

        <?= view_block('blogList', ['class' => 'blog__articles', 'articles' => $articles]); ?>

        <?/*= view_block('ads', ['slot' => '4593933703', 'format' => 'auto', 'responsive' => true, 'container_styles' => 'margin-top: 20px;']) */?>
	</div>
</div>
