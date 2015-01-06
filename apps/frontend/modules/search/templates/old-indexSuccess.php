<?php if($noAds == true): ?>
<?php slot('no_ads', true) ?>
<?php endif;?>

<?php
    $searchWhere = $sf_request->getParameter('w');
    $searchString = $sf_request->getParameter('s');
    $searchACWhere = $sf_request->getParameter('ac_where');
    $searchACWhereIDs = $sf_request->getParameter('ac_where_ids');
    $wherePlaceholder = $sf_request->getParameter('placeholder');
?>
<div class="sector-classification-wrap">
 <?php include_component('box', 'boxCategoriesMenu'); ?>
</div>

<?php if($sf_user->getCountry()->getSlug() == 'fi'): ?>
    <h2 class="dotted"><?php echo __('%what% in %where%', array('%what%' => $searchString, '%where%' => $searchWhere ? $searchWhere : $sf_user->getCounty())); ?></h2>
<?php else: ?>
    <h2 class="dotted"><?php echo __('%what% in %where%', array('%what%' => $searchString, '%where%' => $wherePlaceholder ? $wherePlaceholder : $sf_user->getCity()->getDisplayCity())); ?></h2>
<?php endif; ?>

 <div class="content_in" style="padding: 0;">
    <div class="listing_tabs_wrap" id="content_anchor" style="padding: 0">
        <div id="no_results" style="display: <?php echo $numberOfResults ? 'none': 'block' ?>;">
            <h3><?php echo __('No Results found for %keyword% in %place%', array('%keyword%' => $searchString, '%place%' => $searchWhere ? $searchWhere : $sf_user->getCity()->getDisplayCity())) ?></h3>
            <p><?php echo __('If you want to search again for another location, please use the \'Where\' field to enter the right location. It is also possible to expand your search to cover the whole of %s', array('%s' => $sf_user->getCountry()->getName())) ?></p>
            <p><?php echo sprintf(__('Couldn\'t find the place you were looking for? %s and we\'ll add it.'), link_to(__('Send it to us'), 'company/addCompany')); ?></p>
        </div>

        <?php if ($numberOfResults) : ?>
            <div id="results" style="margin:20px 0 0 0">
                <div class="listing_number">
                    <a href="<?php echo url_for('search/index?s=' . $searchString . '&w=' . $searchWhere) ?>" class="current"><?php echo __('Places') ?> (<span id="places_count"><?php echo $numberOfResults ?></span>)</a>
                </div>
                <div class="listing_wrapper">
                    <div class="listing_place_wrap">
                        <div class="listing_place">
                            loading...<?php echo image_tag('gui/loading.gif', array('class'=>'loading_icon')) ?>
                        </div>
                    </div>

                    <div class="ajaxPager" style="display: none">
                        <div class="pagerLeft">
                     
                        </div>

                        <div class="pagerCenter">
                        </div>

                        <div class="pagerRight">
                      
                        </div>
                    </div>

                </div>
            </div>
        <?php endif ?>
    </div>
</div>

<div class="sidebar">
    <?php // include_partial('home/sideBar') ?>
    <div style="margin-top: 42px">
           <?php include_component('box', 'boxOffers') ?>
    </div>
    <?php include_partial('global/ads', array('type' => 'box')); ?>
    <?php if ($sf_user->getCountry()->getSlug()!= 'fi'):?>  
        <?php include_component('home','social_sidebar'); ?>
    <?php endif;?>
    <?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>
        <?php  include_partial('global/ads', array('type' => 'box2')); ?>   
    <?php endif;?>
     <div class="sidebarBtn-cont">
         <?php echo link_to('<span>+</span>'.__('Add a place', null, 'company'), 'company/addCompany', array('title' => __('Add Place'), 'class'=>'sidebarBtn button_green')); ?>  
     </div>  
</div>

<div class="clear"></div>

<?php if ($numberOfResults) : ?>
    <script type="text/javascript">
        $(document).ready(function() {
            map.useAjaxPagination = true;
            map.itemsPerPage = 20;

            map.keywords  = "<?php echo addcslashes($searchString, '\"') ?>";
            map.address   = '<?php echo $searchWhere ?>';

	    	map.acWhere  = "<?php echo $searchACWhere; ?>";
            map.acWhereIDs   = '<?php $searchACWhereIDs; ?>';

            map.geocodeAndLoad(map.address);

            $("#google_map").css('height', '400px');
            $(".nav_arrow").toggle();

            google.maps.event.trigger(map.map, 'resize');


           
           $('.pagerRight').append('<a href="javascript:;" id="next"><span><?php echo __('Next', null, 'pagination') ?></span></a>');
           $('.pagerLeft').append('<a href="javascript:;" id="prev"><span><?php echo __('Previous', null, 'pagination') ?></span></a>');
        });
    </script>
<?php endif ?>
