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
                    <div class="default-container default-form-wrapper col-sm-12 no-padding">

                        <div class="col-sm-12">
                            <?php include_partial('tabsMenu', $params); ?>	   
                        </div>

                        <h2 class="form-title"><?php echo __('Profile Photo Gallery') ?></h2>

                        <?php if ($sf_user->getFlash('notice')): ?> 
                          <div class="form-message success">
                            <p><?php echo __($sf_user->getFlash('notice')) ?></p>
                          </div> 
                        <?php endif; ?>

                        <div id="pictures_container">
                            <?php $picture_count = $pager->getNbResults(); ?>
                            <p><?php echo format_number_choice('[0]No uploaded photos yet.|[1]1 uploaded photo|(1,+Inf]%count% uploaded photos', array('%count%' => $picture_count), $picture_count, 'messages'); ?></p>
                            <?php if ($pager->getNbResults() > 0) { ?>
                                <div class="wrapper-tabs-event-details">
                                    <div class="tab-photo-event-details row">
                                        <ul class="user-profile-images-tab gallery col-md-12">
                                            <?php foreach ($pager->getResults() as $image) { ?>
                                                <li class="revert-to-bootstrap col-md-4">
                                                    <div class="profile-images-holder">
                                                        <a rel="prettyPhoto[gallery2]" href="<?php echo $image->getThumb('preview') ?>" target="_blank"  title="<?php echo $image->getCaption() ?>">
                                                            <?php echo image_tag($image->getThumb()) ?>
                                                        </a>
                                                        <div class="wrapper-upload-photo-event-details">


                                                            <?php if ($image->getId() != $company->getImageId()): ?>
                                                                <a class="default-btn small profile-picture-btn" href="<?php echo url_for('companySettings/setProfile?id=' . $image->getId() . '&slug=' . $company->getSlug()); ?>"><?php echo __('set as profile photo', null, 'company') ?></a>
                                                            <?php endif; ?>

                                                            <?php if ($is_with_order): ?>
                                                                <a class="default-btn small profile-picture-btn" href="<?php echo url_for('crop/placePhoto?image_id=' . $image->getId() . '&slug=' . $company->getSlug()) ?>"><?php echo __('set as cover photo') ?></a> 
                                                            <?php endif; ?>

                                                            <?php if ($is_with_order): ?>
                                                                <?php if ($image->getId() != $company->getLogoImageId()): ?>
                                                                    <a class="default-btn small profile-picture-btn" href="<?php echo url_for('companySettings/setLogo?id=' . $image->getId() . '&slug=' . $company->getSlug()) ?>"><?php echo __('set as logo', null, 'company') ?></a>
                                                                <?php else: ?>
                                                                    <a class="default-btn small profile-picture-btn" href="<?php echo url_for('companySettings/deleteLogo?id=' . $image->getId() . '&slug=' . $company->getSlug()) ?>"><?php echo __('don\'t show logo', null, 'company') ?></a>
                                                                <?php endif; ?>
                                                            <?php endif; ?>

                                                            <?php if($image->getUserId() == $user->getId() or $is_getlokal_admin): ?>
                                                            <?php echo link_to(__('delete', null, 'company'), 'companySettings/deleteImage?id=' . $image->getId() . '&slug=' . $company->getSlug(), array('class' => 'default-btn small delete-picture-btn delete')) ?>
                                                            <?php //else: ?>
                                                            <!-- <a class="default-btn small profile-picture-btn" href="<?php //echo url_for('report/image?id=' . $image->getId()) ?>" class="iframe"><?php //echo __('report') ?></a> -->
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        </ul>	
                                    </div>
                                </div>
                                <div class="clear"></div>
                                <?php echo pager_navigation($pager, $sf_request->getUri()); ?> 
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