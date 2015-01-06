<div class="tab-utilities">
	<?php
		//$contributors = sfContext::getInstance()->getRequest()->getParameter("contributors", false);
		$photos_author = ((!$contributors) ? "class='current'" : "");
		$photos_contributor = (($contributors) ? "class='current'" : "");
	?>
	<ul class="tab-list" id="photo_tabs">
		<li <?= $photos_author ?> id="photos_author"><a href="javascript:void(0)" onclick="ajaxPagingUrl(1,'#event_photos_container','<?= url_for('event/photos?event_id='. $event->getId()); ?>');setCurrent('photos_author')"><?= __('By Author',null,'events'); ?></a></li>
		<li <?= $photos_contributor ?> id="photos_contributor"><a href="javascript:void(0)" onclick="ajaxPagingUrl(1,'#event_photos_container','<?= url_for('event/photos?event_id='. $event->getId().'&contributors=1'); ?>');setCurrent('photos_contributor')"><?= __('By Attendees',null,'events'); ?></a></li>
	</ul><!-- tab-list -->
</div><!-- tab-utilities -->
	
<div class="tab-photo-event-details" id="event_photos_container">
	<ul>
	<?php include_partial('event/photos', array('images' => $images, 'event' => $event, 'contributors' => $contributors, 'form' => $form, 'user' => $user)) ?>
	</ul>
</div>

<script type="text/javascript">
	function setCurrent(type){
		$("#photo_tabs li").removeClass("current");
		$("#"+type).addClass("current");
	}
</script>