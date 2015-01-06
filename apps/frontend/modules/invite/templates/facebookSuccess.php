<?php slot('no_map', true) ?>
<div id="fb-root"></div>
<div class="settings_content">
    <h2 class="dotted">
        <?php //echo __('Via Facebook', null, 'user')?>
        <?php echo __('Send Your Invite via <img src="/images/gui/facebook.png">', null, 'user') ?>
    </h2>
    <?php if ($sf_user->hasFlash('error')) : ?>
        <?php /* <p><?php echo link_to(__('Back...', null, 'user'), '@invite'); ?></p> */ ?>
    <?php else : ?>
        <?php if (isset($friendList) && $friendList) : ?>
            <input type="hidden" id="mfbidt" value="" style="display: none; visibility: false" />
            <div class="loading" style="display: none;"><img src="/images/gui/loader_fancy.gif"/></div>
            <div class="facebook_scroll">
                <div class="scrollable_content">
                    <ul class="overview">
                        <?php $friendList = $friendList->getRawValue(); ?>
                        <?php foreach ($friendList as $key => $friend) : ?>
                            <li>
                                <label for="<?php echo $friend['id'] ?>">
                                    <img src="https://graph.facebook.com/<?php echo $friend['id'] ?>/picture" width="30" />
                                    <?php echo $friend['name'] ?>
                                </label>

                                <?php if (!$friend['disabled']) : ?>
                                    <a class="button_green sendInvite" href="javascript:;" mfbid="<?php echo $friend['id'] ?>" title="<?php echo __('Invite', null, 'user'); ?>"><?php echo __('Invite', null, 'user'); ?></a>
                                <?php else : ?>
                                    <a class="button_gray sendInvite" mfbid="" title="<?php echo __('Invited', null, 'user'); ?>"><?php echo __('Invited', null, 'user'); ?></a>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <p><span id="status" ></span></p>
            </div>

            <script src="https://connect.facebook.net/en_US/all.js"></script>
            <script type="text/javascript">
                $(function() {
                    FB.init({
                        appId: '289748011093022',
                        status: true,
                        cookie: true,
                        oauth: true
                    });

                    FB.getLoginStatus(function(response) {
                        if (response.status === 'connected') {
                            var uid = response.authResponse.userID;
                            <?php //$sf_user->setAttribute('invite.referer', NULL); ?>
                        }
                        else {
                            // Always login user into FB, because only logged user can send messages!!!
                            <?php //$sf_user->setAttribute('invite.referer', url_for('invite_fb', array(), true)); ?>
                            top.location.href='<?php echo url_for('user/FBLogin') ?>';
                        }
                    });

                    $(".sendInvite").live('click',function() {
                            var mfbid = $(this).attr('mfbid');
                            if (mfbid) {
                                $("#mfbidt").val(mfbid);

                                sendInvite(mfbid);
                            }
                            else {
                                $("#mfbidt").val("");
                            }
                        });
                    });

                    function sendInvite(mfbid) {
                        FB.ui({
                            method: 'send',
                            link: '<?php echo url_for('user_register', array('code' => $hash), true) ?>',
                            display: 'iframe',
                            to: mfbid
                        }, requestCallback);
                    }

                    function requestCallback(response) {
                        if (response != undefined)
                        {
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo url_for('@invite_fb') ?>',
                                data: {friendId : $("#mfbidt").val()},
                                dataType: 'text', //json

                                // callback handler that will be called on success
                                success: function(response, textStatus, jqXHR) {
                                    // log a message to the console

                                },
                                // callback handler that will be called on error
                                error: function(jqXHR, textStatus, errorThrown) {
                                    // log the error to the console
                                    //console.log("The following error occured: " + textStatus, errorThrown);
                                },
                                // callback handler that will be called on completion
                                // which means, either on success or error
                                complete: function(){

                                }
                            });

                            $(".cta").html('<div class="flash_success"><?php echo __('Your invite was sent successfully!', null, 'user') ?></div>');
                            $(".cta").css('display', 'block');
                        }
                        else {
                            $(".cta").html('');
                            $(".cta").css('display', 'none');
                        }
                    }
            </script>
        <?php else : ?>
            <?php echo __('The friend list is empty!', null, 'user'); ?>
        <?php endif; ?>

    <?php endif; ?>
</div>

<script type="text/javascript">
    var offset = 20;
    var isEmpty = false;
    
    $(document).ready(function() {
        $(".scrollable_content").bind("scroll", function() {
            if ($(this).isNearTheEnd()){
                updateFBList($(this));
                window.offset = window.offset + 20; 
            } // load some content
        });
    });
 
    function updateFBList(object) {
        $.ajax({
            type: "POST",
            url: "<?php echo url_for('invite_fb') ?>?offset=" + offset,
            dataType: "json",
            data: { offset: window.offset }
        }).done(function(data) {
            
            if (data && data.friendList) {
                if(!data.friendList.length) {
                    window.isEmpty = true;
                }
                
                html = html1 = html2 = '';
                if (window.isEmpty == false) {
                   $(".loading").show();
                }
                
                $.each(data.friendList, function(id, friend){
                    html1 = '<li><label for="' + friend.id + '"><img src="https://graph.facebook.com/' + friend.id + '/picture" width="30" /> ' + friend.name + '</label>';

                    if (!friend.disabled) {
                        html2 = '<a class="button_green sendInvite" href="javascript:;" mfbid="' + friend.id + '" title="<?php echo __('Invite', null, 'user'); ?>"><?php echo __('Invite', null, 'user'); ?></a></li>';
                    }
                    else {
                        html2 = '<a class="button_gray sendInvite" mfbid="" title="<?php echo __('Invited', null, 'user'); ?>"><?php echo __('Invited', null, 'user'); ?></a></li>';
                    }

                    html += html1 + html2;
                });
                
                if(window.isEmpty == false){
                  object.find('ul.overview').append(html);
                  setTimeout(function(){$(".loading").hide();},1000);
                }
            }
        });
    }

    $.fn.isNearTheEnd = function() {
        return this[0].scrollTop + this.height() >= this[0].scrollHeight;
    };

    $('.path_wrap').css('display', 'none');
//    $('.search_bar').css('display', 'none');
    $(".banner").css("display", "none");
</script>
