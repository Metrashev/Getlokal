<div class="content_events">
  <div class="content_events_in">
    <?php  echo __('You need to log in with a user profile and not as a place admin in order to finish what you started.'); ?></p>
    <?php //include_partial('user/signin_form',array('form'=> new sfGuardFormSignin()));?>
    <?php if ($r=='create'):?>
  		<?php $sf_user->setAttribute('redirect_after_login', url_for('event/'.$r));?>
	<?php elseif ($r=='edit'):?>
		<?php $sf_user->setAttribute('redirect_after_login', url_for('event/'.$r.'?id='.$id,true));?>
	<?php endif;?>
	<?php echo link_to(sprintf(__('Login as %s and '.ucfirst ($r).' List', null, 'user'), $sf_user->getGuardUser()->getUserProfile()) , 'companySettings/logout', array('class'=>'button_pink')) ?>
  </div>
  <div class="clear"></div>
</div>