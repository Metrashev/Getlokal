<?php use_helper('Date')?>
<?php $culture=$sf_user->getCulture();?>
<?php if(count($images)): ?>
<!-- <div class="recomend_events_wrap index">
	<div class="recomend_events_top recomend_past_events_top">
		<h2><?php echo __('Photos from past events', null, 'events')?></h2>
	</div>
	<div class="recommend_events_content_list_wrap past_events_wrapper">
		<ul class="recomend_events_content_list past_events_list">
		  <?php foreach($images as $image): ?>
		    <li class="recomend_event past_event_item">
		    <?php if ($image->getThumb(2)):?>
		    
		    	<?php if ($image->getType()=='poster' ):?><div class="event_image_wrap"><?php endif;?>
				 <?php 
			      	if ($image->getType()=='poster' ):
			      		echo link_to(image_tag($image->getThumb('preview'), array('size'=>'101x135','alt'=>($image->getTitle() ? $image->getTitle() : $image->getCaption())) ), 'event/show?id='. $image->getEventId(), array('title' => ($image->getTitle() ? $image->getTitle() : $image->getCaption())));
			      	else:
		      			echo link_to(image_tag($image->getThumb(2), array('size'=>'180x135','alt'=>($image->getTitle() ? $image->getTitle() : $image->getCaption()) ) ), 'event/show?id='. $image->getEventId(), array('title' => ($image->getTitle() ? $image->getTitle() : $image->getCaption())));
			        endif;
		        ?>
				<?php 	if ($image->getType()=='poster' ):?></div><?php endif;?>
		    
		    <?php else: ?>  
		      <?php echo link_to(image_tag('gui/default_event_'.$image->getEventCategoryId().'.jpg', 'size=180x135 alt='.($image->getTitle() ? $image->getTitle() : $image->getCaption())), 'event/show?id='. $image->getEventId(), array('title' => ($image->getTitle() ? $image->getTitle() : $image->getCaption()))) ?>
		    <?php endif;?>
		      <span><?php echo format_date($image->getStartAt(), 'dd MMM yyyy',$culture);?></span>
		      <h3><?php echo link_to($image->getTitle(), 'event/show?id='. $image->getEventId(), array('title' => ($image->getTitle() ? $image->getTitle() : $image->getCaption()))) ?></h3>
		      <a title="<?php echo $image->getCategoryTitle() ?>" href="<?php echo url_for('event/index?id='. $image->getEventCategoryId()) ?>" class="category"><?php echo $image->getCategoryTitle() ?></a>
		      <div class="clear"></div>
		    </li>
		  <?php endforeach ?>
		</ul>
		<div class="clear"></div>
	</div>
</div> -->
<?php endif ?>

<script type="text/javascript">
$(document).ready(function(){
	var wrapperPast = $('.past_events_wrapper');
	var listPast = $('.past_events_list');
	var itemPast = $('li.past_event_item');
	var duration = 5; //seconds
	var displayItemCount = 3;
	var leftOffset = 0; //25 pixels offsetLeft from the wrapper

	if (itemPast.length > displayItemCount)
	{
		 listPast.css('width', itemPast.length * parseInt(itemPast.outerWidth()));
		wrapperPast.css('height', listPast.outerHeight()+$('.content_in .recomend_past_events_top').outerHeight());
		wrapperPast.append('<a href="javascript:void(0);" id="past_event_slider_back" class="back"></a>')
		wrapperPast.append('<a href="javascript:void(0);" id="past_event_slider_next" class="next"></a>')
		wrapperPast.children('.recommend_events_content_list_wrap').css('height', listPast.outerHeight());
		var pause = false;
		var clicked = false;
		var max = itemPast.length - displayItemCount;
		var _x = -1;
		var _f = 0;
	
		var change = function() {
			if (clicked) return;
			clicked=true;
	    	listPast.animate({left: (_x * -itemPast.outerWidth() + leftOffset) + 'px'}, 200, function() {
	    		clicked=false;
	    	});	    
		    _f = 0;
		};
			  
		var next = function() {
			_x++;
			if(_x > max) _x = 0;
			    change();
			};
			  
		$('.content_in a.back').live('click',function() {
		    var index = Math.max(0, parseInt((-(parseInt(listPast.css('left')) - leftOffset)) / itemPast.outerWidth()) - 1);
		    if(_x != index)
		    {
		      	_x = index;
		      	change();
		    }
		    else if (index == 0)
		    {
		    	_x = max;
		      	change();
		    }
		    return false;
		});

		$('.content_in a.next').live('click',function() {
		    var index = Math.min(max, parseInt((-(parseInt(listPast.css('left')) - leftOffset)) / itemPast.outerWidth()) + 1);
		    if(_x != index)
		    {
		      	_x = index;
		      	change();
		    }
		    else if (index == max)
		    {
		    	_x = 0;
		      	change();
		    }
		    return false;
		});
	
	  	wrapperPast.hover(function() {
		 	pause = true;
	  	}, function() {
	    	pause = false;
	  	});
			  
		setInterval(function() {
			if(pause) return;
		    	_f++;
		    if(_f>duration) {
		      next();
		    }
		}, 1000);
			  
		next();
	}
});
</script>