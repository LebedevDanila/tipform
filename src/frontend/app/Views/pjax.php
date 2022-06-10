<title><?=$meta['title']?></title>
<description><?=$meta['description']?></description>
<keywords><?=$meta['keywords']?></keywords>
<div content-main="" class="content-main">
    <?php echo view_block('header');?>
    <?php echo view_page($content);?>
    <?php echo view_block('footer');?>
    <script src="/bundles/js/<?=$_bundles['js']?>.<?=FRONTEND_VERSION_JS?>_<?=generateHash(6)?>.js" type="text/javascript"></script>
</div>
