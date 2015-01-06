<div class="widget place-info" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
	<address style="display:none">
		<meta itemprop="addressCountry" content="<?php echo mb_convert_case($company->getCountry()->getSlug(), MB_CASE_UPPER) ?>" />
		<meta itemprop="addressLocality" content="<?php echo $company->getCity()->getLocation(); ?>" />
		<meta itemprop="addressRegion" content="<?php echo $company->getCity()->getCounty()->getRegion(); ?>" />
		<?php if ($company->getLocation()->getPostcode()): ?>
			<meta itemprop="postalCode" content="<?php echo $company->getLocation()->getPostcode(); ?>" />
		<?php endif;
		$address = explode(', ', $company->getDisplayAddress(), 2);
		if(isset($address[1])):?>
			<meta itemprop="streetAddress" content="<?php echo $address[1]; ?>" />
		<?php endif;?>
	</address>
	<div class="place-info-head">
		<h3><?php echo __('Information', null, 'company'); ?></h3>		
	</div>
	<!-- place-info-head -->

	<div class="place-info-body">
		<?php
		    $location = $company->getLocation();
		    $isPPP = $company->getActivePPPService(true) ? 1 : 0;
		    $latLng = $location->getLatitude() . ',' . $location->getLongitude();
		    $marker = image_path('gui/icons/'.($isPPP ? 'marker_'. $company->getSectorId() : 'gray_marker_'. $company->getSectorId()), true);
		    $params = array(
		        // 'center' => $latLng, // google know how to center if you give him markers
		        'zoom' => '15',
		        'size' => '358x100',
		        'maptype' => 'roadmap',
		        'markers' => "icon:{$marker}%7Cshadow:false%7C{$latLng}",
		        'sensor' => 'false',
		        //'key' => 'AIzaSyDDZGSZsZTNuGUImUPcFXOEWObG6GX0I08'
		    );
		    $ps = array();
		    foreach ($params as $k => $v) {
		        $ps[] = "{$k}={$v}";
		    }
		    $params = implode('&', $ps);
		?>
		<a href="#" data-toggle="modal" data-target="#modalMap"><img src="https://maps.googleapis.com/maps/api/staticmap?<?php echo $params; ?>">
		</a>


		<ul>
			<li class="get-address-p m-2px">
				<i class="fa fa-map-marker"></i>
					<?php echo $company->getDisplayAddress(); ?>
					<?php if ($company->getAddressInfo()){ ?>
		        		<?php echo $company->getAddressInfo(); ?>
		        	<?php } ?>
				
			</li>
			<?php if ($company->getPhone()): ?>
            	<li class="get-phone-p"><i class="fa fa-phone"></i><strong><?php echo $company->getPhoneFormated()?></strong></li>
            <?php endif; ?>
			<?php if ($company->getEmail()): ?>
				<li><?php echo getSendEmailLink($company); ?></li>
			<?php endif;?>
			<?php if ($company->getWebsiteUrl()): ?>
				<li class="m-2px"><?php echo getCompanyWebSite($company)?></li>
			<?php endif;?>
		</ul>
	</div>
	<!-- place-info-body -->
	<div class="email_form_wrap">
		<div id="contact_form" class=" default-form-wrapper global-padding-form"></div>
	</div>
	<div class="report_success send-email-success-opened send-email-success-closed"></div>

	<div class="place-info-foot">
		<div class="socials">
			<ul>
				<?php if ($company->getFacebookUrl()): ?>
				<li><?php echo getCompanyFacebook($company); ?></li>
				<?php endif; ?>
				<?php if ($company->getTwitterUrl()): ?>
				<li><?php echo getCompanyTwitter($company); ?></li>
				<?php endif; ?>
				<?php if ($company->getFoursquareUrl()): ?>
				<li><?php echo getCompanyFoursquare($company); ?></li>
				<?php endif; ?>
				<?php if ($company->getGoogleplusUrl()): ?>
				<li><?php echo getCompanyGooglePlus($company); ?></li>
				<?php endif; ?>
				<?php if ($company->getCountryId() == 4 && $company->getCompanyDetailSr()->getSrUrl()): ?>
	            <li><?php echo getCompanyYellowPagesRS($company); ?></li>
	            <?php endif; ?>
			</ul>
		</div>
		<!-- socials -->
	</div>
	<!-- place-info-foot -->
</div>
<!-- .widget-place-info -->

<div class="modal fade standart" id="modalMap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true"><a class="close-btn" href="#"></a></span>
				</button>
				<h4 class="modal-title" id="myModalLabel"><?php echo __('Location details', null, 'company'); ?></h4>
			</div>
			<div class="modal-body">
				<div style="width:990px;height:566px;" class="map" id="google_map"></div>
				<div class="widget-map widget-map-global">
					<div class="place-info-head">
						<h3><?php echo __('Information', null, 'company'); ?></h3>
					</div>
					<!-- place-info-head -->

					<div class="place-info-body">

						<ul>
							<li class="get-address-p m-2px">
								<i class="fa fa-map-marker"></i>
									<?php echo $company->getDisplayAddress(); ?>
									<?php if ($company->getAddressInfo()){ ?>
						        		<?php echo $company->getAddressInfo(); ?>
						        	<?php } ?>
							</li>									
							<?php if ($company->getPhone()): ?>
				            	<li class="get-phone-p"><i class="fa fa-phone"></i><strong><?php echo $company->getPhoneFormated()?></strong></li>
				            <?php endif; ?>
							<?php if ($company->getEmail()){ ?>
								<li class="e-mail-pin"><i class="fa fa-envelope"></i><?php echo $company->getEmail(); ?></li>
							<?php } ?>
							<?php if ($company->getWebsiteUrl()): ?>
								<li class="m-2px"><?php echo getCompanyWebSite($company)?></li>
							<?php endif;?>
						</ul>
					</div>
					<!-- place-info-body -->

					<div class="place-info-foot">
						<div class="socials">
							<ul>
								<?php if ($company->getFacebookUrl()): ?>
								<li><?php echo getCompanyFacebook($company); ?></li>
								<?php endif; ?>
								<?php if ($company->getTwitterUrl()): ?>
								<li><?php echo getCompanyTwitter($company); ?></li>
								<?php endif; ?>
								<?php if ($company->getFoursquareUrl()): ?>
								<li><?php echo getCompanyFoursquare($company); ?></li>
								<?php endif; ?>
								<?php if ($company->getGoogleplusUrl()): ?>
								<li><?php echo getCompanyGooglePlus($company); ?></li>
								<?php endif; ?>
								<?php if ($company->getCountryId() == 4 && $company->getCompanyDetailSr()->getSrUrl()): ?>
					            <li><?php echo getCompanyYellowPagesRS($company); ?></li>
					            <?php endif; ?>
							</ul>
						</div>
						<!-- socials -->
					</div>
					<!-- place-info-foot -->
				</div>
			</div>
		</div>
	</div>
</div>
<div id="overlay_<?php echo $company->getId('id')?>" class="hidden">
	<div style="background-color:#fff;width:100px;">
	<?php include_partial('search/item_overlay',array('company'=>$company)); ?>
	</div>
</div>

<?php 
	$lat = $company->Location->getLatitude();
	$lng = $company->Location->getLongitude();
?>

<script type="text/javascript">
	var first_flag = 1;
	$('#modalMap').on('shown.bs.modal', function (e) {
		if(first_flag){
			map.init();
			map.loadMarkers('<?php echo json_encode(array(array(
				'lat' => $lat,
	 			'lng' => $lng,
				'id' => $company->getId(),
				'title' => $company->getCompanyTitle(),
				'icon' => $company->getSmallIcon()
			)))?>');
			map.map.setCenter(new google.maps.LatLng(<?= $lat?>,<?= $lng?>));
			map.map.setZoom(15);
			first_flag = 0;
		}
	})
</script>
<script type="text/javascript" src="/js/send_mail.js"></script>
