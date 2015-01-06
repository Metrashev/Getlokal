<?php if (count($vips)): ?>
    <div id="">
        <h2><?php echo __('Top Places') ?></h2>

        <div class="sidebar_block">
            <?php foreach ($vips as $vip): ?>
                <div class="short">
                    <?php echo link_to(image_tag($vip->getThumb(), array('size' => '45x45', 'alt' => $vip)), $vip->getUri(ESC_RAW), array('title' => $vip)) ?>
                    <h3><?php echo link_to($vip->getCompanyTitle(), $vip->getUri(ESC_RAW), array('title' => $vip)) ?></h3>
                    <?php echo link_to($vip->getClassification(), $vip->getClassificationUri(ESC_RAW), 'class=category') ?>
                    <div class="review_rateing">
                        <div class="rateing_stars">
                            <div class="rateing_stars_orange" style="width: <?php echo $vip->getRating() ?>%;"></div>
                        </div>
                        <span><?php echo $vip->getAverageRating() ?> / 5</span>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
    <?php endif ?>