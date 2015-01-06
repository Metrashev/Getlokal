<?php if (isset($friendsList) && count($friendsList)) : ?> 
    <input type="hidden" id="mfbidt" value="" style="display: none; visibility: false" />
    <div class="facebook_scroll fbids">
        <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
        <div class="viewport">
            <ul class="overview">
                <?php foreach ($friendsList as $id => $name) : ?>
                    <li>
                        <?php if (is_array($disabledList->getRawValue()) && !in_array($id, $disabledList->getRawValue())) : ?>
                            <a class="sendInvite" href="javascript:;" mfbid="<?php echo $id ?>" title="<?php echo __('Invite', null, 'user'); ?>">
                            	<span class="img_wrap">
	                            	<img src="https://graph.facebook.com/<?php echo $id ?>/picture" width="36" />
	                            	<img class="tick" src="/images/facebook/prizes/bg/game_5_tick.png" />
	                            </span>
                        		<span class="text_wrap"><?php echo $name ?></span>
                        		<span class="clear"></span>
                            </a>
                            <div class="clear"></div>
                        <?php else : ?>
                            <a class="invited sendInvite" mfbid="" title="<?php echo __('Invited', null, 'user'); ?>">
                            	<span class="img_wrap">
                            		<img src="https://graph.facebook.com/<?php echo $id ?>/picture" width="36" />
                            		<img class="tick" src="/images/facebook/prizes/bg/game_5_x.png" />
                            	</span>
                        		<span class="text_wrap"><?php echo $name ?></span>
                        		<span class="clear"></span>
                            </a>
                            <div class="clear"></div>
                        <?php endif; ?>

                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="clear"></div>
        </div>
    </div>

    <script type="text/javascript">
        $(function() {
            $(".sendInvite").live('click',function() {
                $(".success_msg_fb").html('');
			
                var mfbid = $(this).attr('mfbid');
                if (mfbid) {
                    $("#mfbidt").val(mfbid);
					$(this).addClass('clicked');
					$('.success_msg').hide();
                    sendInvite(mfbid);
                }
                else {
                    $(this).removeClass('clicked');
                    $("#mfbidt").val("");
                }
            });
        });

        function sendInvite(mfbid) {
            <?php /*
            Facebook message
            FB.ui({
                method: 'send',
                name: '<?php echo __('Win an iPhone5!', null, 'facebookgame') ?>',
                picture: $("input[name=share_image_small]").val() + '?' + "<?php echo time() ?>",
                description: '<?php echo __('Invite three friends and participate in the draw!', null, 'facebookgame') ?>',
                link: '<?php echo url_for('default', array('module' => 'facebook', 'action' => 'game3'), true) ?>?code=' + $("input[name=hash]").val(),
                display: 'iframe',
                to: mfbid
            }, requestCallback);
            */
            ?>

            <?php // Facebook invite ?>
            FB.ui({method: 'apprequests',
                title: '<?php echo __('Win an iPhone5!', null, 'facebookgame') ?>',
                to: mfbid,
                message: '<?php echo __('Invite three friends and win an iPhone 5!', null, 'facebookgame') ?>'
            }, requestCallback);
        }


        function requestCallback(response) {
            if (response != undefined)
            {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo url_for('default', array('module' => 'facebook', 'action' => 'game3'), true); ?>',
                    data: {sendInviteFB: true, friendId : $("#mfbidt").val()},
                    dataType: 'json', //text

                    // callback handler that will be called on success
                    success: function(response, textStatus, jqXHR) {
                        //getFriendsList("<?php echo url_for('default', array('module' => 'facebook', 'action' => 'game3'), true); ?>", true);

                        $(".success_msg_fb").html(response.message);

                        $('.toStep3').show();
                        $('.fb .success_msg').show();
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
            }
            else {

            }
        }
    </script>
<?php endif; ?>