<div class="hidden-sm default-container rel-events-fix rel-events-offers-details">
	<h3 class="heading"><?= __('Similar Events',NULL,'events'); ?></h3> <!-- END heading -->
	<div class="content">	
		<div class="related-events-box">
		<?php 
			foreach ($events as $event) {
				$title = $event->getDisplayTitle();
				$href = url_for('event/show?id='.$event->getId());
				
				if ($event->getImageId()) {
					/** TODO: the if else is left to be edited for different images. If not necessery the if else to be removed. */
					if ($event->getImage()->getType()=='poster' ) {
						$img_tag = image_tag($event->getThumb(2), array(/*'size'=>'70x100', */'alt'=>$title));
					}
					else {
						$img_tag = image_tag($event->getThumb(2), array(/*'size'=>'180x135',*/'alt'=>$title));
					}
				}
				else {
					$img_tag = image_tag('gui/default_event_'.$event->getCategory()->getId().'.jpg', array(/*'size'=>'133x100',*/'alt'=>$title));
				}
				
				$start_at = $event->getDateTimeObject('start_at');
				$end_at = $event->getDateTimeObject('end_at');
				
				if ($start_at->format('H:i:s') == '00:00:00') {
					$from = $start_at->format('d.m.Y');
				}
				else {
					$from = $start_at->format('d.m.Y H:i')."h";
				}
				
				$to = false;
				
				if ($end_at->format("dmYHis") != $start_at->format("dmYHis")) {
					if ($end_at->format('H:i:s') == '00:00:00') {
						$to = $end_at->format('d.m.Y');
					}
					else {
						$to = $end_at->format('d.m.Y H:i')."h";
					}
				}
			
		?>
			<a href="<?= $href; ?>" title="<?= $title; ?>" class="related-event">
				<span class="image-box">
					<?= $img_tag; ?>
				</span>
				<span class="rel-event-info">
					<span class="title"><?= $title; ?></span>
					<?php if ($page = $event->getFirstEventPage()) { ?>
					<span class="place"><?= $page->getCompanyPage()->getCompany()->getCompanyTitleByCulture(); ?></span>
					<?php } ?>
					<span class="city"><?= $event->getCity()->getLocation(); ?></span>
					<span class="date"><?= __("From",null,"events")?>: <span class="bold"><?= $from ?></span> 
					<br/>
					<?= __("To",null,"events")?>: <span class="bold"><?= $to; ?></span></span>
				</span>
			</a> <!-- END related-event -->
		<?php } ?>

		</div> <!-- end related-events-box -->
	</div><!-- END content -->
</div> <!-- end default-container -->