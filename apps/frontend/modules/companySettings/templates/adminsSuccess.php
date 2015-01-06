<?php
include_partial('global/commonSlider');
$params = array('company' => $company, 'adminuser' => $adminuser, 'companies' => $companies, 'is_getlokal_admin' => $is_getlokal_admin);
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
            <div class="row">
                <div class="default-container default-form-wrapper col-sm-12">
                    <h2 class="form-title"><?php echo __('Company Admins') ?></h2>
                    <div class="settings_content">
                        <?php foreach ($pageAdmins as $admin) { ?>
                            <?php echo link_to_public_profile($admin->getUserProfile(), array('target' => '_blank', 'class' => 'default-link')); ?>
                            <?php if ($adminuser->getIsPrimary()) { ?>

                                <?php
                                if ($admin->getStatus() == 'pending') {
                                    echo link_to(__('Approve'), 'companySettings/setAdminStatus?status=approved&pageadmin_id=' . $admin->getId(), array('class' => 'default-btn approve_confirm'));
                                    echo link_to(__('Reject'), 'companySettings/setAdminStatus?status=rejected&pageadmin_id=' . $admin->getId(), array('class' => 'default-btn reject_confirm'));
                                } elseif ($admin->getStatus() == 'rejected') {
                                    echo link_to(__('Approve'), 'companySettings/setAdminStatus?status=approved&pageadmin_id=' . $admin->getId(), array('class' => 'default-btn approve_confirm'));
                                } else {
                                    if ($admin->getId() == $adminuser->getId()) {
                                        echo link_to(__('Stop Administration'), 'companySettings/setAdminStatus?status=rejected&pageadmin_id=' . $admin->getId(), array('class' => 'default-btn stop_confirm'));
                                    } else {
                                        echo link_to(__('Reject'), 'companySettings/setAdminStatus?status=rejected&pageadmin_id=' . $admin->getId(), array('class' => 'default-btn reject_confirm'));
                                    }
                                }
                                ?>
                                <br><br>
                                <?php
                            } else {
                                if ($admin->getId() == $adminuser->getId()) {
                                    echo link_to(__('Stop Administration'), 'companySettings/setAdminStatus?status=rejected&pageadmin_id=' . $admin->getId(), array('class' => 'default-btn stop_confirm'));
                                }
                                ?>
                                <br><br>    
                                <?php
                            }
                        }
                        ?>
                    </div>

                    <div id="dialog-approve" title="<?php echo __('Approve?', null, 'messages') ?>" style="display:none;">
                        <p><?php echo __('Are you sure you want to approve ', null, 'company') ?><?php echo __($adminuser->getUserProfile()) ?>?</p>
                    </div>
                    <div id="dialog-reject" title="<?php echo __('Reject?', null, 'messages') ?>" style="display:none;">
                        <p><?php echo __('Are you sure you want to reject ', null, 'messages') ?><?php echo __($adminuser->getUserProfile()) ?>?</p>
                    </div>
                    <div id="dialog-stop" title="<?php echo __('Stop Administration', null, 'messages') ?>" style="display:none;">
                        <p><?php echo __('Are you sure you want to deactivate ', null, 'messages') ?><?php echo __($adminuser->getUserProfile()) ?><?php echo __(' as admin for ', null, 'messages') ?><?php echo __($company->getCompanyTitle()) ?>?</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    /*Reject confirmation */
    $('a.reject_confirm ').click(function() {
        var rejectLink = $(this).attr('href');
        $("#dialog-reject").dialog({
            resizable: false,
            height: 250,
            width: 340,
            buttons: {
                "<?php echo __('reject', null) ?>": function() {
                    window.location.href = rejectLink;
                },
                <?php echo __('cancel', null, 'company') ?>: function() {
                    $(this).dialog("close");
                }
            }
        });
        $(".ui-dialog").css("z-index", "2");
        return false;
    });

    /*Approve confirmation */
    $('a.approve_confirm ').click(function() {
        var approveLink = $(this).attr('href');
        $("#dialog-approve").dialog({
            resizable: false,
            height: 250,
            width: 340,
            buttons: {
                "<?php echo __('approve', null) ?>": function() {
                    window.location.href = approveLink;
                },
                <?php echo __('cancel', null, 'company') ?>: function() {
                    $(this).dialog("close");
                }
            }
        });
        $(".ui-dialog").css("z-index", "2");
        return false;
    });

    /*Stop administration confirmation */
    $('a.stop_confirm').click(function() {
        var stopLink = $(this).attr('href');
        $("#dialog-stop").dialog({
            resizable: false,
            height: 250,
            width: 340,
            buttons: {
                "<?php echo __('yes', null) ?>": function() {
                    window.location.href = stopLink;
                },
                <?php echo __('cancel', null, 'company') ?>: function() {
                    $(this).dialog("close", 'company');
                }
            }
        });
        $(".ui-dialog").css("z-index", "2");
        return false;
    });
</script>