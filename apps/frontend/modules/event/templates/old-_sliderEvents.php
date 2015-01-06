<?php use_helper('Date')?>
<?php $culture = $sf_user->getCulture();?>
<?php if (count($events)): ?>

	<!-- <div class="slider-unique">
		<ul class="slides-unique">
			<li class="slide-unique">
				<h4>Концерт на Pink Martini</h4>
				<a href="#"><img src="http://lorempixel.com/200/150/sports/" alt="" /></a>
				<span class="fa fa-calendar"><span class="date-of-year">12.06.2014</span></span>
				<p>Култура</p>
			</li>slide-unique
			
			<li class="slide-unique">
				<h4>Концерт на Pink Martini</h4>
				<a href="#"><img src="http://lorempixel.com/200/150/business/" alt="" /></a>
				<span class="fa fa-calendar"><span class="date-of-year">12.06.2014</span></span>
				<p>Култура</p>
			</li>slide-unique
	
			<li class="slide-unique">
				<h4>Концерт на Pink Martini</h4>
				<a href="#"><img src="http://lorempixel.com/200/150/food/" alt="" /></a>
				<span class="fa fa-calendar"><span class="date-of-year">12.06.2014</span></span>
				<p>Кино и театър</p>
			</li>slide-unique
	
			<li class="slide-unique">
				<h4>Концерт на Pink Martini</h4>
				<a href="#"><img src="http://lorempixel.com/200/150/people" alt="" /></a>
				<span class="fa fa-calendar"><span class="date-of-year">12.06.2014</span></span>
				<p>Спорт</p>
			</li>slide-unique
	
			<li class="slide-unique">
				<h4>Концерт на Pink Martini</h4>
				<a href="#"><img src="http://lorempixel.com/200/150/" alt="" /></a>
				<span class="fa fa-calendar"><span class="date-of-year">12.06.2014</span></span>
				<p>Култура</p>
			</li>slide-unique
			
			<li class="slide-unique">
				<h4>Концерт на Pink Martini</h4>
				<a href="#"><img src="http://lorempixel.com/200/150/" alt="" /></a>
				<span class="fa fa-calendar"><span class="date-of-year">12.06.2014</span></span>
				<p>Култура</p>
			</li>slide-unique
		</ul> slides
	
		
		<div class="slider-controls">
			<a href="#" class="slider-prev-unique fa fa-angle-left"></a>
			<a href="#" class="slider-next-unique fa fa-angle-right"></a>
		</div>slider-controls
	</div>slider-unique -->

<div class="slider-unique">
<ul class="slides-unique">
<?php $limit = 4; ?>
  <?php foreach($events as $event): ?>
  	<li class="slide-unique">
      <?php if(!$event->getRecommend() && !$limit): ?>
      <?php break; ?>
      <?php endif; ?>
      <?php $limit--; ?>

    <h4><?php echo link_to($event->getDisplayTitle(), 'event/show?id='. $event->getId(), array('title'=>$event->getDisplayTitle())) ?></h4>
    <?php if ($event->getImageId()):?>
      	 <?php if ($event->getImage()->getType() == 'poster' ):?>
      	 	<div class="event_image_wrap"><?php endif;?>
			 <?php
		      	if ($event->getImage()->getType()=='poster' ):
		      		echo link_to(image_tag($event->getThumb('preview'),array('size'=>'101x135', 'alt'=>$event->getImage()->getCaption() )), 'event/show?id='. $event->getId(), array('title'=>$event->getImage()->getCaption()));
		      	else:
    			 	echo link_to(image_tag($event->getThumb(2), array('size'=>'180x135', 'alt'=>$event->getImage()->getCaption() ) ), 'event/show?id='. $event->getId(), array('title'=>$event->getImage()->getCaption()));
		        endif;
	        ?>
			<?php if ($event->getImage()->getType() == 'poster' ):?></div><?php endif;?>
    <?php else: ?>
      <?php echo link_to(image_tag('gui/default_event_'.$event->getCategoryId().'.jpg', 'size=180x135 alt_title='.$event->getDisplayTitle()), 'event/show?id='. $event->getId()) ?>
    <?php endif; ?>

	<span class="fa fa-calendar">
		<span class="date-of-year">
			<?php echo format_date($event->getStartAt(), 'dd MMM yyyy',$culture);?>
		</span>
	</span>

	<a href="<?php echo url_for('event/index?id='. $event->getCategoryId()) ?>" title="<?php echo $event->getCategory() ?>"
		class="category"><?php echo $event->getCategory() ?>
	</a>
	
    <?php if ($event->getBuyUrl()) : ?>
        <p class="event_buy">
        	<a href="<?php echo $event->getBuyUrl()?>"
				class="button_pink button_ticket"
				title="buy tickets from <?php echo $event->getBuyUrl()?>"
				target="_blank"><?php echo __('Buy Now',null,'events');?>
			</a>
		</p>
    <?php endif; ?>
    </li>

  <?php endforeach ?>
  </ul>

  <div class="slider-controls">
			<a href="#" class="slider-prev-unique fa fa-angle-left"></a>
			<a href="#" class="slider-next-unique fa fa-angle-right"></a>
		</div><!-- /.slider-controls -->
<div class="clear"></div>
</div>
<?php endif ?>


<script type="text/javascript">

(function($) {
    $(document).ready(function() {
        $(".slides-unique").carouFredSel({

			width: 915,
			height: 'auto',
			prev: '.slider-prev-unique',
			next: '.slider-next-unique',
			auto: false

        });
    });
})(jQuery);

</script>
