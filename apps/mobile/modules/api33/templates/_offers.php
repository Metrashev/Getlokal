<?php 
    use_helper('Text');
    if (isset($offers) && !empty($offers)): ?>
    <h5 class="gray">
        <strong><?php echo __("OFFERS") ?></strong> (<?php echo count($offers) ?>)
    </h5>
    <div class="offers">
        <?php foreach ($offers as $o):
            // image
            if ($o->getImageId() && $image = Doctrine_Core::getTable ( 'Image' )->findOneById($o->getImageId())) {
                $src = $image->getFile();
            } else {
                $src = image_path('gui/default_place_292x220.png');                
            }
            ?>  
            <a href="getlokal://offer?<?php echo $o->getId(); ?>">
                <div class="offer" style="background-image: url('<?php echo $src; ?>');"> <!-- background image here -->
                    <div class="info">
                        <div class="title"><?php echo truncate_text($o->getDisplayTitle(), 50) ?></div>   
                    </div>
                    <div class="vouchers"><?php echo $o->getDisplayVouchersRemaining() ?></div>
                </div>
            </a>
        <?php endforeach ?>
    </div>
<?php endif ?> 