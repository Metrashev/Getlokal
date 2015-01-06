<div class="list_event">
	
		<a href="<?php echo url_for('event/show?id='.$event->getId());?>" title="<?php echo ($event->getDisplayTitle() ? $event->getDisplayTitle() : $event->getImage()->getCaption());?>">
		    <?php if ($event->getImageId() && $event->getImage()->getFileName()):?>
		      	 <?php if ($event->getImage()->getType()=='poster' ):?>
		      	 <?php endif;?>

		      	 <h3><a href="<?php echo url_for('event/show?id='.$event->getId());?>" title="<?php echo ($event->getDisplayTitle() ? $event->getDisplayTitle() : $event->getImage()->getCaption());?>"><?php echo ($event->getDisplayTitle() ? $event->getDisplayTitle() : $event->getImage()->getCaption());?></a></h3>
		      	 <div class="event-city"><?php echo $event->getCity()->getLocation() ?></div>

				 <div class="events-image-container">
				 	<a href="<?php echo url_for('event/show?id='.$event->getId());?>" title="<?php echo ($event->getDisplayTitle() ? $event->getDisplayTitle() : $event->getImage()->getCaption());?>">
					 	<?php 
	 				      	if ($event->getImage()->getType()=='poster' ):
	 				      		echo image_tag($event->getThumb('preview'),array('size'=>'101x135', 'alt'=>($event->getDisplayTitle() ? $event->getDisplayTitle() : $event->getImage()->getCaption())));
	 				      	else:
	 			    			 	echo image_tag($event->getThumb(2), array( 'size'=>'178x135', 'alt'=>($event->getDisplayTitle() ? $event->getDisplayTitle() : $event->getImage()->getCaption()) ) );
	 				        endif;
	 			        ?>
 			   		</a>
 			   		 
				 	<?php 	if ($event->getImage()->getType()=='poster' ):?>

	 				<?php endif;?>
					<?php else: ?>  
		      		<?php echo link_to(image_tag('gui/default_event_'.$event->getCategory()->getId().'.jpg', 'size=178x135 alt='.($event->getDisplayTitle() ? $event->getDisplayTitle() : $event->getImage()->getCaption())), 'event/show?id='. $event->getId(), array('title' => ($event->getDisplayTitle() ? $event->getDisplayTitle() : $event->getImage()->getCaption()))) ?>
		    		<?php endif;?>
		    		<?php if($event->hasTickets()):?>
		    			<div class="has-ticket"><i class="fa fa-ticket"></i><?php echo __('Tickets Available', null, 'events');?></div>
		    		<?php endif;?>

	 			</div>
		  </a>
	
	<p class="event_date">
	
	<?php /*if($event->hasTickets()):?>
		Tickets
	<?php endif;*/?>
	<?php
		$start_at = $event->getDateTimeObject('start_at');
		$end_at = $event->getDateTimeObject('end_at');
		
     	if ($start_at->format('H:i:s') == '00:00:00') :
			$from = $start_at->format('d.m.Y');
		else:
			$from = $start_at->format('d.m.Y H:i')."h";
		endif;
		
		$to = false;
		
		if($end_at->format("dmYHis") != $start_at->format("dmYHis")){
			if ($end_at->format('H:i:s') == '00:00:00') :
				$to = $end_at->format('d.m.Y');
			else:
				$to = $end_at->format('d.m.Y H:i')."h";
			endif;
		} 
	?>
		<?php echo __("From",null,"events")?> : <span class="black"> <?php echo $from ?></span>
	<?php if($to):?>
		<br>
		<?php echo __("To",null,"events")?> : <span class="black"> <?php echo $to?></span>
	<?php endif;?>
	   
	   </p>
	<p class="event_location">
            <span>
              <?php if ($page= $event->getFirstEventPage()): ?>
                    <?php echo link_to_company($page->getCompanyPage()->getCompany()) ?> 
              <?php endif;?>
            </span>
            <br>
  <!-- <a href="<?php echo url_for('event/index?category_id='. $event->getCategoryId()) ?>" class="category" title="<?php echo $event->getCategory() ?>"><?php echo $event->getCategory();?></a></p> -->
  <?php $city_id = !empty($city) ? $city->getId() : "current" ?>
  <a href="javascript:void(0);" class="category" title="<?php echo $event->getCategory() ?>" onclick="loadPage('<?php echo url_for("event/recommendedTabs?&city_id=".$city_id."&category_id=".$event->getCategoryId())?>/selected_tab/'+$('input[name=selected_tab]').val(),1,1);clearDateText();$('#event-category').val(<?php echo $event->getCategoryId()?>).trigger('change')"><?php echo $event->getCategory();?></a></p>
</div>
