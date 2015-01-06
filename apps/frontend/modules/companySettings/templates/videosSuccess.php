<?php
include_partial('global/commonSlider');
$params = array('company' => $company, 'adminuser' => $adminuser, 'companies' => $companies, 'is_getlokal_admin' => $is_getlokal_admin);
?>

<?php use_helper('jQuery') ?>

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
            <div class="row">
                <div class="default-container default-form-wrapper col-sm-12">
                    <h2 class="form-title"><?php echo __('Video', null, 'company'); ?></h2>

                    <?php if ($sf_user->getFlash('notice')): ?> 
                        <div class="form-message success">
                            <p><?php echo __($sf_user->getFlash('notice')) ?></p>
                        </div> 
                    <?php endif; ?>

                    <div class="settings_content">
                        <div id="loading-image" style="display:none">
                            <img src="/images/gui/loading.gif" alt="Loading..." />
                            <?php echo __("Your video is being uploaded. Please do not close this page and wait until the process of uploading has completed and you have seen a confirmation message. If you close the page the process will be interrupted and your video will not be successfully uploaded!", null, 'company'); ?>
                        </div>	

                        <?php if ($company->getActivePPPService()): ?>
                            <div id="success_message_holder" class="reg_msg_success" style="display: none;"></div>

                            <?php
                            foreach ($form->getErrorSchema() as $field => $error) {
                                printf("%s: %s\n", $field, $error->getMessage());
                            }
                            ?> 

                            <?php if ($form->getObject()->isNew()): ?>
                                <form action="<?php echo url_for('companySettings/videos?slug=' . $company->getSlug()); ?>" method="POST" enctype="multipart/form-data">
                                <?php else: ?>
                                    <form action="<?php echo url_for('companySettings/editVideo?slug=' . $company->getSlug() . '&videoid=' . $form->getObject()->getId()); ?>" method="POST" >
                                    <?php endif; ?>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="default-input-wrapper active required <?php echo $form['caption']->hasError() ? 'incorrect' : '' ?>">
                                                <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                                                <?php echo $form['caption']->renderLabel(__('Video Title', null, 'company'), array('for' => $form['caption']->getName(), 'class' => 'default-label')) ?>
                                                <?php echo $form['caption']->render(array('class' => 'default-input', 'placeholder' => $form['caption']->renderPlaceholder(), 'name' => 'video_caption')); ?>             
                                                <div class="error-txt" id="video_caption_error"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="default-input-wrapper active required <?php echo $form['description']->hasError() ? 'incorrect' : '' ?>">
                                                <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                                                <?php echo $form['description']->renderLabel(__('Video Description', null, 'company'), array('for' => $form['description']->getName(), 'class' => 'default-label')) ?>
                                                <?php echo $form['description']->render(array('class' => 'default-input', 'placeholder' => $form['description']->renderPlaceholder(), 'name' => 'video_description')); ?>             
                                                <div class="error-txt" id="video_description_error"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if ($form->getObject()->isNew()): ?>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="file-input-wrapper active upload <?php echo $form['filename']->hasError() ? 'incorrect' : '' ?>">
                                                    <label for="fileUpload" class="file-label">
                                                        <?php echo __('No File chosen', null, 'form'); ?>
                                                        <?php echo $form['filename']->render(array('name' => 'video_filename', 'id' => 'fileUpload', 'class' => 'file-input')) ?>
                                                    </label>
                                                    <div class="error-txt" id="file_error_message"></div>
                                                </div>
                                            </div>
                                        </div>

                                    <?php else: ?>
                                        <input type="hidden" name="videoid" value="<?php echo $form->getObject()->getId(); ?>" /> 
                                    <?php endif; ?>
                                    <input name="token" id="videouploader_toked_id" type="hidden" value=""/>
                                    <?php echo $form->renderHiddenFields(); ?> 	 
                                    <div class="row">
                                        <div class="col-sm-12 form-btn-row">
                                            <input type="submit" name="formsubmit" id="formsubmit" value="<?php echo __('Send'); ?>" class="default-btn success pull-right" />
                                        </div>
                                    </div>
                                </form>
                            <?php endif; ?>

                            <br />

                            <div id="youtobe_player_video_holder"></div>
                            <br /><br />
                            <div class="video_images_title_and_description_holder">
                                <?php if ($videos): ?>
                                    <script type="text/javascript">
                                        $(document).ready(function() {
                                            var params = {allowScriptAccess: "always"};
                                            var atts = {id: "youtobe_player_video_holder"};
                                            swfobject.embedSWF("http://www.youtube.com/e/<?php print $videos[0]->getLink(); ?>?enablejsapi=1&playerapiid=youtobe_player_video_holder",
                                                    "youtobe_player_video_holder", "624", "356", "8", null, null, params, atts);
                                        });
                                    </script>
                                    <ul class="user_settings_gallery_list">
                                        <?php foreach ($videos as $video): $videoHolderId = "video_holder_" . $video->getId(); ?>
                                            <li id="<?php echo $videoHolderId; ?>" class="current_picture current_picture_full">
                                                <a class="lightbox" title="<?php echo $video->getDescription(); ?>" href="javascript:__changeYoutobeVideo('<?php echo $video->getLink(); ?>');">
                                                    <img src="http://img.youtube.com/vi/<?php print $video->getLink(); ?>/1.jpg" alt="<?php echo $video->getDescription(); ?>" />
                                                </a>
                                                <a class="default-btn" href="<?php echo url_for('companySettings/videos?slug=' . $company->getSlug() . '&videoid=' . $video->getId()); ?>"><?php echo __('Edit', null, 'company'); ?></a>
                                                <?php echo link_to(__('delete', null, 'company'), 'companySettings/DeleteVideo?slug=' . $company->getSlug() . '&videoid=' . $video->getId(), array('class' => 'default-btn')); ?>
                                                <p><?php echo $video->getCaption(); ?></p>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>

                            <?php if ($form->getObject()->isNew()): ?>
                                <?php include_partial('companySettings/advideosjs', array('company' => $company)); ?>
                            <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.current_picture_full{
	list-style: none;
}
</style>