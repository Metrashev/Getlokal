<?php 
	if( is_object($sliderData['classification']) ){
		$selected = $sliderData['count']." ".$sliderData['classification']->getTitle();
	}elseif( is_object($sliderData['sector']) ){
		$selected = $sliderData['sector']->getTitle();
	}
?>
<div class="slider_wrapper global-slider-margin wrapper_slider-search-result">
	<div class="search-result-slider">
	</div>
	<div class="slider-separator"></div>	
</div>
<div class="post-wrapper post-wrapper-small">
	<div class="container">
		<div class="row">		
			<div class="col-sm-12">
			<div class="col-sm-12 path-holder-margin">
	        	<?php include_partial('global/breadCrumb');?>      
	      	</div>
				<h1 class="top-info-heading" id="selected_category_title"><?php echo $selected." ".__('in', null, 'events')." {$sliderData['cityName']}" ?></h1>
				<p></p>
			</div>
		</div><!-- row -->
	</div><!-- container -->
</div>