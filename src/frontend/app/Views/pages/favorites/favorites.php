<div class="favorites container page">
    <?php
        $breadcrumbs = [
            [
                'link' => '/',
                'name' => 'Главная',
            ],
            [
                'link' => $_SERVER['REQUEST_URI'],
                'name' => 'Избранные аккаунты',
            ],
        ];
        echo view_block('breadcrumbs', ['data' => $breadcrumbs]);
    ?>
    <h1 class="favorites__title">Избранные аккаунты</h1>
    <?php if(!empty($favorites)): ?>
        <div class="favorites__content flex-a">
            <?php foreach ($favorites as $row): ?>
                <?= view_block('account', ['delete_class' => 'js__favoritesItemDelete', 'picture' => $row['picture'], 'username' => $row['username'], 'followers' => $row['followers'], 'is_static' => !empty($row['is_static']) ? true : false]) ?>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="favorites__empty">У вас пока нет избранных аккаунтов</div>
    <?php endif; ?>
    <?/*= view_block('ads', ['slot' => '2990698685', 'format' => 'auto', 'responsive' => true, 'container_styles' => 'margin-top: 20px;']) */?>
    <!-- Yandex.RTB R-A-1586459-2 -->
    <div id="yandex_rtb_R-A-1586459-2"></div>
    <script>window.yaContextCb.push(()=>{
        Ya.Context.AdvManager.render({
            renderTo: 'yandex_rtb_R-A-1586459-2',
            blockId: 'R-A-1586459-2'
        })
    })</script>
</div>
