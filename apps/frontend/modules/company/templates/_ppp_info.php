<address>
    <meta itemprop="addressCountry" content="<?php echo mb_convert_case($company->getCountry()->getSlug(), MB_CASE_UPPER) ?>" />
    <meta itemprop="addressLocality" content="<?php echo $company->City->getLocation(); ?>" />
    <meta itemprop="addressRegion" content="<?php echo $company->City->County->getRegion(); ?>" />
    <?php if ($company->getLocation()->getPostcode()): ?>
        <meta itemprop="postalCode" content="<?php echo $company->getLocation()->getPostcode(); ?>" />
    <?php endif; ?>
    <?php $address = explode(', ', $company->getDisplayAddress(), 2); ?>
    <meta itemprop="streetAddress" content="<?php echo $address[1]; ?>" />
</address>


<div class="widget place-info">
    <div class="place-info-head">
        <h3><?php echo __('Information', null, 'company'); ?></h3>        
    </div><!-- place-info-head -->

    <div class="place-info-body">
   		<?php
   			$phones = array();
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
        <a href="#" data-toggle="modal" data-target="#modalMap"><img src="https://maps.googleapis.com/maps/api/staticmap?<?php echo $params; ?>"></a>

        <ul>
            <li class="get-address-p address-pin">
                <i class="fa fa-map-marker"></i>
                    <?php echo $company->getDisplayAddress(); ?>
                    <?php if ($company->getAddressInfo()) { ?>
                        <?php echo $company->getAddressInfo(); ?>
                    <?php } ?>
            </li>
            <?php if ($company->getPhone()) { 
            	$phones[] = $company->getPhone();
            	?>
                <li class="get-phone-p"><i class="fa fa-phone"></i><strong><?php echo $company->getPhoneFormated() ?></strong></li>
            <?php } ?>
            <?php if ($company->getPhone1() && !in_array($company->getPhone1(), $phones)) { 
            	$phones[] = $company->getPhone1();
            	?>
                <li class="get-phone-p"><i class="fa fa-phone"></i><strong><?php echo $company->getPhoneFormated($company->getPhone1()) ?></strong></li>
            <?php } ?>
            <?php if ($company->getPhone2() && !in_array($company->getPhone2(), $phones)) { ?>
                <li class="get-phone-p"><i class="fa fa-phone"></i><strong><?php echo $company->getPhoneFormated($company->getPhone2()) ?></strong></li>
            <?php } ?>
            <?php if ($company->getEmail()) { ?>
                <li><?php echo getSendEmailLink($company); ?></li>
            <?php } ?>
<!-- <li><a href="#"><i class="fa fa-envelope"></i>Send E-mail</a></li> -->
            <?php if ($company->getWebsiteUrl()) { ?>
                <li class="website-pin"><?php echo getCompanyWebSite($company) ?></li>
            <?php } ?>
            
            <div class="email_form_wrap">
				<div id="contact_form" class="default-form-wrapper global-padding-form"></div>
			</div>
			<div class="report_success send-email-success-opened send-email-success-closed"></div>
            <?php
            $menu = $company->getFirstMenu();
            if ($menu) {
                ?>
                <li><a href="#"><i class="fa fa-columns"></i><?php echo sfOutputEscaperGetterDecorator::unescape($menu->getDownloadLink(__($menu->getName()), 'target = "_blank"')); ?></a></li>
            <?php } ?>

			<?php if ($company->getCompanyDetail() && $company->getCompanyDetail()->getHourFormatCPage('wed')) { ?>
                <li>
                    <a href="javascript:void(0)" id="work-time-link" class="work-time-btn">
                        <i class="fa fa-clock-o"></i>
    						<?php echo __('Working Hours', null, 'company') ?>
                        <i class="fa fa-caret-up"></i>
                    </a>
                </li>
			<?php } ?>
        </ul>
        	<?php if($company->getCompanyDetail() && $company->getCompanyDetail()->getHourFormatCPage('wed')){?>
		            <div class="profile-content-foot hidden-sm">
		                <table>
		                    <thead></thead>
		                    <tbody>
		
		                        <tr class="week-days">
		                            <?php foreach (array('mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun') as $day) { ?>
		                                <th class="<?php echo ($company->getCompanyDetail()->getHourFormatCPage($day) == 'closed' ? 'gray' : '') ?>"><?php echo __(ucfirst($day)); ?></th>
		                            <?php } ?>
		                        </tr>
		
		                        <tr>
		                            <?php
		                            foreach (array('mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun') as $day) {
		                                if ($company->getCompanyDetail()->getHourFormatCPage($day)) {
		                                    echo ($company->getCompanyDetail()->getHourFormatCPage($day) == 'closed' ? '<td class="gray">-</td>' : '<td>' . $company->getCompanyDetail()->getHourFormatCPage($day)) . '</td>';
		                                }
		                            }
		                            ?>
		                        </tr>
		
		                    </tbody>
		                    <tfoot></tfoot>
		                </table>
		            </div><!-- profile-content-foot -->
            <?php }?>

            <ul id="working-days-sidebar" class="working-days-sidebar-ppp hidden-md hidden-lg">
                <li class="working-day-title">Понеделник</li>
                <li class="working-day-time">9:30-23:30</li>
                <li class="working-day-title">Вторник</li>
                <li class="working-day-time">9:30-23:30</li>
                <li class="working-day-title">Сряда</li>
                <li class="working-day-time">9:30-23:30</li>
                <li class="working-day-title">Четвъртък</li>
                <li class="working-day-time">9:30-23:30</li>
                <li class="working-day-title">Петък</li>
                <li class="working-day-time">9:30-23:30</li>
                <li class="working-day-title">Събота</li>
                <li class="working-day-time">9:30-23:30</li>
                <li class="working-day-title">Неделя</li>
                <li class="working-day-time">9:30-23:30</li>
            </ul>
    </div><!-- place-info-body -->
    

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
        </div><!-- socials -->
    </div><!-- place-info-foot -->
</div><!-- .widget-place-info -->

<div class="modal fade standart" id="modalMap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><a class="close-btn" href="#"></a></span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo __('Location details', null, 'company'); ?></h4>
            </div>
            <div class="modal-body">
            <div style="width:990px;height:566px;" class="map" id="google_map"></div>
                <div class="widget-map widget-map-global">
                    <div class="place-info-head">
                        <h3><?php echo __('Information', null, 'company'); ?></h3>                                
                    </div><!-- place-info-head -->

                    <div class="place-info-body">

                        <ul>
                            <li class="get-address-p address-pin">
                                <i class="fa fa-map-marker"></i>
                                    <?php echo $company->getDisplayAddress(); ?>
                                    <?php if ($company->getAddressInfo()) { ?>
                                        <?php echo $company->getAddressInfo(); ?>
                                    <?php } ?>
                               
                            </li>
                            <?php if ($company->getPhone()) { ?>
                                <li class="get-phone-p"><i class="fa fa-phone"></i><strong><?php echo $company->getPhoneFormated() ?></strong></li>
                            <?php } ?>
                            <?php if ($company->getEmail()) { ?>
                                <li class="e-mail-pin"><i class="fa fa-envelope"></i><?php echo $company->getEmail(); ?></li>
                            <?php } ?>
                <!-- <li><a href="#"><i class="fa fa-envelope"></i>Send E-mail</a></li> -->
                            <?php if ($company->getWebsiteUrl()) { ?>
                                <li class="website-pin-modal"><?php echo getCompanyWebSite($company) ?></li>
                            <?php } ?>
                        </ul>
                    </div><!-- place-info-body -->

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
                        </div><!-- socials -->
                    </div><!-- place-info-foot -->
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
			//map.map.setCenter(new google.maps.LatLng(<?= $lat?>,<?= $lng?>))
			map.map.fitToMarkers();
			first_flag = 0;
		}
	})
</script>
<script type="text/javascript" src="/js/send_mail.js"></script>