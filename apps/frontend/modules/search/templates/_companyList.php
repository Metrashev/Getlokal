<?php 
	if(!isset($isHomePage)){
		$isHomePage = 0;
	}
	$Request = sfContext::getInstance()->getRequest(); 
	$city = $Request->getParameter("city",false);
	$county = $Request->getParameter("county",false);
	
	$search_s = $Request->getParameter("s",false);
	$search_w = $Request->getParameter("w",false);
	$search_ac_where = $Request->getParameter("ac_where",false);
	$search_ac_where_ids = $Request->getParameter("ac_where_ids",false);
	
	$numberOfResults = count($companies);
	$i = 0;
	$overlays = array();
	$json_companies = array(); ?>

	<?php if(!$companies){ ?>
		<p><?php echo __("If you want to search again for another location, please use the 'Where' field to enter the right location. It is also possible to expand your search to cover the whole of %s", array('%s' => $sf_user->getCountry()->getName())) ?></p>
   		<p><?php echo sprintf(__("Couldn't find the place you were looking for? %s and we'll add it."), link_to(__('Send it to us'), 'company/addCompany', array('class'=>'default-link'))); ?></p>
   	<?php } ?>

	<?php 
	foreach($companies as $i => $company){
		if($dataType == 3 && $i == 4 && ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO)){?>
			<div class="col-sm-12">
				<div class="default-container">
					<div class="content">
						<?php include_partial('global/ads', array('type' => 'search')) ?>
					</div>
					<!-- END content -->
				</div>
			</div>
		<?php }
		include_partial( 'search/companyListItem', array('company'=> $company, 'isHomePage' => $isHomePage, 'dataType' => $dataType) );
		$tmp = array();
 		
 		if($dataType == 3){ // From Search
 			$tmp['lat'] = $company->getLat();
 			$tmp['lng'] = $company->getLng();
 		}elseif($dataType == 1){ // From Home Page (Model)
 			$tmp['lat'] = $company->Location->getLatitude();
 			$tmp['lng'] = $company->Location->getLongitude();
 		}
 		
 		$tmp['id'] = $company->getId();
 		$tmp['title'] = $company->getCompanyTitle();
 		$tmp['icon'] = $company->getSmallIcon();
 		
 		$json_companies[] = $tmp;
	}
?>
<?php if ($numberOfResults){ ?>
    <script type="text/javascript">
        
        $(document).ready(function() {
            jsonString = '<?php echo json_encode($json_companies);?>';

            map.acWhere  = "<?php echo $search_ac_where ? $search_ac_where : $city ?>";
            map.acWhereIDs   = '<?php echo $search_ac_where_ids ? $search_ac_where_ids : "" ?>';
            
            map.keywords  = "<?php echo $search_s ? $search_s : "";//addcslashes($searchString, '\"') ?>";
            map.address   = '<?php echo $search_w ? $search_w : $city ?>';
                        
            map.loadMarkers(jsonString);

            //map.geocodeAndPositionMap(map.address);
            
            //google.maps.event.trigger(map.map, 'resize');

           
           //$('.pagerRight').append('<a href="javascript:;" id="next"><span><?php echo __('Next', null, 'pagination') ?></span></a>');
           //$('.pagerLeft').append('<a href="javascript:;" id="prev"><span><?php echo __('Previous', null, 'pagination') ?></span></a>');
        });
    </script>
<?php } ?>