<?php 
	use_helper('Date', 'XssSafe');
	include_partial('showSlider');

	slot('facebook');
	$culture = $sf_user->getCulture(); 
	?>
	<meta property="fb:app_id" content="<?php echo sfConfig::get('app_facebook_app_' . $sf_user->getCountry()->getSlug() . '_id'); ?>"/>
	<meta property="og:title" content="<?php echo $event->getDisplayTitle(); ?>" />
	<meta property="og:type" content="event" />
	
	<?php
	date_default_timezone_set('Europe/Bucharest');
	$start_date_time = date(DATE_ISO8601, strtotime($event->getStartAt()));
	?>
	
	<meta property="event:start_time" content="<?php echo $start_date_time ?>" /> 
	<meta property="og:url" content="<?php echo url_for('event/show?id=' . $event->getId(), true) ?>" />
	<?php if ($event->getDisplayDescription()): ?>
	    <meta property="og:description" content="<?php echo truncate_text(strip_tags($event->getDisplayDescription(ESC_RAW)), 500, ' ') ?>" />
	<?php endif; ?>
	<meta property="og:location:latitude" content="<?php echo $event->getCity()->getLat(); ?>" />
	<meta property="og:location:longitude" content="<?php echo $event->getCity()->getLng(); ?>" />
	<meta property="og:image" content="<?php
						                    if ($event->getImage()->getType() == 'poster'){
						                        echo image_path($event->getThumb('preview'), true);
						                    }else{
						                        echo image_path($event->getThumb(2), true);
						                    }
						               ?>" />
	
	<?php end_slot() ?>
	
	<?php if ($photoTab): ?>
    <script type="text/javascript">
        $("document").ready(function() {

            $('.standard_tabs_top a').removeClass('current');
            $('.standard_tabs_top #photos_tab').addClass('current');
        });
    </script>
<?php endif; ?>

<div class="wrapper-event-details-slider smaller-z-index">
	<div class="container">
		<div class="row">

		<div class="event-details-path">
			<div class="col-sm-7 col-md-7 col-lg-8">
			<?php foreach (breadCrumb::getInstance()->getItems() as $i => $item){
        			if ($item->getUri()){
            			echo link_to($item->getText(), $item->getUri(), array('class' => 'path-event'));
        			}
		        	if ($i + 1 < sizeof(breadCrumb::getInstance()->getItems())){
		        		echo '<span>/</span>'; 
					}
        		  }?>
            	<h1><?php echo $event->getDisplayTitle() ?></h1>
			</div> <!-- col-sm-8 -->
                <div class="col-sm-5 col-md-5 col-lg-4 event-details-article-uploader">
                    <div class="profile-information">
                     	<div class="profile-image">
                     		<?php echo link_to(image_tag($event->getUserProfile()->getThumb(), array('size' => '60x60')), $event->getUserProfile()->getUri(), array('target' => '_blank'));?>
                        </div><!-- profile-image -->
                        <div class="profile-content">
                            <p><?php echo __('This event is created by', null, 'events') . " "; ?></p>
                            <h3 class="events-details-user-name"><?php echo $event->getUserProfile()->getLink(ESC_RAW); ?></h3>
                            <h4 class="events-details-user-name-more"><a class="more-events-by" href="<?php echo url_for('profile/events?username='. $event->getUserProfile()->getSfGuardUser()->getUsername()) ?>"><?php echo __('More events from', null, 'events') . " " . $event->getUserProfile() ?></a></h4>
                        </div>
                    </div>
                </div> <!-- event-details-article-uploader -->
            </div> <!-- event-details-path and col-sm-12 -->
			
		<div class="col-sm-8 boxesToBePulledDown">
			<div class="col-sm-12 wrapper-event-details-content">
				<div class="section-event-details-head">
					<div class="event-details-image">
						<?php
						if ($event->getImageId()){
		                    if ($event->getImage()->getType() == 'poster'){
		                        echo image_tag($event->getThumb('preview'), array('size' => '195x260', 'alt' => $event->getImage()->getCaption()));
		                    }else{
		                        echo image_tag($event->getThumb(2), array('size' => '260x195', 'alt' => $event->getImage()->getCaption()));
		                    }
	                    }else{
							$sector_id = $event->getCategory()->getId();
							$image_path = "/images/gui/default_event_".$sector_id.".jpg";
							echo image_tag($image_path, array('size' => '260x195'));
						}
	                    
	                    ?>
					</div>
						<div class="wrapper-event-details-head">
							<div class="share-event-details">
								<div class="wrapper-share-page-event-details">
									<h4><?php echo __('SHARE', null, 'company'); ?></h4>
									<div class="socials-container-event-details">		
										 <?php  include_partial('global/social', array( 'hasSocialScripts' => true,'hasSocialHTML' => true )); ?>
	 								</div> <!-- socials-container-offers-details -->
 								</div>
							</div> <!-- wrapper-event-details-head -->				
						</div>
					<div class="event-details-desc s-h-functionality"> 
						<div class="event-details-desc-inner child-text-container">
							
							<?php echo nl2br(html_entity_decode($event->getDisplayDescription())); ?>

							<div class="show-more-less-container abs-set">
				                <div class="row">
									<div class="col-sm-12">
										<div class="custom-row toggle-row show-more">
											<div class="center-block txt-more">
												<i class="fa fa-angle-double-down fa-lg"></i>
												<span><?php echo __('SHOW MORE', null, 'company'); ?></span>
												<i class="fa fa-angle-double-down fa-lg"></i>
											</div>

											<div class="center-block txt-less">
												<i class="fa fa-angle-double-up fa-lg"></i>
												<span><?php echo __('SHOW LESS', null, 'company'); ?></span>
												<i class="fa fa-angle-double-up fa-lg"></i>
											</div>
										</div><!-- Form Show-more-less Bar -->
									</div>
								</div>
							</div>

						</div>

					</div> <!-- share-event-details -->
				</div> <!-- section-event-details-head -->
				<div class="section-buttons-event-details">
					<ul>
						<?php if($user && $user->getId()==$event->getUserId()){ ?>
						<li><a  href="<?php echo url_for('event/edit?id='.$event->getId())?>" class="default-btn edit"><span></span><?php echo __('Edit Event',null,'events');?></a></li>
						<?php }?>
		                <?php if ($attendUser){?>
		                <li><a id="attending" class="default-btn partSuccess" title="" href="javascript:void(0)" ><span></span><?php echo __('Will Аttend',null,'events');?></a></li>
		                <li><a id="unAttentUser" class="default-btn not-attending-btn" href="javascript:void(0)"><span></span><?php echo __("Won't Attend",null,'events')?></a></li>
		                <li class="hidden"><a id="attentUser" class="default-btn action will-attend-btn" href="javascript:void(0)"><span></span><?php echo __('Will Аttend', null, 'events');?></a></li>
		                <?php }elseif ($user){?>
		                <li><a id="attentUser" class="default-btn action will-attend-btn" href="javascript:void(0)"><span></span><?php echo __('Will Аttend', null, 'events');?></a></li>
		                <li class="hidden"><a id="attending" class="default-btn partSuccess" title="" href="javascript:void(0)" ><span></span><?php echo __('Will Аttend',null,'events');?></a></li>
		                <li class="hidden"><a id="unAttentUser"class="default-btn not-attending-btn" href="javascript:void(0)"><span></span><?php echo __("Won't Attend",null,'events')?></a></li>
		                <?php }else{?>
		                <li><a id="login_attend_btn" class="default-btn action will-attend-btn" href="javascript:void(0)" ><span></span><?php echo __('Will Аttend', null,'events');?></a></li>
		    	        <?php }?>
		             </ul>
					<div id="login_form_content_events" class="login_form_wrap_attend" style="display:none">
	                    <a href="javascript:void(0)" id="header_close"></a>
	                    <?php include_component('user', 'signinRegister',array('trigger_id' => 'login_attend_btn'/*, 'goto_id' => 'login_content_events'*/));?>
	                </div>
                    <div class="clear"></div>
				</div> <!-- section-buttons-event-details -->			
			</div><!-- wrapper-event-details-content -->
			
			<?php 
				if ($countEvents > 0 && 0){
                	include_partial('event/similarEvents', array('events' => $events, 'id' => $event->getId()));
                }else{
					if (isset($companies) && $companies) {
                		include_partial('event/placesNearby', array('companies' => $companies, 'similarTitle' => $similarTitle));
                	}
				} 
            ?>
			<div class="col-sm-12 wrapper-tabs-event-details">
					<div id="comment_photo_tab" class="pp-tabs">
						<div class="pp-tabs-head">
							<ul class="default-form-tabs">
								<li class=<?php echo $photoTab ? '""' : '"current"'; ?>><a href="<?=url_for('event/comments?event_id=' . $event->getId()); ?>"><span><?= $event->getActivityEvent()->getCommentCount(); ?></span><?= __('Comments'); ?></a></li>
								<li class=<?php echo $photoTab ? '"current"' : '""'; ?>><a href="<?= url_for('event/photos?event_id=' . $event->getId()); ?>"><span><?= count($images); ?></span><?= __('Photos', null, 'company'); ?></a></li>
							</ul>
						</div><!-- pp-tabs-head -->		

						<div class="pp-tabs-body">
							<div class="pp-tab" style="display: block;">
								<div class="review-lists" id="comment">
									<?php 
									//if (!$photoTab) { ?>
									<?php /*
										<div class="social-plugin-facebook-event-details">
											<div id="fb-root"></div>
											<script>(function(d, s, id) {
											  var js, fjs = d.getElementsByTagName(s)[0];
											  if (d.getElementById(id)) return;
											  js = d.createElement(s); js.id = id;
											  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
											  fjs.parentNode.insertBefore(js, fjs);
											}(document, 'script', 'facebook-jssdk'));</script>
											<div class="fb-comments" data-href="http://developers.facebook.com/docs/plugins/comments/" data-numposts="1" data-colorscheme="light"></div>
										</div>
										
										<!-- user-review -->
										<!-- user-comments -->*/
										?>
										<?php
										include_partial('global/facebook_comments'); 
										include_component('comment', 'comments', array('activity' => $event->getActivityEvent(), 'user' => $user, 'url' => url_for('event/comments?event_id=' . $event->getId())));
									//} ?>
								</div><!-- review-tab-lists -->
							</div><!-- pp-tab -->

							<div class="pp-tab" style="display: none;">
								<!-- tab-utilities -->	
								<?php include_partial('event/photoTab', array('images' => $photos, 'event' => $event, 'contributors' => $contributors, 'form' => $formImg, 'user' => $user)) ?>
																
							</div><!-- pp-tab -->

							<!-- pp-tab -->	
							
						</div><!-- pp-tabs-body -->
					</div>
			</div><!-- wrapper-tabs-event-details -->
		</div><!-- col-sm-8 -->
		

<!-- ======================================================== SIDEBAR =================================================-->	
<?php
	$place = '';
	$place2 = '';
	$pages = $event->getAllEventPage();
	if (count($event->getAllEventPage())){
		foreach ($pages as $kay => $page){
			$place .= '<strong>'.link_to($page->getCompanyPage()->getCompany()->getCompanyTitle(), $page->getCompanyPage()->getCompany()->getUri(ESC_RAW), 'class=event_place_info_sidebar target="_blank" title=' . $page->getCompanyPage()->getCompany()->getCompanyTitle()).",".'</strong>';
			$place2 .= link_to($page->getCompanyPage()->getCompany()->getCompanyTitle(), $page->getCompanyPage()->getCompany()->getUri(ESC_RAW), 'class=event_place target="_blank" title=' . $page->getCompanyPage()->getCompany()->getCompanyTitle());
		}
	}
	$place .= '<span class="sidebar-event-place-info">'.$event->getCity()->getLocation().'</span>'; 
	$place2 .= '<span class="separator-place-events-details">'.$event->getCity()->getLocation().'</span>';
	$startDate = $event->getStartAt() ? date('d/m.Y', strtotime($event->getStartAt())) : '';
	$endDate = $event->getEndAt() ? date('d/m.Y', strtotime($event->getEndAt())) : '';
	$startHour = $event->getStartH() ? ' ' . date('G:i', strtotime($event->getStartH())) : '';
?>
			<div class="col-sm-4 boxesToBePulledDown p-10">
				<div class="widget offer-info">
						<div class="place-info-head">
							<h3><?php echo __('Information', null, 'company'); ?></h3>
						</div><!-- place-info-head -->

						<div class="place-info-body">
						<?php
							if (count($pages)) {
								$i = true;
								foreach ($pages as $kay => $page){
									if ($i) {
										$company_main = $page->getCompanyPage()->getCompany();
										$i = false;
									}
									$company = $page->getCompanyPage()->getCompany();
									$location = $company->getLocation();
									$latLng = $location->getLatitude() . ',' . $location->getLongitude();
									$marker = image_path('gui/icons/marker_'. $company->getSectorId(), true);
									
									$markers[] = "icon:{$marker}%7Cshadow:false%7C{$latLng}";
								}
								
								$all_markers = implode('&', $markers);
							
						    
						    $params = array(
						        // 'center' => $latLng, // google know how to center if you give him markers
						        'zoom' => '15',
						        'size' => '358x100',
						        'maptype' => 'roadmap',
						        'markers' => $all_markers,
						        'sensor' => 'false',
						        //'key' => 'AIzaSyDDZGSZsZTNuGUImUPcFXOEWObG6GX0I08'
						    );
						    $ps = array();
						    foreach ($params as $k => $v) {
						        $ps[] = "{$k}={$v}";
						    }
						    $params = implode('&', $ps);
						?>
							<a href="#" data-toggle="modal" data-target="#modalMap"><img src="http://maps.googleapis.com/maps/api/staticmap?<?php echo $params; ?>" alt=""></a>               
                    <?php } ?>
							<ul class="event-info-items">
								<?php if (isset($place) && $place) { ?>
								<li class="get-address-p"><i class="fa fa-map-marker pin-place"></i><?=$place?></li>
								<?php } ?>
								<li class="get-address-p"><i class="fa fa-calendar"></i><strong class="pin-calendar"><?=$startDate.($endDate != '' ? " - $endDate" : '')?></strong></li>
						<?php if($startHour != ''){?>
								<li class="get-address-p"><i class="fa fa-clock-o"></i><div class="hour-offer-info-event"><?=$startHour?></div></li>
						<?php }
							  if ($event->getInfoUrl()){?>
								<li><a class="more-info-events-detail-info" href="<?=$event->getInfoUrl() ?>" target="_blank"><i class="fa fa-globe"></i><?=__('More Info', null, 'company') ?></a></li>
						<?php }
							  if ($event->getPrice() != 0){ ?>
			                  	<li class="get-address-p"><i class="fa fa-ticket"></i> <strong><span class="ticket-event-info-item"><?php echo Event::getRealPrice($event->getPrice()) ?></span></strong>
			                  	<?php if ($event->getBuyUrl()){ ?>
				                    <a class="get-ticket-event-details" href="<?php echo $event->getBuyUrl() ?>" target="_blank"><?php echo __('Buy Now', null, 'events'); ?></a>
				                <?php } ?>			                  	
			                  	</li>
			                  <?php } 
			                  if ($event->getBuyUrl()){ ?>
				                    <p class="event_buy"><a href="<?php echo $event->getBuyUrl() ?>" class="button_pink button_ticket" title="buy tickets from <?php echo $event->getBuyUrl() ?>" target="_blank"><?php echo __('', null, 'events'); ?></a></p>
				                <?php } ?>
								
								<li class="place-follow-num get-address-p"><i class="fa fa-users"></i><?=__('Attending',null,'events')?> <strong><span><?=$countEventUsers?></span></strong></li>
							</ul>
<?php /*
TODO: there are no folowers for eventes to be done after redisign
							<ul class="event-info-items-followers">
								<li><a href="#"><img src="http://lorempixel.com/45/45/" alt=""></a></li>
								<li><a href="#"><img src="http://lorempixel.com/45/45/" alt=""></a></li>
								<li><a href="#"><img src="http://lorempixel.com/45/45/" alt=""></a></li>
								<li><a href="#"><img src="http://lorempixel.com/45/45/" alt=""></a></li>
								<li class="counter-followers-wrapper"><a class="counter-followers" href="#">+ 230</a></li>
							</ul>
	*/
?>						
							<div class="wrapper-create-event-btn">
								<a class="default-btn success create-new-event-btn" href="<?php echo url_for('event/create') ?>"><i class="fa fa-plus"></i><?php echo __('New Event', null, 'events') ?></a>
							</div>

						</div><!-- place-info-body -->
					</div>
				
				<?php /*
					<div class="default-container">
						<h3 class="heading"><?php echo __('Sponsored'); ?></h3> <!-- END heading -->
							<div class="content">
								<a href="#"><img src="css/images/sponsored.png" alt="" width="0" height="0" style="display: none !important; visibility: hidden !important; opacity: 0 !important; background-position: 0px 0px;"></a>
							</div> <!-- END content -->
					</div>
					*/?>

					<?php
						if ($countEvents > 0) {
	                        include_partial('event/similarEvents', array('events' => $events, 'id' => $event->getId()));
						}
					?>
                        
					
				<?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>
				<div class="default-container">
					<h3 class="heading"><?php echo __('Sponsored'); ?></h3>
					<!-- END heading -->
					<div class="content">
						<?php include_partial('global/ads', array('type' => 'box')) ?>
					</div>
					<!-- END content -->
				</div>
				<?php endif;?>
				</div>
<!-- ======================================================== END SIDEBAR =================================================-->	

		</div><!-- end row -->
	</div><!-- end container -->
</div> <!-- wrapper-event-details-slider -->

<div class="modal fade standart" id="modalMap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 	 <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	       <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><a class="close-btn" href="#"></a></span></button>
	        <h4 class="modal-title" id="myModalLabel"><?php echo __('Location details', null, 'company'); ?></h4>
	      </div>
	      <div class="modal-body">
	       <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d93836.52538514952!2d23.32394669999999!3d42.695432150000016!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40aa8682cb317bf5%3A0x400a01269bf5e60!2z0KHQvtGE0LjRjw!5e0!3m2!1sbg!2sbg!4v1412254216232" width="100%" height="530px" frameborder="0" style="border:0"></iframe> -->
				<div style="width:990px;height:566px;" class="map" id="google_map"></div>
				<div class="widget-map">
					<div class="place-info-head">
						<h3><?php echo __('Information', null, 'company'); ?></h3>
						<a href="#" class="edit hidden"><i class="fa fa-pencil"></i>edit</a>
					</div><!-- place-info-head -->

					<div class="place-info-body">
						
						<ul>
							<?php if (isset($place2) && $place2) {  ?>
							<li class="get-address-p"><i class="fa fa-map-marker event-pin"></i><?=$place2?></li>
							<?php }?>
							<?php 
								if (isset($company_main) && $company_main) {
									if ($company_main->getPhone()): ?>
            							<li class="get-phone-p"><i class="fa fa-phone phone-pin"></i><strong><?php echo $company_main->getPhoneFormated()?></strong></li>
            						<?php endif; ?>
									<?php if ($company_main->getEmail()){ ?>
										<li><a href="#"><i class="fa fa-envelope"></i><?php echo $company_main->getEmail(); ?></a></li>
									<?php } ?>
							<?php if ($company_main->getWebsiteUrl()): ?>
								<li class="pin-globe modal-pin-globe"><a><?php echo getCompanyWebSite($company_main)?></a></li>
							<?php endif;?>
							<?php } ?>													
						</ul>
					</div><!-- place-info-body -->
					
					<div class="place-info-foot">
					<!-- 
						<div class="socials">
							<ul>
								<li>
									<a href="#" class="link-facebook">
										<i class="fa fa-facebook fa-2x"></i>
									</a>
								</li>

								<li>
									<a href="#" class="link-twitter">
										<i class="fa fa-twitter fa-2x"></i>
									</a>
								</li>

								<li>
									<a href="#" class="link-foursquare">
										<i class="fa fa-foursquare fa-2x"></i>
									</a>
								</li>

								<li>
									<a href="#" class="link-googleplus">
										<i class="fa fa-google-plus fa-2x"></i>
									</a>
								</li>
							</ul>
						</div><!-- socials -->
					</div><!-- place-info-foot -->
				</div>
      		</div>
 		  </div>
       </div>
	</div>  <!-- modal -->    

<script type="text/javascript">
// if FB share works without this script it could be removed
$(window).bind("load", function() {
    (function(doc, script) {
        var js, 
        fjs = doc.getElementsByTagName(script)[0],
        frag = doc.createDocumentFragment(),
        add = function(url, id) {
            if (doc.getElementById(id)) {return;}
            js = doc.createElement(script);
            js.src = url;
            id && (js.id = id);
            frag.appendChild( js );
        };
        http://static.ak.fbcdn.net/connect.php/js/FB.Share
        
        // Facebook SDK
        add('//static.ak.fbcdn.net/connect.php/js/FB.Share');
      
        fjs.parentNode.insertBefore(frag, fjs);
    }(document, 'script')); 
});
// end of FB if

$(document).ready(function() {
	<?php if ($photoTab) { ?>
		$('.pp-tab').toggle();

		$('html, body').animate({
	        scrollTop: $('#comment_photo_tab').offset().top - $('.header_wrapper').height()
	    }, 1500);
	<?php } ?>
	
//      $('#login_attend_btn').click(function() {
//          $('.login_form_wrap').slideToggle();
//      });
    
    //$('.content_event_desc').css('paddingLeft', $('.content_event_gallery').width() + 20 + 'px');
    var update = false;
    $('#login_attend_btn').click(function() {
        $('#login_form_content_events').toggle('normal');
    });
    $('#login_right').click(function() {
        $('#login_form_right').slideToggle();
    });
});

$(function() {
  $('a[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {

      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });
});


<?php if ($user) { ?>

var ulBox = $('.section-buttons-event-details').children('ul');
$('#attentUser').click( function() {
    $.ajax({
	      url: "<?php echo url_for('event/addEventUser?id='.$event->getId())?>",
	      dataType: "json",
	      success: function(data) {
		      ulBox.children().removeClass('hidden');
		      $('#attentUser').parent().addClass('hidden');
		      $('.place_fallow_num').html('<?= '<i class="fa fa-users"></i>'. __("Attending",null,"events") .' <strong><span>'?>'+data.newCountEventUsers+'</span>');
	      }
    });    
});  
//Change unAttend to attend
$('#unAttentUser').click( function() {
	  $.ajax({
		  url: "<?php echo url_for('event/delEventUser?event_id='.$event->getId().'&user_id='.$user->getId())?>",
		  dataType: "json",
		  success: function(data) {
			  ulBox.children().removeClass('hidden');
			  $('#unAttentUser').parent().addClass('hidden');
			  $('#attending').parent().addClass('hidden');
			  $('.place_fallow_num').html('<?= '<i class="fa fa-users"></i>'. __("Attending",null,"events") .' <strong><span>'?>'+data.newCountEventUsers+'</span>');
		  }
	  });
			
});
<?php } ?>

var first_flag = 1;
<?php if (isset($company_main) && $company_main) { ?>
$('#modalMap').on('shown.bs.modal', function (e) {
	if(first_flag){
		map.init();
		map.loadMarkers('<?php echo json_encode(array(array(
			'lat' => $company_main->Location->getLatitude(),
 			'lng' => $company_main->Location->getLongitude(),
			'id' => $company_main->getId(),
			'title' => $company_main->getCompanyTitle(),
			'icon' => $company_main->getSmallIcon()
		)))?>');
		map.map.setZoom(15);
		first_flag = 0;
	}
})
<?php } ?>
</script>
