<div class="slider_wrapper global-slider-margin wrapper_slider-search-result">
	<div class="search-result-slider">
	</div>
	<div class="slider-separator"></div>	
</div>
<div class="post-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 search-found-places">

				<?php if($sliderData['numberOfResults']){ ?>
					<h2><span>
							<?php echo format_number_choice('[0]0 places|[1]1 place|(1,+Inf]%count% places', array('%count%' => $sliderData['numberOfResults']), $sliderData['numberOfResults']); ?>
						</span> <?php echo __('were found in'); ?> <span><?=($sliderData['searchWhere'] == '' || is_null($sliderData['searchWhere']) ? $sliderData['cityName'] : $sliderData['searchWhere'])?> <?=__('for')." '{$sliderData['searchString']}'"?></span></h2>
						<p>
							<?php echo sprintf(__("Couldn't find the place you were looking for? %s and we'll add it."), link_to(__('Send it to us'), 'company/addCompany', array('class' => 'search-add-new-place'))); ?>
						</p>
				<?php } else{ ?>
					<h2><?php echo __('No Results found for %keyword% in %place%', array('%keyword%' => $sliderData['searchString'], '%place%' => $sliderData['searchWhere'])) ?></h2>
				<?php } ?>
			</div>
		</div><!-- row -->
	</div><!-- container -->
</div>