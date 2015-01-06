<?php if ($culture == 'bg') : ?>
    <?php $homepageUrl = 'http://apps.facebook.com/lucky-three-bg'; ?>
<?php elseif($culture == 'mk') : ?>
    <?php $homepageUrl = 'http://apps.facebook.com/lucky-three-mk'; ?>
<?php elseif ($culture == 'sr') : ?>
    <?php $homepageUrl = 'http://apps.facebook.com/lucky-three-sr'; ?>
<?php endif; ?>


<?php if (!$fromFacebookGame) : ?>
    <?php $homepageUrl = url_for('facebook/game3'); ?>
<?php endif; ?>

<?php $siteUrl = url_for('homepage', array(), true); ?>

<div class="wrapInner">
	<div class="header">
            <img src="/images/facebook/prizes/<?php echo $culture ?>/game_<?php echo $facebookGame->getId() ?>_header.png" />
	</div>
 
	<div class="content">
		<div class="winner_content">
			<?php if (isset($games) && count($games)) : ?>
			    <?php $iterations = 0; ?>
			    <?php foreach ($games as $game) : ?>
			        <?php $iterations++; ?>
			        <?php if ($iterations == 1) : ?>
			        	<div>
				        	<img src="/images/facebook/prizes/<?php echo $culture ?>/game_<?php echo $game->getId() ?>_prize_big_award.png" class="left" />
		    				<div class="left_wrap">
					            <h1>
					            	<span><?php echo __('Спечелил', null, 'facebookgame') ?></span>
					            	<?php echo sfOutputEscaper::unescape($game->getDescription()); ?>
					            	<span class="pink"><?php echo $game->getUserProfile()->getSfGuardUser()->getFirstName(), ' ', $game->getUserProfile()->getSfGuardUser()->getLastName() ?></span>
                                </h1>
                            </div>
                        </div>
			        <?php else : ?>
		                <?php if ($iterations == 2) : ?>
		                    <h2 class="result_title"><?php echo __('Победители в предишните надпревари', null, 'facebookgame') ?></h2>
		                <?php endif; ?>
	
			            <div class="small_results">
                                        <img src="/images/facebook/prizes/<?php echo $culture ?>/game_<?php echo $game->getId() ?>_prize_old.png" />
			                <p><?php echo __('Спечелил', null, 'facebookgame') ?> <?php echo sfOutputEscaper::unescape($game->getDescription()); ?></p>
			                <p class="pink"><?php echo $game->getUserProfile()->getSfGuardUser()->getFirstName(), ' ', $game->getUserProfile()->getSfGuardUser()->getLastName() ?></p>
			            	<div class="clear"></div>
			            </div>
			        <?php endif; ?>
			        <?php if ($iterations % 2 != 0) : ?>
			        	<div class="clear"></div>
			        <?php endif; ?>
			    <?php endforeach; ?>
			<?php else : ?>
			    <div class="content_in"><?php echo __('В момента все още няма приключени анкети...', null, 'facebookgame') ?></div>
			<?php endif; ?>
		</div>
	</div>
	
        <div class="footer">
            <a href="<?php echo $siteUrl ?>"><?php echo __('Home', null, 'facebookgame') ?></a>
            <a id="playAgain" href="<?php echo $homepageUrl ?>"><?php echo __('Play again', null, 'facebookgame') ?></a>
            <a href="<?php echo url_for('static_page', array('slug' => 'rules-lucky3')) ?>" target="_blank"><?php echo __('Rules', null, 'facebookgame') ?></a>

            <?php if (isset($games) && count($games)) : ?>
                <a href="<?php echo url_for('facebook/game3', array(), true) . '?type=winners' ?>"><?php echo __('Winners', null, 'facebookgame') ?></a>
                <a href="<?php echo url_for('facebook/game3', array(), true) . '?type=results' ?>"><?php echo __('Results', null, 'facebookgame') ?></a>
                <?php /*<a href="<?php echo url_for('facebook/game2cbg', array(), true) . '?type=awards' ?>">Награди</a>*/ ?>
            <?php endif; ?>
            <img src="/images/facebook/prizes/<?php echo $culture ?>/game_<?php echo $facebookGame->getId() ?>_footer_logo.png" alt="Lucky Three" />
        </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
        <?php if ($fromFacebookGame) : ?>
            $('#playAgain').live('click', function() {
                //$(".final_results").html("<img src=\"/images/facebook/prizes/bg/loading.gif\" />");
                //$(".step3").hide();
                //$(".step1").show();
                location.reload();

                return false;
            });
        <?php endif; ?>

	<?php if (!$fromFacebookGame) : ?>
		$('html').css('background', 'url("<?php echo public_path("/images/gui/bg.gif", true); ?>") repeat scroll 0 0 #E9E1D4')
	<?php endif;?>
});
</script>