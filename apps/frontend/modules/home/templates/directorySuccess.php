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
            <?php foreach ($classifications as $classification): ?>
                <?php if ($classification->Translation[$sf_user->getCountry()->getSlug()]->number_of_places): ?>
                    <li><?php echo link_to($classification, '@locations?slug=' . $classification->getSlug() . '&sector=' . $classification->getPrimarySector()->getSlug(), array('class' => 'default-link')) ?></li>
                <?php endif; ?>
            <?php endforeach ?> 
        </ul>
    </div>	
</div>

<style>
    .directory{
        list-style: none;
    }
</style>