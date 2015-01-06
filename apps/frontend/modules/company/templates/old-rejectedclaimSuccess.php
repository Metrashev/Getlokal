<div class="content_in">
<h1><?php echo __('Claim Your Company', null, 'company');?></h1>
<?php echo sprintf(__('Your Place Claim for %s, %s  has already been rejected and you have been notified by email.', null, 'claim'), $company->getCompanyTitle(), $company->getDisplayAddress()); ?><br /><br />
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