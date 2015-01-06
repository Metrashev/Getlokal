<?php slot('no_map', true) ?>
<div class="settings_content">

     <h3 class="dotted">
          <?php echo __('Via Gmail or Yahoo', null, 'user')?>
     </h3>

    <h2 class="h-title">
        <?php echo __('Send Your Invite via <a href="?invite_choice=gmail" title="Gmail"><img src="/images/logos/gmail.png"></a> or <a href="?invite_choice=yahoo" title="Yahoo"><img src="/images/logos/yahoo.png"></a>', null, 'user')?>
    </h2>
 <div class="clear"></div>
    <?php if ($sf_user->hasFlash('error')) : ?>
        <p><?php echo link_to(__('Back', null, 'user'), '@invite_gy'); ?></p>
    <?php endif; ?>
</div>


<script type="text/javascript">
	$(document).ready(function() {
		$('.path_wrap').css('display', 'none');
//		$('.search_bar').css('display', 'none');
		$(".banner").css("display", "none");
	});
</script>
