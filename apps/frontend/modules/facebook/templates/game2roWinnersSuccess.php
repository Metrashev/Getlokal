<div class="wrapInner">

<?php if ($facebookGame->getSlug() == 'big-race-ro') : ?>
	<div class="header">
            <img src="/images/facebook/prizes/ro/game_<?php echo $facebookGame->getId() ?>_header.png" />
	</div>
<?php elseif ($facebookGame->getSlug() == 'bere-vs-vin') : ?>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.wrapInner').css('width', '990px');
            $('.wrapInner > div.content ').css('top', '220px');
            $('.wrapInner > div.content ').css('border-top', '10px solid #6ec0c1');
            $('.footer').css('top', '220px');
          });
     
    </script>
    <div class="big_bg_image">
        <img src="/images/facebook/prizes/ro/game_<?php echo $facebookGame->getId() ?>_header.png" />
    </div>
	
	<div class="game_title">
      <h1>Ce bei mai des?</h1>
	</div>
<?php endif; ?>
 
	<div class="content">
		<div class="winner_content">
			<?php if (isset($games) && count($games)) : ?>
			    <?php $iterations = 0; ?>
			    <?php foreach ($games as $game) : ?>
			        <?php $iterations++; ?>
			        <?php if ($iterations == 1) : ?>
			        	<div class="step1">
				        	<img src="/images/facebook/prizes/ro/game_<?php echo $game->getId() ?>_prize_big_award.png" />
		    				<div class="left_wrap">
					            <h1>
					            	<span>CÂŞTIGĂTOR!</span>
					            	<?php echo sfOutputEscaper::unescape($game->getDescription()); ?>
					            	<span class="pink"><?php echo $game->getUserProfile()->getSfGuardUser()->getFirstName(), ' ', $game->getUserProfile()->getSfGuardUser()->getLastName() ?></span>
								</h1>
							</div>
						</div>
			        <?php else : ?>
		                <?php if ($iterations == 2) : ?>
		                    <h2 class="result_title">Câștigătorii la concursurile anterioare</h2>
		                <?php endif; ?>
	
			            <div class="small_results">
                                        <img src="/images/facebook/prizes/ro/game_<?php echo $game->getId() ?>_prize_old.png" />
			                <p>Câștigător <?php echo sfOutputEscaper::unescape($game->getDescription()); ?></p>
			                <p class="pink"><?php echo $game->getUserProfile()->getSfGuardUser()->getFirstName(), ' ', $game->getUserProfile()->getSfGuardUser()->getLastName() ?></p>
			            	<div class="clear"></div>
			            </div>
			        <?php endif; ?>
			        <div class="clear"></div>
			    <?php endforeach; ?>
			<?php else : ?>
			    <div class="content_in">În prezent nu există nici un rezultat ...</div>
			<?php endif; ?>
		</div>
	</div>
	
	<div class="footer">
        <a href="<?php echo url_for('@homepage', array(), true); ?>"><img src="<?php echo public_path('/images/facebook/v3/bg/icon_e.png', true) ?>" /></a>
        <a href="<?php echo url_for('facebook/game2ro', array(), true) ?>">Start</a>
	    <?php if ($facebookGame->getSlug() == 'big-race-ro') : ?>		
			<a href="<?php echo url_for('static_page', array('slug' => 'reguli-bucuresti-vs-provincia')) ?>" target="_blank">Reguli de joc</a>
		<?php elseif ($facebookGame->getSlug() == 'bere-vs-vin') : ?>
			<a href="<?php echo url_for('static_page', array('slug' => 'reguli-bere-vs-vin')) ?>" target="_blank">Reguli de joc</a>
		<?php endif; ?>
            <?php if (isset($games) && count($games)) : ?>
                <a href="<?php echo url_for('facebook/game2ro', array(), true) . '?type=winners' ?>">Câștigători</a>
                <a href="<?php echo url_for('facebook/game2ro', array(), true) . '?type=results' ?>">Rezultate</a>
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