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
		<div class="results_content">
			<h1 class="pink"><?php echo __('Results from past games', null, 'facebookgame') ?></h1>
			
			<?php if (isset($games) && count($games)) : ?>
				<ul class="vote_list">
				    <?php foreach ($games as $game) : ?>
				    	<li>
					    	<div class="left">
					        	<h2><?php echo $game->getName(); ?></h2>
								<div class="total_votes"><p><?php echo __('Гласували общо', null, 'facebookgame') ?>: <span class="blue"><?php echo $game->getCountUsers(); ?> <?php echo __('човека', null, 'facebookgame') ?></span></p></div>
							</div>
							<div class="left">
						        <div class="result_wrap">
						            <?php $iterations = 0; ?>
						            <?php foreach($results = $game->getUserResults($game->getCountUsers()) as $param1 => $param2) : ?>
						                <?php $iterations++; ?>
						                <span><?php echo $param1 ?></span>
						                <div class="result_bar">
						                	<div <?php echo (($iterations%2) == 0) ? 'class="scnd"' : ''; ?> style="width:<?php echo $param2 ?>%"></div>
						                </div>
						                <span class="blue">
						                	<img src="/images/gui/bg_vote.gif" />
						                	<?php echo $param2.'%' ?>
						                </span>
						                <div class="clear"></div>
						            <?php endforeach; ?>
						        </div>
						    </div>
						    <div class="clear"></div>
						</li>
				    <?php endforeach; ?>
			    </ul> 
			<?php else : ?>
			    <div class="content_in"><?php echo __('В момента все още няма приключени надпревари...', null, 'facebookgame') ?></div>
			<?php endif; ?>
		</div>
	</div>


        <div class="footer">
            <a href="<?php echo $siteUrl ?>"><?php echo __('Home', null, 'facebookgame') ?></a>
            <a id="playAgain" href="<?php echo $homepageUrl ?>"><?php echo __('Play again', null, 'facebookgame') ?></a>
            <a href="<?php echo url_for('static_page', array('slug' => 'rules-lucky3')) ?>" target="_blank"><?php echo __('Rules', null, 'facebookgame') ?></a>

            <?php if (isset($games) && count($games)) : ?>
                <?php /*
                <a href="<?php echo url_for('facebook/game3', array(), true) . '?type=winners' ?>"><?php echo __('Winners', null, 'facebookgame') ?></a>
                <a href="<?php echo url_for('facebook/game3', array(), true) . '?type=results' ?>"><?php echo __('Results', null, 'facebookgame') ?></a>
                 */ ?>

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
