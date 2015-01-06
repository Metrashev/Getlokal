<div class="wrapInner">
	<img style="display:block; margin:20px auto;" src="/images/facebook/prizes/bg/game_<?php echo $facebookGame->getId() ?>_splash.jpg" alt="Очаквайте" />
	<div class="footer">
        <a href="<?php echo url_for('@homepage', array(), true); ?>" target="_blank"><img src="<?php echo public_path('/images/facebook/v3/bg/icon_e.png', true) ?>" /></a>
        <a href="<?php echo url_for('facebook/game2bg', array(), true) ?>">Начало</a>
	    <?php /*<a href="<?php echo url_for('static_page', array('slug' => 'rules-bigrace-sofiacountry')) ?>" target="_blank">Правила на играта</a>*/ ?>

            <?php if (isset($games) && count($games)) : ?>
                <a href="<?php echo url_for('facebook/game2bg', array(), true) . '?type=winners' ?>">Победители</a>
                <a href="<?php echo url_for('facebook/game2bg', array(), true) . '?type=results' ?>">Резултати</a>
                <?php /*<a href="<?php echo url_for('facebook/game2bg', array(), true) . '?type=awards' ?>">Награди</a>*/ ?>
            <?php endif; ?>
	</div>
</div> 