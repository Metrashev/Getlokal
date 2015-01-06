<?php slot('no_map', true) ?>
<?php use_stylesheets_for_form($form) ?>
<?php use_stylesheet('ui-lightness/jquery-ui-1.8.17.custom.css'); ?>
<?php //use_javascripts_for_form($form) ?>
<?php //$pages = $list->getListPage()?>
<?php $pages = $list->getAllListPage()?>
<?php
$show=false;
if($user && $user->getId() && ( $user->getId()==$list->getUserId() ||  $list->getIsOpen() ) ):
	$show=true;
endif;
 ?>
<?php $hasSocialScripts = true?>
<?php $hasSocialHTML = false;?>
<div class="content_in_full">
	<div class="listing_content">
	  <?php if(!$is_place_admin_logged):?>
        <?php if ($user && $user->getId()==$list->getUserId()) :?>
			<a class="button_pink" href="<?php echo url_for('list/edit?id='.$list->getId() )?>"><?php echo __('Edit List', null, 'list')?></a>
		<?php endif;?>
			<?php /*?>
			<a href="<?php echo url_for('list/index') ?>" class="button_pink"><?php echo __("Back to \'Lists\'",null,'list')?></a>
      		<?php */ ?>
      <?php endif;?>
		<?php if ($list->getImageId()): $image_path =  image_path($list->getThumb('preview'), true);?>
			<div class="list_desc_picture">
				<div title="<?php echo $list->getTitle(); ?>">
					<?php echo image_tag($list->getThumb(0),array('size'=>'127x127', 'alt' => $list->getTitle())); ?>
					<span><?php echo format_number_choice('[0]<span id="spanPlaceCount">0</span> <br />places|[1]<span id="spanPlaceCount">1</span> <br />place|(1,+Inf]<span id="spanPlaceCount">%count%</span> <br />places', array('%count%' => count($pages)), count($pages),'list'); ?></span>
					<img class="list_type" alt="<?php echo $list->getIsOpen() ? 'unlocked' : 'locked'?>" title="<?php echo __($list->getIsOpen() ? 'Open' : 'Closed')?>" src="/images/gui/<?php echo $list->getIsOpen() ? 'unlocked_pink' : 'locked_pink'?>.png" />
				</div>
			</div>
		<?php elseif (count($pages)):
			foreach ($pages as $company):
				if ($company->getCompanyPage()->getCompany()->getImageId()):?>
					<div class="list_desc_picture">
						<div title="<?php echo $list->getTitle(); ?>">
							<?php $image_path =  image_path($company->getCompanyPage()->getCompany()->getThumb(0), true);?>
							<?php echo image_tag($company->getCompanyPage()->getCompany()->getThumb(0),array('size'=>'127x127', 'alt'=> $list->getTitle())); ?>
							<span><?php echo format_number_choice('[0]<span id="spanPlaceCount">0</span> <br />places|[1]<span id="spanPlaceCount">1</span> <br />place|(1,+Inf]<span id="spanPlaceCount">%count%</span> <br />places', array('%count%' => count($pages)), count($pages),'list'); ?></span>
							<img class="list_type" alt="<?php echo $list->getIsOpen() ? 'unlocked' : 'locked'?>" title="<?php echo __($list->getIsOpen() ? 'Open' : 'Closed')?>" src="/images/gui/<?php echo $list->getIsOpen() ? 'unlocked_pink' : 'locked_pink'?>.png" />
						</div>
					</div>

					<?php break;
				endif;
			endforeach;
		endif;
		 ?>
	<?php slot('facebook') ?>
		<meta property="fb:app_id" content="<?php echo sfConfig::get('app_facebook_app_'.$sf_user->getCountry()->getSlug().'_id');?>"/>
		<meta property="og:title" content="<?php echo $list->getTitle(); ?>" />
		<?php if (isset($image_path)):?>
		<meta property="og:image" content="<?php echo $image_path ?>" />
		<?php endif;?>
		<meta property="og:site_name" content="<?php echo $sf_request->getHost() ?>" />
  		<meta property="og:country-name" content="<?php echo $sf_user->getCountry() ?>" />
  		<meta property="og:url" content="<?php echo url_for('list/show?id='.$list->getId(), true) ?>" />
	<?php end_slot() ?>
		<?php //include_partial('list/social');?>

		<div class="description create_listForm">
			<h2><?php echo $list->getTitle() ?></h2>
                        <div class="hp_block">

                             <?php if($is_place_admin_logged):?>
                                    <?php $sf_user->setAttribute('redirect_after_login', url_for('list/create'));?>
                                    <?php echo link_to(sprintf(__('Login as %s and Create List', null, 'user'), $sf_user->getGuardUser()->getUserProfile()) , 'companySettings/logout', array('class'=>'button_green')) ?>
                             <?php else :?>
                             <a class="button_green" style="float:right; padding: 13px 16px; font-size:20px;" href="<?php echo url_for('list/create' )?>"><?php echo __('Create List', null, 'list')?></a>
                            <?php endif;?>

		        </div>
			<p><?php echo html_entity_decode ($list->getDescription()); ?></p>
			<span><?php //echo count($pages); echo __(' places in this list',NULL,'list'); ?></span>
			<span><?php //echo format_number_choice('[0]There are no places in this list|[1]1 place in this list|(1,+Inf]%count% places in this list', array('%count%' => count($pages)), count($pages),'list'); ?></span>
		</div>
		<div class="clear"></div>

		<div class="social_share_wrap" style="top:100px;">
			<?php include_partial('global/social', array('hasSocialScripts' => true, 'hasSocialHTML' => true)); ?>
		</div>
	</div>

	<div class="googlemap" id="map_canvas_list" ></div>

				<script type="text/javascript">
				 	  var map_center = new google.maps.LatLng(
							  <?php echo ($sf_user->getCity()->getLat()) ?>,
							  <?php echo ($sf_user->getCity()->getLng()) ?>
							 );
					  var myOptions = {
					    center: map_center,
					    zoom: 10,
					    mapTypeId: google.maps.MapTypeId.ROADMAP,
					    streetViewControl: true
					  };

					  var map_list = new google.maps.Map(document.getElementById("map_canvas_list"), myOptions);

					  var bounds = new google.maps.LatLngBounds( );

					<?php if (count($pages)): foreach ($pages as $place):?>
						point = new google.maps.LatLng(<?php echo $place->getCompanyPage()->getCompany()->getLocation()->getLatitude() !=0 ? ($place->getCompanyPage()->getCompany()->getLocation()->getLatitude()): ($place->getCompanyPage()->getCompany()->getCity()->getLat()) ?>,<?php echo $place->getCompanyPage()->getCompany()->getLocation()->getLongitude()!=0 ? ( $place->getCompanyPage()->getCompany()->getLocation()->getLongitude() ):($place->getCompanyPage()->getCompany()->getCity()->getLng()) ?>);
						<?php /*?>
					      point = new google.maps.LatLng(<?php echo $place->getLat()!=0 ? ( $place->getLat() ): ($sf_user->getCity()->getLat()) ?>,<?php echo $place->getLon()!=0 ? ( $place->getLon() ):($sf_user->getCity()->getLng()) ?>);
					      <?php */ ?>
				  	  	  map_list.marker = new google.maps.Marker({
                                                    title: '<?php echo $place->getCompanyPage()->getCompany()->getCompanyTitle($sf_user->getCulture()) ?>',
                                                    map: map_list,
                                                    draggable: false,
                                                    <?php if ($place->getCompanyPage()->getCompany()->getActivePPPService(true)):?>
                                                        icon: new google.maps.MarkerImage('/images/gui/icons/small_marker_'+<?php echo $place->getCompanyPage()->getCompany()->getSectorId() ?>+'.png', null, null, null, new google.maps.Size(40,40)),
                                                        zIndex: google.maps.Marker.MAX_ZINDEX + 1
                                                    <?php else :?>
                                                    icon: new google.maps.MarkerImage('/images/gui/icons/gray_small_marker_'+<?php echo $place->getCompanyPage()->getCompany()->getSectorId() ?>+'.png', null, null, null, new google.maps.Size(40,40))
                                                    <?php endif;?>
                                          });
						  map_list.marker.setPosition(point);

						  bounds.extend(point);
					<?php endforeach;?>
					map_list.fitBounds( bounds );
					<?php endif;?>
//					$(".search_bar").css("display", "none");
				</script>

				<div class="clear"></div>
		            <div class="places_in_list">
                                <div class="content_in">
                                    <?php if($show):?>
                                        <div class="list_searchform_wrapper">
						<div id="dropdown_search">
							<div class="form_search">
								<div class="form_box">
									<?php //echo $form['place_id']->renderLabel()?>
									<input id="search_place" type="text" placeholder="<?php echo __('Click to add places to this list!', null, 'list') ?>" autocomplete="off"/>
								</div>
								<div class="form_city<?php if( $form['location_id']->hasError()):?> error<?php endif;?>">
									<?php echo $form['location_id']->renderLabel()?>
									<?php echo $form['location_id'] ?>
									<?php echo $form['location_id']->renderError()?>
									<a href="javascript:void(0);" id="search_city_name"></a>
								</div>
								<div class="clear"></div>
							</div>
							<div class="form_box">
								<div id="PlacesList" class="list_of_places places_dropdown">
									<a href="javascript:void(0)" id="form_close"></a>
									<div><div class="scrollbar">
									<div class="track"><div class="thumb"><div class="end"></div></div></div></div>
									<div class="viewport"><div class="overview"></div></div></div>
								</div>
							</div>
						</div>

                                        </div>
					<?php endif;?>
					<!-- Pager -->
						 <?php $options = array( //'places' => $pages,
						 		'pager' => $pager,
						 		'culture'=>$sf_user->getCulture(),
						 		'user'=>$user,
						 		'listUserId'=>$list->getUserId(),
						 		'listId'=>$list->getId(),
						 		'is_place_admin_logged'=>$is_place_admin_logged
						 );
						 ?>
						 <?php include_partial('list/places_pager', $options ); ?>
					<!-- End Of Pager -->
					<div class="listing_place">
					<?php if(!$sf_user->isAuthenticated() && $list->getIsOpen()): ?>

							<a href="javascript:void(0);" id="addplace" class="button_pink"><?php echo __('Add Place') ?></a>
							<div class="comments">
								<div class="login_form_wrap">
									<a href="javascript:void(0)" id="header_close"></a>
									<?php include_partial('user/signin_form',array('form'=>$login_form, 'publish_item'=>__('places')));?>
								</div>
							</div>
					<?php endif; ?>
					</div>

					<?php if($sf_user->getCulture() == 'sr' && $list->getUserProfile()->getGender() == 'f') :?>
						<?php $file = 'dashboardf'; ?>
					<?php else :?>
						<?php $file = 'list'; ?>
					<?php endif; ?>


                                    </div>
				</div>
				<div class="sidebar list_of_places">
                                    <div class="event_details">
						<div class="event_details_img">
							<?php echo image_tag($list->getUserProfile()->getThumb(), array('size'=>'45x45', 'alt' => $list->getUserProfile())) ?>
						</div>
						<p>
                                                    <?php echo __('This list is created by', null, $file)." "; ?>
						</p>
                                                <p class="user">
                                                    <?php echo $list->getUserProfile()->getLink(ESC_RAW) ?></span>
                                                </p>
                                                <div class="clear"></div>
						<p>
                                                    <a href="<?php echo  url_for('@user_page?username='. $list->getUserProfile()->getSfGuardUser()->getUsername().'&listTab=true#lists_tab')?> "><?php echo __('More lists from', null, 'list')." ".$list->getUserProfile()?></a>
						</p>

					</div>
					<div class="clear"></div>
                                        <div class="separator_dotted"></div>
					<div class="list_comments">
						<h2><?php echo __('Comments About This List', null, 'list') ?></h2>
						<?php include_component('comment', 'comments', array('activity' => $list->getActivityList(), 'user' => $user, 'url'=>url_for('list/comments?list_id='. $list->getId()), 'pager_class'=>'list_comments' )) ?>
						<?php if(!$sf_user->isAuthenticated()): ?>
						<a href="javascript:void(0);" class="button_pink"><?php echo __('Add Comment', null, 'list')?></a>
						<?php endif; ?>
					</div>
				</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
  
	if ($('.sidebar .comments .review').length == 0)
	{
		//$('.sidebar .comments').prepend('<div class="review review_list_company"><a href="javascript:void(0);" title="getLokal">getLokal</a><a class="review_list_img" href="javascript:void(0);" title="getLokal"><img width="100" height="100" title="getLokal" alt="getLokal" src="/images/gui/getlokal_profile.jpg"></a><div class="review_content"><p>'+"<?php echo 'hello there'?>"+'</p></div></div>');
	}
        <?php if(!$sf_user->isAuthenticated()): ?>
            $('.sidebar .login_form_wrap').append('<a href="javascript:void(0)" id="header_close"></a>');
            $('.login_form_wrap').css('display', 'none');
            $('.sidebar a#header_close').click(function() {
                    $('.sidebar .login_form_wrap').toggle('fast');
                    $('.sidebar .list_comments a.button_pink').toggle();
            })
            $('.content_in .login_form_wrap a#header_close').click(function() {
                    $('#addplace').toggle();
            })
            $('.sidebar a.button_pink').click(function() {
                    $('.login_form_wrap').css('display', 'none');
                    if ($('#addplace').css('display') == 'none')
                        $('#addplace').toggle();
                    $(this).toggle('fast');
                    $('.sidebar .login_form_wrap').toggle('fast');
            });
            $('#addplace').click(function() {
                    $('.login_form_wrap').css('display', 'none');
                    if ($('.sidebar a.button_pink').css('display') == 'none')
                        $('.sidebar a.button_pink').toggle();
                    $(this).toggle();
                    $('.content_in .login_form_wrap').toggle('fast');
            });
        
        <?php endif; ?>
         <?php if($show):?>
	$('.close_form_report').live('click', function() {
		$('.sidebar').find('.ajax').css('display', 'none');
		$('.sidebar').find('.add_review').css('display', 'block');
	});

	var city_clicked = false;
	$('a#search_city_name').text($('#autocomplete_list_location_id').val());
	$('a#search_city_name').click(function() {
           
		if (!city_clicked)
		{        $('#search_place').addClass('shorten');
			$(this).toggle('fast');
			$(this).parent().css({padding: '15px 10px'});
			$(this).parent().children('input').toggle('fast', 'swing', function() {
				$(this).parent().children('input').focus();
				city_clicked = true;
			});
		}
	});
	$('#autocomplete_list_location_id').blur(function() {
             
		if (city_clicked)
		{       $('#search_place').removeClass('shorten');     
			val = $(this).val();
			if ($.trim(val) != '') {
				$(this).parent().children('a').text(val.split(',')[0]);
			}
			else {
				$(this).val($(this).parent().children('a').text());
			}
			city_clicked = false;
		}
		$(this).toggle('fast');
		$(this).parent().children('a').toggle('fast', 'swing', function() {
			$(this).parent().css({padding: '22px 10px 20px'});
		});
	});

	$('.ac_results').live('mouseup', function(e) {
		$('#search_city_name').text($('.ac_over').text().split(',')[0]);
	})

	$('#PlacesList > div').tinyscrollbar({ size: 120 });
	  $('.form_search').css('width', '594px');

  	$('#form_close').click(function() {
  		$("#PlacesList").css('display', 'none');
	});

  $('body').bind('click', function(e) {
	    if($(e.target).closest('#dropdown_search').length == 0) {
	    	$("#PlacesList").css('display', 'none');
	    }
	});
  $('#search_place').keyup (function(){
	  //console.log($('#list_location_id').val());
	  var values = $(this).val();
	  var cityId = $('#list_location_id').val();
	  var listId = <?php echo $form->getObject()->getId() ?>;
	  $('#PlacesList').css('width', ($('.form_search').width() - 26));
	  $('.viewport').css({'width': ($('.form_search').width() - 61), height: '138px'});

	  if(values.length > 2){
		  $("#PlacesList").css('display', 'block');
    	$.ajax({
			url: '<?php echo url_for("list/getPage") ?>',
				data: {'place': values, 'listId': listId, 'cityId': cityId},
			success: function(data, url) {
				$("#PlacesList").attr('data', 'show');
				$("#PlacesList .overview").html(data);
				$("#PlacesList .overview div div a").each(function() {
					$(this).html($(this).html().replace(values, '<span>' + values + "</span>"));
				});
				$("#PlacesList > div").tinyscrollbar_update();
				if ($('#PlacesList .overview').outerHeight() < $('#PlacesList .viewport').outerHeight()) {
					$('#PlacesList .viewport').css('height', $('#PlacesList .overview').outerHeight());
					$('#PlacesList').css('height', 'auto');
				}

			},
		    error: function(e, xhr)
		    {
		        console.log(xhr);
		    }
		});
	  }
	  else{
		  $("#PlacesList").css("display", "none");
		  }
  });
  <?php endif;?>
        
});
</script>
