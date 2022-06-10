<!doctype html>
<html lang="ru">
<head>
    <title><?=$meta['title']?></title>
    <?php if ($useragent->isMobile()): ?>
        <link href="https://cdn.adfinity.pro/foralls/adfinity_1.1.css" rel="stylesheet">
        <script src="https://yandex.ru/ads/system/header-bidding.js"></script>
        <script src="https://cdn.adfinity.pro/foralls/adfinity_1.1.js"></script>
        <script src="https://cdn.adfinity.pro/partners/instaprofi.ru/hbconfig.js"></script>
        <link rel="preconnect" href="https://ads.betweendigital.com" crossorigin>
    <?php endif;?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <?php if($meta['robot'] === 0) :?>
        <meta name="robots" content="nofollow"/>
        <meta name="robots" content="noindex"/>
    <?php endif;?>
    <?php if(! empty($meta['canonical'])) :?>
        <link rel="canonical" href="<?=$meta['canonical']?>" />
    <?php endif;?>
    <?php if(! empty($meta['og'])) :?>
        <meta property="og:site_name" content="<?=$meta['og']['site_name']?>" />
        <meta property="og:url" content="<?=$meta['og']['url']?>" />
        <?php if(! empty($meta['og']['image'])) :?>
            <meta property="vk:image" content="<?=$meta['og']['image']?>" />
            <meta property="og:image" content="<?=$meta['og']['image']?>" />
            <meta property="og:image:width" content="600" />
            <meta property="og:image:height" content="315" />
        <?php endif;?>
        <meta property="og:title" content='<?=str_replace("'", '"', $meta['title'])?>' />
        <meta property="og:type" content="website" />
        <meta property="og:description" content='<?=str_replace("'", '"', $meta['description'])?>' />
    <?php endif;?>

    <meta name="description" content="<?=$meta['description']?>" />
    <meta name="keywords" content="<?=$meta['keywords']?>" />
    <meta name="yandex-verification" content="874587ad83fef859" />
    <meta name="google-site-verification" content="nNE9eC48DPh8OKYmRO6UZkluAxnQ0Hig5d38RlDUqOg" />

    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#dfe2ff">
    <meta name="msapplication-config" content="/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

    <?php if(env('app.env') === 'dev') :?>
        <link rel="stylesheet" href="/static/css/main.css?v=<?=FRONTEND_VERSION_CSS?>" />
    <?php else :?>
        <link rel="stylesheet" href="/bundles/css/main-min.<?=FRONTEND_VERSION_CSS?>.css" />
    <?php endif;?>

    <script type="text/javascript">
        const GLOBAL = {protect: "<?=env("protection.name")?>", version: {js:'<?=FRONTEND_VERSION_JS?>',css:'<?=FRONTEND_VERSION_CSS?>'}};
    </script>
</head>
<body>
<section>
    <?php echo view_block('header');?>
    <?php echo view_page($content);?>
    <?php echo view_block('footer');?>
</section>

<?php echo view_block('loader');?>

<script type="text/javascript" src="/bundles/js/main-min.<?=FRONTEND_VERSION_JS?>.js"></script>
<script type="text/javascript">
    $.ajax({
        type: "GET",
        url: "/bundles/js/<?=$_bundles['js']?>.<?=FRONTEND_VERSION_JS?>.js",
        dataType: "script",
        cache: true,
        async: false
    });
</script>

<?php if (env('app.env') === 'prod' && !empty($_SERVER['HTTP_USER_AGENT']) && !preg_match("#Chrome-Lighthouse#", $_SERVER['HTTP_USER_AGENT'])): ?>

<?php endif; ?>

</body>
</html>