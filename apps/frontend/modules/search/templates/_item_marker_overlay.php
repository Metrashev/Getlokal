<div class="desc_img_wrap">
    <?php echo link_to(
        image_tag('http://static.getlokal.com/'.$company->getImageURL(2)),
        $company->getUri(ESC_RAW),
        'target=_blank class=listing_place_img title=' . $company->getCompanyTitle()
    ); ?>
    <?php if (isset($attrs) && $attrs['is_ppp']): ?>
        <img src="/images/gui/icon_map_badge.png" />
    <?php endif;?>
</div>
<div class="details">
    <span class="title"><?php echo link_to(
        $company->getCompanyTitle(),
        $company->getUri(ESC_RAW),
        array('title' => $company->getCompanyTitle(), 'target' => '_blank')
    ); ?></span>
    <span class="classification">
    <?php echo link_to(
        $company->getClassification(),
        $company->getClassificationUri(ESC_RAW),
        array('title' => $company->getClassification(), 'class' => 'category', 'target' => '_blank')
    ); ?></span>

   <div class="stars-holder small map-overlay-wrapper-stars">     
        <ul>
          <li class="gray-star"><i class="fa fa-star"></i></li>
          <li class="gray-star"><i class="fa fa-star"></i></li>
          <li class="gray-star"><i class="fa fa-star"></i></li>
          <li class="gray-star"><i class="fa fa-star"></i></li>
          <li class="gray-star"><i class="fa fa-star"></i></li>
        </ul>
        <div class="top-list">
            <div class="hiding-holder" style="width: <?php echo $company->getRating() ?>%;">
               <ul class="spans-holder">
                    <li class="red-star"><i class="fa fa-star"></i></li>
                    <li class="red-star"><i class="fa fa-star"></i></li>
                    <li class="red-star"><i class="fa fa-star"></i></li>
                    <li class="red-star"><i class="fa fa-star"></i></li>
                    <li class="red-star"><i class="fa fa-star"></i></li>
               </ul>
            </div>
         </div>
    </div>

    <?php if ($company->getPhone()): ?>
        <div class="phone"><?php echo $company->getPhoneFormated() ?></div>
    <?php endif ?>
</div>
<div class="clear"></div>

<?php if (isset($attrs) && $attrs['is_ppp']): ?>
    <?php $offerCount = $company->getAllOffers(true, false, true); ?>
    <?php $eventCount = $company->getEventCount(); ?>

    <?php if ($offerCount or $eventCount): ?>
        <div class="vip_content">
            <?php if ($eventCount): ?>
                <?php
                    $title = $eventCount . ' ' . __('Incoming Events', null, 'events');
                    echo link_to($title, $company->getUri(ESC_RAW) . '#event', compact('title'));
                ?>
            <?php endif; ?>

            <?php if ($offerCount): ?>
                <?php
                    $title = $offerCount.' '.__('Current Offers', null, 'offer');
                    echo link_to($title, $company->getUri(ESC_RAW).'#offer', compact('title')); ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php endif;?>

