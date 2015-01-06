<div class="wrapInner">
	<img style="display:block; margin:20px auto;" src="/images/facebook/prizes/mk/game_<?php echo $facebookGame->getId() ?>_splash.jpg" alt="Coming soon..." />
	<div class="footer">
        <a href="<?php echo url_for('@homepage', array(), true); ?>" target="_blank"><img src="<?php echo public_path('/images/facebook/v3/mk/icon_e.png', true) ?>" /></a>
        <a href="<?php echo url_for('facebook/game2mk', array(), true) ?>">Насловна</a>
	    <a href="<?php echo url_for('static_page', array('slug' => 'rules-bigrace-momcidevojki')) ?>" target="_blank">Правила на натпреварот</a>

            <?php if (isset($games) && count($games)) : ?>
                <a href="<?php echo url_for('facebook/game2mk', array(), true) . '?type=winners' ?>">Победници</a>
                <a href="<?php echo url_for('facebook/game2mk', array(), true) . '?type=results' ?>">Резултати</a>
                <?php /*<a href="<?php echo url_for('facebook/game2mk', array(), true) . '?type=awards' ?>">Награди</a>*/ ?>
            <?php endif; ?>
	</div>
</div> 