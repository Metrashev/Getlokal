<?php slot('no_map', true) ?>
<?php slot('no_ads', true) ?>
<?php use_helper('Pagination');?>

<?php $is_with_order = $company->getActivePPPService(true);?>

<div class="settings_content">
	<h2><?php echo sprintf(__('Photo Gallery of %s'), $company->getCompanyTitle())?></h2>
    <p><?php echo format_number_choice('[0]No uploaded photos yet.|[1]1 uploaded photo|(1,+Inf]%count% uploaded photos', array('%count%' => $pager->getNbResults()), $pager->getNbResults(),'messages'); ?></p>
	
	<?php if($pager->getNbResults() > 0): ?>
		<ul class="settings_gallery">
			<?php foreach($pager->getResults() as $image): ?>
				<li <?php echo ($image->getId() != $company->getImageId()) ? '' : 'class="current"' ?>>
					<?php if($image->getId() == $company->getImageId()): ?>
						<h3><?php echo __('Profile photo', null, 'company'); ?></h3>
					<?php endif; ?>
					<a href="<?php echo $image->getThumb('preview') ?>" target="_blank" class="lightbox" rel="group" title="<?php echo $image->getCaption() ?>">
						<?php echo image_tag($image->getThumb()) ?>
					</a>

					<div class="profile_picture_wrap">
						<a href="#"><?php echo __('Options'); ?> <img src="/images/gui/menu_user_arrow.png" /></a>
						
						
						<div class="profile_picture_options">
							<?php if($image->getId() != $company->getImageId()): ?>
								<a href="<?php echo url_for('companySettings/setProfile?id='. $image->getId().'&slug='.$company->getSlug()); ?>"><?php echo __('set as profile photo', null,'company')?></a>
							<?php else: ?>
								<?php /*?><a href=""><?php echo __('unset profile photo', null,'company')?></a> */?>
							<?php endif; ?>
							
							<?php if ($is_with_order):?>
								<a href="<?php echo url_for('crop/placePhoto?image_id='. $image->getId().'&slug='.$company->getSlug()) ?>"><?php  echo __('set as cover photo')?></a> 
							<?php endif;?>
							
							<?php if ($is_with_order):?>
								<?php if($image->getId() != $company->getLogoImageId()): ?>
									<a href="<?php echo url_for('companySettings/setLogo?id='. $image->getId().'&slug='.$company->getSlug()) ?>"><?php echo __('set as logo', null,'company')?></a>
								<?php else:?>
									<a href="<?php echo url_for('companySettings/deleteLogo?id='. $image->getId().'&slug='.$company->getSlug()) ?>"><?php echo __('don\'t show logo', null,'company')?></a>
								<?php endif; ?>
							<?php endif;?>
							<?php /* <a href="#" class="button_green">Make new thumbnail</a> <!--phase 2  */ ?>
		      
							<?php if($image->getUserId() == $user->getId() or $is_getlokal_admin): ?>
								<?php echo link_to(__('delete', null, 'company'), 'companySettings/deleteImage?id='. $image->getId().'&slug='.$company->getSlug(),array('class'=>'link_confirm')) ?>
							<?php else: ?>
								<a href="<?php echo url_for('report/image?id='. $image->getId()) ?>" class="iframe"><?php echo __('report') ?></a>
							<?php endif; ?>
						</div>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
		<div class="clear"></div>
		<?php  echo pager_navigation($pager, $sf_request->getUri()); ?>	
	<?php endif;?>
	<div class="clear"></div>
</div>
<div id="dialog-confirm" title="<?php echo __('Delete this image?', null, 'company') ?>" style="display:none;">
        <p><?php echo __('Are you sure you want to delete this image?', null, 'company') ?></p>
</div>
<script type="text/javascript">
$(document).ready(function() {
$('.path_wrap').remove();
/*Delete photo confirmation */
     $('a.link_confirm ').click(function() {
            var delelePhotoLink = $(this).attr('href');        
            $("#dialog-confirm").dialog({
                resizable: false,
                height: 250,
                width:340,
                buttons: {
                    "<?php echo __('delete', null) ?>": function() {
                       window.location.href = delelePhotoLink;
                    },
                    <?php echo __('cancel', null) ?>: function() {
                        $(this).dialog("close");
                    }
                }
            });
            $(".ui-dialog").css("z-index", "2");
            return false;
        });
/*END Delete photo */
  $('a.lightbox').fancybox({
    titlePosition: 'over',
    cyclic:        true
  });
  
  $('a.iframe').each(function(i,s) {
    $(s).fancybox({
      type  : 'iframe',
        width : 800,
        height: 600,
        href  : $(s).attr('href')+ '?modal=1'
    });
  });

	$('.profile_picture_wrap > a').click(function () {
		$('.profile_picture_options').slideUp(100);
		if ($(this).next().css('display') == 'none') {
			$(this).next().slideDown(100);
		}
		return false;
	});
});
</script>