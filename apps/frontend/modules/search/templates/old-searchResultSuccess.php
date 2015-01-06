<?php 
	$searchWhere = $sf_request->getParameter('w');
	$searchString = $sf_request->getParameter('s');
	$searchACWhere = $sf_request->getParameter('ac_where');
	$searchACWhereIDs = $sf_request->getParameter('ac_where_ids');	
?>
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
                            <?php 
                            $i = 0;
                            $overlays = array();
                            foreach ($result as $company){
                            	include_partial('search/searchResultItem', array('company' => $company));
                            	$companies[] = array(
									'id' => $company->getId(),
									'title' => $company->getCompanyTitle(),
									'lat' => $company->getLat(),
									'lng' => $company->getLng(),
									'icon' => $company->getIcon());
								$overlays[$company->getid()] = $company->getOverlay();                            	
                            }
                            ?>
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
<div id="overlays____" style="display:none">
	<?php 
	foreach($overlays as $id=>$o):
		echo "<div id='$id'>".html_entity_decode($o)."</div>";
	endforeach;
	?>
</div>

<?php if ($numberOfResults){ ?>
    <script type="text/javascript">    
        $(document).ready(function() {
            jsonString = '<?php echo json_encode($companies);?>';
            map.useAjaxPagination = true;
            map.itemsPerPage = 20;

            map.keywords  = "<?php echo addcslashes($searchString, '\"') ?>";
            map.address   = '<?php echo $searchWhere ?>';

	    	map.acWhere  = "<?php echo $searchACWhere; ?>";
            map.acWhereIDs   = '<?php echo $searchACWhereIDs; ?>';
                        
            map.loadMarkers(jsonString);

            map.totalObjects = <?php echo $numberOfResults; ?>;
            map.initAjaxPager();

            map.geocodeAndPositionMap(map.address);
            
            $("#google_map").css('height', '400px');
            $(".nav_arrow").toggle();

            google.maps.event.trigger(map.map, 'resize');


           
           $('.pagerRight').append('<a href="javascript:;" id="next"><span><?php echo __('Next', null, 'pagination') ?></span></a>');
           $('.pagerLeft').append('<a href="javascript:;" id="prev"><span><?php echo __('Previous', null, 'pagination') ?></span></a>');
        });
    </script>
<?php } ?>