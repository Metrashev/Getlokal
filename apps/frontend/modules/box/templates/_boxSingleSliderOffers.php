<div class="col-sm-12 wrapper-small-slider">
	<?php if(count($offers) == 0){ ?>
	<div class="offers_empty">
		<div class="offers-title">
			<?php echo __('OFFERS IN', null, 'offer'); ?><span> <?php echo $sf_user->getCity()->getDisplayCity(); ?></span>
		</div>
	
		<div class="offers-content-empty">
			<div class="empty-image">
				<img src="/css/images/pig.png" alt="">
			</div>
	
			<p><?php echo __("There are no offers", null, 'offer'); ?></p>
		</div><!-- offers-content-empty -->
	</div><!-- offers_empty -->
	<?php } else{ ?>
	<div class="offers_wrapper">
		<div class="section-offers">
			<div class="offers-title">
				<?php echo __('OFFERS IN' , null, 'offer'); ?><span> <?php echo $sf_user->getCity()->getDisplayCity(); ?></span>
			</div>
				<div class="offers-content offers-content-small">
				<div id="offers-wrapper">
					<div id="offers-carousel">
						<ul class="offer-slider offer-slider-single">
							<?php 
								foreach($offers as $offer){
									include_partial("offer/offer", array('offer' => $offer));
								}
							?>				
						</ul>
						<div class="clearfix"></div>
						<a id="offers-prev" class="offers-prev offers-prev-single" href="#"><i class="fa fa-chevron-left fa-2x"></i></a>
						<a id="offers-next" class="offers-next offers-next-single" href="#"><i class="fa fa-chevron-right fa-2x"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div><!--offers_wrapper -->
<?php } ?>
</div>