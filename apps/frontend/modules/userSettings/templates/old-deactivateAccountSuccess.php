<div class="settings_content">
      <h2><?php echo __('Here are three good reasons to keep your account:');?></h2>
  <div>
    <ol>
      <li><?php echo __('You get interesting information about all the places and events near you');?></li>
      <li><?php echo __('You have the opportunity to win fab prizes by participating in getlokal promotions');?></li>
      <li><?php echo __('If you want to leave the getlokal community, all of your reviews, photos, events and lists will be deleted!');?></li>
    </ol>
  </div>

  <form action="<?php echo url_for('userSettings/deactivateAccount') ?>" method="post">
    <div class="form_box">
      <input type="submit" value="<?php echo __('Delete')?>" class="input_submit" onclick="return confirm('<?php echo __('Still want to delete your profile?')?>');"/>
    </div>
  </form>
</div>



