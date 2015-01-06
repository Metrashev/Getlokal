<?php 
$city = $event->getCity();
$company = $event->EventPage[0]->CompanyPage->Company;
?>
<a href="<?php echo url_for('event/show?id='.$event->getId()) ?>" title="<?php echo $event->getDisplayTitle() ?>" class="related-event">
	<span class="image-box">
		<?php echo image_tag($event->getThumb(2), array( 'size'=>'88x88', 'alt'=>$event->getDisplayTitle() ) );?>
	</span>

	<span class="rel-event-info">
		<span class="title"><?php echo $event->getDisplayTitle() ?></span>
		<?php if(is_object($company)){?>
			<span class="place"><?=$company->getTitle()?></span>
		<?php }?>
		<span class="city"><?=$city->getName()?></span>
		<span class="date"><?=__('from')?>: <span class="bold"><?=date('d.m.Y', strtotime($event->getStartAt()))?></span> <?=__('to')?>: <span class="bold"><?=date('d.m.Y', strtotime($event->getEndAt()))?></span></span>
	</span>
</a> <!-- END related-event -->
