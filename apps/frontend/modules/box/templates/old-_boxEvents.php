<?php use_helper('Date')?>
<?php $culture=$sf_user->getCulture();?>
<?php if(isset($events1) || isset($events2)): ?>
<div class="recomend_events_wrap recomend_events_city_wrap">
	<div class="recomend_events_top">
		<?php if ( ($sf_user->getCulture()=='bg' ) && (substr($sf_user->getCity()->getLocation(),0,2 )=='В' || substr($sf_user->getCity()->getLocation(),0,2 )=='Ф' ) ):?>
			<h2 style="width: 420px;"><a title="<?php echo sprintf(__('Events in %s', null, 'exception'),$sf_user->getCity()->getLocation()); ?>" href="<?php echo url_for('event')?>"><?php echo sprintf(__('Events in %s', null, 'exception'),$sf_user->getCity()->getLocation()); ?></a></h2>
		<?php else :?>
			<?php if ($county): ?>
				<h2 style="width: 420px;"><a title="<?php echo sprintf(__('Events in %s', null,'events'),$sf_user->getCounty()->getLocation()); ?>" href="<?php echo url_for('event')?>"><?php echo sprintf(__('Events in %s', null,'events'),$sf_user->getCounty()->getLocation()); ?></a></h2>
			<?php else: ?>
				<h2 style="width: 420px;"><a title="<?php echo sprintf(__('Events in %s', null,'events'),$sf_user->getCity()->getDisplayCity()); ?>" href="<?php echo url_for('event')?>"><?php echo sprintf(__('Events in %s', null,'events'),$sf_user->getCity()->getDisplayCity()); ?></a></h2>
			<?php endif; ?>
		<?php endif;?>
		<?php /* ?>
	    	<a href="#" class="button_green">Weekend</a>
		<?php */ ?>
	   	<a title="<?php echo __('Tomorrow')?>" href="<?php echo url_for('event').'?selected_tab=date&date_selected='.date('Y-m-d', time()+86400) ?>" class="button_green"><?php echo __('Tomorrow')?></a>
	    <a title="<?php echo __('Today' , null , 'events')?>" href="<?php echo url_for('event').'?selected_tab=date&date_selected='.date('Y-m-d', time()) ?>" class="button_green"><?php echo __('Today')?></a>
		<div class="clear"></div>
	</div>
	<ul class="recomend_events_content_list">
		<?php if (count($events1)>0):?>
		<?php foreach($events1 as $event): ?>
  			<li class="recomend_event">
  				<?php if ($event->getImageId()):?>
			      	 <?php if ($event->getImage()->getType()=='poster' ):?><div class="event_image_wrap"><?php endif;?>
						 <?php
					      	if ($event->getImage()->getType()=='poster' ):
					      		echo link_to(image_tag($event->getThumb('preview'),array('size'=>'101x135', 'alt'=>$event->getDisplayTitle())), 'event/show?id='. $event->getId(), array('title' => $event->getDisplayTitle()));
					      	else:
			    			 	echo link_to(image_tag($event->getThumb(2), 'size=180x135 alt='.$event->getDisplayTitle()), 'event/show?id='. $event->getId(), array('title' => $event->getDisplayTitle()));
					        endif;
				        ?>
						 <?php 	if ($event->getImage()->getType()=='poster' ):?></div><?php endif;?>
			    <?php else: ?>
			      <?php echo link_to(image_tag('gui/default_event_'.$event->getCategory()->getId().'.jpg', 'size=180x135 alt='.$event->getDisplayTitle()), 'event/show?id='. $event->getId(), array('title' => $event->getDisplayTitle())) ?>
			    <?php endif;?>
			    <span><?php echo format_date($event->getStartAt(), 'dd MMM yyyy',$culture);?></span>
			    <h3><?php echo link_to($event->getDisplayTitle(), 'event/show?id='. $event->getId(), array('title' => $event->getDisplayTitle())) ?></h3>
			    <a title="<?php echo $event->getDisplayTitle() ?>" href="<?php echo url_for('event/index?id='. $event->getCategoryId()) ?>" class="category"><?php echo $event->getCategory() ?></a>
				<div class="clear"></div>
			</li>
		<?php endforeach ?>
		<?php endif;?>
		<?php if (isset($events2)) : ?>
		<?php foreach($events2 as $event): ?>
  			<li class="recomend_event">
  				<?php if ($event->getImageId()):?>
			      	 <?php if ($event->getImage()->getType()=='poster' ):?><div class="event_image_wrap"><?php endif;?>
						 <?php
					      	if ($event->getImage()->getType()=='poster' ):
					      		echo link_to(image_tag($event->getThumb('preview'),array('size'=>'101x135', 'alt'=>$event->getDisplayTitle())), 'event/show?id='. $event->getId(), array('title' => $event->getDisplayTitle()));
					      	else:
			    			 	echo link_to(image_tag($event->getThumb(2), 'size=180x135 alt='.$event->getDisplayTitle()), 'event/show?id='. $event->getId(), array('title' => $event->getDisplayTitle()));
					        endif;
				        ?>
						 <?php 	if ($event->getImage()->getType()=='poster' ):?></div><?php endif;?>
			    <?php else: ?>
			      <?php echo link_to(image_tag('gui/default_event_'.$event->getCategory()->getId().'.jpg', 'size=180x135 alt='.$event->getDisplayTitle()), 'event/show?id='. $event->getId(), array('title' => $event->getDisplayTitle())) ?>
			    <?php endif;?>
			    <span><?php echo format_date($event->getStartAt(), 'dd MMM yyyy',$culture);?></span>
			    <h3><?php echo link_to($event->getDisplayTitle(), 'event/show?id='. $event->getId(), array('title' => $event->getDisplayTitle())) ?></h3>
			    <a title="<?php echo $event->getCategory() ?>" href="<?php echo url_for('event/index?id='. $event->getCategoryId()) ?>" class="category"><?php echo $event->getCategory() ?></a>
				<div class="clear"></div>
			</li>
		<?php endforeach ?>
		<?php endif;?>
  	</ul>
	<div class="clear"></div>
</div>
<div class="recomend_events_footer">
	<a title="<?php echo __('See More Events', null, 'events')?>" href="<?php echo url_for('event').'?selected_tab=date&date_selected='.date('Y-m-d', time()+86400) ?>"><b><?php echo __('See More Events', null, 'events')?></b></a>
</div>
<?php endif ?>
