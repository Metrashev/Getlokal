<div class="wrapInner">
	<div class="header">
            <img src="/images/facebook/prizes/bg/game_<?php echo $facebookGame->getId() ?>_header.png" />
	</div>
 
	<div class="content">
		<div class="winner_content">
			<?php if (isset($games) && count($games)) : ?>
			    <?php $iterations = 0; ?>
			    <?php foreach ($games as $game) : ?>
			        <?php $iterations++; ?>
			        <?php if ($iterations == 1) : ?>
			        	<div class="step1">
				        	<img src="/images/facebook/prizes/bg/game_<?php echo $game->getId() ?>_prize_big_award.png" />
		    				<div class="left_wrap">
					            <h1>
					            	<span>СПЕЧЕЛИЛ</span>
					            	<?php echo sfOutputEscaper::unescape($game->getDescription()); ?>
					            	<span class="pink"><?php echo $game->getUserProfile()->getSfGuardUser()->getFirstName(), ' ', $game->getUserProfile()->getSfGuardUser()->getLastName() ?></span>
								</h1>
							</div>
						</div>
			        <?php else : ?>
		                <?php if ($iterations == 2) : ?>
		                    <h2 class="result_title">Победители в предишните надпревари</h2>
		                <?php endif; ?>
	
			            <div class="small_results">
                                        <img src="/images/facebook/prizes/bg/game_<?php echo $game->getId() ?>_prize_old.png" />
			                <p>Спечелил <?php echo sfOutputEscaper::unescape($game->getDescription()); ?></p>
			                <p class="pink"><?php echo $game->getUserProfile()->getSfGuardUser()->getFirstName(), ' ', $game->getUserProfile()->getSfGuardUser()->getLastName() ?></p>
			            	<div class="clear"></div>
			            </div>
			        <?php endif; ?>
			        <div class="clear"></div>
			    <?php endforeach; ?>
			<?php else : ?>
			    <div class="content_in">В момента все още няма приключени анкети...</div>
			<?php endif; ?>
		</div>
	</div>
	
	<div class="footer">
        <a href="<?php echo url_for('@homepage', array(), true); ?>"><img src="<?php echo public_path('/images/facebook/v3/bg/icon_e.png', true) ?>" /></a>
        <a href="<?php echo url_for('facebook/game2cbg', array(), true) ?>">Начало</a>
        <a href="<?php echo url_for('static_page', array('slug' => 'rules-bigrace-pop-folk-vs-other')) ?>" target="_blank">Правила на играта</a>
            <?php if (isset($games) && count($games)) : ?>
                <a href="<?php echo url_for('facebook/game2cbg', array(), true) . '?type=winners' ?>">Победители</a>
                <a href="<?php echo url_for('facebook/game2cbg', array(), true) . '?type=results' ?>">Резултати</a>
                <?php /*<a href="<?php echo url_for('facebook/game2cbg', array(), true) . '?type=awards' ?>">Награди</a>*/ ?>
            <?php endif; ?>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
	
	function myLoop () {
		setTimeout(function () {
			console.log('1');
			$('.step1').css('height', $('.step1 > img').outerHeight());
			if ($('.step1 > img').outerHeight() < 1)
				myLoop();
		}, 300);
	}
	myLoop();
	
	<?php if (!$isFbGame) : ?>
		$('html').css('background', 'url("../images/gui/bg.gif") repeat scroll 0 0 #E9E1D4')
	<?php endif;?>
	
});
</script>