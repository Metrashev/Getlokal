<?php foreach ($pager->getResults() as $place): ?>

    <li class="user_review">
        <div id="place-item" class="review review_list_company">
           
                <h2><?php echo link_to($place->getCompanyTitle(), $place->getUri(ESC_RAW), array('target' => '_blank')) ?></h2>
                <?php echo link_to($place->getClassification(), $place->getClassificationUri(ESC_RAW), array('class' => 'category', 'target' => '_blank')) ?>
                <a href="<?php echo url_for($place->getUri(ESC_RAW)) ?>" class="review_list_img">
                     <?php echo image_tag($place->getThumb(0), array('size' => '100x100', 'alt' => $place->getCompanyTitle())) ?>
                </a>
                <div class="review_content">
                    <div class="rateing_stars">
                        <div style="width: <?php echo $place->getRating() ?>%" class="rateing_stars_pink"></div>
                        <span><?php echo $place->getAverageRating() ?> / 5</span>
                    </div>
                </div>
               
           

        </div>    
    </li>

<?php endforeach; ?>

