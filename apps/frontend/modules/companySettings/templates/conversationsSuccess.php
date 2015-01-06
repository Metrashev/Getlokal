<?php use_helper('Date', 'TimeStamps'); ?>
<?php slot('no_ads', true) ?>

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
                        <h2 class="form-title"><?php echo __('Messages') ?></h2>


						<?php /* 
                        <div class="settings_content">
                            <?php if (count($converstaions) == 0): ?>
                                <p><?php echo __('No messages', null, 'offer') ?></p>
                            <?php else: ?>
                                <div class="company_followers company_inbox">
                                    <?php foreach ($converstaions as $conversation): ?>

                                        <div class="company_follower"  id="<?php echo $conversation->getToPage()->getId() ?>">
                                            <?php echo link_to('<img src="/images/gui/close.png" alt="X" />', 'message/delete?id=' . $conversation->getId(), 'class=messageDelete confirm=' . __('Do you really want to delete this converstaion?')) ?>

                                            <span><?php echo ezDate(date('d.m.Y H:i', strtotime($conversation->getUpdatedAt()))); ?></span>
                                            <?php if (get_class($conversation->getToPage()->getRawValue()) == 'CompanyPage'): ?>
                                                <?php $company = $conversation->getToPage()->getCompany(); ?>
                                                <?php echo link_to(image_tag($company->getThumb(1)), $company->getUri(ESC_RAW)) ?>
                                                <?php echo link_to_company($company) ?>
                                            <?php else: ?>
                                                <?php $user_profile = $conversation->getToPage()->getUserProfile(); ?>
                                                <?php echo $user_profile->getLink(1, 'width=45', ESC_RAW); ?>
                                                <?php echo link_to_public_profile($user_profile); ?>
                                            <?php endif; ?>
                                            <?php echo link_to(__('View Messages') . ' <img src="/images/gui/menu_user_arrow.png" />', 'message/view?user=' . $conversation->getToPage()->getId(), 'class="right" style="clear:right; margin-top:4px;"') ?>
                                            <?php if (!$conversation->getMessage()->getIsRead()): ?>
                                                <p><strong><?php echo (mb_strlen($conversation->getMessage()->getBody(), 'UTF8') <= 53 ) ? $conversation->getMessage()->getText() : mb_substr($conversation->getMessage()->getBody(), 0, 50, 'UTF8') . '...'; ?></strong></p>
                                            <?php else: ?>
                                                <p><?php echo (mb_strlen($conversation->getMessage()->getBody(), 'UTF8') <= 53 ) ? $conversation->getMessage()->getBody() : mb_substr($conversation->getMessage()->getBody(), 0, 50, 'UTF8') . '...'; ?></p>
                                            <?php endif; ?>
                                            <div class="clear"></div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <div id="message_content"><div></div></div>
                        </div>
                        */ ?>


                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        $('.company_follower a.right').click(function() {
            var elem = $(this);
            var parent = $(this).parent();
            if ($('#message_content > div').css('display') == 'block')
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
                    },
                    complete: function() {
                        $('#message_content .messages_scroll').tinyscrollbar_update('bottom');
                    }
                });
            }
            return false;
        });

        if (window.location.hash) {
            var hash = window.location.hash.substring(1);
            $('#' + hash + ' a.button_pink').trigger('click');
        }
    });
</script>

