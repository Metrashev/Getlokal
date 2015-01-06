<?php use_helper('I18N', 'Date','Link') ?>
<?php include_partial('user_profile/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('User', array(), 'messages') ?></h1>

  <?php include_partial('user_profile/flashes') ?>



  <div id="sf_admin_content">
    <form action="<?php echo url_for('user_profile_collection', array('action' => 'batch')) ?>" method="post">

<div class="sf_admin_list">
 
    <table cellspacing="0">
      <thead>
        <tr>
          <th id="sf_admin_list_batch_actions"><input id="sf_admin_list_batch_checkbox" type="checkbox" onclick="checkAll();" /></th>
          <?php include_partial('user_profile/list_th_tabular', array('sort' => false)) ?>
          <th id="sf_admin_list_th_actions"><?php echo __('Actions', array(), 'sf_admin') ?></th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th colspan="13">
          

            
          </th>
        </tr>
      </tfoot>
      <tbody>
      
          <tr class="sf_admin_row <?php echo $odd ?>">
            <?php include_partial('user_profile/list_td_batch_actions', array('user_profile' => $user_profile, 'helper' => $helper)) ?>
            <?php $linka =  link_to_frontend ('user_page', array('username'=>$user_profile->getsfGuardUser()->getUsername(),'sf_culture'=>'en'),false)?>
            <?php echo link_to($user_profile.' Profile Page', $linka)?><br>
            <?php include_partial('user_profile/list_td_tabular', array('user_profile' => $user_profile)) ?>
            <?php include_partial('user_profile/list_td_actions', array('user_profile' => $user_profile, 'helper' => $helper)) ?>
          </tr>
       
      </tbody>
    </table>

</div>



    <ul class="sf_admin_actions">
      <?php include_partial('user_profile/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('user_profile/list_actions', array('helper' => $helper)) ?>
    </ul>
    </form>
  </div>

 
</div>
