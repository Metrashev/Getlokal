<?php $specialUserId = 5712; ?>
<?php use_helper('Date', 'XssSafe');?>
<div class="listing_place <?php echo $company->getActivePPPService(true) ? 'vip' : '' ?>"
    id="company-<?php echo $company->getId() ?>">
     <?php if ($company->getActivePPPService()): ?>
        <?php echo link_to(
            image_tag($company->getThumb(2), 'alt=' . $company->getCompanyTitle()),
            $company->getUri(ESC_RAW),
            'class=listing_place_img title=' . $company->getCompanyTitle()
        ); ?>
                <div class="vip_badge"></div>
                <div class="official_page"><?php echo __('Official page', null, 'company'); ?></div>

     <?php else: ?>
        <?php echo link_to(
            image_tag($company->getThumb(), 'size=100x100 alt=' . $company->getCompanyTitle()),
            $company->getUri(ESC_RAW),
            'class=listing_place_img title=' . $company->getCompanyTitle()
        ); ?>
     <?php endif; ?>   
    <div class="listing_place_in">
      <?php if (!$company->getActivePPPService()): ?>
        <div class="listing_place_rateing">
            <div class="rateing_stars">
                <div class="rateing_stars_orange" style="width: <?php echo $company->getRating() ?>%;"></div>
            </div>
            <div>
                <span><?php echo format_number_choice(
                '[0]0 reviews|[1]1 review|(1,+Inf]%count% reviews',
                array('%count%' => $company->getNumberOfReviews()),
                $company->getNumberOfReviews()
            ); ?></span>
            </div>
        </div>
        <h3>
          <a href="<?php echo url_for($company->getUri(ESC_RAW)) ?>" title="<?php echo $company->getCompanyTitle() ?>">
            <?php echo $company->getCompanyTitle() ?>
          </a>
        </h3>
        <?php else: ?>   
        <h3>
            <a href="<?php echo url_for($company->getUri(ESC_RAW)) ?>" title="<?php echo $company->getCompanyTitle() ?>"><?php echo $company->getCompanyTitle() ?></a>
        </h3>
        <div class="listing_place_rateing vip">
            <div class="rateing_stars">
                <div class="rateing_stars_orange" style="width: <?php echo $company->getRating() ?>%;"></div>
            </div>
            <span><?php echo format_number_choice(
                '[0]0 reviews|[1]1 review|(1,+Inf]%count% reviews',
                array('%count%' => $company->getNumberOfReviews()),
                $company->getNumberOfReviews()
                    ); ?></span>
        </div>
        <?php endif; ?>   
        <p><strong><?php echo link_to(
            $company->getClassification(),
            $company->getClassificationUri(ESC_RAW),
            array('title=' . $company->getSector(), 'class' => 'category')
        ); ?></strong></p>
        <p>
            <?php echo $company->getDisplayAddress(); ?>
            <?php if ($company->getPhone()): ?>
                <br /><?php echo $company->getPhoneFormated(); ?>
            <?php endif ?>
        </p>
        <?php if ($company->getAllOffers()):?>
            <div title="<?php echo format_number_choice( '[1]1 offer for %company%|(1,+Inf]%count% offers for %company%', 
                                  array('%count%' => $company->getAllOffers(true,false,true), '%company%'=>$company->getCompanyTitle() ), 
                                  $company->getAllOffers(true,false,true),'offer' )   ; ?>" class="available_company_offers">
                <div class="company_offers_count">
                    <?php echo $company->getAllOffers(true, false, true) ;?>       
                </div>
            </div>
        <?php endif;?>

    </div>
    <div class="clear"></div>

    <!--last review-->
    <?php
        $tr = array(
            'user_id' => $attrs['tr_user_id'],
            'name' => $attrs['tr_u_name'],
            'username' => $attrs['tr_u_username'],
            'review' => $attrs['tr_review']
        );
        if ($tr['review'] && $tr['user_id'] && $tr['username']):
    ?>
        <div class="listing_place_review">
            <strong>
                <?php echo link_to($tr['name'], 'profile/index?username=' . $tr['username'], array(
                    'title' => $tr['name']
                )); ?>
            </strong>
            <?php if ($sf_user->getCulture() == 'bg'): ?>
                <?php echo image_tag('gui/quotation_icon_bg.png', array('class' => 'quotation_icon')) ?>
            <?php else : ?>
                <?php echo image_tag('gui/quotation_icon.png', array('class' => 'quotation_icon')) ?>
            <?php endif; ?>
            <q class="item_review">
                 <?php if(strlen(strip_tags($tr['review'])) > 400): ?>
                 <?php 
                        $truncate_text = substr(strip_tags($tr['review']), 0, 400 - strlen('...'));
                        echo preg_replace('/\s+?(\S+)?$/', '', $truncate_text).'...';
                   ?>    
                 <?php else:?>
                        <?php echo ESC_XSSSAFE($tr['review']);?>
                 <?php endif; ?>
                
            <?php if(strlen($tr['review']) > 400): ?>
                <a href="<?php echo url_for($company->getUri(ESC_RAW)) ?>" class="link_to_company"><?php echo __('see more') ?></a></h3>
            <?php endif; ?>
            </q>
        </div>
    <?php endif; ?>
</div>
