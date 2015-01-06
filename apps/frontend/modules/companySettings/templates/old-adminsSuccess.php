<?php slot('no_ads', true) ?>
<?php slot('no_map', true) ?>
<div class="settings_content">
  <h2><?php echo __('Company Admins')?></h2>
  <?php foreach ($pageAdmins as $admin):?>
    <?php echo link_to_public_profile($admin->getUserProfile(), array('target'=>'_blank')) ; ?>
   <?php if ($adminuser->getIsPrimary()):?>
      <?php if ($admin->getStatus() == 'pending'):?>
        <?php echo link_to(__('Approve'), 'companySettings/setAdminStatus?status=approved&pageadmin_id='. $admin->getId(), array( 'class' => 'approve_confirm')) ?>
      	<?php echo link_to(__('Reject'), 'companySettings/setAdminStatus?status=rejected&pageadmin_id='. $admin->getId(),  array( 'class' => 'reject_confirm')) ?>
      <?php elseif ($admin->getStatus() == 'rejected'):?>
        <?php echo link_to(__('Approve'), 'companySettings/setAdminStatus?status=approved&pageadmin_id='. $admin->getId(), array( 'class' => 'approve_confirm')) ?>
      <?php else:?>       
        <?php if ($admin->getId() == $adminuser->getId()):?>
          <?php echo link_to(__('Stop Administration'), 'companySettings/setAdminStatus?status=rejected&pageadmin_id='. $admin->getId(), array( 'class' => 'stop_confirm')) ?>
        <?php else:?>
          <?php echo link_to(__('Reject'), 'companySettings/setAdminStatus?status=rejected&pageadmin_id='. $admin->getId(),  array( 'class' => 'reject_confirm')) ?>
        <?php endif;?>     
      <?php endif;?><br><br>
    <?php else:?>
         <?php if ($admin->getId() == $adminuser->getId()):?>
          <?php echo link_to(__('Stop Administration'), 'companySettings/setAdminStatus?status=rejected&pageadmin_id='. $admin->getId(), array( 'class' => 'stop_confirm')) ?>
        <?php endif?><br><br>    
      
      <?php endif;?>
  <?php endforeach; ?>
</div>
<div class="clear"></div>
<div id="dialog-approve" title="<?php echo __('Approve?', null, 'messages') ?>" style="display:none;">
        <p><?php echo __('Are you sure you want to approve ', null, 'company') ?><?php echo __($adminuser->getUserProfile()) ?>?</p>
</div>
<div id="dialog-reject" title="<?php echo __('Reject?', null, 'messages') ?>" style="display:none;">
        <p><?php echo __('Are you sure you want to reject ', null, 'messages') ?><?php echo __($adminuser->getUserProfile()) ?>?</p>
</div>
<div id="dialog-stop" title="<?php echo __('Stop Administration', null, 'messages') ?>" style="display:none;">
        <p><?php echo __('Are you sure you want to deactivate ', null, 'messages') ?><?php echo __($adminuser->getUserProfile()) ?><?php echo __(' as admin for ', null, 'messages') ?><?php echo __($company->getCompanyTitle()) ?>?</p>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $('.path_wrap').remove();

/*Reject confirmation */
     $('a.reject_confirm ').click(function() {
            var rejectLink = $(this).attr('href');        
            $("#dialog-reject").dialog({
                resizable: false,
                height: 250,
                width:340,
                buttons: {
                    "<?php echo __('reject', null) ?>": function() {
                       window.location.href = rejectLink;
                    },
                    <?php echo __('cancel', null) ?>: function() {
                        $(this).dialog("close");
                    }
                }
            });
            $(".ui-dialog").css("z-index", "2");
            return false;
        });
/*END Reject confirmation */
/*Approve confirmation */
     $('a.approve_confirm ').click(function() {
            var approveLink = $(this).attr('href');        
            $("#dialog-approve").dialog({
                resizable: false,
                height: 250,
                width:340,
                buttons: {
                    "<?php echo __('approve', null) ?>": function() {
                       window.location.href = approveLink;
                    },
                    <?php echo __('cancel', null) ?>: function() {
                        $(this).dialog("close");
                    }
                }
            });
            $(".ui-dialog").css("z-index", "2");
            return false;
        });
/*END Approve confirmation */
/*Stop administration confirmation */
     $('a.stop_confirm').click(function() {
            var stopLink = $(this).attr('href');        
            $("#dialog-stop").dialog({
                resizable: false,
                height: 250,
                width:340,
                buttons: {
                    "<?php echo __('yes', null) ?>": function() {
                       window.location.href = stopLink;
                    },
                    <?php echo __('cancel', null) ?>: function() {
                        $(this).dialog("close");
                    }
                }
            });
            $(".ui-dialog").css("z-index", "2");
            return false;
        });
/*END Stop admin confirmation */
});
</script>
