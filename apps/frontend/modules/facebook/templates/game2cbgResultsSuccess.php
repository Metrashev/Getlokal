<div class="wrapInner">
	<div class="header">
            <img src="/images/facebook/prizes/bg/game_<?php echo $facebookGame->getId() ?>_header.png" />
	</div>

	<div class="content">
		<div class="content_in">
			<h1 class="pink">Резултати от проведените надпревари</h1>
			
			<?php if (isset($games) && count($games)) : ?>
				<ul class="vote_list">
				    <?php foreach ($games as $game) : ?>
				    	<li>
					    	<div class="left_wrap">
					        	<h2><?php echo $game->getName(); ?></h2>
								<div class="total_votes"><p>Гласували общо: <span class="blue"><?php echo $game->getCountUsers(); ?> човека</span></p></div>
							</div>
							<div class="right_wrap">
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
			    <div class="content_in">В момента все още няма приключени надпревари...</div>
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
