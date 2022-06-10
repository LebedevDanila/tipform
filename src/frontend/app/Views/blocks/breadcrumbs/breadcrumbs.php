<?php if (empty($z['data']))
{
    return false;
}?>
<ol itemscope itemtype="http://schema.org/BreadcrumbList" class="breadcrumbs">
    <?php $count = count($z['data']);?>
    <?php foreach($z['data'] as $k => $row) :?>
        <li itemscope itemprop="itemListElement"  itemtype="http://schema.org/ListItem">
            <?php if(! empty($row['link'])) :?>
                <a itemprop="item"href="<?=$row['link']?>" class="a _blue <?=($k + 1 === count($z['data']) ? '__this' : '__a')?>"><span itemprop="name"><?=$row['name']?></span></a>
            <?php else :?>
                <span itemprop="name" class="__this"><?=$row['name']?></span>
            <?php endif;?>
            <meta itemprop="position" content="<?=$k + 1?>" />
            <?php if($k + 1 !== $count) :?>
                <span class="__gt">/</span>
            <?php endif;?>
        </li>
    <?php endforeach;?>
</ol>
