<div class="slider_wrapper pp global-slider-margin">
  <div class="slider-image">
    <div class="dim"></div>
  </div>
  <div class="slider-separator"></div>  
</div><!-- slider_wrapper -->

<div class="post-wrapper post-wrapper-small">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="path-holder">
                    <?=html_entity_decode($sliderData['path'])?>
                </div>

				<h1 class="top-info-heading" id="selected_category_title">
					<?php 
						if(getlokalPartner::getInstanceDomain() == 78){
							echo sprintf(__('Events in %s', null, 'events'), $sf_user->getCounty());
						}else{
							echo sprintf(__('Events in %s', null, 'events'), $sf_user->getCity()->getDisplayCity());
						}
					?>
				</h1>

			</div>
		</div><!-- row -->
	</div><!-- container -->
</div>

<div class="upcoming-events-wrapper boxesToBePulledDown">
	<div class="events_wrapper">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<?php include_component( 'event', 'sliderEvents', array('city' => $sliderData['city']))?>
				</div>
			</div>
		</div>
	</div><!-- events_wrapper -->
</div>