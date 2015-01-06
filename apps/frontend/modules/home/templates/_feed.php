<?php 
	use_helper('Date');
	use_helper('TimeStamps');
	$activities = $pager->getResults();
	//echo sizeof($activities); die;
?>
<div class="testimonial-head">
	<div class="head-title">
		<?php echo __('Activity in Getlokal', null, 'company'); ?>
	</div><!-- head-title -->
</div><!-- testimonial-head -->
<div class="testimonials">
	<div class="body-content">					
		<ul class="list-testimonials">
			<?php 
			if(sizeof($activities)){
				foreach ($activities as $item){
					if( is_object($item) ){
						$profile = $item->getUserProfile();
						if(is_object($profile)){
							include_partial('feedItem', array('item' => $item));
						}
					}
				}
			}
			?>							
		</ul>
	</div><!-- body-content -->
</div><!-- testimonials -->