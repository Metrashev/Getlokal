<?php slot('no_map', true) ?>
<?php use_helper('Pagination') ?>
<div class="settings_content">
	<h2><?php echo __('Profile Photo Gallery');?></h2>
	<?php $picture_count = $pager->getNbResults();?>
	<p><?php echo format_number_choice('[0]No uploaded photos yet.|[1]1 uploaded photo|(1,+Inf]%count% uploaded photos', array('%count%' => $picture_count), $picture_count,'messages'); ?></p>
	<?php if($pager->getNbResults() > 0 ): ?>
		<ul class="settings_gallery">
			<?php foreach($pager->getResults() as $image): ?>
				<li <?php echo ($image->getId() != $profile->getImageId()) ? '' : 'class="current"' ?>>
					<a href="<?php echo $image->getThumb('preview') ?>" target="_blank" class="lightbox" rel="group" title="<?php echo $image->getCaption() ?>">
						<?php echo image_tag($image->getThumb()) ?>
					</a>
					<div class="profile_picture_wrap">
						<a href="#"><?php echo __('Options'); ?> <img src="/images/gui/menu_user_arrow.png" /></a>
						
						<div class="profile_picture_options">
							<?php if($image->getId() != $profile->getImageId()): ?>
								<a href="<?php echo url_for('userSettings/setProfile?id='. $image->getId()) ?>"><?php echo __('set as profile photo', null, 'company')?></a>
							<?php endif ?>
							<?php /* <a href="#" class="button_green">Make new thumbnail</a> <!--phase 2  */ ?>
							<?php echo link_to(__('delete', null, 'company'), 'userSettings/deleteImage?id='. $image->getId(), array('class' => "link_confirm")) ?>
						</div>
					</div>
				</li>
			<?php endforeach ?>
		</ul>
	<?php endif ?>
    <div id="dialog-confirm" title="<?php echo __('Delete this image?', null, 'company') ?>" style="display:none;">
        <p><?php echo __('Are you sure you want to delete this image?', null, 'company') ?></p>
    </div>
	<div class="clear"></div>
	<?php echo pager_navigation($pager, 'userSettings/images') ?>
</div>

<script type="text/javascript">
$(document).ready(function() {
	$('.path_wrap').css('display', 'none');
//	$('.search_bar').css('display', 'none');
	$(".banner").css("display", "none");
	$('a.lightbox').fancybox({
		titlePosition: 'over',
		cyclic:        true
	});

	$('.profile_picture_wrap > a').click(function () {
		$('.profile_picture_options').slideUp(100);
		if ($(this).next().css('display') == 'none') {
			$(this).next().slideDown(100);
		}
		return false;
	});
     $('a.link_confirm').click(function() {
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
})
</script>