<?php 
	use_helper('Pagination');

	$searchWhere = $sf_request->getParameter('w');
	$searchString = $sf_request->getParameter('s');
	$searchACWhere = $sf_request->getParameter('ac_where');
	$searchACWhereIDs = $sf_request->getParameter('ac_where_ids');

	$numberOfResults = count($topLocations);
 	//$sliderData['numberOfResults'] = $numberOfResults;
	$sector = isset($sector) && is_object($sector) ? $sector : null;
	$classification = isset($classification) && is_object($classification) ? $classification : null;
 	//var_dump($sector->getId(), $classifications->getId()); die;
 	$sliderData['sector'] = $sector;
 	$sliderData['classification'] = $classification;
 	if(isset($isClassification) && $isClassification == true){
 		$sliderData['count'] = $pager->getNbResults();
 	}else{
 		$sliderData['count'] = 0;
 	}
 	$sliderData['cityName'] = $sf_user->getCity()->getDisplayCity();
		
  	include_partial('categorySlider', array('sliderData' => $sliderData));
?>
<div class="categories_wrapper categories-search boxesToBePulledDown">
	<div class="container">
		<div class="row">
			<div class="hidden-xs hidden-sm col-md-3">
				<?php 
					$vars = array(
						'show_full_list' => true,
						'classifications'=>$classifications,
						'selected_sector'=>$sector,
						'selected_classification'=>$classification);
					$component = get_component('box','boxCategories',$vars);
					slot('side_categories');
					echo $component;
					end_slot();
					echo $component;
				?>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-9">
				<div class="top-places">
					<div class="categories-title">
					<?php
							if(getlokalPartner::getInstanceDomain() == 78){
								echo __('Places in %county%', array('%county%' => '<span>'.$sf_user->getCounty().'</span>'));
							}else{
								echo __('Places in %city%', array('%city%' => '<span>'.$sf_user->getCity()->getDisplayCity().'</span>'));
							} 
						?>
					</div>
					<div class="places-left-side">
						<ul class="places-list">
							<?php 
							foreach ($topLocations as $d){
								//echo $d->getTitle();
							}
	                        include_partial( 'search/companyList', array('companies'=> $topLocations, 'isHomePage' => 0, 'dataType' => 1) );
	                        ?>
	                        <?php  
								if(isset($isClassification) && $isClassification == true){
									if ($county){
							        	echo pager_navigation($pager, '@classificationCounty?slug='. $classification->getSlug(). '&sector='. $sector->getSlug(). '&county='. $sf_user->getCounty()->getSlug());
							        }else{
							        	echo pager_navigation($pager, '@classification?slug='. $classification->getSlug(). '&sector='. $sector->getSlug(). '&city='. $sf_user->getCity()->getSlug());
							        }
								} 
							?>	                        			
						</ul>						
					</div>
					<div class="inner-sidebar-container">
						<?php include_partial('global/map')?>
					</div>
					
				</div><!-- top-places -->
			</div>			
		</div>
	</div>
</div><!-- categories_wrapper -->

<div class="additional-advertisement">
			<div class="container">
				<div class="row">
				<?php /*
					<div class="col-sm-4">
						<div class="advertisement">
							<div class="place-sponsored">
								<div class="sponsored-head">
									<h3><?php echo __('Sponsored'); ?></h3>
								</div>
								<div class="sponsored-body">
									<img src="/css/images/sponsored.png" alt="">
								</div><!-- ad-block -->
							</div>
						</div><!-- advertisement -->
					</div><!-- col-sm-4 -->
				*/?>

					<div class="col-xs-12 col-sm-6 col-md-4 wrapper-small-slider">
						<?php include_component('box','boxSingleSliderEvents'); ?>
					</div>
					
					<div class="col-xs-12 col-sm-6 col-md-4">
						<?php include_component('box','boxSingleSliderOffers'); ?>
					</div>
			</div>
		</div>
</div>
<?php if ($numberOfResults){ ?>
    <script type="text/javascript">    
        $(document).ready(function() {
            
            map.totalObjects = <?php echo $numberOfResults; ?>;
            map.initAjaxPager();

            map.geocodeAndPositionMap(map.address);
            
            $("#google_map").css('height', '400px');
            $(".nav_arrow").toggle();

            google.maps.event.trigger(map.map, 'resize');


           
           //$('.pagerRight').append('<a href="javascript:;" id="next"><span><?php echo __('Next', null, 'pagination') ?></span></a>');
           //$('.pagerLeft').append('<a href="javascript:;" id="prev"><span><?php echo __('Previous', null, 'pagination') ?></span></a>');
        });
    </script>
<?php } ?>