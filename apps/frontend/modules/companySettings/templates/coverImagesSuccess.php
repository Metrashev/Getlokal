<?php
use_helper('Pagination');
include_partial('global/commonSlider');
$params = array('company' => $company, 'adminuser' => $adminuser, 'companies' => $companies, 'is_getlokal_admin' => $is_getlokal_admin);
$is_with_order = $company->getActivePPPService(true);
?>
<div class="container set-over-slider">
    <div class="row">	
        <div class="container">
            <div class="row">
                <?php include_partial('topMenu', $params); ?>	
            </div>
        </div>	          
    </div>		

    <div class="col-sm-4">
        <div class="section-categories">
            <?php include_partial('rightMenu', $params); ?>	            
        </div>
    </div>
    <div class="col-sm-8">
        <div class="content-default">
            <form action="<?php echo url_for('userSettings/communication') ?>" method="post" class="default-form clearfix">
                <div class="row">
                    <div class="default-container default-form-wrapper col-sm-12">

                        <div class="col-sm-12">
                            <?php include_partial('tabsMenu', $params); ?>	   
                        </div>

                        <h2 class="form-title"><?php echo sprintf(__('Cover Photo Gallery of %s'), $company->getCompanyTitle()) ?></h2>

                        <?php if ($sf_user->getFlash('notice')): ?> 
                            <div class="form-message success">
                                <p><?php echo __($sf_user->getFlash('notice')) ?></p>
                            </div> 
                        <?php endif; ?>

                        <div id="pictures_container">
                            <?php $picture_count = $pager->getNbResults(); ?>
                            <p><?php echo format_number_choice('[0]No uploaded cover photos yet.|[1]1 uploaded cover photo|(1,+Inf]%count% uploaded cover photos', array('%count%' => $pager->getNbResults()), $pager->getNbResults(), 'messages'); ?></p>
                            <?php if ($pager->getNbResults() > 0) { ?>
                                <div class="wrapper-tabs-event-details">
                                    <div class="tab-photo-event-details">
                                        <ul class="user-profile-images-tab gallery clearfix">
                                            <?php foreach ($pager->getResults() as $image): ?>
                                                <li <?php echo ($company->getCoverImageId() != $image->getId() ? '' : 'class="current"') ?>>
                                                    <?php if ($company->getCoverImageId() == $image->getId()): ?>
                                                        <h4><?php echo __('Cover Photo', null, 'company'); ?></h4>
                                                    <?php endif; ?>

                                                    <a href="<?php echo sfConfig::get('app_cover_photo_dir') . $image->getFilename() ?>" target="_blank" class="lightbox" rel="group" title="<?php echo $image->getCaption() ?>">
                                                        <img src="<?php echo sfConfig::get('app_cover_photo_dir') . $image->getFilename() ?>" ></img>
                                                    </a>
                                                    <div class="wrapper-upload-photo-event-details">

                                                        <?php if ($company->getCoverImageId() != $image->getId()): ?>
                                                            <a class="default-btn small profile-picture-btn" href="<?php echo url_for('companySettings/setCoverPhoto?image_id=' . $image->getId() . '&slug=' . $company->getSlug()) ?>"><?php echo __('set as cover photo') ?></a>
                                                        <?php endif; ?>

                                                        <?php if ($image->getUserId() == $user->getId()): ?>
                                                            <?php echo link_to(__('delete', null, 'company'), 'companySettings/deleteCoverImage?id=' . $image->getId() . '&slug=' . $company->getSlug(), array('class' => 'link_confirm default-btn small delete-picture-btn delete')) ?><br/>
                                                        <?php endif ?>
                                                    </div>
                                                </li>
                                            <?php endforeach ?>
                                        </ul>	
                                    </div>
                                </div>
                                <div class="clear"></div>
                                <?php echo pager_navigation($pager, 'companySettings/coverImages?slug='.$company->getSlug()); ?>
                            <?php } ?>
                        </div>
                        <!-- Form End -->
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="dialog-confirm" title="<?php echo __('Delete this image?', null, 'company') ?>" style="display:none;">
    <p><?php echo __('Are you sure you want to delete this image?', null, 'company') ?></p>
</div>

<script type="text/javascript">
    setTimeout(function() {
        $(".success").fadeOut().empty();
    }, 8000);

    $('a.delete-picture-btn ').click(function() {
        var delelePhotoLink = $(this).attr('href');
        $("#dialog-confirm").dialog({
            resizable: false,
            height: 250,
            width: 340,
            buttons: {
                "<?php echo __('delete', null) ?>": function() {
                    window.location.href = delelePhotoLink;
                },
<?php echo __('cancel', null, 'company') ?>: function() {
                    $(this).dialog("close");
                }
            }
        });
        return false;
    });
</script>

<style>
.user-profile-images-tab li{
    width: 270px;
}
.user-profile-images-tab li img{
	width: 270px;
	height: 115px;
}
</style>