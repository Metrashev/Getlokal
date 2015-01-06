<?php 
	$searchWhere = $sf_request->getParameter('w');
	$searchString = $sf_request->getParameter('s');
	$searchACWhere = $sf_request->getParameter('ac_where');
	$searchACWhereIDs = $sf_request->getParameter('ac_where_ids');

	$sliderData['numberOfResults'] = $numberOfResults;
	$sliderData['searchString'] = $searchString;
	$sliderData['searchWhere'] = $searchWhere;
	$sliderData['cityName'] = $sf_user->getCity()->getDisplayCity();
		
	include_partial('sliderIndex', array('sliderData' => $sliderData));	  
?>
<div class="categories_wrapper categories-search boxesToBePulledDown">
	<div class="container">
		<div class="row">
			<div class="hidden-xs hidden-sm col-md-3">
				<?php include_component('box','boxCategories', array('show_full_list' => true))?>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-9">
				<div class="top-places">
					<div class="categories-title">
						<?php
							if(getlokalPartner::getInstanceDomain() == 78){
								echo __('Top Places in %county%', array('%county%' => '<span>'.$sf_user->getCounty().'</span>'));
							}else{
								echo __('Top Places in %city%', array('%city%' => '<span>'.$sf_user->getCity()->getLocation().'</span>'));
							} 
						?>
					</div>

					<div class="places-left-side width-fix">
						<ul class="places-list">
							<?php 
	                            include_partial( 'search/companyList', array('companies'=> $result, 'isHomePage' => 0, 'dataType' => 3) );
	                        ?>
						</ul>
						<div class="wrapper-pager">
							<div class="ajaxPager paging paging-number" >
								<div class="pagerLeft"></div>
							    <div class="pagerCenter"></div>
							    <div class="pagerRight"></div>
							</div>
						</div>
						
					</div>
					<div class="inner-sidebar-container">
						<?php include_partial('global/map')?>
					</div>
				</div><!-- top-places -->
			</div>
		</div>
	</div>
</div><!-- categories_wrapper -->
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