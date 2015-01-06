<?php ?>
<div class="similar_events_wrap event_item_page ">
    <div>
        <div class="similar_places_more">
            <a id="similar_places" href="<?php echo url_for('event/placesNearby?id='.$id)?>"><?php echo __('Places Nearby',null,'events')?></a>
        </div>
        <h2><?php echo __('Similar Events',NULL,'events')?></h2>
  
    </div>  
    <div class="clear"></div>
<ul class="event_pictures">
    <?php foreach ($events as $event):?>
	  	<li>
	  		
			  	 <?php if ($event->getImageId()):?>
		      	 <?php if ($event->getImage()->getType()=='poster' ):?><div class="event_image_wrap"><a href="<?php echo url_for('event/show?id='.$event->getId());?>" title="<?php echo $event->getDisplayTitle();?>"><?php endif;?>
					 <?php 
				      	if ($event->getImage()->getType()=='poster' ):
				      		echo image_tag($event->getThumb('preview'),array('size'=>'70x100', 'alt'=>$event->getDisplayTitle() ));
				      	else:
		    			 	?><a href="<?php echo url_for('event/show?id='.$event->getId());?>" title="<?php echo $event->getDisplayTitle();?>"><?php echo image_tag($event->getThumb(2), array('size'=>'180x135','alt'=>$event->getDisplayTitle())); ?></a>
				        <?php endif;
			        ?>
					 <?php 	if ($event->getImage()->getType()=='poster' ):?></a></div><?php endif;?>
			    <?php else: ?>  
			      <?php echo link_to(image_tag('gui/default_event_'.$event->getCategory()->getId().'.jpg', 'size=133x100 alt='.$event->getDisplayTitle()), 'event/show?id='. $event->getId()) ?>
			    <?php endif;?>
		    
		  	<a href="<?php echo url_for('event/show?id='.$event->getId());?>" title="<?php echo $event->getDisplayTitle();?>" class="header-of-events"><?php echo $event->getDisplayTitle();?></a>
                        <p class="event_date">
                            <?php if ($event->getDateTimeObject('start_at')->format('H:i:s') == '00:00:00') :  
                                    echo $event->getDateTimeObject('start_at')->format('d/m/Y');
                                  else:
                                    echo $event->getDateTimeObject('start_at')->format('d/m/Y H:i');
                            endif; ?>
                            <?php echo $event->getCity()->getLocation() ?>
                        </p>
                        <p class="event_location"> 
                            <span>
                                <?php if ($page= $event->getFirstEventPage()): ?>
                                    <?php echo link_to_company($page->getCompanyPage()->getCompany()) ?> | 
                                <?php endif;?>
                            </span>    
                            <a href="<?php echo url_for('event/index?category_id='. $event->getCategoryId()) ?>" class="category" title="<?php echo $event->getCategory() ?>"><?php echo $event->getCategory();?></a>
                        </p> 
	  	</li>
    <?php endforeach;?>
</ul>
	  <div class="clear"></div>
  </div>
  
  
  <script type="text/javascript">

$(document).ready(function() {
  
  $('#similar_places').click(function() {
  
    $.ajax({
    url: this.href,
    beforeSend: function( ) {
      $('.similar_events_wrap').html('<div class="review_list_wrap"><img src="/images/gui/loading.gif"/></div>');
      },
    success: function( data ) {
      $('.similar_events_wrap').html(data);
    }
  });
    return false;
  });
})
</script>