<div class="ads" style="<?= $z['container_styles'] ?? '' ?>">
    <ins class="adsbygoogle"
        style="display:block; <?= $z['element_styles'] ?? '' ?>"
        <?php if (isset($z['layout'])): ?>
        data-ad-layout="<?= $z['layout'] ?>"
        <?php endif; ?>
        data-ad-client="ca-pub-3466713921867030"
        data-ad-slot="<?= $z['slot'] ?>"
        <?php if (isset($z['format'])): ?>
            data-ad-format="<?= $z['format'] ?>"
        <?php endif; ?>
        <?php if (isset($z['responsive'])): ?>
            data-full-width-responsive="true"
        <?php endif; ?>></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>