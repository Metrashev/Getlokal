<?php //include_partial($partial,  array('pageUser' => $pageUser, 'pager' => $pager, 'is_current_user' => $is_current_user));?>
<?php use_helper('Date', 'Pagination');?>
<?php 
$messages = $pager->getResults();
$messages_count = $pager->getNbResults();
$culture =$sf_user->getCulture();
?>
<div class="review_list_wrap">
	<?php if ($messages_count == 0): ?>
		<p><?php echo __('No messages', null, 'offer') ?></p>
	<?php else:?>
		<?php  foreach ($messages as $message): ?>
			<div>
				<?php echo $message->getBody(); ?>
  				<div class="clear"></div>
  			</div>
 		<?php endforeach;?>
	<?php endif;?>
	<?php  echo pager_navigation($pager, url_for('profile/messages')); ?>
</div>

