<div class="col-md-12 col-lg-12 hidden-sm section-places-nearby">
	<h4><?php echo __('PLACES NEARBY', null, 'events'); ?></h4>
	<ul>
		<?php 
			if($companies){
				foreach ($companies as $company){
					include_partial('placeNearbyItem', array('company' => $company));
				}
			}
		?>
	</ul>
</div> <!-- section-places-nearby -->