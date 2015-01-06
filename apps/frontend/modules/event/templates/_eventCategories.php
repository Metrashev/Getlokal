<div class="events-section-categories">
	<div class="event-categories-title">
		<?php echo __('Select category', null, 'events') ?>
	</div>
	<!-- categories-title -->
	<ul class="events-category-list">
		<li class="selected">
			<div class="marker"></div> 
			<a value="all_cats" title="<?php echo __('All categories', null, 'events') ?>"> 
				<?php echo __('All categories', null, 'events') ?>
			</a>
		</li>
		<?php foreach ($categories as $category) : ?>
		<li>
			<div class="marker"></div> 
			<a value="<?=$category->getId();?>" title="<?php echo $category->getTitle() ?>"> 
				<?php echo $category->getTitle() ?>
			</a>
		</li>
		<?php endforeach; ?>
	</ul>
	<!-- categories-list -->
</div>
