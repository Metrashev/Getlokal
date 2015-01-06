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
                        <h2 class="form-title"><?php echo __('Followers') ?></h2>

                        <?php if ($sf_user->getFlash('notice')): ?> 
                            <div class="form-message success">
                                <p><?php echo __($sf_user->getFlash('notice')) ?></p>
                            </div> 
                        <?php endif; ?>

                        <div id="pictures_container">
                            <?php $picture_count = $pager->getNbResults(); ?>
                            <p><?php echo format_number_choice('[0]No followers|[1]1 follower|(1,+Inf]%count% followers', array('%count%' => $pager->getNbResults()), $pager->getNbResults(), 'messages'); ?></p>
                            <?php if ($pager->getNbResults() > 0) { ?>
                                <div class="wrapper-tabs-event-details">
                                    <div class="tab-photo-event-details">
                                        <ul class="list-box-wrapper">
                                            <?php
                                            foreach ($pager->getResults() as $follower) {
                                                $userProfile = $follower->getUserProfile();
                                                if ($sf_user->getCulture() != 'sr') {
                                                    $vr1 = $userProfile->getCountry()->getCountryNameByCulture();
                                                    $vr2 = $userProfile->getCity()->getDisplayCity();
                                                } else {
                                                    $vr1 = $userProfile->getCity()->getDisplayCity();
                                                    $vr2 = $userProfile->getCountry()->getCountryNameByCulture();
                                                }
                                                $send_message = true;
                                                ?>    
                                                <li class="list-box settings">
                                                    <div class="custom-row">
                                                        <img src="<?= myTools::getImageSRC($userProfile->getThumb(), 'user') ?>" class="img-circle profile-img">
                                                        <div class="info">
                                                            <?php echo link_to($follower->getUserProfile(), '@user_page?username=' . $userProfile->getsfGuardUser()->getUsername(), 'class="name"'); ?>
                                                            <div class="location"><i class="fa fa-map-marker"></i><?php echo $vr1 . ", " . $vr2 ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="custom-row">
                                                        <?php /* if (sfConfig::get('app_enable_messaging')): ?>
                                                            <?php if ($follower->getInternalNotification()): ?>  
                                                                <?php echo link_to(__('Send Message'), 'message/view?user=' . $follower->getUserProfile()->getUserPage()->getId(), array('class' => 'default-btn small send-msg-btn')); ?>
                                                                <?php if ($follower->getMessagesCount()): ?>
                                                                    <?php echo link_to(__('View Messages'), 'message/view?user=' . $follower->getUserProfile()->getUserPage()->getId(), array('class' => 'default-btn small right')); ?>
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                        <?php endif; */ ?> 
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        </ul> 
                                        <div id="message_content"><div style="display:none"></div></div>
                                    </div>
                                </div>
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

<script type="text/javascript">
    $(document).ready(function() {
        // send message form
        $('.list-box-wrapper a.send-msg-btn').click(function() {
            if ($('#message_content > div').css('display') == 'block')
            {
                $('#message_content > div').slideUp('fast');
            }
            else {
                var elem = $(this);
                var parent = $(this).parent();
                parent.parent().find('a.send-msg-btn').not($(this)).removeClass('button_clicked');
                $.ajax({
                    url: this.href,
                    beforeSend: function() {
                        parent.append($('#message_content'));
                        $('#message_content div').hide();
                    },
                    success: function(data, url) {
                        $('#message_content div').html(data);
                        $('#message_content div').slideDown('fast');

                    },
                    //   complete: function() {
                    // $('#message_content .messages_scroll').tinyscrollbar_update('bottom');
                    //   }
                });
            }
            return false;
        });

        // view messages
        $('.list-box-wrapper a.right').click(function() {

            var elem = $(this);
            var parent = $(this).parent();
            if ($('#message_content > div').css('display') === 'block')
                $('#message_content > div').slideUp('fast');
            else {
                $.ajax({
                    url: this.href,
                    beforeSend: function() {
                        parent.append($('#message_content'));
                        $('#message_content div').hide();
                    },
                    success: function(data, url) {
                        $('#message_content div').html(data);
                        $('#message_content div').slideDown('fast');
                        $('.response').css({'display': 'none'});
                        if ($('#message_content .messages_scroll .overview > div').length > 3) {
                            $('#message_content .messages_scroll').tinyscrollbar({size: 215});
                        }
                        else {
                            $('#message_content .messages_scroll .viewport').css({height: 'auto'});
                            $('#message_content .messages_scroll .overview').css({position: 'static'});
                            $('#message_content .messages_scroll .scrollbar').remove();
                        }
                        if (elem.hasClass('send-msg-btn'))
                            $('#message_content div div.messages_scroll').hide();
                    },
                    complete: function() {
                        $('#message_content .messages_scroll').tinyscrollbar_update('bottom');
                    }
                });
            }
            return false;
        });
    });
</script>

<style>
    .list-box.settings{
        width: 580px;
    }
    .list-box-wrapper .list-box.settings .info .name{
        max-width: 450px;
    }
    .list-box-wrapper .list-box.settings .custom-row .default-btn.small{
        max-width: none;
    }
</style>