<?php use_helper('Pagination'); ?>
<?php use_helper('Date') ?>
<?php
$events = $pager->getResults();
$eventscount = $pager->getNbResults();
$i18n = $sf_user->getCulture();
?>
<?php $currentUrl = sfContext::getInstance()->getRequest()->getParameter( 'category_id' )?>
<?php include_partial('event/eventsCalendarFilterJs', $arCalendarFilterAttributes); ?>

<div class="related_category event_dropdown">
    <div class="left_alais">
        <h2><?php echo __('Select category', null, 'events') ?></h2>
        <div class="menu_vertical_separator"></div>
    </div> 
    <select id="event-category" class="selectCategoryMenu no-border">
        <option all-in-city = '1' value="<?php echo url_for('event', array('city' => $city->getId())); ?>" title="<?php echo __('All categories', null, 'events') ?>" <?php echo ($currentUrl == '') ? ' selected="selected" ' : ''; ?>><?php echo __('All categories', null, 'events') ?></option>
        <?php foreach ($categories as $category) : ?>
            <option title="<?php echo $category->getTitle() ?>" 
                    value="?category_id=<?php echo $category->getId();?>" data-type="<?php echo $category->getId();?>"
                    <?php echo ($currentUrl == $category->getId()) ? ' selected="selected" ' : ''; ?>>
                <?php echo $category->getTitle() ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

				<div class="clear"></div>

<div class="events_bg">
    <div class="content_events">
        <div class="breadcrumb">
            <?php foreach(breadCrumb::getInstance()->getItems() as $i=>$item): ?>
              <?php if($item->getUri()): ?>
                <?php echo link_to($item->getText(), $item->getUri()) ?>
              <?php else: ?>
                <h1 class="dotted_event_heading"><?php echo $item->getText() ?></h1>
              <?php endif ?>
              <?php if($i+1 < sizeof(breadCrumb::getInstance()->getItems())) echo '/' ?>
            <?php endforeach ?>
       </div>
        <h1><?php
        if (isset($tickets) && $tickets):
            echo sprintf(__('Events with Tickets in %s', null, 'events'), $city->getDisplayCity());
        //else:
        //    echo  sprintf(__('Events in %s', null, 'events'), $city->getDisplayCity());
        endif;
        ?></h1>

    </div>
    
    <div class="clear"></div>
    <!-- Content Area -->
    <div class="events_content_wrap">
        <div class="events_navigation">
            <?php //echo $titleDate[0].' '.__($titleDate[1]).' '.$titleDate[2] ?>
            <a href="<?php echo url_for('event/index?') . $previous_day_url ?>" class="button_green"><?php echo __('Previous Day', null, 'events') . ' (' . __($previous_day, null, 'form') . ')' ?></a>
            <h2><?php echo format_date($titleDate, 'dd MMMM yyyy','sr'); ?></h2>
            <a style="float:right" href="<?php echo url_for('event/index?') . $next_day_url ?>" class="button_green"><?php echo __('Next Day', null, 'events') . ' (' . __($next_day, null, 'form') . ')' ?></a>
            <div class="clear"></div>
        </div>
        <div class="content_in category_view">
            
            <!--Recommendations-->
            <?php if ($eventscount == 0): ?>
                <p>
                    <?php echo __("Sorry, we don't have any events just yet. Please help us by posting the events you know about and sharing them with us. Thank you!", null, 'events'); ?>
                </p>
            <?php else: ?>
                <div class="list_event_wrap">
                    <?php foreach ($events as $event): ?>           
                        <?php include_partial('event/event', array('event' => $event)); ?>
                    <?php endforeach; ?>
                </div>   
                <div class="clear"></div>
                <?php echo pager_navigation($pager, $sf_request->getUri()); ?>
            <?php endif; ?>
        </div>
         
        <div class="sidebar all-included">
           
            <?php if ($user && $user->getId() && !$is_place_admin_logged): ?>
                   <a href="<?php echo url_for('event/create') ?>" class="button_green create_event"><?php echo __('New Event', null, 'events') ?></a>
               <?php elseif ($is_place_admin_logged): ?>
                   <?php $sf_user->setAttribute('redirect_after_login', url_for('event/create')); ?>
                   <?php echo link_to(sprintf(__('Login as %s and Create an Event', null, 'user'), $sf_user->getGuardUser()->getUserProfile()), 'companySettings/logout', array('class' => 'button_green admin')) ?>
               <?php else: ?>
                   <a href="javascript:void(0)" id="login" class="button_green create_event"><?php echo __('New Event', null, 'events') ?></a>
                   <div class="login_form_wrap" style="display:none">
                       <a href="javascript:void(0)" id="header_close"></a>
                       <?php
                       include_partial('user/signin_form', array(
                           'form' => $form,
                           'localReferer' => url_for('event/create')
                       ));
                       ?>
                   </div>
               <?php endif; ?>
            <div class="events_calendar">
               <div id="datepicker"></div>
           </div>   
            <div class="clear"></div>
            <?php //include_partial('global/embedding', array('embed' => 'events')) ?>
            <?php include_component('box', 'boxOffers') ?>
            <?php include_component('event', 'articles', array('events'=>$events)); ?>
            <div class="separator_dotted"></div>
            <?php include_component('event', 'relatedPlaces', array('events'=>$events)); ?>
            <?php include_partial('global/ads', array('type' => 'box')) ?>
            <div style="margin-top:18px"class="separator_dotted"></div>
            <?php include_component('box', 'boxVip') ?>
            <?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>
                 <?php  include_partial('global/ads', array('type' => 'box2')); ?> 
            <?php endif;?> 
        </div>

        <div class="events-socials">
          <div class="social_share_wrap" style="top:100px;">
            <?php include_partial('global/social', array('embed' => 'events', 'hasSocialScripts' => true, 'hasSocialHTML' => true)); ?>
          </div>
        </div>

    </div>
</div>
<div class="clear"></div>
<!-- Sidebar Area -->
<!--<div class="events_calendar">
        <h2>Calendar</h2>
        calendar here<br/>
</div>
<a class="button_pink">new</a>-->
<div class="clear"></div>

<script type="text/javascript">
$(document).ready(function(){
     $('#login').click(function() {
            $('.login_form_wrap').slideToggle();
        });
var bounds = new google.maps.LatLngBounds( );
<?php if (count($events)): ?>  
        <?php foreach ($events as $event): ?>
                <?php if ($place= $event->getFirstEventPage()):  ?>
                          point = new google.maps.LatLng(<?php echo $place->getCompanyPage()->getCompany()->getLocation()->getLatitude() !=0 ? ($place->getCompanyPage()->getCompany()->getLocation()->getLatitude()): ($place->getCompanyPage()->getCompany()->getCity()->getLat()) ?>,<?php echo $place->getCompanyPage()->getCompany()->getLocation()->getLongitude()!=0 ? ( $place->getCompanyPage()->getCompany()->getLocation()->getLongitude() ):($place->getCompanyPage()->getCompany()->getCity()->getLng()) ?>);

                  map.markers[<?php echo $place->getCompanyPage()->getCompany()->getId(); ?>] = new google.maps.Marker({
                                title: '<?php echo $place->getCompanyPage()->getCompany()->getCompanyTitle() ?>',
                                position: point,
                                map: map.map,
                                draggable: false,
                                <?php if ($place->getCompanyPage()->getCompany()->getActivePPPService(true)):?>
                                icon: new google.maps.MarkerImage('/images/gui/icons/small_marker_'+<?php echo $place->getCompanyPage()->getCompany()->getSectorId() ?>+'.png', null, null, null, new google.maps.Size(40,40)),
                                zIndex: google.maps.Marker.MAX_ZINDEX + 1
                                <?php else :?>
                                icon: new google.maps.MarkerImage('/images/gui/icons/gray_small_marker_'+<?php echo $place->getCompanyPage()->getCompany()->getSectorId() ?>+'.png', null, null, null, new google.maps.Size(40,40)),
                                <?php endif;?>
                                  });


                          bounds.extend(point);
                          google.maps.event.addListener(map.markers[<?php echo $place->getCompanyPage()->getCompany()->getId(); ?>], 'click', function() {
                                map.overlay.load(<?php echo json_encode(get_partial('search/item_overlay', array('company' => $place->getCompanyPage()->getCompany())));?>);
                                      map.overlay.setCenter(new google.maps.LatLng(<?php echo $place->getCompanyPage()->getCompany()->getLocation()->getLatitude(); ?>, <?php echo $place->getCompanyPage()->getCompany()->getLocation()->getLongitude(); ?>));
                                      map.overlay.show();
                                      $('.nav_arrow2').hide();
                                      $('#hide_sim_places').show();
                                  });

                 <?php  endif;?> 
        <?php endforeach;?>

        map.map.fitBounds(bounds);
        google.maps.event.trigger(map.map, 'resize');

<?php endif;?>
});
				</script>
