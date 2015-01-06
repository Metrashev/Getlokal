<?php slot('no_map', true) ?>
<?php slot('no_ads', true) ?>
<?php use_helper('Pagination');?>
<div class="settings_content">
	<h2><?php echo sprintf(__('Cover Photo Gallery of %s'), $company->getCompanyTitle())?></h2>
    <p><?php echo format_number_choice('[0]No uploaded cover photos yet.|[1]1 uploaded cover photo|(1,+Inf]%count% uploaded cover photos', array('%count%' => $pager->getNbResults()), $pager->getNbResults(),'messages'); ?></p>
	
	<?php if($pager->getNbResults() > 0): ?>
		<ul class="settings_gallery settings_gallery_big">
			<?php foreach($pager->getResults() as $image): ?>
				<li <?php echo ($company->getCoverImageId() != $image->getId() ? '' : 'class="current"')?>>
					<?php if ($company->getCoverImageId() == $image->getId()):?>
						<h3><?php echo __('Cover Photo', null, 'company'); ?></h3>
					<?php endif; ?>
					<a href="<?php echo  sfConfig::get('app_cover_photo_dir').$image->getFilename() ?>" target="_blank" class="lightbox" rel="group" title="<?php echo $image->getCaption() ?>">
						<img src="<?php echo  sfConfig::get('app_cover_photo_dir').$image->getFilename() ?>" ></img>
						<span class="clear"></span>
					</a>
      
      				<div class="profile_picture_wrap">
						<a href="#"><?php echo __('Options'); ?> <img src="/images/gui/menu_user_arrow.png" /></a>
						
						<div class="profile_picture_options">
							<?php if ($company->getCoverImageId() != $image->getId()):?>
								<a href="<?php echo url_for('companySettings/setCoverPhoto?image_id='. $image->getId().'&slug='.$company->getSlug()) ?>"><?php  echo __('set as cover photo')?></a>
							<?php endif;?>
							
							<?php if($image->getUserId() == $user->getId()): ?>
								<?php echo link_to(__('delete', null, 'company'), 'companySettings/deleteCoverImage?id='. $image->getId().'&slug='.$company->getSlug(), array('class'=>'link_confirm')) ?><br/>
							<?php endif ?>
						</div>
					</div>
					
					<?php /* <a href="#" class="button_green">Make new thumbnail</a> <!--phase 2  */ ?>
				</li>
			<?php endforeach ?>
		</ul>
		<div class="clear"></div>
		<?php  echo pager_navigation($pager, 'companySettings/coverImages?slug='.$company->getSlug()); ?>	
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
    })
  });

	$('.profile_picture_wrap > a').click(function () {
		$('.profile_picture_options').slideUp(100);
		if ($(this).next().css('display') == 'none') {
			$(this).next().slideDown(100);
		}
		return false;
	});
})
</script>