<?php include_partial('global/commonSlider'); ?>
<div class="container set-over-slider">
    <div class="row"> 
        <div class="container">
            <div class="row">
                <h1 class="col-xs-12 main-form-title"><?php echo __('Directory'); ?></h1>
            </div>
        </div>            
    </div>
    <div class="default-container default-form-wrapper col-sm-12">
        <ul class="directory">    
            <?php foreach ($locations as $location): ?> 
                <?php
                $partner_class = getlokalPartner::getLanguageClass(getlokalPartner::getInstance());
                if ($location->getIsDefault() && 0):
                    $url = '@sublevel?slug=' . $classification->getSlug() . '&sector=' . $classification->getPrimarySector()->getSlug() . '&city=' . $location->getSlug();
                else:
                    $url = '@classification?slug=' . $classification->getSlug() . '&sector=' . $classification->getPrimarySector()->getSlug() . '&city=' . $location->getSlug();
                endif;
                echo '<li>' . link_to($location->getLocation() . ', ' . mb_convert_case($location->getCounty()->getName(), MB_CASE_TITLE, 'UTF-8'), $url, array('class' => 'default-link')) . '</li>';
                ?>
            <?php endforeach ?>
        </ul>
    </div>  
</div>

<style>
    .directory{
        list-style: none;
    }
</style>