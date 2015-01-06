<form action="<?php echo url_for('follow/edit?page_id='. $form->getObject()->getPageId()) ?>" method="post">
   <?php echo $form['_csrf_token']->render() ?>
   <?php //$email_notification = ($form->getObject()->getEmailNotification() == 1)? array('checked'=> 'CHECKED'):'';?>
   <?php // $internal_notification = ($form->getObject()->getInternalNotification() == 1)? array('checked'=> 'CHECKED'):'';?>
   <?php // $newsfeed = ($form->getObject()->getNewsfeed() == 1)? array('checked'=> 'CHECKED'):'';?>
   <?php // $weekly_update = ($form->getObject()->getWeeklyUpdate() == 1)? array('checked'=> 'CHECKED'):'';?>
   <?php echo $form['email_notification']->render() ?>
   <?php echo $form['email_notification']->renderLabel(__('Email notification'));?>
   <?php echo $form['internal_notification']->render() ?>
        <?php echo $form['internal_notification']->renderLabel(__('Messages')) ?>
        <?php echo $form['newsfeed']->render() ?>
        <?php echo $form['newsfeed']->renderLabel(__('Show in newsfeed')) ?>
        <?php echo $form['weekly_update']->render();?>
        <?php echo $form['weekly_update']->renderLabel(__('Receive weekly update email'))?>
   
   <div class="form_box">
      <input type="submit" value="<?php echo __('Save');?>" class="input_submit" />
    </div>
</form>