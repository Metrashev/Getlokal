<div class="content_in">
<h1><?php echo __('Claim Your Company', null, 'company');?></h1>
<?php echo sprintf(__('Your Claim request for %s, %s is currently pending.', null, 'claim'), $company->getCompanyTitle(), $company->getDisplayAddress())?></br>
<?php echo sprintf(__('After its approval by getlokal, you will be able to upload photos, working hours, description of %s, as well as to respond to user reviews.', null, 'claim'), $company->getCompanyTitle()); ?><br /><br />
<?php echo sprintf(__('If you have any questions, feel free to %s.',null,'claim'),link_to(__('contact us', NULL, 'claim'), 'contact/getlokal', array('title' => __('contact us', NULL, 'claim'))))?><?php //echo ;?>
</div>
<div class="sidebar">
</div>
<div class="clear"></div>
<script type="text/javascript">
	$(document).ready(function() {
		$('.path_wrap').remove();
		$('.search_bar').remove();
		$(".banner").remove();
	});
</script>