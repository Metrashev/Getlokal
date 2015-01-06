<?php use_helper('Date');?>
<?php use_helper('TimeStamps');?>

<?php if (isset($listOfStatuses) && count($listOfStatuses)) : ?>
<div class="status_scroll">
	<div class="scrollbar"><div class="track"><div class="thumb"></div></div></div>
	<div class="viewport">
		<ul class="overview">
	        <?php foreach ($listOfStatuses as $status) : ?>
	            <li>
                    <?php if (!$hideRemoveLink) : ?>
                    	<a href="#" onclick="removeStatus(<?php echo $status->getId(); ?>); return false;" title="<?php echo __('Delete', null, 'status') ?>"><?php echo __('Delete', null, 'status') ?></a>
                    <?php endif; ?>
	                <p class="right"><?php echo ezDate(date('d.m.Y H:i', strtotime($status->getCreatedAt()))); ?></p>
	                <?php echo sfOutputEscaper::unescape($status->getText()); ?>
	            </li>
	        <?php endforeach; ?>
		</ul>
	</div>
</div>
<?php endif; ?>