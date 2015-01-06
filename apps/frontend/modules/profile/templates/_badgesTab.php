<ul class="list-box-wrapper">

<?php foreach($badges as $badge){ ?>

	<li class="list-box usr-badge">
		<div class="custom-row">
			<?php echo image_tag($badge->getFile('active_image')->getUrl()); ?>
			<div class="info">
				<div class="name"><?php echo $badge->getName() ?></div>
				<div class="location"><?php echo sprintf( __('Badge unlocked by <strong> %s%s </strong> of users'),$badge->getPercent(),'%' ) ?></div>
				<div class="tag"><?php echo $badge->getDescription() ?> <strong><?php echo $badge->getLongDescription() ?></strong></div>
			</div>
		</div>
	</li><!-- END usr-badge -->

<?php } ?>
</ul>